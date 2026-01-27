<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JournalWrongPrice;

class JournalWrongPriceController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Journal', 'url' => route('journal.index')],
            ['label' => 'Wrong Price']
        ];

        return view('journal.wrong_price.index', [
            'title' => 'Harga Tidak Sesuai',
            'breadcrumbs' => $breadcrumbs,
            'harga_tidak_sesuai' => JournalWrongPrice::all()
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
