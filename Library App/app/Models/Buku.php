<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = "buku";
    protected $primaryKey = "kode_buku";
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_buku',
        'id_kategori',
        'judul',
        'penulis',
        'penerbit',
        'tahun'
    ];
    public function kategori(){
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}   
