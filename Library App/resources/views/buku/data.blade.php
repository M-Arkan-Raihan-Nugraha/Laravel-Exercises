<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title">Daftar Buku</h3>
    <a href="{{ route('buku.create') }}" class="btn btn-primary btn-sm">Tambah Buku</a>
  </div>

  <div class="card-body">
    <table class="table table-bordered table-striped text-center">
      <thead>
        <tr>
          <th>Kode Buku</th>
          <th>Kategori</th>
          <th>Judul</th>
          <th>Penulis</th>
          <th>Penerbit</th>
          <th>Tahun</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $b)
        <tr>
          <td>{{ $b->kode_buku }}</td>
          <td>{{ $b->kategori->nama_kategori ?? '-' }}</td>
          <td>{{ $b->judul }}</td>
          <td>{{ $b->penulis }}</td>
          <td>{{ $b->penerbit }}</td>
          <td>{{ $b->tahun }}</td>
          <td>
            <a href="{{ route('buku.edit', $b->kode_buku) }}" class="btn btn-warning btn-sm">Edit</a>

            <form action="{{ route('buku.destroy', $b->kode_buku) }}" method="POST" style="display:inline"
              onsubmit="return confirm('Yakin mau hapus buku {{ $b->judul }}?')">
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