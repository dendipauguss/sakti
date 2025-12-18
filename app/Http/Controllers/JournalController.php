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
use Carbon\Carbon;

class JournalController extends Controller
{
    public function index()
    {
        return view('journal.index', [
            'title' => 'Dashboard Journal',
            'waktu_eksekusi_market' => JournalMarketExecution::all()
        ]);
    }

    // =============== UPLOAD PAGE ===============
    public function uploadPage()
    {
        return view('journal.upload', [
            'title' => 'Upload Journal Report'
        ]);
    }

    // =============== PROCESS FILE ===============
    public function uploadProcess(Request $req)
    {
        $req->validate([
            'file' => 'required|mimes:htm,html,txt'
        ]);

        $file = $req->file('file')->get();
        $rawLines = explode("\n", $file);

        // Clean html tag
        $lines = array_map(fn($l) => trim(strip_tags($l)), $rawLines);

        $creditFacility = [];
        $marketExecution = [];
        $wrongPrice = [];

        for ($i = 0; $i < count($lines); $i++) {

            $line = trim($lines[$i]);

            // ======================
            // 1) CREDIT FACILITY
            // ======================
            if (preg_match('/credit|credit in|credit out/i', $line)) {
                $creditFacility[] = $line;
            }

            // ==================================================
            // 2) WAKTU EKSEKUSI MARKET  (request → confirm)
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
            // 3) HARGA TIDAK SESUAI  (confirm close → close order)
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

                    $mismatch = false;

                    if ($execType == 'buy' && $completed != $bid) {
                        $mismatch = true;
                    }

                    if ($execType == 'sell' && $completed != $ask) {
                        $mismatch = true;
                    }

                    if ($mismatch) {
                        $wrongPrice[] = [
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
        ]);

        return view('journal.result', [
            'title' => 'Hasil Parsing Journal',
            'parsed' => $lines,
            'creditFacility' => $creditFacility,
            'marketExecution' => $marketExecution,
            'wrongPrice' => $wrongPrice,
        ]);
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

        return redirect()->route('journal.index')->with('success', 'Market Execution berhasil disimpan');
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
                'tanggal'           => $row['tanggal'],
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

        foreach ($rows as $line) {
            JournalCreditFacility::create([
                'journal_upload_id' => $upload->id,
                'no_akun' => $this->extractNoAkun($line),
                'tanggal' => $this->extractTanggal($line),
                'type'    => str_contains(strtolower($line), 'credit in')
                    ? 'credit in'
                    : 'credit out',
                'raw_line' => $line
            ]);
        }

        return back()->with('success', 'Credit Facility berhasil disimpan');
    }

    // =====================================================
    // ⭐ HELPER FUNCTIONS
    // =====================================================

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
