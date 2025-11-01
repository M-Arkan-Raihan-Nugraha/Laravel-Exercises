<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->string('kode_buku')->primary();
            $table->unsignedBigInteger('id_kategori');
            $table->string("judul", 50);
            $table->string("penulis", 50);
            $table->string("penerbit", 50);
            $table->year("tahun");
            $table->timestamps();
            $table->foreign('id_kategori')->references('id')->on('kategori')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
