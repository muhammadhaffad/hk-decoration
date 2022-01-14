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

    .table> :not(:first-child) {
        border-color: var(--bs-gray-300);
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
            <form action="/invoice" method="post">
                @csrf
                <div class="d-flex justify-content-between align-items-end">
                    <strong>
                        KODE TRANSAKSI &NestedGreaterGreater; #{{$order->kodeSewa}}
                    </strong>
                    <input type="hidden" name="kodeSewa" value="{{$order->kodeSewa}}">
                    <button type="submit" class="btn btn-outline-dark">Invoice</button>
                </div>
            </form>
            @if($order->status === 'unpaid')
            <span class="badge bg-warning text-wrap">UNPAID</span>
            @elseif($order->status === 'paid')
            <span class="badge bg-success text-wrap">PAID</span>
            @elseif($order->status === 'expired')
            <span class="badge bg-warning text-wrap">EXPIRED</span>
            @elseif($order->status === 'failed')
            <span class="badge bg-danger text-wrap">FAILED</span>
            @endif
            <span class="badge @if($order->jenis == 'DP') bg-secondary @else bg-primary @endif">
                @if($order->jenis == 'DP') UANG MUKA @else Bayar LUNAS @endif
            </span>
            <br>
            <strong>Tanggal penyewaan:</strong>
            <br>
            <small>{{date('d, F Y', strtotime($order->tanggalSewa))}} s/d {{date('d, F Y', strtotime($order->tanggalBongkar))}}</small>
            <br>
            <strong>Tambah hari:</strong>
            {{$order->lamaSewa}} Hari
            <br>
            <div id="{{$order->kodeSewa}}">
                <table class="table">
                    <thead class="table-secondary">
                        <tr class="text-center align-bottom">
                            <th class="col-12 col-lg-3 text-start">Produk</th>
                            <th class="col-lg d-none d-lg-table-cell">Harga satuan</th>
                            <th class="col-lg d-none d-lg-table-cell">Kuantitas</th>
                            <th class="col-lg d-none d-lg-table-cell">Harga tambah hari</th>
                            <th class="col-lg d-none d-lg-table-cell">Harga subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderitems()->get() as $item)
                        <tr class="align-middle text-center">
                            <td class="col-12 col-lg-3 text-start">
                                <div class="d-flex align-items-start align-items-lg-center">
                                    <img src="{{asset('storage/' . $item->orderable()->first()->gambar)}}" alt="mdo" class="me-2 rounded" width="70" height="70" style="object-fit:cover">
                                    <div class="flex-column">
                                        <p class="mb-0 d-lg-none text-muted"><small>@currency($item->orderable()->first()->harga)</small></p>
                                        <p class="mb-0">{{$item->orderable()->first()->nama}}</p>
                                        <small>
                                            <p class="mb-0 d-lg-none text-muted">Harga tambah hari: @currency($item->hargaSewa)</p>
                                        </small>
                                        <small class="mb-0 d-lg-none text-muted">Subtotal: {{$item->kuantitas}}&Cross;(@currency($item->orderable()->first()->harga)&plus;{{$item->lamaSewa}}&Cross;@currency($item->hargaSewa)) = @if($order->jenis == 'DP') <del>@currency($item->subtotal)</del> (@currency($item->subtotal*0.5)) @else @currency($item->subtotal) @endif</small>
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
                                {{$item->lamaSewa}}&Cross;@currency($item->hargaSewa)
                                @else
                                -
                                @endif
                            </td>
                            <td class="col-lg d-none d-lg-table-cell harga-total d-none d-lg-table-cell text-start">
                                <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="{{$item->kuantitas}}&Cross;(@currency($item->orderable()->first()->harga)&plus;{{$item->lamaSewa}}&Cross;@currency($item->hargaSewa))">
                                    <a class="text-decoration-none text-black" href="#">@if($order->jenis == 'DP') <del>@currency($item->subtotal)</del> <br> @currency($item->subtotal*0.5) @else @currency($item->subtotal) @endif</a>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <p class="mb-0 d-lg-none text-muted">Biaya ongkir: @currency($order->ongkir)</p>
                <div class="col-lg-9 fw-bold pe-0 text-lg-end text-start">
                    Total pembayaran:
                </div>
                <div class="col-lg-3 mb-4 text-lg-end">
                    @currency($order->total)
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-group my-2">
                        <label class="form-label">Metode pembayaran:</label>
                        <br>
                        <strong>{{$transaction->payment_name}}</strong>
                    </div>
                    <div class="form-group my-2">
                        <label class="form-label">No. Referensi</label>
                        <input type="text" class=" form-control" value="{{$order->kodeSewa}}" readonly>
                    </div>
                    <div class="form-group my-2">
                        <label class="form-label">Tagihan</label>
                        <input type="text" class=" form-control" value="@currency($order->total)" readonly>
                    </div>
                    <div class="form-group my-2">
                        <label class="form-label">Batas pembayaran</label>
                        <p>
                            {{date('d, F Y H:i', $transaction->expired_time).' WIB'}}
                        </p>
                    </div>
                    @if(isset($transaction->qr_url))
                    <div class="form-group my-2">
                        <small><i>Scan kode QR berikut ini:</i></small>
                        <br>
                        <img src="{{$transaction->qr_url}}" width="200" height="200">
                    </div>
                    @endif
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($transaction->instructions as $i => $instruction)
                    <li class="list-group-item d-flex justify-content-between" style="background-color: #e9ecef;">
                        {{$instruction->title}}
                        <i class="show-detail bi bi-caret-right-fill" data-bs-toggle="collapse" data-bs-target=".instruction{{$i}}"></i>
                    </li>
                    @foreach($instruction->steps as $step)
                    <li class="list-group-item collapse instruction{{$i}}">{!!$loop->iteration . ". " . $step!!}</li>
                    @endforeach
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<script>
    function loadImg() {
        $('#frame').attr('src', URL.createObjectURL(event.target.files[0]));
    }

    function removeImg() {
        $('#frame').attr('src', '');
    }
</script>
<script>
    $('.upload-bukti').click(function() {
        let kodeSewa = $(this).attr('kode-sewa');
        $('#kodeSewa').val(kodeSewa);
    });
</script>
<script>
    $('.show-orders')
        .click(function() {
            teks = $(this).text();
            if (teks === 'Tampilkan daftar order...') {
                $(this).toggleClass('btn-primary').toggleClass('btn-danger');
                $(this).text('Sembunyikan daftar order...');
            } else {
                $(this).toggleClass('btn-primary').toggleClass('btn-danger');
                $(this).text('Tampilkan daftar order...');
            }
        })
</script>
<script>
    $('.show-detail')
        .click(function() {
            $(this)
                .toggleClass('bi-caret-down-fill')
                .toggleClass('bi-caret-right-fill')
        });
</script>
@endsection