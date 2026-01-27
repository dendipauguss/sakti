<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JournalCreditFacility;

class JournalCreditFacilityController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Journal', 'url' => route('journal.index')],
            ['label' => 'Credit Facility']
        ];

        return view('journal.credit_facility.index', [
            'title' => 'Credit Facility',
            'breadcrumbs' => $breadcrumbs,
            'credit_facility' => JournalCreditFacility::all()
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
