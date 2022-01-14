@extends('layouts.master')
@section('title')
Galeri
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
        display: block;
        display: -webkit-box;
        max-width: 100%;
        height: 60px;
        margin: 0 auto;
        line-height: 1;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .img-container {
        position: relative;

    }

    .img-container img {
        height: 100%;
        width: 100%;
    }

    .img-container
    .img-footer {
        position: absolute;
        bottom: 0;
        left: 0;
        padding: 0 10px;

        width: 100%;

        color: #fff;
        background: rgba(0, 0, 0, 0.7);
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
</style>
@endsection
@section('content')

<div id="header">
    <div class="bg-dark header-image d-flex align-items-center justify-content-center">
        <img src="{{asset('images/slide2.jpg')}}" class="img-fluid opacity-50" style="object-fit: cover; object-position: bottom">
        <div class="fw-bold position-absolute mt-5" style="max-width: 70%;">
            <h1 class="text-light text-center">Galery</h1>
            <p class="text-light lead block-ellipsis">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
        </div>
    </div>
</div>

<div id="content">
    <div class="container mt-5 mb-5">
        <div class="d-flex fs-1 my-5 justify-content-center" style="font-family: 'Alice', sans-serif;">
            <div style="transform: scale(-1, 1);">&backsim;</div>{{$gallery->nama}}<div>&backsim;</div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 g-3">
            @foreach($gallery->photos()->get() as $index => $photo)
            <div class="col">
                <picture>
                    <div class="img-container overflow-hidden">
                        <img src="{{asset('storage/' . $photo->foto)}}" class="d-block w-100" alt="..." style="object-fit:cover">
                        <div class="img-footer py-3">
                            {{$photo->deskripsi}}
                        </div>
                    </div>
                </picture>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="imagemodal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Image preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="" class="imagepreview" style="width: 100%;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(function() {
        $('.pop').on('click', function() {
            if ($(this).find('div').hasClass('carousel-item active')) {
                let url = $(this).find('.carousel-item.active img').attr('src');
                $('.imagepreview').attr('src', url);
                $('#imagemodal').modal('show');
            } else {
                console.log('false');
            }
        });
    });
</script>
@endsection