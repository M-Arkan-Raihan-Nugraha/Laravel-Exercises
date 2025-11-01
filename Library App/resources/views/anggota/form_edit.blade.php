@extends('templates.layout')

@section('content')
<div class="card">
  <div class="card-header"><h3>Edit Anggota</h3></div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
      </div>
    @endif

    <form action="{{ route('anggota.update', $anggota->kode_anggota) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group mb-2">
        <label>Kode Anggota</label>
        <input type="text" name="kode_anggota" class="form-control" value="{{ old('kode_anggota', $anggota->kode_anggota) }}" required>
      </div>
      <div class="form-group mb-3">
        <label>Nama Anggota</label>
        <input type="text" name="nama_anggota" class="form-control" value="{{ old('nama_anggota', $anggota->nama_anggota) }}" required>
      </div>
      <button type="submit" class="btn btn-success">Update</button>
      <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>
@endsection
