<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
        public function index()
    {
        $user = Auth::user(); // Mengambil data user yang sedang login

        // Anda bisa menambahkan logika untuk mengambil data spesifik di sini
        // Contoh:
        // if ($user->role == 'admin') {
        //     $data = // Ambil data khusus admin
        // } else {
        //     $data = // Ambil data khusus SKPD
        // }
        
        // Cukup tampilkan view yang sama untuk kedua role
        return view('admin.dashboard'); 
    }

}
