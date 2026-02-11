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
            'equity_report' => EquityReport::all(),
            'equity_comparisons' => EquityComparison::all(),
        ]);
    }

    public function create() {}

    public function store(Request $request)
    {
        //
    }

    public function show($equity_report_id)
    {
        $equityComparisons = EquityComparison::with('equityReport')->where('equity_upload_id', $equity_report_id)->get();

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Equity Report', 'url' => route('equity.index')],
            ['label' => 'Detail Report']
        ];

        return view('equity.show', [
            'title' => 'Detail Equity Report',
            'breadcrumbs' => $breadcrumbs,
            'comparisons' => $equityComparisons,
        ]);
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

        $from_date_1 = Carbon::createFromFormat('Y.m.d', $parsed1['from_date']);
        $from_date_2 = Carbon::createFromFormat('Y.m.d', $parsed2['from_date']);

        $susunan_file_berdasarkan_tanggal = $from_date_1 < $from_date_2;

        if ($susunan_file_berdasarkan_tanggal) {
            $equity1 = $parsed1['rows'];       // [login => data]
            $equity2 = $parsed2['rows'];
        } else {
            $equity1 = $parsed2['rows'];       // [login => data]
            $equity2 = $parsed1['rows'];
        }

        // ==================================================
        // 3️⃣ SIMPAN METADATA UPLOAD (OPSIONAL)
        // ==================================================
        // $upload = EquityReport::create([
        //     'file_1_name' => $file1->getClientOriginalName(),
        //     'file_2_name' => $file2->getClientOriginalName(),
        //     'periode_1' => $from_date_1,
        //     'periode_2' => $from_date_2,
        // ]);

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

            $periode_1 = $row1['periode'] ?? null;
            $periode_2 = $row2['periode'] ?? null;

            $floating_pl1 = $row1['floating_pl'] ?? null;
            $floating_pl2 = $row2['floating_pl'] ?? null;

            $deposit_1 = $row1['deposit'] ?? null;
            $deposit_2 = $row2['deposit'] ?? null;

            $credit_1 = $row1['credit'] ?? null;
            $credit_2 = $row2['credit'] ?? null;

            // 🔴 SKIP jika tidak lengkap
            if ($val1 === null || $val2 === null) {
                continue;
            }

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
            } elseif ($val1 < 0 || $val2 < 0) {
                $status = 'MINUS';
            } else {
                $status = 'TURUN';
            }

            // 🔴 FILTER TAMPILAN
            $bolehTampil =
                $status === 'SAMA' || $status === 'MINUS'
                || $status === 'TIDAK LENGKAP' || $status === 'NAIK' || $status === 'TURUN' || ($status === 'TURUN' && $val2 < 0);

            if (!$bolehTampil) {
                continue;
            }

            // ✅ HANYA YANG SAMA MASUK SINI
            $comparison[] = [
                'login'        => $login,
                'name'         => $row1['name'] ?? $row2['name'] ?? '-',
                'deposit_1'      => $deposit_1,
                'deposit_2'      => $deposit_2,
                'credit_1'      => $credit_1,
                'credit_2'      => $credit_2,
                'currency'   => $row1['currency'] ?? $row2['currency'] ?? '-',
                'equity_1' => $val1,
                'equity_2' => $val2,
                'periode_1'    => $periode_1,
                'periode_2'    => $periode_2,
                'floating_pl1' => $floating_pl1,
                'floating_pl2' => $floating_pl2,
                'selisih'      => $val2 - $val1,
                'status'       => $status
            ];
        }

        // dd($comparison);

        usort($comparison, function ($a, $b) {
            $priority = ['SAMA' => 1, 'MINUS' => 2, 'TURUN' => 3, 'NAIK' => 4, 'TIDAK LENGKAP' => 5];
            return $priority[$a['status']] <=> $priority[$b['status']];
        });

        session([
            'parsed_equity' => $comparison,
            'file_1_name' => $file1->getClientOriginalName(),
            'file_2_name' => $file2->getClientOriginalName(),
            'periode_1' => $parsed1['from_date'] ?? null,
            'periode_2' => $parsed2['from_date'] ?? null,
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
        $file_1_name = session('file_1_name');
        $file_2_name = session('file_2_name');
        $periode_1 = session('periode_1', null);
        $periode_2 = session('periode_2', null);

        $upload = EquityReport::create([
            'file_1_name' => $file_1_name,
            'file_2_name' => $file_2_name,
            'periode_1' => $periode_1,
            'periode_2' => $periode_2,
        ]);

        foreach ($rows as $row) {
            EquityComparison::create([
                'equity_upload_id' => $upload->id,
                'login'           => $row['login'],
                'name'            => $row['name'],
                'equity_old'       => $row['equity_1'],
                'equity_new'       => $row['equity_2'],
                'floating_pl_old'  => $row['floating_pl1'] ?? null,
                'floating_pl_new'  => $row['floating_pl2'] ?? null,
                'credit_old'       => $row['credit_1'] ?? null,
                'credit_new'       => $row['credit_2'] ?? null,
                'deposit_old'      => $row['deposit_1'] ?? null,
                'deposit_new'      => $row['deposit_2'] ?? null,
                'selisih'          => $row['selisih'],
                'satuan'         => $row['currency'],
                'status'           => $row['status'],
            ]);
        }

        return back()->with('success', 'Perbandingan Equity berhasil disimpan');
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

    private function parseEquityReport(string $html): array
    {
        $data = [
            'periode' => null,
            'from_date' => null,
            'to_date' => null,
            'rows'    => []
        ];

        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);

        // ==================================================
        // 1️⃣ PARSE PERIODE / TAHUN
        // ==================================================
        $trs = $xpath->query('//tr');

        foreach ($trs as $tr) {
            $text = trim(preg_replace('/\s+/', ' ', $tr->textContent));

            /**
             * Cocok untuk:
             * from 2025.01.01 to 2025.01.01
             * from '2024.03.14' to '2024.03.14'
             */
            if (preg_match(
                "/from\s+'?(\d{4}\.\d{2}\.\d{2})'?\s+to\s+'?(\d{4}\.\d{2}\.\d{2})'?/i",
                $text,
                $m
            )) {
                $data['from_date'] = $m[1]; // 2025.01.01
                $data['to_date']   = $m[2]; // 2025.01.01
                $data['periode']   = substr($m[1], 0, 4); // ambil tahun
                break;
            }
        }

        // ==================================================
        // 2️⃣ PARSE DATA EQUITY
        // ==================================================
        $rows = $xpath->query('//tr');

        $headerMap = [];
        $data['rows'] = [];

        foreach ($rows as $row) {

            $cells = $xpath->query('./td', $row);
            if ($cells->length < 5) continue;

            // ============================
            // 1️⃣ DETEKSI HEADER
            // ============================
            if (empty($headerMap)) {
                $tmp = [];

                foreach ($cells as $i => $cell) {
                    $col = $this->normalizeHeader($cell->textContent);
                    if ($col !== '') {
                        $tmp[$col] = $i;
                    }
                }

                // Wajib punya login & equity
                if (isset($tmp['login']) && isset($tmp['equity'])) {
                    $headerMap = $tmp;
                }

                continue;
            }

            // ============================
            // 2️⃣ DATA ROW
            // ============================
            $loginIndex = $headerMap['login'];
            $login = trim($cells->item($loginIndex)->textContent);

            if (!preg_match('/^\d{7,9}$/', $login)) {
                continue;
            }

            $get = function ($key) use ($cells, $headerMap) {
                if (!isset($headerMap[$key])) return null;
                return $this->parseNumber(
                    $cells->item($headerMap[$key])->textContent ?? null
                );
            };

            $getText = function ($key) use ($cells, $headerMap) {
                if (!isset($headerMap[$key])) return null;
                return trim($cells->item($headerMap[$key])->textContent);
            };

            $data['rows'][$login] = [
                'login'        => $login,
                'name'         => $getText('name'),
                'pl_balance'   => $get('pl_balance'),
                'closed_pl'    => $get('closed_pl'),
                'deposit'      => $get('deposit'),
                'balance'      => $get('balance'),
                'floating_pl'  => $get('floating_pl'),
                'credit'       => $get('credit'),
                'equity'       => $get('equity'),
                'margin'       => $get('margin'),
                'free_margin'  => $get('free_margin'),
                'currency'     => $getText('currency'),
            ];
        }

        return $data;
    }

    private function normalizeHeader(string $text): string
    {
        $text = strtolower(trim($text));
        $text = str_replace(['/', ' '], '_', $text);
        $text = preg_replace('/_+/', '_', $text);

        return match ($text) {
            'login' => 'login',
            'name', 'group' => 'name',
            'deposit' => 'deposit',
            'credit' => 'credit',
            'commission' => 'commission',
            'swap' => 'swap',
            'profit' => 'profit',
            'interest' => 'interest',
            'balance' => 'balance',
            'floating_pl', 'floating_p_l' => 'floating_pl',
            'equity' => 'equity',
            'margin' => 'margin',
            'free_margin' => 'free_margin',
            'currency', 'bank' => 'currency',
            'pl_balance' => 'pl_balance',
            'closed_pl' => 'closed_pl',
            default => ''
        };
    }

    private function parseNumber($value): ?float
    {
        if ($value === null) {
            return null;
        }

        // Trim + normalisasi spasi (termasuk &nbsp;)
        $value = trim($value);
        $value = str_replace(["\xc2\xa0", ' '], '', $value);

        // Handle format (49.61) => -49.61
        if (preg_match('/^\(([\d.]+)\)$/', $value, $m)) {
            return -(float) $m[1];
        }

        // Hapus tanda + jika ada
        $value = ltrim($value, '+');

        // Validasi angka (negatif & desimal)
        if (!is_numeric($value)) {
            return null;
        }

        return (float) $value;
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
