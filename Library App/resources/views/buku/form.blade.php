@extends('templates.layout')

@section('content')
<div class="card">
  <div class="card-header">
    <h3>Tambah Buku</h3>
  </div>
  <div class="card-body">

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('buku.store') }}" method="POST">
      @csrf

      <div class="form-group mb-2">
        <label for="kode_buku">Kode Buku</label>
        <input type="text" name="kode_buku" class="form-control" value="{{ old('kode_buku') }}" required>
      </div>

      <div class="form-group mb-2">
        <label for="id_kategori">Kategori</label>
        <select name="id_kategori" class="form-select" required>
          <option value="">-- Pilih Kategori --</option>
          @foreach($kategori as $k)
            <option value="{{ $k->id }}" {{ old('id_kategori') == $k->id ? 'selected' : '' }}>
              {{ $k->nama_kategori }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="form-group mb-2">
        <label for="judul">Judul</label>
        <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
      </div>

      <div class="form-group mb-2">
        <label for="penulis">Penulis</label>
        <input type="text" name="penulis" class="form-control" value="{{ old('penulis') }}" required>
      </div>

      <div class="form-group mb-2">
        <label for="penerbit">Penerbit</label>
        <input type="text" name="penerbit" class="form-control" value="{{ old('penerbit') }}" required>
      </div>

      <div class="form-group mb-3">
        <label for="tahun">Tahun</label>
        <input type="number" name="tahun" class="form-control" min="1900" max="2099" value="{{ old('tahun') }}" required>
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
    </form>

  </div>
</div>
@endsection
