@extends('templates.layout')

@section('title', 'Daftar Anggota')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title">Daftar Anggota</h3>
    <a href="{{ route('anggota.create') }}" class="btn btn-primary btn-sm">Tambah Anggota</a>
  </div>

  <div class="card-body text-center">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama Anggota</th>
          <th>Jenis Kelamin</th>
          <th>Alamat</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $a)
        <tr>
          <td>{{ $a->id }}</td>
          <td>{{ $a->nama }}</td>
          <td>{{ $a->jk }}</td>
          <td>{{ $a->alamat }}</td>
          <td>
            <a href="{{ route('anggota.edit', $a->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('anggota.destroy', $a->id) }}" method="POST" style="display:inline"
              onsubmit="return confirm('Yakin mau hapus anggota {{ $a->nama }}?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
