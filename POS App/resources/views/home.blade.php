@extends('templates.layout')

@section('title', 'Home Page')

@section('content')
<div class="container-fluid">

  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Welcome Message -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="alert alert-primary">
        <h4>Selamat Datang di Aplikasi POS</h4>
        <p>Ini adalah dashboard utama untuk mengelola data.</p>
      </div>
    </div>
  </div>

  <!-- Statistik Box -->
  <div class="row">
    <!--begin::Col-->
    <div class="col-lg-3 col-6">
      <!--begin::Small Box Widget 1-->
      <div class="small-box text-bg-danger">
        <div class="inner">
          <h3>{{ $jumlah_pelanggan ?? 0 }}</h3>
          <p>Jumlah Pelanggan</p>
        </div>
        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
          aria-hidden="true">
          <path
            d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4" />
        </svg>
        <a href="/customer" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
          Lihat Pelanggan <i class="bi bi-link-45deg"></i>
        </a>
      </div>
      <!--end::Small Box Widget 1-->
    </div>
    <!--end::Col-->
    <div class="col-lg-3 col-6">
      <!--begin::Small Box Widget 2-->
      <div class="small-box text-bg-warning">
        <div class="inner">
          <h3>{{ $jumlah_kategori ?? 0 }}</h3>
          <p>Jumlah Kategori</p>
        </div>
        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
          aria-hidden="true">
          <path
            d="M3 2v4.586l7 7L14.586 9l-7-7zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586z" />
          <path
            d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1z" />
        </svg>
        <a href="/category" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
          Lihat Kategori <i class="bi bi-link-45deg"></i>
        </a>
      </div>
      <!--end::Small Box Widget 2-->
    </div>
    <!--end::Col-->

    <div class="col-lg-3 col-6">
      <!--begin::Small Box Widget 3-->
      <div class="small-box text-bg-success">
        <div class="inner">
          <h3>{{ $jumlah_produk ?? 0 }}</h3>
          <p>Jumlah Produk</p>
        </div>
        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
          aria-hidden="true">
          <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
        </svg>
        <a href="/product" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
          Lihat Produk <i class="bi bi-link-45deg"></i>
        </a>
      </div>
      <!--end::Small Box Widget 3-->
  <!--end::Row-->
@endsection