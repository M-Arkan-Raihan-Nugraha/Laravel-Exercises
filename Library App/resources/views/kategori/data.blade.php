<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title">Daftar Kategori</h3>
    <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm">Tambah Kategori</a>
  </div>

  <div class="card-body">
    <table class="table table-bordered table-striped text-center">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama Kategori</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $k)
        <tr>
          <td>{{ $k->id }}</td>
          <td>{{ $k->nama_kategori }}</td>
          <td>
            <a href="{{ route('kategori.edit', $k->id) }}" class="btn btn-warning btn-sm">Edit</a>

            <form action="{{ route('kategori.destroy', $k->id) }}" method="POST" style="display:inline"
              onsubmit="return confirm('Yakin mau hapus kategori {{ $k->nama_kategori }}?')">
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