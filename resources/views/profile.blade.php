@extends('layouts.master')
@section('title')
Profile
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
$userdata = $user->customer()->first();
@endphp
<div class="container mb-5" style="margin-top: 6rem; max-width: 800px">
    <div class="row align-items-center">
        <div class="col-lg-3">
            <div class="text-center text-lg-end">
                <img src="{{ 'storage/' . $userdata->fotoProfil}}" alt="mdo" class="rounded-circle" style="max-width: 100px; height: 100px; object-fit: cover">
            </div>
        </div>
        <div class="col-lg-9">
            <div class="row flex-column text-center text-lg-start align-content-end">
                <h5 class="mt-3">{{'@'.$user->username}}</h5>
            </div>
            <div class="row text-center text-lg-start pt-auto">
                <p class="mt-lg-3">
                    <a class="btn btn-outline-success text-lg-center" href="/edit-profile">Edit profile</a>
                </p>
            </div>
        </div>
    </div>
    <hr>
    <div class="row mx-lg-5 mb-3">
        <label for="nama" class="col-lg-3 col-form-label"><h6>Nama lengkap</h6></label>
        <div class="col-lg-9">
            <input type="text" class="form-control" id="nama" value="{{ $userdata->nama }}" disabled>
        </div>
    </div>
    <div class="row mx-lg-5 mb-3">
        <label for="email" class="col-lg-3 col-form-label"><h6>Email</h6></label>
        <div class="col-lg-9">
            <input type="email" class="form-control" id="email"value="{{ $user->email }}" disabled>
        </div>
    </div>
    <div class="row mx-lg-5 mb-3">
        <label for="phone" class="col-lg-3 col-form-label"><h6>Nomor telepon</h6></label>
        <div class="col-lg-9">
            <input type="text" class="form-control" id="phone"value="{{ $userdata->nomorTelepon }}" disabled>
        </div>
    </div>
    <div class="row mx-lg-5 mb-3">
        <label for="address" class="col-lg-3 col-form-label"><h6>Alamat</h6></label>
        <div class="col-lg-9">
            <textarea type="text" class="form-control" id="address" disabled>{{ $userdata->alamat }}</textarea>
        </div>
    </div>
    <div class="row mx-lg-5 mb-3">
        <label for="birthday" class="col-lg-3 col-form-label"><h6>Tangal lahir</h6></label>
        <div class="col-lg-9">
            <input type="date" class="form-control" id="birthday"value="{{ $userdata->tanggalLahir }}" disabled>
        </div>
    </div>
</div>
@endsection