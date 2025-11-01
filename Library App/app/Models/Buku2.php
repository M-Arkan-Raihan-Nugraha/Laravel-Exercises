<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku2 extends Model
{
    protected $table = "buku";
    protected $primaryKey = "kode_buku"; // primary key tabel
    public $incrementing = false; // kalau kode_buku bukan auto increment
    protected $keyType = 'string'; // kalau kode_buku tipe string

    protected $fillable = ['kode_buku', 'id_kategori','judul', 'penulis', 'penerbit', 'tahun'];
    public function kategori(){
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}   
