<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Http\Requests\StoreBukuRequest;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    public function index()
    {
        $data = Buku::get();
        return view('buku.index', compact('data'));
    }

    public function create()
    {
        $kategori = Kategori::all();

        return view('buku.form', compact('kategori'));
    }

    public function store(StoreBukuRequest $request)
    {

        DB::beginTransaction();
        try{
            Buku::create($request->all());
            DB::Commit();

            return redirect('buku')->with('success', 'Data berhasil disimpan!');
        } catch (Exception | PDOException $e) {
            DB::rollBack();
            return redirect()->with('error');
            return $this->failResponse($e->getMessage(),
            $e->getCode());
        }
    }

    public function show(Buku $buku)
    {
        //
    }

    public function edit(Buku $buku)
    {
        $kategori = Kategori::all();
        return view('buku.form_edit', compact('buku', 'kategori'));
    }

    public function update(StoreBukuRequest $request, Buku $buku)
    {
        DB::beginTransaction();
        try{
        $buku->update([
            'kode_buku'   => $request->kode_buku,
            'id_kategori' => $request->id_kategori,
            'judul'       => $request->judul,
            'penulis'     => $request->penulis,
            'penerbit'    => $request->penerbit,
            'tahun'       => $request->tahun,
        ]);

        DB::commit();
        return redirect('buku')->with('success', 'Data berhasi diupdate');
        } catch (Exception | PDOException $e) {
            DB::rollBack();
            return redirect('buku')->with('error', $e->getMessage());
        }
    }

    public function destroy(Buku $buku)
    {
        try {
            $buku->delete();
            return redirect('buku')->with('success', 'Data berhasil dihapus');
        } catch (Exception | PDOException $e) {
            return redirect('buku')->with('error', $e->getMessage());
        }
    }
}