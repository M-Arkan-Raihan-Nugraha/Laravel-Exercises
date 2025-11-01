<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Anggota;
use App\Models\Peminjaman;

class HomeController extends Controller
{
    public function index()
    {
        $jumlah_buku = Buku::count();
        $jumlah_kategori = Kategori::count();
        $jumlah_anggota = Anggota::count();
        $jumlah_peminjaman = Peminjaman::count();
        
        return view('home', compact(
            'jumlah_buku',
            'jumlah_kategori',
            'jumlah_anggota',
            'jumlah_peminjaman',
        ));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}
