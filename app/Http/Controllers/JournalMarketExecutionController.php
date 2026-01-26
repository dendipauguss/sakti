<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JournalMarketExecution;

class JournalMarketExecutionController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['label' => 'Journal', 'url' => route('journal.index')],
            ['label' => 'Market Execution']
        ];

        return view('journal.market_execution.index', [
            'title' => 'Market Execution',
            'breadcrumbs' => $breadcrumbs,
            'market_execution' => JournalMarketExecution::all()
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

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
