<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title">Daftar Produk</h3>
    <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm">Tambah Produk</a>
  </div>

  <div class="card-body">
    <table class="table table-bordered table-striped text-center">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Deskripsi</th>
          <th>Stok</th>
          <th>Harga</th>
          <th>Kategori</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $p)
        <tr>
          <td>{{ $p->id }}</td>
          <td>{{ $p->name }}</td>
          <td>{{ $p->description}}</td>
          <td>{{ $p->stock }}</td>
          <td>{{ $p->price }}</td>
          <td>{{ $p->category->name ?? '-' }}</td>
          <td>
            <a href="{{ route('product.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>

            <form action="{{ route('product.destroy', $p->id) }}" method="POST" style="display:inline"
              onsubmit="return confirm('Yakin mau hapus product {{ $p->name }}?')">
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