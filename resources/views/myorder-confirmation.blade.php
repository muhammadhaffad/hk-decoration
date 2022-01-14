@extends('layouts.master')
@section('title')
Order
@endsection
@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
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

    input.checkbox {
        width: 18px;
        height: 18px;
    }
</style>
<link rel="stylesheet" href="{{asset('css/navbar.css')}}">
<link rel="stylesheet" href="{{asset('css/carousel.css')}}">
@endsection
@section('content')
<div class="container" style="margin-top: 6rem;">
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <div class="row mb-3">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th class="col-12">
                            <div class="d-flex justify-content-between">
                                <p class="mb-0">
                                    Daftar Transaksi
                                </p>
                                <a href="/myorder" class="text-decoration-none mb-0 text-primary fw-normal">
                                    Lihat penyewaan
                                </a>

                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php $count = 0 @endphp
                    @foreach($orders->get() as $order)
                    @if($order->payment()->first()->status != 'Belum dikonfirmasi' && $order->payment()->first()->status != null)
                    @php $count += 1 @endphp
                    <tr>
                        <td colspan="col-10">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th class="col-12 col-lg-4 align-middle">
                                            <form action="/receipt" method="post">
                                                KODE TRANSAKSI ❯ #{{$order->kodeSewa}}
                                                @if($order->payment()->first()->status !== 'Sudah dikonfirmasi')
                                                <span class="badge bg-danger text-wrap">Konfirmasi gagal</span>
                                                @else
                                                <span class="badge bg-success text-wrap">Konfirmasi sukses</span>
                                                @csrf
                                                <input type="hidden" name="kodeSewa" value="{{$order->kodeSewa}}">
                                                <button type="submit" class="badge btn btn-sm btn-primary text-white">Tampil struk</button>
                                                @endif
                                            </form>
                                            Tanggal penyewaan: <div class="fw-normal">{{date('d, F Y', strtotime($order->tanggalSewa))}} - {{date('d, F Y', strtotime($order->tanggalBongkar))}}</div>
                                        </th>
                                        <th class="col-lg d-none d-lg-table-cell">Harga satuan</th>
                                        <th class="col-lg d-none d-lg-table-cell">Kuantitas</th>
                                        <th class="col-lg d-none d-lg-table-cell">Tambah hari</th>
                                        <th class="col-lg d-none d-lg-table-cell">Harga tambah hari</th>
                                        <th class="col-lg d-none d-lg-table-cell">Harga subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderitems()->get() as $item)
                                    <tr class="align-middle">
                                        <td class="col-12 col-lg-4">
                                            <div class="d-flex align-items-center">
                                                <img src="{{asset('storage/' . $item->orderable()->first()->gambar)}}" alt="mdo" class="me-2" style="width: 120px; height: 150px; object-fit:cover">
                                                <div class="flex-column">
                                                    <p class="mb-0 d-lg-none text-muted"><small>@currency($item->orderable()->first()->harga)</small></p>
                                                    <div class="h6 mb-0">{{$item->orderable()->first()->nama}}</div>
                                                    <div class="">#{{$order->kodeSewa}}</div>
                                                    <small>
                                                        <p class="mb-0 d-lg-none text-muted">Tambah hari: {{$item->lamaSewa}} Hari</p>
                                                        <p class="mb-0 d-lg-none text-muted">Harga tambah hari: @currency($item->hargaSewa)</p>
                                                    </small>
                                                    <p class="mb-0 d-lg-none text-muted">Subtotal: {{$item->kuantitas}}&Cross;(@currency($item->orderable()->first()->harga)&plus;{{$item->lamaSewa}}&Cross;@currency($item->hargaSewa)) = @currency($item->subtotal)</p>
                                                </div>
                                            </div>
                                            <div class="d-flex d-lg-none justify-content-end align-items-end">
                                                Jumlah: {{$item->kuantitas}}
                                            </div>
                                        </td>
                                        <td class="col-lg d-none d-lg-table-cell harga-satuan d-none d-lg-table-cell">@currency($item->orderable()->first()->harga)</td>
                                        <td class="col-lg d-none d-lg-table-cell d-none d-lg-table-cell">
                                            {{$item->kuantitas}}
                                        </td>
                                        <td class="col-lg d-none d-lg-table-cell d-none d-lg-table-cell">
                                            @if($item->lamaSewa != 0)
                                            {{$item->lamaSewa}} Hari
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td class="col-lg d-none d-lg-table-cell d-none d-lg-table-cell">
                                            @if($item->lamaSewa != 0)
                                            {{$item->lamaSewa}}&Cross;@currency($item->hargaSewa)
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td class="col-lg d-none d-lg-table-cell harga-total d-none d-lg-table-cell">
                                            <small>{{$item->kuantitas}}&Cross;(@currency($item->orderable()->first()->harga)&plus;{{$item->lamaSewa}}&Cross;@currency($item->hargaSewa))</small>
                                            <br>
                                            = @currency($item->subtotal)
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <p class="mb-0 d-lg-none text-muted">Biaya ongkir: @currency($order->ongkir)</p>
                                <div class="col-lg-10 fw-bold pe-0 text-lg-end text-start">
                                    Total pembayaran:
                                </div>
                                <div class="col-lg-2 mb-4 text-start">
                                    @currency($order->total + $order->ongkir) <span class="badge @if($order->jenis == 'DP') bg-secondary @else bg-primary @endif">@if($order->jenis == 'DP') Uang muka @else Bayar lunas @endif</span>
                                </div>
                            </div>
                            @if($order->payment()->first()->status !== 'Sudah dikonfirmasi')
                            <div class="d-flex justify-content-end">
                                <div class="text-end col-lg-2">
                                    <div kode-sewa="{{$order->kodeSewa}}" class="upload-bukti btn btn-primary mt-2 w-100" data-bs-toggle="modal" data-bs-target="#upload-bukti">Upload bukti transfer</div>
                                </div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
            @if($count == 0)
            <div class="alert alert-secondary" role="alert">
                Belum ada order yang sudah dikonfirmasi,..
            </div>
            @endif
        </div>
    </div>
    <div class="modal fade" id="upload-bukti" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="upload-buktiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="/myorder/pay" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="upload-buktiLabel">Upload bukti transfer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img id="frame" class="img-thumbnail mx-auto d-block mb-3 text-start" style="width: 200px; height: 200px;" alt="Bukti pembayaran">
                        <input id="kodeSewa" type="hidden" name="kodeSewa">
                        <div class="input-group">
                            <input class="form-control form-control-sm  @error('bukti') is-invalid @enderror" name="bukti" type="file" onchange="loadImg()">
                            <button type="reset" class="btn btn-danger btn-sm " type="button" onclick="removeImg()"><i class="bi bi-trash-fill text-white"></i></button>
                            <p><small>File harus berupa gambar dengan ukuran kurang dari 1 MB (1024 KB)</small></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $('.upload-bukti').click(function() {
        let kodeSewa = $(this).attr('kode-sewa');
        $('#kodeSewa').val(kodeSewa);
    });
</script>
<script>
    function loadImg() {
        $('#frame').attr('src', URL.createObjectURL(event.target.files[0]));
    }

    function removeImg() {
        $('#frame').attr('src', '');
    }
</script>
@endsection