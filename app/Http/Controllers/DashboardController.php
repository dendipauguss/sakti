<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Dashboard']
        ];

        return view('dashboard', [
            'title' => 'Dashboard',
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}
