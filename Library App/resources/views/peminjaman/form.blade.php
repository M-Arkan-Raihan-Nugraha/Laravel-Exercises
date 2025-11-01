@extends('templates.layout')

@section('content')
<div class="card">
  <div class="card-header"><h3>Tambah Data</h3></div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
      </div>
    @endif

    <form action="{{ route('peminjaman.store') }}" method="POST">
      @csrf

      <div class="form-group mb-2">
        <label for="id_anggota">Anggota</label>
        <select name="id_anggota" class="form-select" required>
          <option value="">-- Pilih Anggota --</option>
          @foreach($anggota as $a)
            <option value="{{ $a->id }}" {{ old('id_anggota') == $a->id ? 'selected' : '' }}>
              {{ $a->nama }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="form-group mb-2">
        <label for="kode_buku">Buku</label>
        <select name="kode_buku" class="form-select" required>
          <option value="">-- Pilih Buku --</option>
          @foreach($buku as $b)
            <option value="{{ $b->kode_buku }}" {{ old('kode_buku') == $b->kode_buku ? 'selected' : '' }}>
              {{ $b->judul }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="form-group mb-3">
        <label>Tanggal Pinjam</label>
        <input type="date" name="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam') }}" required>
      </div>

      <div class="form-group mb-3">
        <label>Tanggal Kembali</label>
        <input type="date" name="tanggal_kembali" class="form-control" value="{{ old('tanggal_kembali') }}" required>
      </div>

      <div class="form-group mb-3">
        <label>Status</label>
        <select name="status" class="form-select" required>
          <option value="">-- Pilih Status --</option>
          <option value="Dipinjam" {{ old('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
          <option value="Dikembalikan" {{ old('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>
@endsection