@extends('layouts.master')
@section('title')
Home
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
<link rel="stylesheet" href="{{asset('css/carousel.css')}}">
@endsection
@section('content')
<div id="myCarousel" class="carousel slide" data-bs-ride="carousel" style="margin-bottom: 4rem;">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="bg-dark">
                <img src="{{asset('images/header1.jpg')}}" class="opacity-50" style="min-height:600px; width:100%; object-fit: cover; object-position: center">
            </div>

            <div class="container">
                <div class="carousel-caption text-start">
                    <h1>Example headline.</h1>
                    <p>Some representative placeholder content for the first slide of the carousel.</p>
                    <p><a class="btn btn-lg btn-outline-light" href="#">Sign up today</a></p>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="bg-dark">
                <img src="{{asset('images/header2.jpg')}}" class="opacity-50" style="min-height:600px; width:100%; object-fit: cover; object-position: center">
            </div>

            <div class="container">
                <div class="carousel-caption">
                    <h1>Another example headline.</h1>
                    <p>Some representative placeholder content for the second slide of the carousel.</p>
                    <p><a class="btn btn-lg btn-outline-light" href="#">Learn more</a></p>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="bg-dark">
                <img src="{{asset('images/header3.jpg')}}" class="opacity-50" style="min-height:600px; width:100%; object-fit: cover; object-position: center">
            </div>

            <div class="container">
                <div class="carousel-caption text-end">
                    <h1>One more for good measure.</h1>
                    <p>Some representative placeholder content for the third slide of this carousel.</p>
                    <p><a class="btn btn-lg btn-outline-light" href="#">Browse gallery</a></p>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<div class="container marketing">
    @foreach($homepages as $idx => $homepage)
    <div class="row featurette">
        <div class="col-md-7 @if($idx % 2 == 0) order-md-2 @endif" style="font-family: 'Alice', sans-serif;">
            <h2 class="featurette-heading">{{$homepage->judul}}</h2>
            <p class="lead">{!!$homepage->deskripsi!!}</p>
        </div>
        <div class="col-md-5 @if($idx % 2 == 0) order-md-1 @endif">
            @if($homepage->type == 'link')
            <iframe src="{{$homepage->media}}" alt="mdo" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" style="height: 451px;"></iframe>
            @elseif($homepage->type == 'video')
            <video class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" style="height: 451px;" controls>
                <source src="{{asset('storage/'.$homepage->media)}}" type="video/mp4">
            </video>
            @else
            <img id="gambar" src="{{asset('storage/'.$homepage->media)}}" alt="mdo" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" style="height: 451px; object-fit: cover">
            @endif
        </div>
    </div>
    <hr class="featurette-divider">
    @endforeach

</div>
@endsection