<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Http\Requests\StoreAnggotaRequest;
use Illuminate\Support\Facades\DB;
use Exception;
use PDOException;

class AnggotaController extends Controller
{
    public function index()
    {
        $data = Anggota::all();
        return view('anggota.index', compact('data'));
    }

    public function create()
    {
        return view('anggota.form');
    }

    public function store(StoreAnggotaRequest $request)
    {
        DB::beginTransaction();
        try {
            
            Anggota::create([
                'nama' => $request->nama,
                'jk' => $request->jk,
                'alamat' => $request->alamat
            ]);

            DB::commit();
            return redirect('anggota')->with('success', 'Data berhasil disimpan!');
        } catch (Exception | PDOException $e) {
            DB::rollBack();
            return redirect('anggota')->with('error', $e->getMessage());
        }
    }

    public function edit(Anggota $anggota)
    {
        return view('anggota.form_edit', compact('anggota'));
    }

    public function update(StoreAnggotaRequest $request, Anggota $anggota)
    {
        DB::beginTransaction();
        try {
            $anggota->update($request->only(['nama', 'jk', 'alamat']));
            DB::commit();
            return redirect('anggota')->with('success', 'Data berhasil diupdate!');
        } catch (Exception | PDOException $e) {
            DB::rollBack();
            return redirect('anggota')->with('error', $e->getMessage());
        }
    }

    public function destroy(Anggota $anggota)
    {
        try {
            $anggota->forceDelete();
            return redirect('anggota')->with('success', 'Data berhasil dihapus!');
        } catch (Exception | PDOException $e) {
            return redirect('anggota')->with('error', $e->getMessage());
        }
    }
}