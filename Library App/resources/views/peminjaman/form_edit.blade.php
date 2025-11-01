@extends('templates.layout')

@section('content')
<div class="card">
  <div class="card-header"><h3>Edit Data</h3></div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
      </div>
    @endif

    <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group mb-2">
        <label>Tanggal Pinjam</label>
        <input type="date" name="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam', $peminjaman->id) }}" required>
      </div>
      <div class="form-group mb-2">
        <label>Tanggal Kembali</label>
        <input type="date" name="tanggal_kembali" class="form-control" value="{{ old('tanggal_kembali', $peminjaman->id) }}" required>
      </div>
      <button type="submit" class="btn btn-success">Update</button>
      <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>
@endsection
