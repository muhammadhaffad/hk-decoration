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
    h4,
    .paragraph {
        line-height: 2;
    }

    p.div {
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
<div id="content" style="margin-top: 80px;">
    <div class="container mt-5">
        @include('components.flash-alert')
        <div class="p-3">
            <form method="post" action="{{url()->current().'/addtocart'}}">
                @csrf
                <div class="">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="sticky-top">
                                @php
                                $rating = $decoration->testimonials()->avg('rating');
                                $review = $decoration->testimonials()->count();
                                @endphp
                                <img id="gambarProduk" src="{{asset('storage/' . $decoration->gambar)}}" width="100%" height="100%" style="object-fit: cover; height: 600px">
                            </div>
                        </div>
                        <div class="col-lg-7 px-4">
                            <div class="d-flex justify-content-between">
                                <h4 class="fs-2 mb-0" id="namaProduk" style="font-family: 'Alice', sans-serif;">{{$decoration->nama}}</h4>
                                <a href="{{route('chat').'?type='.$decoration->getTable().'&id='.$decoration->id}}" class="btn fs-5">
                                    <span class="bi bi-chat-dots-fill"></span> Chat
                                </a>
                            </div>
                            <div class="d-flex align-items-center">
                                <input class="rating me-1" name="rating" max="5" oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)" step="0.5" style="--value:{{$rating}}" type="range" value="{{$rating}}" required> <u>{{$review}} REVIEW</u>
                            </div>
                            <p class="mt-0 mb-0" id="stokProduk">Tersedia: {{$decoration->stok - $decoration->jmldisewa}}</p>
                            <small class="text-danger">*Penyewaan diatas batas tersedia akan dicek berdasarkan tanggal penyewaan</small>
                            <div class="p-2 bg-primary my-4">
                                <h2 class="mb-0 text-white" id="hargaProduk">@currency($decoration->harga)</h2>
                            </div>
                            <div class="fs-5 mb-4">
                                Deskripsi
                            </div>
                            <div class="paragraph">
                                {!!$decoration->keterangan!!}
                            </div>
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
                                        @php
                                        $dari = $decoration->orders()->where('tanggalKembali', null)->groupBy('tglSewa', 'tglBongkar')->get()->pluck('tglSewa')->toArray();
                                        $sampai = $decoration->orders()->where('tanggalKembali', null)->groupBy('tglSewa', 'tglBongkar')->get()->pluck('tglBongkar')->toArray();
                                        @endphp
                                        @foreach($dari as $idx => $dariTgl)
                                        <tr>
                                            <td>{{$dariTgl}}</td>
                                            <td>{{$sampai[$idx]}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr class="my-4">
                            <div class="d-flex">
                                <div style="max-width: 150px;" class="me-2">
                                    <input id="maksKuantitas" type="number" name="qty" class="form-control" value="1" min="1" max="{{$decoration->stok}}" step="1" />
                                </div>
                                <button id="tambahProduk" type="submit" class="btn btn-outline-dark w-100 {{(@$decoration->carts()->where('user_id', auth()->user()->id)->first()) ? 'disabled' : ''}} "><i class="bi bi-bag-plus"></i> TAMBAH</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="p-3">
            <div class="d-flex justify-content-between">
                <h4 style="line-height: 1;">ULASAN KUSTOMER</h4>
                <button class="btn btn-outline-dark" data-bs-toggle="collapse" data-bs-target="#submitReview" aria-expanded="false" aria-controls="collapseExample">BUAT ULASAN</button>
            </div>
            <hr>
            <div id="submitReview" class="collapse">
                <form method="post" action="" enctype="multipart/form-data">
                    @csrf
                    <label class="form-label">RATING</label>
                    <input class="rating" name="rating" max="5" oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)" step="0.5" style="--value:2.5" type="range" value="2.5" required>
                    <label class="form-label mt-2">JUDUL</label>
                    <input type="text" name="judul" class="form-control" required>
                    <label class="form-label mt-2">GAMBAR (OPTIONAL)</label>
                    <input type="file" name="gambar" class="form-control form-control-file">
                    <label class="form-label mt-2">ISI</label>
                    <textarea rows="10" name="isi" class="form-control form-text" required></textarea>
                    <button type="submit" class="btn btn-outline-dark mt-4">SUBMIT</button>
                </form>
                <hr>
            </div>
            @foreach($decoration->testimonials()->get() as $testimonial)
            <div class="reviewCustomer">
                <div class="d-flex">
                    <h5>{{$testimonial->judul}}</h5>
                    <input class="rating ms-2" name="rating" max="5" oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)" step="0.5" style="--value:{{$testimonial->rating}}" type="range" value="{{$testimonial->rating}}" disabled>
                </div>
                <small>
                    <i>{{$testimonial->user()->first()->username}} on {{date('M d, Y', strtotime($testimonial->created_at))}}</i>
                </small>
                <div class="d-flex mt-3">
                    @if($testimonial->gambar)
                    <img class="me-3" src="{{asset('storage/'.$decoration->gambar)}}" alt="" width="120" , height="150" style="object-fit: cover;">
                    @endif
                    <p>
                        {{$testimonial->isi}}
                    </p>
                </div>
            </div>
            @endforeach
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