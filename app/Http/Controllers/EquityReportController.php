<?php

namespace App\Http\Controllers;

use App\Models\EquityReport;
use Illuminate\Http\Request;

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

    public function uploadEquityReport(Request $req)
    {
        $req->validate([
            'file' => 'required|mimes:htm,html,txt'
        ]);

        $lines = array_map(
            fn($l) => trim(strip_tags($l)),
            explode("\n", $req->file('file')->get())
        );

        $rows = [];

        foreach ($lines as $line) {

            // skip header / kosong
            if (!preg_match('/^\d+\s+/', $line)) continue;

            $parsed = $this->parseEquityLine($line);
            if (!$parsed) continue;

            $parsed['margin_level'] = $this->calcMarginLevel(
                $parsed['equity'],
                $parsed['margin']
            );

            $parsed['risk_status'] = $this->detectEquityRisk($parsed);

            $rows[] = $parsed;
        }

        session(['parsed_equity' => $rows]);

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Equity Report', 'url' => route('equity.index')],
            ['label' => 'Upload'],
            ['label' => 'Result']
        ];

        return view('equity.result', compact('rows', 'breadcrumbs'));
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
