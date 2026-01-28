<?php

namespace App\Http\Controllers;

use App\Models\JournalIPPerusahaan;
use Illuminate\Http\Request;

class JournalIPPerusahaanController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Journal Report', 'url' => route('journal.index')],
            ['label' => 'IP Perusahaan', 'url' => route('ip-perusahaan.index')],
        ];

        return view('journal.ip_perusahaan.index', [
            'ip_perusahaan' => JournalIPPerusahaan::all(),
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(JournalIPPerusahaan $journalIPPerusahaan)
    {
        //
    }

    public function edit(JournalIPPerusahaan $journalIPPerusahaan)
    {
        //
    }

    public function update(Request $request, JournalIPPerusahaan $journalIPPerusahaan)
    {
        //
    }

    public function destroy(JournalIPPerusahaan $journalIPPerusahaan)
    {
        //
    }
}
