<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Shows the dashboard page
     * @return view
     */
    public function __invoke()
    {
        return view('dashboard');
    }
}
