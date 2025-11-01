@extends('templates.layout')

@section('title', 'Data Peminjaman')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title">Data Peminjaman</h3>
    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
  </div>

  <div class="card-body text-center">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Anggota</th>
          <th>Buku</th>
          <th>Tanggal Pinjam</th>
          <th>Tanggal Kembali</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $p)
        <tr>
          <td>{{ $p->id }}</td>
          <td>{{ $p->anggota->nama ?? '-' }}</td>
          <td>{{ $p->buku->judul ?? '-' }}</td>
          <td>{{ $p->tanggal_pinjam }}</td>
          <td>{{ $p->tanggal_kembali }}</td>
          <td>{{ $p->status }}</td>
          <td>
            <a href="{{ route('peminjaman.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('peminjaman.destroy', $p->id) }}" method="POST" style="display:inline"
              onsubmit="return confirm('Yakin mau hapus data ?')">
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
