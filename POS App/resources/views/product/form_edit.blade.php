@extends('templates.layout')

@section('content')
<div class="card">
  <div class="card-header"><h3>Edit Produk</h3></div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
      </div>
    @endif

    <form action="{{ route('product.update', $product->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group mb-2">
        <label for="name">Nama</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
      </div>

      <div class="form-group mb-2">
        <label for="description">Deskripsi</label>
        <input type="text" name="description" class="form-control" value="{{ old('description', $product->description) }}" required>
      </div>

      <div class="form-group mb-2">
        <label for="stock">Stok</label>
        <input type="text" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
      </div>

      <div class="form-group mb-2">
        <label for="price">Harga</label>
        <input type="text" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
      </div>

      <div class="form-group mb-2">
        <label for="category_id">Kategori</label>
        <select name="category_id" class="form-select" required>
          <option value="">-- Pilih Kategori --</option>
          @foreach($category as $k)
            <option value="{{ $k->id }}" 
              {{ old('category_id', $product->category_id) == $k->id ? 'selected' : '' }}>
              {{ $k->name }}
            </option>
          @endforeach
        </select>
      </div>

      <button type="submit" class="btn btn-success">Update</button>
      <a href="{{ route('product.index') }}" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>
@endsection
