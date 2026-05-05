<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfesseurDashboardController extends Controller
{
    public function index()
    {
        return view('professeur.dashboard');
    }
}
