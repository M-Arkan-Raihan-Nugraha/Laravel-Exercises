<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Http\Requests\StoreKategoriRequest;
use Illuminate\Support\Facades\DB;
use Exception;
use PDOException;

class KategoriController extends Controller
{
    public function index()
    {
        $data = Kategori::get();
        return view('kategori.index', compact('data'));
    }

    public function create()
    {
        return view('kategori.form');
    }

    public function store(StoreKategoriRequest $request)
    {
        DB::beginTransaction();
        try {
            Kategori::create($request->all());
            DB::commit();

            return redirect('kategori')->with('success', 'Data berhasil disimpan!');
        } catch (Exception | PDOException $e) {
            DB::rollBack();
            return redirect('kategori')->with('error', $e->getMessage());
        }
    }

    public function edit(Kategori $kategori)
    {
        $listKategori = Kategori::all();
        return view('kategori.form_edit', compact('kategori', 'listKategori'));
    }

    public function update(StoreKategoriRequest $request, Kategori $kategori)
    {
        DB::beginTransaction();
        try {
            $kategori->update([
                'kode_kategori' => $request->kode_kategori,
                'nama_kategori' => $request->nama_kategori,
            ]);

            DB::commit();
            return redirect('kategori')->with('success', 'Data berhasil diupdate!');
        } catch (Exception | PDOException $e) {
            DB::rollBack();
            return redirect('kategori')->with('error', $e->getMessage());
        }
    }

    public function destroy(Kategori $kategori)
    {
        try {
            $kategori->delete();
            return redirect('kategori')->with('success', 'Data berhasil dihapus!');
        } catch (Exception | PDOException $e) {
            return redirect('kategori')->with('error', $e->getMessage());
        }
    }
}