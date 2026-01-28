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
    public function uploadProcess(Request $req)
    {
        $req->validate([
            'file' => 'required|mimes:htm,html,txt',
            'ip_perusahaan' => 'required|string',
        ]);

        $file = $req->file('file')->get();

        $rawLines = explode("\n", $file);

        // Clean html tag
        $lines = array_map(fn($l) => trim(strip_tags($l)), $rawLines);

        $creditFacility = [];
        $marketExecution = [];
        $wrongPrice = [];

        // ======================
        // 1) IP PERUSAHAAN
        // ======================            

        $ipPerusahaan = array_map('trim', explode(',', $req->ip_perusahaan));
        $ipCompanyLogs = $this->parseIPPerusahaanFromHTML($file, $ipPerusahaan);

        for ($i = 0; $i < count($lines); $i++) {

            $line = trim($lines[$i]);

            // ======================
            // 2) CREDIT FACILITY
            // ======================

            $parsed = $this->parseCreditFacilityLine($line);
            if ($parsed !== null) {
                $creditFacility[] = $parsed;
            }

            // ==================================================
            // 3) WAKTU EKSEKUSI MARKET  (request → confirm)
            // ==================================================
            if (isset($lines[$i + 1])) {

                $nextLine = trim($lines[$i + 1]);

                if (
                    str_contains(strtolower($line), 'request') &&
                    str_contains(strtolower($nextLine), 'confirm')
                ) {

                    // Ambil timestamp
                    $time1 = $this->extractTime($line);      // request
                    $time2 = $this->extractTime($nextLine);  // confirm
                    $info = $this->extractInfo($line); // dari request line

                    if ($time1 && $time2) {

                        // Konversi ke microsecond timestamp
                        $ts1 = intval($time1->format("U")) * 1_000_000 + intval($time1->format("u"));
                        $ts2 = intval($time2->format("U")) * 1_000_000 + intval($time2->format("u"));

                        // Selisih dalam microdetik
                        $diffMicro = $ts2 - $ts1;

                        // Konversi ke detik float
                        $diffSeconds = $diffMicro / 1_000_000;

                        if ($diffSeconds > 1 && !empty($info['no_tiket'])) {
                            $marketExecution[] = [
                                'no_akun' => $info['no_akun'],
                                'no_tiket' => $info['no_tiket'],
                                'tanggal' => $info['tanggal'],

                                'request_time' => $ts1,
                                'confirm_time' => $ts2,
                                'diff_microseconds' => $diffMicro,
                                'delay_seconds' => $diffSeconds,
                                'delay_formatted' => $this->formatDelay($diffSeconds),

                                'request_raw' => $line,
                                'confirm_raw' => $nextLine,
                            ];
                        }
                    }
                }
            }

            // ==================================================
            // 4) HARGA TIDAK SESUAI  (confirm close → close order)
            // ==================================================
            if (isset($lines[$i + 1])) {

                $line1 = $line;
                $line2 = trim($lines[$i + 1]);

                if (
                    str_contains(strtolower($line1), 'confirm') &&
                    str_contains(strtolower($line1), 'close') &&
                    str_contains(strtolower($line2), 'close order')
                ) {

                    $execType = $this->extractExecType($line1); // buy / sell
                    $completed = $this->extractCompletedPrice($line2);
                    [$bid, $ask] = $this->extractBidAsk($line1);
                    $info = $this->extractInfo($line); // dari request line
                    $no_tiket = $this->extractInfo($line2);

                    $mismatch = false;

                    if ($execType == 'buy' && $completed != $bid) {
                        $mismatch = true;
                    }

                    if ($execType == 'sell' && $completed != $ask) {
                        $mismatch = true;
                    }

                    if ($mismatch && !empty($info['no_tiket'])) {
                        $wrongPrice[] = [
                            'no_akun' => $info['no_akun'],
                            'no_tiket' => $no_tiket['no_tiket'],
                            'tanggal' => $info['tanggal'],
                            'confirm' => $line1,
                            'close_order' => $line2,
                            'exec_type' => $execType,
                            'completed' => $completed,
                            'bid' => $bid,
                            'ask' => $ask
                        ];
                    }
                }
            }
        }

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
            'parsed' => $lines,
            'creditFacility' => $creditFacility,
            'marketExecution' => $marketExecution,
            'wrongPrice' => $wrongPrice,
            'ip_perusahaan' => $ipPerusahaan,
            'ipCompanyLogs' => $ipCompanyLogs,
            'breadcrumbs' => $breadcrumbs
        ]);
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

        return back()->with('success', 'Market Execution berhasil disimpan');
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

        return back()->with('success', 'Wrong Price berhasil disimpan');
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

        return back()->with('success', 'Credit Facility berhasil disimpan');
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

    private function parseIPPerusahaanFromHTML(string $html, array $ipPerusahaan): array
    {
        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        $dom->loadHTML($html);

        $rows = $dom->getElementsByTagName('tr');
        $results = [];

        foreach ($rows as $row) {
            $cols = $row->getElementsByTagName('td');

            if ($cols->length < 3) {
                continue;
            }

            $time = trim($cols->item(0)->textContent);
            $ip   = trim($cols->item(1)->textContent);
            $msg  = trim($cols->item(2)->textContent);

            // Skip baris tanpa IP
            if (!$ip || !filter_var($ip, FILTER_VALIDATE_IP)) {
                continue;
            }

            // Cek IP perusahaan
            if (!in_array($ip, $ipPerusahaan)) {
                continue;
            }

            // Parse tanggal & waktu
            if (!preg_match('/(\d{4}\.\d{2}\.\d{2}) (\d{2}:\d{2}:\d{2})/', $time, $dt)) {
                continue;
            }

            // Ambil no akun jika ada
            $noAkun = null;
            if (preg_match("/'(\d{5,})'/", $msg, $m)) {
                $noAkun = $m[1];
            }

            $results[] = [
                'tanggal' => \Carbon\Carbon::createFromFormat('Y.m.d', $dt[1])->toDateString(),
                'waktu'   => $dt[2],
                'no_akun' => $noAkun,
                'ip'      => $ip,
                'raw'     => $msg,
            ];
        }

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
            (?<type>credit\s+in|credit\s+out)
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
            'credit_in'  => $type === 'credit in'  ? abs($amount) : 0,
            'credit_out' => $type === 'credit out' ? abs($amount) : 0,
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
