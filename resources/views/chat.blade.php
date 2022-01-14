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
<div class="row px-2 px-lg-0 d-flex" style="padding-top:5em; padding-bottom:1em; flex:1; --bs-gutter-x: 0rem;">
    <div class="card col-lg-6 mx-auto">
        <h6 class="card-header">Chat</h6>
        <div id="chat-body" class="card-body" style="height: 1vh; overflow-y:auto; overflow-x:hidden">
            @foreach($chats->get() as $c)
            <div class="d-flex @if($c->from == auth()->user()->id) justify-content-end @endif text-white my-1">
                <div class="bg-primary p-2 rounded" style="width: fit-content;">
                    @if($c->orderable_type)
                    @php $o = $c->orderable()->first() @endphp
                    <div class="ms-auto">
                        <div class="d-flex align-items-center">
                            <img class="rounded" src="{{asset('storage/'. $o->gambar)}}" alt="" height="60" width="60" style="object-fit: cover;">
                            <div class="d-flex flex-column ms-2">
                                <div class="fs-6">
                                    {{$o->nama}}
                                </div>
                                <small class="fw-light">
                                    @currency($o->harga)
                                </small>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-1">
                    @endif
                    <p class="mb-0 @if($c->from == auth()->user()->id) text-end @endif" style="line-height: 1.5;">
                        {{$c->pesan}}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="card-footer">
            <form action="{{route('chat.send')}}" method="POST">
                @csrf
                @if($product)
                <div class="product mb-2 d-flex flex-column p-2 rounded border border-1 bg-white">
                    <input type="hidden" name="type" value="{{request()->get('type')}}">
                    <input type="hidden" name="id" value="{{request()->get('id')}}">
                    <div class="d-flex align-items-center">
                        <img class="rounded" src="{{asset('storage/'.$product->gambar)}}" alt="" height="60" width="60" style="object-fit: cover;">
                        <div class="d-flex flex-column ms-2">
                            <div class="fw-bold">
                                {{$product->nama}}
                            </div>
                            <small class="fw-light">
                                @currency($product->harga)
                            </small>
                        </div>
                        <div class=" ms-auto align-self-start">
                            <button type="button" class="btn-sm btn-close"></button>
                        </div>
                    </div>
                </div>
                @endif
                <div class="input-group">
                    <input type="text" name="pesan" class="form-control">
                    <button class="btn btn-primary input-group-btn" style="border-radius: 0 0.25em 0.25em 0!important;"><span class="bi bi-send-fill"></span></button>
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
    $(document).ready(function() {
        $('#chat-body').scrollTop(2000);
    })
    $('.btn-close').click(function() {
        let reply = $(this).closest('.product');
        reply.remove();
    });
</script>
@endsection