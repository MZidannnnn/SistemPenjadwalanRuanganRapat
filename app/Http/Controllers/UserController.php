<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    //
    /**
     * Menampilkan halaman daftar semua ruangan.
     */
    public function index()
    {
        // Mengambil semua data dari tabel 'ruangan'
        $users = User::all();

        // Mengirim data ke view
        return view('pages.user', ['users' => $users]);
    }
}
