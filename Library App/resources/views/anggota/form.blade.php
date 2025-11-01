@extends('templates.layout')

@section('content')
<div class="card">
  <div class="card-header"><h3>Tambah Anggota</h3></div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
      </div>
    @endif

    <form action="{{ route('anggota.store') }}" method="POST">
      @csrf
      <div class="form-group mb-3">
        <label>Nama Anggota</label>
        <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
      </div>

      <div class="form-group mb-3">
        <label>Jenis Kelamin</label>
        <select name="jk" class="form-select" required>
          <option value="">-- Pilih Jenis Kelamin --</option>
          <option value="Laki-laki" {{ old('jk') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
          <option value="Perempuan" {{ old('jk') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
      </div>

      <div class="form-group mb-3">
        <label>Alamat</label>
        <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}" required>
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>
@endsection