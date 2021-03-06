@extends('layouts.master')
@section('title')
Dekorasi
@endsection
@section('style')
<style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    .header-image {
        height: 20rem;
    }

    .header-image>img {
        position: absolute;
        top: 0;
        left: 0;
        min-width: 100%;
        height: 20rem;
    }

    .block-ellipsis {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    p,
    h4 {
        line-height: 2;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
</style>
<link rel="stylesheet" href="{{asset('css/navbar.css')}}">
<link rel="stylesheet" href="{{asset('css/carousel.css')}}">
@endsection
@section('content')
@php
use Illuminate\Support\Str;
@endphp
<div id="header">
    <div class="bg-dark header-image d-flex align-items-center justify-content-center">
        <img src="{{asset('images/header2.jpg')}}" class="img-fluid opacity-50" style="object-fit: cover; object-position: center">
        <div class="fw-bold position-absolute mt-5" style="max-width: 70%;">
            <h1 class="text-light text-center">Dekoration Ideas</h1>
            <p class="text-light lead block-ellipsis">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
        </div>
    </div>
</div>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark" aria-label="Ninth navbar example">
    <div class="container-xl">
        <div class="text-muted d-lg-none">Lihat kategori...</div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu_category" aria-controls="menu_category" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-arrows-expand"></i>
        </button>

        <div class="collapse navbar-collapse" id="menu_category">
            <ul class="navbar-nav mb-2 mx-auto mb-lg-0 align-items-lg-center">
                <li class="nav-item mx-1 my-1 my-lg-0">
                    <a class="btn btn-outline-light w-100 {{ request()->get('category') == 'all' || request()->get('category') == null ? 'active' : '' }}" aria-current="page" href="?category=all">Semua kategori</a>
                </li>
                @foreach($categories as $category)
                <li class="nav-item mx-1 my-1 my-lg-0">
                    <a class="btn btn-outline-light w-100 {{ request()->get('category') == $category->nama ? 'active' : '' }}" aria-current="page" href="?category={{$category->nama}}">{{$category->nama}}</a>
                </li>
                @endforeach
                <li class="nav-item mx-1 my-1 my-lg-0">
                    <a class="btn btn-outline-light w-100 {{ request()->get('category') == 'item tambahan' ? 'active' : '' }}" aria-current="page" href="?category=item tambahan">Item tambahan</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div id="content">
    <div class="container mt-5">
        @include('components.flash-alert')
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-3 row-cols-lg-4 g-2">
            @foreach($decorations as $decoration)
            <div class="col p-2">
                <div class="card shadow-sm overflow-hidden" style="border-radius: 12px;">
                    <div class="d-flex position-absolute w-100">
                        <button type="button" class="btnLihatDetail btn ms-auto fs-6 text-white" data-bs-toggle="modal" data-bs-target="#detailProduk" style="background-color: rgba(0, 0, 0, 0.5)">
                            <span class="bi bi-eye"></span>
                        </button>
                    </div>
                    <img id="gambar" src="{{asset('storage/' . $decoration->gambar)}}" width="100%" height="250" style="object-fit: cover;">
                    <div class="card-body rounded">
                        <div id="nama" class="card-title mb-0">{{$decoration->nama}}</div>
                        <input hidden type="text" id="harga" value="{{$decoration->harga}}">
                        <input type="hidden" id="keterangan" value="{{$decoration->keterangan}}">
                        <div class="fs-5">@currency($decoration->harga)</div>
                        <input class="rating" name="rating" max="5" oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)" step="0.5" style="--value:{{$decoration->testimonials()->avg('rating')}}" type="range" value="{{$decoration->testimonials()->avg('rating')}}" disabled>
                        <p class="card-text block-ellipsis">{{Str::limit(strip_tags($decoration->keterangan), 50)}}</p>
                        <input hidden type="text" id="dariTgl" value="{{implode(',', $decoration->orders()->where('tanggalKembali', null)->groupBy('tglSewa', 'tglBongkar')->get()->pluck('tglSewa')->toArray())}}">
                        <input hidden type="text" id="sampaiTgl" value="{{implode(',', $decoration->orders()->where('tanggalKembali', null)->groupBy('tglSewa', 'tglBongkar')->get()->pluck('tglBongkar')->toArray())}}">
                        @php
                        $checkItemAdded = $decoration->carts()->where('user_id', @auth()->user()->id)->first();
                        $checkStock = $decoration->stok === 0 ? true : false;
                        $url = route('decoration.addtocart',['id'=>$decoration->id]);
                        $url .= $additionItem == true ? '?additionitem=true' : ''
                        @endphp
                        <form action="{{$url}}" method="post">
                            @csrf
                            <div class="d-flex justify-content-between">
                                <button type="submit" id="btnTambah" href="{{$url}}" class="btn btn-outline-dark w-100 me-2 {{ ($checkItemAdded != null || $checkStock == true) ? 'disabled' : '' }}"><i class="bi bi-bag-plus"></i> Tambah</button>
                                <a href="{{($additionItem) ? route('decoration.item.detail', ['id' => $decoration->id]) : route('decoration.packet.detail', ['id' => $decoration->id])}}" class="btnLihatDetail btn btn-outline-primary d-flex align-items-center">Lihat</a>
                            </div>
                        </form>
                        <small>
                            <div class="text-muted mt-2 d-flex">
                                stok:
                                <div id="stok" tersedia="{{($decoration->stok-$decoration->jmldisewa >= 0) ? $decoration->stok-$decoration->jmldisewa :'0'}}" class="ms-1">{{$decoration->stok}}</div>
                                , tersedia: {{($decoration->stok-$decoration->jmldisewa >= 0) ? $decoration->stok-$decoration->jmldisewa :'0'}}
                            </div>
                        </small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-5 d-flex justify-content-end">
            {{$decorations->links()}}
        </div>
    </div>
</div>

<div class="modal fade" id="detailProduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailProdukLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content p-3">
            <form method="post">
                @csrf
                <div class="modal-body">
                    <div class="d-flex justify-content-end mb-2">
                        <button type="button" class="btn-close d-md-block" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="sticky-top">
                                <img id="gambarProduk" src="{{asset('images/slide2.jpg')}}" width="100%" height="100%" style="object-fit: cover; height: 600px">
                            </div>
                        </div>
                        <div class="col-lg-7 px-4">
                            <h4 class="fs-2 mb-0" id="namaProduk" style="font-family: 'Alice', sans-serif;">Produk 1</h4>
                            <div class="d-flex align-items-center">
                                <input id="rating" class="rating" name="rating" max="5" oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)" step="0.5" style="--value:2.5" type="range" value="2.5" disabled>
                            </div>
                            <p class="mt-0 mb-0" id="stokProduk">Tersisa: 10</p>
                            <small class="text-danger">*Penyewaan diatas batas tersedia akan dicek berdasarkan tanggal penyewaan</small>
                            <div class="p-2 bg-primary my-4">
                                <h2 class="mb-0 text-white" id="hargaProduk">Rp50.000</h2>
                            </div>
                            <div class="fs-5 mb-4">
                                KETERANGAN
                            </div>
                            <p class="mb-0" style="line-height: 2" id="keteranganProduk"></p>
                            <div class="fs-5 my-4">
                                TANGGAL YANG SUDAH DIPESAN
                            </div>
                            <div class="overflow-auto">
                                <table id="rincianSewa" class="mb-3 table-warning table">
                                    <thead>
                                        <tr>
                                            <th>Dari tanggal</th>
                                            <th>Sampai tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <hr class="my-4">
                            <div class="d-flex">
                                <div style="max-width: 150px;" class="me-2">
                                    <input id="maksKuantitas" type="number" name="qty" class="form-control" value="1" min="1" max="10" step="1" />
                                </div>
                                <button id="tambahProduk" type="submit" class="btn btn-outline-dark w-100"><i class="bi bi-bag-plus"></i> Tambah</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    $("input[type='number']").inputSpinner();
</script>
<script>
    $('.btnLihatDetail').click(function() {
        let card = $(this).closest('.card');
        let gambar = card.find('#gambar').attr('src');
        let rating = card.find('.rating').val();
        let ratingstar = card.find('.rating').attr('style');
        let nama = card.find('#nama').text();
        let harga = card.find('#harga').val();
        let keterangan = card.find('#keterangan').val();
        let maksOrder = card.find('#stok').text();
        let tersedia = card.find('#stok').attr('tersedia');
        let cekKeranjang = card.find('#btnTambah').hasClass('disabled');
        let urlTambah = card.find('#btnTambah').attr('href');
        let dariTgl = card.find('#dariTgl').val().split(',');
        let sampaiTgl = card.find('#sampaiTgl').val().split(',');

        let modal = $('.modal-content');
        modal.find('#tambahProduk').removeClass('disabled');
        modal.find('#rincianSewa tbody tr').remove();

        modal.find('#gambarProduk').attr('src', gambar);
        modal.find('#rating').val(rating);
        modal.find('#rating').attr('style', ratingstar);
        modal.find('#namaProduk').text(nama);
        modal.find('#hargaProduk').text(new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR"
        }).format(harga));
        modal.find('#keteranganProduk').html(keterangan);
        modal.find('#maksKuantitas').attr('max', maksOrder);
        modal.find('#stokProduk').text('tersedia: ' + tersedia);
        if (cekKeranjang) {
            modal.find('#tambahProduk').addClass('disabled');
        }
        modal.find('form').attr('action', urlTambah);
        for (let i = 0; i < dariTgl.length; i++) {
            modal.find('#rincianSewa>tbody').append("<tr><td>" + dariTgl[i] + "</td><td>" + sampaiTgl[i] + "</td></tr>")
        }
    })
</script>
@endsection