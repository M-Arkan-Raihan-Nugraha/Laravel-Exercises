<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use App\Http\Requests\StorePeminjamanRequest;
use Illuminate\Support\Facades\DB;
use Exception;
use PDOException;

class PeminjamanController extends Controller
{
    public function index()
    {
        $data = Peminjaman::all();
        return view('peminjaman.index', compact('data'));
    }

    public function create()
    {
        $anggota = Anggota::all();
        $buku = Buku::all();

        return view('peminjaman.form', compact('anggota', 'buku'));
    }

    public function store(StorePeminjamanRequest $request)
    {
       
        DB::beginTransaction();
        try {
            
            Peminjaman::create($request->all());
            DB::commit();

            return redirect('peminjaman')->with('success', 'Data berhasil disimpan!');
        } catch (Exception | PDOException $e) {
            DB::rollBack();
            return redirect('peminjaman')->with('error', $e->getMessage());
        }
    }

    public function edit(Peminjaman $peminjaman)
    {
        return view('peminjaman.form_edit', compact('peminjaman'));
    }

    public function update(StorePeminjamanRequest $request, Peminjaman $peminjaman)
    {
        DB::beginTransaction();
        try {
            $peminjaman->update($request->only(['tanggal_pinjam', 'tanggal_kembali', 'status']));
            DB::commit();
            return redirect('peminjaman')->with('success', 'Data berhasil diupdate!');
        } catch (Exception | PDOException $e) {
            DB::rollBack();
            return redirect('peminjaman')->with('error', $e->getMessage());
        }
    }

    public function destroy(Peminjaman $peminjaman)
    {
        try {
            $peminjaman->forceDelete();
            return redirect('peminjaman')->with('success', 'Data berhasil dihapus!');
        } catch (Exception | PDOException $e) {
            return redirect('peminjaman')->with('error', $e->getMessage());
        }
    }
}