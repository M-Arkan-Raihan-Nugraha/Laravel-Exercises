@extends('templates.layout')

@section('content')
<div class="card">
  <div class="card-header">
    <h3>Edit Kategori</h3>
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

    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group mb-2">
        <label for="nama_kategori">Nama Kategori</label>
        <input type="text" name="nama_kategori" class="form-control"
               value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
      </div>

      <button type="submit" class="btn btn-success">Update</button>
      <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
    </form>

  </div>
</div>
@endsection
