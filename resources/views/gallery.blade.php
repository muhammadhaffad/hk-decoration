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
        <img src="{{asset('images/header4.jpg')}}" class="img-fluid opacity-50" style="object-fit: cover; object-position: center">
        <div class="fw-bold position-absolute mt-5" style="max-width: 70%;">
            <h1 class="text-light text-center">Galery</h1>
            <p class="text-light lead block-ellipsis">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
        </div>
    </div>
</div>

<div id="content">
    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-sm-2 g-3">
            @foreach($galleries as $gallery)
            <div class="col-lg-6 mb-4">
                <div class="card overflow-hidden" style="border-radius: 12px;">
                    <div id="{{$gallery->slug}}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($gallery->photos()->get() as $index => $photo)
                            <div class="carousel-item {{$index == 0 ? 'active' : ''}}">
                                <img src="{{asset('storage/' . $photo->foto)}}" class="d-block w-100" alt="..." style="height:270px; object-fit:cover">
                                <div class="carousel-caption d-block text-start ps-3" style="background: rgba(33,37,41, 0.6); right: 0; left: 0; bottom: 0;">
                                    {{$photo->deskripsi}}
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#{{$gallery->slug}}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#{{$gallery->slug}}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <div class="card-body shadow">
                        <div class="d-flex justify-content-between">
                            <h5>{{$gallery->nama}}</h5>
                            <a class="btn btn-outline-dark text-decoration-none w-25" href="{{'gallery/'.$gallery->slug}}">Lihat</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-5 d-flex justify-content-end">
            {{$galleries->links()}}
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