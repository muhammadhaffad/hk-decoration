@extends('admin.layouts.master', ['title' => 'Chat'])
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

    .user-clicked,
    .user-clicked>td>a {
        background-color: rgb(13, 110, 253);
        color: white !important;
    }

    div.dataTables_wrapper div.dataTables_filter input {
        margin-left: 0;
    }

    .image-badge-container {
        display: inline-block;
        /* keeps the img with the badge if the img is forced to a new line */
        position: relative;
        margin-bottom: 5px;
    }

    .badge-on-image {
        position: absolute;
        /* position where you want it */
        right: 0px;
        padding: 3px 6px;
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
<div class="row px-2 px-lg-0 shadow-sm" style=" height:calc(100% - 150px); margin-bottom:10px; --bs-gutter-x: 0rem;">
    <div class="card p-3 col-4 rounded-0">
        <table class="table w-100" id="chat-table">
            <thead>
                <tr>
                    <th>Kustomer</th>
                </tr>
            </thead>
            <tbody>
                @foreach($userChat->get() as $u)
                @php $u = $u->user()->first() @endphp
                <tr class="@if(request()->segment(3) == $u->id) user-clicked @endif">
                    <td>
                        <a class=" text-decoration-none text-muted" href="{{route('admin.chat.to', ['id' => $u->id])}}">
                            <div class="image-badge-container">
                                @if($u->chats()->where('status', 'unread')->count())
                                <span class="badge bg-danger badge-on-image">{{$u->chats()->where('status', 'unread')->count()}}</span>
                                @endif
                                <img src="{{asset('storage/'.$u->customer()->first()->fotoProfil)}}" class="rounded-circle bg-dark me-1" height="45" width="45">
                            </div>
                            {{$u->username}}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card col-8 rounded-0">
        @isset($user)
        <div class="card-header">
            <img src="{{asset('storage/' . @$user->customer()->first()->fotoProfil)}}" class=" rounded-circle" height="45" width="45" style="object-fit:cover">
            {{@$user->username}}
        </div>
        @endisset
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
        @isset($user)
        <div class="card-footer">
            <form action="{{route('admin.chat.send', ['id' => $user->id])}}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="pesan" class="form-control">
                    <button class="btn btn-primary input-group-btn" style="border-radius: 0 0.25em 0.25em 0!important;"><span class="fa fa-paper-plane"></span></button>
                </div>
            </form>
        </div>
        @endisset
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('#chat-table').DataTable({
            paging: false,
            ordering: false,
            info: false,
            scrollY: '50vh',
            dom: "<'row'<'col-lg-12 col-md-12 col-xs-12'f><'col-lg-2 col-md-2 col-xs-12'l>>" +
                "<'row'<'col-sm-12'tr>>",
            language: {
                search: '',
                searchPlaceholder: "Cari kustomer..."
            },
        });
        $('.dataTables_filter label').css({
            'width': '100%',
            'margin-left': 0,
            'display': 'inline-block'
        });
        $('.dataTables_filter input[type="search"]').css({
            'width': '100%',
            'display': 'inline-block'
        });
        $('#chat-body').scrollTop(2000);
    });
</script>
<script>
    $('.btn-close').click(function() {
        let reply = $(this).closest('.product');
        reply.remove();
    });
</script>
@endsection