<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\MarketExecutionExport;
use App\Models\JournalMarketExecution;
use App\Models\JournalUpload;
use App\Models\JournalWrongPrice;
use App\Models\JournalCreditFacility;
use App\Models\JournalIPPerusahaan;
use App\Models\JournalIPPublik;
use Carbon\Carbon;

class JournalController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Journal Report']
        ];

        return view('journal.index', [
            'title' => 'Dashboard Journal',
            'breadcrumbs' => $breadcrumbs,
            'waktu_eksekusi_market' => JournalMarketExecution::all(),
            'harga_tidak_sesuai' => JournalWrongPrice::all(),
            'credit_facility' => JournalCreditFacility::all()
        ]);
    }

    // =============== UPLOAD PAGE ===============
    public function uploadPage()
    {
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Journal Report']
        ];

        return view('journal.upload', [
            'title' => 'Upload Journal Report',
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    // =============== PROCESS FILE ===============
    public function uploadProcessJournal(Request $req)
    {
        $req->validate([
            'file' => 'required|mimes:htm,html,txt',
            'ip_perusahaan' => 'nullable|string',
        ], [
            'ip_perusahaan.required' => 'Kolom IP Perusahaan tidak boleh kosong kakak.'
        ]);

        $filePath = $req->file('file')->getRealPath();

        $creditFacility = [];
        $marketExecution = [];
        $wrongPrice = [];

        // ======================
        // 1) IP PERUSAHAAN
        // ======================            

        $ipPerusahaan = array_map('trim', explode(',', $req->ip_perusahaan));
        $ipCompanyLogs = $this->parseIPPerusahaanStream($filePath, $ipPerusahaan);

        $handle = fopen($filePath, 'r');
        $prevLine = null;

        $totalBaris = 0;

        while (($line = fgets($handle)) !== false) {
            $totalBaris++;

            $line = trim(strip_tags($line));

            if ($line === '') {
                $prevLine = null;
                continue;
            }

            // ======================
            // CREDIT FACILITY
            // ======================

            if (stripos($line, 'changed credit') !== false) {
                $parsed = $this->parseCreditFacilityLine($line);
                if ($parsed !== null) {
                    $creditFacility[] = $parsed;
                }
            }

            if ($prevLine) {

                // ==================================================
                // WAKTU EKSEKUSI MARKET  (request → confirm)
                // ==================================================

                if (
                    stripos($prevLine, 'request') !== false &&
                    stripos($line, 'confirm') !== false
                ) {

                    $time1 = $this->extractTime($prevLine);
                    $time2 = $this->extractTime($line);
                    $info  = $this->extractInfo($prevLine);

                    if ($time1 && $time2 && !empty($info['no_tiket'])) {

                        $ts1 = intval($time1->format("U")) * 1_000_000 + intval($time1->format("u"));
                        $ts2 = intval($time2->format("U")) * 1_000_000 + intval($time2->format("u"));

                        $diffMicro  = $ts2 - $ts1;
                        $diffSecond = $diffMicro / 1_000_000;

                        if ($diffSecond > 1) {
                            $marketExecution[] = [
                                'no_akun' => $info['no_akun'],
                                'no_tiket' => $info['no_tiket'],
                                'tanggal' => $info['tanggal'],
                                'delay_seconds' => $diffSecond,
                                'delay_formatted' => $this->formatDelay($diffSecond),
                                'diff_microseconds' => $diffMicro,
                                'request_time' => $ts1,
                                'confirm_time' => $ts2,
                                'request_raw' => $prevLine,
                                'confirm_raw' => $line,
                            ];
                        }
                    }
                }

                // ==================================================
                // HARGA TIDAK SESUAI  (confirm close → close order)
                // ==================================================

                if (
                    stripos($prevLine, 'confirm') !== false &&
                    stripos($prevLine, 'close') !== false &&
                    stripos($line, 'close order') !== false
                ) {

                    $execType = $this->extractExecType($prevLine);
                    $completed = $this->extractCompletedPrice($line);
                    [$bid, $ask] = $this->extractBidAsk($prevLine);
                    $info = $this->extractInfo($prevLine);
                    $no_tiket = $this->extractInfo($line);

                    $mismatch =
                        ($execType === 'buy'  && $completed != $bid) ||
                        ($execType === 'sell' && $completed != $ask);

                    if ($mismatch && !empty($info['no_tiket'])) {
                        $wrongPrice[] = [
                            'no_akun' => $info['no_akun'],
                            'no_tiket' => $no_tiket['no_tiket'],
                            'tanggal' => $info['tanggal'],
                            'confirm' => $prevLine,
                            'close_order' => $line,
                            'exec_type' => $execType,
                            'completed' => $completed,
                            'bid' => $bid,
                            'ask' => $ask
                        ];
                    }
                }
            }

            $prevLine = $line;
        }

        fclose($handle);

        session([
            'parsed_credit' => $creditFacility,
            'parsed_market' => $marketExecution,
            'parsed_wrong'  => $wrongPrice,
            'parsed_ip_perusahaan' => $ipCompanyLogs
        ]);


        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Journal Report', 'url' => route('journal.index')],
            ['label' => 'Hasil Parsing Journal']
        ];

        return view('journal.result', [
            'title' => 'Hasil Parsing Journal',
            'parsed' => $totalBaris,
            'creditFacility' => $creditFacility,
            'marketExecution' => $marketExecution,
            'wrongPrice' => $wrongPrice,
            'ip_perusahaan' => $ipPerusahaan,
            'ipCompanyLogs' => $ipCompanyLogs,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function uploadMultiJournal(Request $req)
    {
        $req->validate([
            'files.*' => 'required|mimes:htm,html,txt'
        ]);

        $duplicates = $this->uploadProcessIPPublikSama(
            $req->file('files')
        );

        // dd($duplicates); // --- IGNORE ---

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Journal Report', 'url' => route('journal.index')],
            ['label' => 'Hasil Parsing Journal']
        ];

        session(['parsed_ip_sama' => $duplicates]);

        return view('journal.same_ip', [
            'duplicates' => $duplicates,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function uploadProcessJournalHistoryStatement() {}

    public function saveIPPublik()
    {
        $rows = session('parsed_ip_sama', []);

        foreach ($rows as $ip => $logs) {
            foreach ($logs as $log) {
                JournalIPPublik::create([
                    'no_akun'                => $log['no_akun'],
                    'tanggal'                => $log['tanggal'],
                    'waktu'                  => $log['waktu'],
                    'ip_address_publik'      => $ip,
                    'filename'               => $log['file'],
                    'raw_line'               => $log['raw'],
                ]);
            }
        }

        return back()->with('success', 'IP Publik Sama berhasil disimpan');
    }

    public function saveMarket()
    {
        $rows = session('parsed_market', []);

        $upload = JournalUpload::create([
            'filename' => 'journal_' . now()->format('Ymd_His')
        ]);

        foreach ($rows as $row) {
            JournalMarketExecution::create([
                'journal_upload_id' => $upload->id,
                'no_akun'           => $row['no_akun'],
                'no_tiket'          => $row['no_tiket'],
                'tanggal'           => Carbon::createFromFormat('Y.m.d', $row['tanggal'])->toDateString(),
                'request_time'      => $row['request_time'],
                'confirm_time'      => $row['confirm_time'],
                'delay_microseconds' => $row['diff_microseconds'],
                'delay_seconds'     => $row['delay_seconds'],
                'delay_formatted'   => $row['delay_formatted'],
                'request_raw'       => $row['request_raw'],
                'confirm_raw'       => $row['confirm_raw'],
            ]);
        }

        return redirect()->back()->with('success', 'Market Execution berhasil disimpan');
    }

    public function saveWrong()
    {
        $rows = session('parsed_wrong', []);

        $upload = JournalUpload::latest()->first();

        foreach ($rows as $row) {
            JournalWrongPrice::create([
                'journal_upload_id' => $upload->id,
                'no_akun'           => $row['no_akun'],
                'no_tiket'          => $row['no_tiket'],
                'tanggal'           => Carbon::createFromFormat('Y.m.d', $row['tanggal'])->toDateString(),
                'exec_type'         => $row['exec_type'],
                'completed_price'   => $row['completed'],
                'bid_price'         => $row['bid'],
                'ask_price'         => $row['ask'],
                'confirm_raw'       => $row['confirm'],
                'close_order_raw'   => $row['close_order'],
            ]);
        }

        return redirect()->back()->with('success', 'Wrong Price berhasil disimpan');
    }

    public function saveCredit()
    {
        $rows = session('parsed_credit', []);

        $upload = JournalUpload::latest()->first();

        foreach ($rows as $row) {
            JournalCreditFacility::create([
                'journal_upload_id' => $upload->id,
                'no_akun' => $row['no_akun'],
                'no_tiket' => $row['no_tiket'],
                'tanggal' => $row['tanggal'],
                'waktu' => $row['waktu'],
                'ip_address' => $row['ip_address'],
                'credit_in' => $row['credit_in'],
                'credit_out' => $row['credit_out'],
                'raw_line' => $row['raw']
            ]);
        }

        return redirect()->back()->with('success', 'Credit Facility berhasil disimpan');
    }

    public function saveIPPerusahaan()
    {
        $rows = session('parsed_ip_company', []);
        $upload = JournalUpload::latest()->first();

        foreach ($rows as $row) {
            JournalIPPerusahaan::create([
                'journal_upload_id'      => $upload->id,
                'no_akun'                => $row['no_akun'],
                'tanggal'                => $row['tanggal'],
                'waktu'                  => $row['waktu'],
                'ip_address_publik'      => $row['ip'],
                'ip_address_perusahaan'  => $row['ip'],
                'raw_line'               => $row['raw'],
            ]);
        }

        return back()->with('success', 'IP Perusahaan berhasil disimpan');
    }

    public function saveAll()
    {
        $this->saveIPPerusahaan();
        $this->saveMarket();
        $this->saveWrong();
        $this->saveCredit();

        return back()->with('success', 'Semua data journal berhasil disimpan');
    }

    public function exportExcel()
    {
        return Excel::download(new MarketExecutionExport, 'market_execution.xlsx');
    }

    public function exportPDF()
    {
        $title = 'Ekspor PDF';
        $data = JournalMarketExecution::all();

        $pdf = Pdf::loadView('journal.execution_market.pdf', compact('data', 'title'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('market_execution.pdf');
    }

    // =====================================================
    // ⭐ HELPER FUNCTIONS
    // =====================================================

    private function isIgnoredIP(string $ip): bool
    {
        // IPv6 localhost
        if ($ip === '::1') return true;

        // Loopback IPv4
        if ($ip === '127.0.0.1') return true;

        // Private network ranges
        if (
            preg_match('/^10\./', $ip) ||
            preg_match('/^192\.168\./', $ip) ||
            preg_match('/^172\.(1[6-9]|2[0-9]|3[0-1])\./', $ip)
        ) {
            return true;
        }

        return false;
    }

    private function cleanDuplicateIPPerFile(array $ipMap): array
    {
        foreach ($ipMap as $ip => $logs) {

            $unique = [];

            foreach ($logs as $log) {

                $key = $log['file'] . '-' . $log['no_akun'];

                if (!isset($unique[$key])) {
                    $unique[$key] = $log;
                }
            }

            $ipMap[$ip] = array_values($unique);
        }

        return $ipMap;
    }

    private function uploadProcessIPPublikSama(array $files): array
    {
        $ipMap = [];

        foreach ($files as $file) {

            $filename = $file->getClientOriginalName();
            $html = $file->get();

            libxml_use_internal_errors(true);

            $dom = new \DOMDocument();
            $dom->loadHTML($html);
            $xpath = new \DOMXPath($dom);

            $rows = $xpath->query('//tr');

            foreach ($rows as $row) {

                $cells = $xpath->query('.//td', $row);

                // Format journal: datetime | IP | message
                if ($cells->length < 3) continue;

                $datetime = trim($cells->item(0)->textContent);
                $ip       = trim($cells->item(1)->textContent);
                $message  = trim($cells->item(2)->textContent);
                $raw      = trim($row->textContent);

                // Validasi datetime
                if (!preg_match('/^\d{4}\.\d{2}\.\d{2}\s+\d{2}:\d{2}:\d{2}/', $datetime)) {
                    continue;
                }

                // Validasi IP
                if (!filter_var($ip, FILTER_VALIDATE_IP)) {
                    continue;
                }

                // IP yang diabaikan
                if ($this->isIgnoredIP($ip)) continue;

                // Ambil NO AKUN dari message
                $noAkun = null;

                // Ambil no akun dari format 5 karakter di dalam tanda kutip dan titik dua setelahnya ('xxxx':)
                if (preg_match("/'(\d{5})'/", $message, $m)) {
                    $noAkun = $m[1];
                }

                if (!$noAkun) continue;

                [$tanggal, $waktuFull] = explode(' ', $datetime);
                $waktu = substr($waktuFull, 0, 8);

                $ipMap[$ip][] = [
                    'tanggal' => $tanggal,
                    'waktu'   => $waktu,
                    'no_akun' => $noAkun,
                    'file'    => $filename,
                    'raw'     => $raw,
                ];
            }
        }

        // Bersihkan duplikat dalam satu file
        $ipMap = $this->cleanDuplicateIPPerFile($ipMap);

        // 🔥 Ambil hanya IP yang dipakai lebih dari 1 akun
        return array_filter($ipMap, function ($logs) {

            $akun = array_unique(array_filter(array_column($logs, 'no_akun')));

            return count($akun) > 1;
        });
    }

    private function parseIPPerusahaanStream(string $filePath, array $ipPerusahaan): array
    {
        $results = [];
        $handle = fopen($filePath, 'r');

        while (($line = fgets($handle)) !== false) {

            if (!preg_match('/<tr>.*?<\/tr>/i', $line)) {
                continue;
            }

            preg_match_all('/<td>(.*?)<\/td>/i', $line, $cols);

            if (count($cols[1]) < 3) continue;

            $time = strip_tags($cols[1][0]);
            $ip   = strip_tags($cols[1][1]);
            $msg  = strip_tags($cols[1][2]);

            if (!filter_var($ip, FILTER_VALIDATE_IP)) continue;
            if (!in_array($ip, $ipPerusahaan)) continue;

            if (!preg_match('/(\d{4}\.\d{2}\.\d{2}) (\d{2}:\d{2}:\d{2})/', $time, $dt)) continue;

            $noAkun = null;
            if (preg_match("/'(\d{5,})'/", $msg, $m)) {
                $noAkun = $m[1];
            }

            $results[] = [
                'tanggal' => \Carbon\Carbon::createFromFormat('Y.m.d', $dt[1])->toDateString(),
                'waktu' => $dt[2],
                'no_akun' => $noAkun,
                'ip' => $ip,
                'raw' => $msg,
            ];
        }

        fclose($handle);
        return $results;
    }

    private function parseCreditFacilityLine(string $line): ?array
    {
        $line = trim($line);

        $regex = '/
            (?<tanggal>\d{4}\.\d{2}\.\d{2})\s*
            (?<waktu>\d{2}:\d{2}:\d{2})\.(?<ms>\d{3})
            (?<ip>\d{1,3}(?:\.\d{1,3}){3})
            \'\d+\':\s*
            changed\s+credit\s+
            \#(?<tiket>\d+)\s*-\s*
            (?<amount>-?\d+\.\d+)\s+
            for\s+\'(?<akun>\d+)\'\s*-\s*
             (?<type>\b[a-zA-Z_]+\s+(?:in|out)\b)
        /ix';

        if (!preg_match($regex, $line, $m)) {
            return null;
        }

        $amount = (float) $m['amount'];
        $type   = strtolower($m['type']);

        return [
            'tanggal'    => \Carbon\Carbon::createFromFormat('Y.m.d', $m['tanggal'])->toDateString(),
            'waktu'      => $m['waktu'],          // 18:15:08
            'ip_address' => $m['ip'],             // FULL IP FIXED ✅
            'no_akun'    => $m['akun'],
            'no_tiket'   => $m['tiket'],
            'credit_in'  => $type === 'credit in' || $type === 'sm in' ? abs($amount) : 0,
            'credit_out' => $type === 'credit out' || $type === 'sm out' ? abs($amount) : 0,
            'raw'        => $line,
        ];
    }

    private function extractTime($line)
    {
        // Format waktu: 2021.09.10 14:31:14.204
        preg_match('/(\d{4}\.\d{2}\.\d{2}) (\d{2}:\d{2}:\d{2}\.\d{3})/', $line, $m);

        if (!$m) return null;

        return date_create_from_format('Y.m.d H:i:s.u', $m[1] . ' ' . $m[2]);
    }

    private function extractExecType($line)
    {
        return str_contains(strtolower($line), 'sell') ? 'sell' : 'buy';
    }

    private function extractBidAsk($line)
    {
        // Format: (1789.66000 / 1790.11000)
        preg_match('/\(([\d\.]+) \/ ([\d\.]+)\)/', $line, $m);

        if (!$m) return [null, null];

        return [$m[1], $m[2]];
    }

    private function extractCompletedPrice($line)
    {
        // Format: at 1785.68000 completed
        preg_match('/at ([\d\.]+) completed/', $line, $m);

        return $m ? $m[1] : null;
    }

    private function extractInfo($line)
    {
        $info = [
            'tanggal' => null,
            'no_akun' => null,
            'no_tiket' => null,
        ];

        // Ambil tanggal
        if (preg_match('/(\d{4}\.\d{2}\.\d{2})/', $line, $m)) {
            $info['tanggal'] = $m[1];
        }

        // Ambil no_akun dari 'xxxxxx'
        if (preg_match("/'(\d{5,})'/", $line, $m)) {
            $info['no_akun'] = $m[1];
        }

        // Ambil no tiket dari #xxxxxxx
        if (preg_match('/#(\d{5,})/', $line, $m)) {
            $info['no_tiket'] = $m[1];
        }

        return $info;
    }

    private function formatDelay($secondsFloat)
    {
        $ms   = intval(($secondsFloat - floor($secondsFloat)) * 1000);
        $secs = floor($secondsFloat);
        $h    = floor($secs / 3600);
        $m    = floor(($secs % 3600) / 60);
        $s    = $secs % 60;

        return sprintf("%02d:%02d:%02d.%03d", $h, $m, $s, $ms);
    }
}
