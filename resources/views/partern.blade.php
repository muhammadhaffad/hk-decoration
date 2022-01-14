@extends('layouts.master')
@section('title')
Partern
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

    .p-ellipsis {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
    }

    .img-container {
        position: relative;

    }

    .img-container img {
        height: 100%;
        width: 100%;
    }

    .img-container .img-footer {
        position: absolute;
        bottom: 0;
        left: 0;
        padding: 0 10px;

        width: 100%;

        color: #fff;
        background: rgba(0, 0, 0, 0.7);
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

<div id="header">
    <div class="bg-dark header-image d-flex align-items-center justify-content-center">
        <img src="{{asset('images/header3.jpg')}}" class="img-fluid opacity-50" style="object-fit: cover; object-position: center">
        <div class="fw-bold position-absolute mt-5" style="max-width: 70%;">
            <h1 class="text-light text-center">Package Fotografie</h1>
            <p class="text-light lead block-ellipsis">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
        </div>
    </div>
</div>

<div id="content">
    <div class="container mt-5 mb-5">
        @include('components.flash-alert')
        <div class="row row-cols-1 row-cols-sm-2 g-3">
            @foreach($sesspackages->get() as $sesspackage)
            <div class="col-lg-6">
                <div class='img-container rounded overflow-hidden'>
                    <div class="d-flex w-100 position-absolute">
                        <button class="btn btnLihatDetail text-white ms-auto fs-5" data-bs-toggle="modal" data-bs-target="#detailSesiPaket" style="margin-left: -5px;">
                            <span class="bi bi-eye"></span>
                        </button>
                    </div>
                    <img id="gambar" src="{{asset('storage/' . $sesspackage->gambar)}}" alt="" style="height: 300px; object-fit: cover" />
                    <div class='img-footer'>
                        <h4 id="nama" class="mt-2">{{$sesspackage->nama}}</h4>
                        <input class="rating" name="rating" max="5" oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)" step="0.5" style="--value:{{$sesspackage->testimonials()->avg('rating')}}; --fillbg:rgb(100,100,100); background:transparent" type="range" value="{{$sesspackage->testimonials()->avg('rating')}}" disabled>
                        <input type="hidden" id="keterangan" value="{{$sesspackage->keterangan}}">
                        <p class="block-ellipsis">{{Str::limit(strip_tags($sesspackage->keterangan), 50)}}</p>
                        @php
                        $checkItemAdded = $sesspackage->carts()->where('user_id', @auth()->user()->id)->first();
                        $url = route('partern.addtocart',['id'=>$sesspackage->id]);
                        @endphp
                        <form action="{{$url}}" method="post">
                            @csrf
                            <div class="d-lg-flex justify-content-lg-between d-block pb-2">
                                <h3 id="harga" harga="{{$sesspackage->harga}}" class="fw-light w-100">@currency($sesspackage->harga)</h3>
                                <div class="btn-group w-100 d-md-block text-end">
                                    <button type="submit" id="btnTambah" url="{{$url}}" class="btn btn-outline-light {{ ($checkItemAdded) ? 'disabled' : '' }}"><i class="bi bi-bag-plus"></i> {{ ($checkItemAdded) ? 'Sudah ditambahkan' : 'Tambah' }}</button>
                                    <a href="{{route('partern.detail',['id' => $sesspackage->id])}}" class="btnLihatDetail btn btn-outline-light" style="margin-left: -5px;">Lihat</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="modal fade" id="detailSesiPaket" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailSesiPaketLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">

        <div class="modal-content p-3">
            <form action="" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn-close mb-2" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="col-lg-5">
                            <div class="sticky-top">
                                <img id="gambarProduk" src="{{asset('images/slide2.jpg')}}" width="100%" height="100%" style="object-fit: cover; height: 600px">
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <h4 id="namaProduk" class="fs-2" style="font-family: 'Alice', sans-serif;">Produk 1</h4>
                            <input class="rating" name="rating" max="5" oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)" step="0.5" style="--value:2.5" type="range" value="" disabled>
                            <div class="p-2 mt-4 bg-primary">
                                <h2 class="fw-light mb-0 text-white" id="hargaProduk">Rp50.000</h2>
                            </div>
                            <div class="fs-5 my-4">
                                KETERANGAN
                            </div>
                            <p class="mb-0" id="keteranganProduk"></p>
                            <hr class="my-4">
                            <div class="d-flex justify-content-end">
                                <button id="tambahProduk" type="submit" class="btn btn-outline-dark w-50 ms-auto"><i class="bi bi-bag-plus"></i> Tambah</button>
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
    $('.btnLihatDetail').click(function() {
        let card = $(this).closest('.img-container');
        let gambar = card.find('#gambar').attr('src');
        let rating = card.find('.rating').val();
        let ratingstar = card.find('.rating').attr('style');
        let nama = card.find('#nama').text();
        let harga = card.find('#harga').attr('harga');
        let keterangan = card.find('#keterangan').val();
        let cekKeranjang = card.find('#btnTambah').hasClass('disabled');
        let urlTambah = card.find('#btnTambah').attr('url');

        let modal = $('.modal-content');
        modal.find('#tambahProduk').removeClass('disabled');
        modal.find('#gambarProduk').attr('src', gambar);
        modal.find('.rating').val(rating);
        modal.find('.rating').attr('style', ratingstar);
        modal.find('#namaProduk').text(nama);
        modal.find('#hargaProduk').text(new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR"
        }).format(harga));
        modal.find('#keteranganProduk').html(keterangan);
        if (cekKeranjang) {
            modal.find('#tambahProduk').addClass('disabled');
        }
        modal.find('form').attr('action', urlTambah);
    })
</script>
@endsection