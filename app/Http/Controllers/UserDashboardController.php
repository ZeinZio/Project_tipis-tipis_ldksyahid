<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Nanti kita akan tambahkan logic pengecekan ATS dan skor CV di sini
        $cvScore = 0; // Dummy
        $portfolioCount = 0; // Dummy
        $isVerified = false; // Dummy, nanti akan dicek oleh Admin khusus
        
        $title = 'Dashboard Aku';
        
        return view('dashboard.user.index', compact('user', 'cvScore', 'portfolioCount', 'isVerified', 'title'));
    }
}
