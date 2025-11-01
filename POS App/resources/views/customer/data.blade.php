<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title">Daftar Pelanggan</h3>
    <a href="{{ route('customer.create') }}" class="btn btn-primary btn-sm">Tambah Pelanggan</a>
  </div>

  <div class="card-body">
    <table class="table table-bordered table-striped text-center">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Alamat</th>
          <th>Telepon</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $c)
        <tr>
          <td>{{ $c->id }}</td>
          <td>{{ $c->name }}</td>
          <td>{{ $c->email}}</td>
          <td>{{ $c->address }}</td>
          <td>{{ $c->phone_number }}</td>
          <td>{{ $c->status == 1 ? 'Member' : 'Non Member' }}</td>
          <td>
            <a href="{{ route('customer.edit', $c->id) }}" class="btn btn-warning btn-sm">Edit</a>

            <form action="{{ route('customer.destroy', $c->id) }}" method="POST" style="display:inline"
              onsubmit="return confirm('Yakin mau hapus customer {{ $c->name }}?')">
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