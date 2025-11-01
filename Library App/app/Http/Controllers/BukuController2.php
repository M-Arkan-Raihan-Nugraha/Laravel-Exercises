<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori; // tambahkan ini

class BukuControllerr extends Controller
{
    public function store(Request $request)
    {
        Buku::create($request->all());
        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function index()
    {
        $data = Buku::all();
        return view('buku.index', compact('data'));
    }

    public function create()
    {
        // ambil semua kategori dari tabel kategori
        $kategori = Kategori::all();

        // kirim ke form
        return view('buku.form', compact('kategori'));
    }
    public function destroy($id){
        $buku = \App\Models\Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }
    public function edit($kode_buku){
        $buku = Buku::findOrFail($kode_buku);
        $kategori = Kategori::all();
        return view('buku.form_edit', compact('buku', 'kategori'));
    }
    public function update(Request $request, $kode_buku){
        $buku = Buku::findOrFail($kode_buku);
        $buku->update($request->all());
        return redirect()->route('buku.index')->with('success', 'Buku berhasil diupdate!');
    }


}
