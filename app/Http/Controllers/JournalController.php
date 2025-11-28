<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JournalController extends Controller
{
    // =============== UPLOAD PAGE ===============
    public function uploadPage()
    {
        return view('journal.upload');
    }

    // =============== PROCESS FILE ===============
    public function uploadProcess(Request $req)
    {
        $req->validate([
            'file' => 'required|mimes:htm,html,txt'
        ]);

        $file = $req->file('file')->get();
        $lines = explode("\n", $file);

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
                    $time1 = $this->extractTime($line);
                    $time2 = $this->extractTime($nextLine);

                    if ($time1 && $time2) {
                        $diff = $time2->getTimestamp() - $time1->getTimestamp();

                        if ($diff > 1) {
                            $marketExecution[] = [
                                'request' => $line,
                                'confirm' => $nextLine,
                                'delay_seconds' => $diff
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

        return view('journal.result', [
            'parsed' => $lines,
            'creditFacility' => $creditFacility,
            'marketExecution' => $marketExecution,
            'wrongPrice' => $wrongPrice,
        ]);
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
}
