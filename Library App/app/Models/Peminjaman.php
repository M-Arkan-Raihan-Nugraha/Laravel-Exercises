<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = "peminjaman";
    protected $fillable = [
        'id_anggota',
        'kode_buku',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status'
    ];

    public function anggota(){
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }
    
    public function buku() {
    return $this->belongsTo(Buku::class, 'kode_buku');
}
}
