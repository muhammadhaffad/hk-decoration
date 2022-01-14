@extends('layouts.master')
@section('title')
Edit Profile
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
$userdata = auth()->user()->customer()->first();
@endphp
<div class="container mb-5" style="margin-top: 6rem; max-width: 800px">
    <form action="" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row align-items-center">
            <div class="col-lg-3">
                <div class="text-center text-lg-end">
                    <img src="{{asset('storage/' . $userdata->fotoProfil)}}" alt="mdo" class="rounded-circle" style="max-width: 100px; height: 100px; object-fit: cover">
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row flex-column text-center text-lg-start align-content-end">
                    <h5 class="mt-3">{{'@'.auth()->user()->username}}</h5>
                </div>
                <div class="row text-start text-lg-start pt-auto me-lg-5">
                    <p>
                        <label for="profile" class="form-label">Ganti foto profile</label>
                        <input type="file" name="fotoProfil" class="form-control" id="profile">
                        <small>File harus berupa gambar dengan ukuran kurang dari 1 MB (1024 KB)</small>
                    </p>
                </div>
            </div>
        </div>
        <hr>
        <div class="row mx-lg-5 mb-3">
            <label for="nama" class="col-lg-3 col-form-label">
                <h6>Nama lengkap</h6>
            </label>
            <div class="col-lg-9">
                <input type="text" name="nama" class="form-control" id="nama" value="{{$userdata->nama}}">
            </div>
        </div>
        <div class="row mx-lg-5 mb-3">
            <label for="email" class="col-lg-3 col-form-label">
                <h6>Email</h6>
            </label>
            <div class="col-lg-9">
                <input type="email" name="email" class="form-control" id="email" value="{{auth()->user()->email}}">
            </div>
        </div>
        <div class="row mx-lg-5 mb-3">
            <label for="phone" class="col-lg-3 col-form-label">
                <h6>Nomor telepon</h6>
            </label>
            <div class="col-lg-9">
                <input type="text" name="nomorTelepon" class="form-control" id="phone" value="{{$userdata->nomorTelepon}}">
            </div>
        </div>
        <div class="row mx-lg-5 mb-3">
            <label for="address" class="col-lg-3 col-form-label">
                <h6>Alamat</h6>
            </label>
            <div class="col-lg-9">
                <textarea type="text" name="alamat" class="form-control" id="address">{{$userdata->alamat}}</textarea>
            </div>
        </div>
        <div class="row mx-lg-5 mb-3">
            <label for="birthday" class="col-lg-3 col-form-label">
                <h6>Tangal lahir</h6>
            </label>
            <div class="col-lg-9">
                <input type="date" name="tanggalLahir" class="form-control" id="birthday" value="{{$userdata->tanggalLahir}}">
            </div>
        </div>
        <div class="row mx-lg-5 mb-3">
            <label for="birthday" class="col-lg-3 col-form-label">
                <h6>Foto KTP</h6>
            </label>
            <div class="col-lg-9">
                <input type="file" name="fotoKtp" class="form-control" id="profile">
                <p><small>File harus berupa gambar dengan ukuran kurang dari 1 MB (1024 KB)</small></p>
            </div>
        </div>
        <div class="row mx-lg-5">
            <button type="submit" class="btn btn-primary ms-auto" style="max-width: 150px;">Konfirmasi</button>
        </div>
    </form>
</div>
@endsection