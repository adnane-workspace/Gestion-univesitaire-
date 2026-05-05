<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EtudiantDashboardController extends Controller
{
    public function index()
    {
        return view('etudiant.dashboard');
    }
}
