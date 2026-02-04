<?php

namespace App\Http\Controllers;

use App\Models\EquityReport;
use App\Models\EquityComparison;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EquityReportController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Equity Report']
        ];

        return view('equity.index', [
            'title' => 'Dashboard Equity',
            'breadcrumbs' => $breadcrumbs,
            'equity_report' => EquityReport::all()
        ]);
    }

    public function create() {}

    public function store(Request $request)
    {
        //
    }

    public function show(EquityReport $equityReport)
    {
        //
    }

    public function edit(EquityReport $equityReport)
    {
        //
    }

    public function update(Request $request, EquityReport $equityReport)
    {
        //
    }

    public function destroy(EquityReport $equityReport)
    {
        //
    }

    public function upload()
    {
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Equity Report', 'url' => route('equity.index')],
            ['label' => 'Upload']
        ];

        return view('equity.upload', [
            'title' => 'Upload Equity Report',
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function uploadProcessEquity(Request $req)
    {
        $req->validate([
            'equity_file_1' => 'required|mimes:htm,html',
            'equity_file_2' => 'required|mimes:htm,html',
        ]);

        // AMBIL FILE EQUITY REPORT
        $file1 = $req->file('equity_file_1');
        $file2 = $req->file('equity_file_2');

        $html1 = $file1->get();
        $html2 = $file2->get();

        // Parse masing-masing file → [login => equity]
        $parsed1 = $this->parseEquityReport($html1);
        $parsed2 = $this->parseEquityReport($html2);

        $periode1 = $parsed1['periode'];   // contoh: 2024
        $periode2 = $parsed2['periode'];   // contoh: 2025

        $equity1 = $parsed1['rows'];       // [login => data]
        $equity2 = $parsed2['rows'];

        // ==================================================
        // 3️⃣ SIMPAN METADATA UPLOAD (OPSIONAL)
        // ==================================================
        $upload = EquityReport::create([
            'file_1_name' => $file1->getClientOriginalName(),
            'file_2_name' => $file2->getClientOriginalName(),
            'periode_1'   => $periode1,
            'periode_2'   => $periode2,
        ]);

        $comparison = [];

        // Gabungkan semua login dari dua file
        $logins = array_unique(array_merge(
            array_keys($equity1),
            array_keys($equity2)
        ));


        foreach ($logins as $login) {

            $row1 = $equity1[$login] ?? null;
            $row2 = $equity2[$login] ?? null;

            $val1 = $row1['equity'] ?? null;
            $val2 = $row2['equity'] ?? null;

            $periode_1 = $row['periode_1'] ?? null;
            $periode_2 = $row['periode_2'] ?? null;

            // // 🔴 SKIP jika tidak lengkap
            // if ($val1 === null || $val2 === null) {
            //     continue;
            // }

            // // 🔴 SKIP jika TIDAK SAMA
            // if ($val1 != $val2) {
            //     continue;
            // }

            if ($val1 === null || $val2 === null) {
                $status = 'TIDAK LENGKAP';
            } elseif ($val1 == $val2) {
                $status = 'SAMA';
            } elseif ($val2 > $val1) {
                $status = 'NAIK';
            } else {
                $status = 'TURUN';
            }

            // ✅ HANYA YANG SAMA MASUK SINI
            $comparison[] = [
                'login'        => $login,
                'name'         => $row1['name'] ?? $row2['name'] ?? '-',
                'equity_file1' => $val1,
                'equity_file2' => $val2,
                'periode_1'    => $periode_1,
                'periode_2'    => $periode_2,
                'selisih'      => 0,
                'status'       => $status,
            ];
        }

        // dd($comparison);

        $statusPriority = [
            'SAMA' => 1,
            'NAIK' => 2,
            'TURUN' => 3,
            'TIDAK LENGKAP' => 4,
        ];

        usort($comparison, function ($a, $b) use ($statusPriority) {
            return ($statusPriority[$a['status']] ?? 99)
                <=> ($statusPriority[$b['status']] ?? 99);
        });

        session([
            'parsed_equity' => $comparison
        ]);

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Equity Report', 'url' => route('equity.index')],
            ['label' => 'Hasil Upload']
        ];

        return view('equity.result', [
            'title'      => 'Perbandingan Equity Report',
            'comparison' => $comparison,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function saveComparison()
    {
        $rows = session('parsed_equity', []);

        $upload = EquityReport::create([
            'file_1_name' => 'equity_report_1' . now()->format('Ymd_His'),
            'file_2_name' => 'equity_report_2' . now()->format('Ymd_His'),
            'periode_1' => now()->format('Y'),
        ]);

        foreach ($rows as $row) {
            EquityComparison::create([
                'equity_upload_id' => $upload->id,
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

    private function mergeEquityReports(array $reportA, array $reportB): array
    {
        $logins = array_unique(
            array_merge(array_keys($reportA), array_keys($reportB))
        );

        $result = [];

        foreach ($logins as $login) {
            $result[$login] = [
                'equity_a' => $reportA[$login] ?? null,
                'equity_b' => $reportB[$login] ?? null,
            ];
        }

        return $result;
    }

    private function parseNumber(string $value): float
    {
        return (float) str_replace(' ', '', trim($value));
    }

    private function parseEquityReport(string $html): array
    {
        $data = [
            'periode' => null,
            'rows'    => []
        ];

        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        $dom->loadHTML($html);

        $xpath = new \DOMXPath($dom);

        // ==================================================
        // 1️⃣ PARSE PERIODE / TAHUN
        // ==================================================
        $ths = $xpath->query('//th');

        foreach ($ths as $th) {
            $text = trim($th->textContent);

            // Ambil dari: from '2024.03.14'
            if (preg_match("/from\s+'(\d{4})\.\d{2}\.\d{2}'/", $text, $m)) {
                $data['periode'] = $m[1]; // 2024
                break;
            }

            // (opsional) fallback dari: SPA Maret 2024
            if (preg_match("/SPA\s+.+?\s+(\d{4})/", $text, $m)) {
                $data['periode'] = $m[1];
                break;
            }
        }

        // ==================================================
        // 2️⃣ PARSE DATA EQUITY
        // ==================================================
        $rows = $xpath->query('//tr');

        foreach ($rows as $row) {

            $cells = $xpath->query('.//td', $row);

            if ($cells->length !== 12) {
                continue;
            }

            $login = trim($cells->item(0)->textContent);
            if (!is_numeric($login)) continue;

            $data['rows'][$login] = [
                'login'       => $login,
                'name'        => trim($cells->item(1)->textContent),
                'deposit'     => $this->parseNumber($cells->item(2)->textContent),
                'credit'      => $this->parseNumber($cells->item(3)->textContent),
                'commission'  => $this->parseNumber($cells->item(4)->textContent),
                'swap'        => $this->parseNumber($cells->item(5)->textContent),
                'profit'      => $this->parseNumber($cells->item(6)->textContent),
                'interest'    => $this->parseNumber($cells->item(7)->textContent),
                'balance'     => $this->parseNumber($cells->item(8)->textContent),
                'floating_pl' => $this->parseNumber($cells->item(9)->textContent),
                'equity'      => $this->parseNumber($cells->item(10)->textContent),
                'currency'    => trim($cells->item(11)->textContent),
            ];
        }

        return $data;
    }

    private function parseEquityLine(string $line): ?array
    {
        // Contoh:
        // 36311087 TRFX.std 10000.00 0.00 8500.00 9000.00 -500.00 -1500.00

        preg_match('/
        (?<akun>\d+)\s+
        (?<group>\S+)\s+
        (?<balance>-?[\d\.]+)\s+
        (?<credit>-?[\d\.]+)\s+
        (?<equity>-?[\d\.]+)\s+
        (?<margin>-?[\d\.]+)\s+
        (?<free_margin>-?[\d\.]+)\s+
        (?<floating>-?[\d\.]+)
    /x', $line, $m);

        if (!$m) return null;

        return [
            'no_akun'     => $m['akun'],
            'group'       => $m['group'],
            'balance'     => (float)$m['balance'],
            'credit'      => (float)$m['credit'],
            'equity'      => (float)$m['equity'],
            'margin'      => (float)$m['margin'],
            'free_margin' => (float)$m['free_margin'],
            'floating_pl' => (float)$m['floating'],
            'report_date' => now()->toDateString(),
        ];
    }

    private function calcMarginLevel($equity, $margin)
    {
        if ($margin <= 0) return null;
        return round(($equity / $margin) * 100, 2);
    }

    private function detectEquityRisk(array $r): string
    {
        // STOP OUT
        if ($r['equity'] <= $r['margin'] || $r['free_margin'] <= 0) {
            return 'STOP_OUT';
        }

        // MARGIN CALL
        if ($r['margin_level'] !== null && $r['margin_level'] <= 100) {
            return 'MARGIN_CALL';
        }

        return 'NORMAL';
    }
}
