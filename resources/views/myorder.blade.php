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
            <table class="table">
                <thead class="table-secondary">
                    <tr>
                        <th class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-0">
                                    Daftar Transaksi &NestedGreaterGreater; {{$status}}
                                </p>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Tampilkan status...
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="?status=paid">Sudah dibayar</a></li>
                                        <li><a class="dropdown-item" href="?status=unpaid">Belum dibayar</a></li>
                                        <li><a class="dropdown-item" href="?status=expired">Kedaluwarsa</a></li>
                                        <li><a class="dropdown-item" href="?status=failed">Gagal</a></li>
                                        <li><a class="dropdown-item" href="?status=refund">Refund</a></li>
                                    </ul>
                                </div>
                                <!-- <a href="/myorder/confirmation" class="text-decoration-none mb-0 text-primary fw-normal">
                                    Lihat konfirmasi
                                </a> -->

                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php $count = 0 @endphp
                    @foreach($orders->get() as $order)
                    @php $count += 1 @endphp
                    <tr>
                        <td colspan="col-10" class="pt-4">
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
                            <div class="d-flex justify-content-between">
                                <div>
                                    @if($order->status === 'unpaid')
                                    <span class="badge bg-warning text-wrap">UNPAID</span>
                                    @elseif($order->status === 'paid')
                                    <span class="badge bg-success text-wrap">PAID</span>
                                    @elseif($order->status === 'expired')
                                    <span class="badge bg-warning text-wrap">EXPIRED</span>
                                    @elseif($order->status === 'failed')
                                    <span class="badge bg-danger text-wrap">FAILED</span>
                                    @elseif($order->status === 'refund')
                                    <span class="badge bg-secondary text-wrap">REFUND</span>
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
                                    <strong>Biaya ongkir:</strong>
                                    @currency($order->ongkir)
                                    <br>
                                    <strong>Biaya transfer</strong>
                                    @currency($order->biayaTransfer)
                                    <br>
                                    <strong>Total pembayaran:</strong>
                                    @currency($order->total)
                                </div>
                                <div>
                                </div>
                            </div>
                            <a class="show-orders btn btn-sm btn-primary text-decoration-none" data-bs-toggle="collapse" href="#{{$order->kodeSewa}}" role="button">Tampilkan daftar order...</a>
                            <div id="{{$order->kodeSewa}}" class="collapse mt-3">
                                <table class="table">
                                    <thead class=" table-borderless table-secondary">
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
                                                        <small class="mb-0 d-lg-none text-muted">Subtotal: {{$item->kuantitas}}&Cross;(@currency($item->orderable()->first()->harga)&plus;{{$item->lamaSewa}}&Cross;@currency($item->hargaSewa)) = @currency($item->subtotal)</small>
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
                                                <small>{{$item->kuantitas}}&Cross;(@currency($item->orderable()->first()->harga)&plus;{{$item->lamaSewa}}&Cross;@currency($item->hargaSewa))</small>
                                                <br>
                                                = @currency($item->subtotal)
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-secondary">
                                        <tr class="d-none d-lg-table-row">
                                            <td colspan="4" class="text-end">
                                                Biaya ongkir:
                                            </td>
                                            <td>@currency($order->ongkir)</td>
                                        </tr>
                                        <tr class="d-none d-lg-table-row">
                                            <td colspan="4" class="text-end">
                                                Biaya transfer:
                                            </td>
                                            <td>@currency($order->biayaTransfer)</td>
                                        </tr>
                                        <tr class="d-none d-lg-table-row">
                                            <td colspan="4" class="text-end">
                                                Total pembayaran:
                                            </td>
                                            <td>@currency($order->total)</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            @if($order->status === 'unpaid')
                            <div class="d-flex justify-content-end mb-3">
                                <div class="text-end">
                                    <a class="btn btn-dark mx-3 w-100" href="{{route('myorder.detail',['code'=>$order->kodeSewa])}}">Bayar</a>
                                </div>
                            </div>
                            @elseif($order->status === 'paid')
                            <div class="d-flex justify-content-end mb-3">
                                <div class="text-end">
                                    <a class="btn btn-success mx-3 w-100" href="{{route('reorder',['code'=>$order->kodeSewa])}}">Pesan kembali</a>
                                </div>
                            </div>
                            @else
                            <div class="d-flex justify-content-end mb-3">
                                <div class="text-end">
                                    <a class="btn btn-success mx-3 w-100" href="{{route('reorder',['code'=>$order->kodeSewa])}}">Pesan kembali</a>
                                </div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($count == 0)
            <div class="alert alert-secondary" role="alert">
                Order masih kosong,..
            </div>
            @endif
        </div>
    </div>
    <!-- <div class="modal fade" id="upload-bukti" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="upload-buktiLabel" aria-hidden="true">
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
    </div> -->
</div>
@endsection
@section('js')
@if (count($errors) > 0)
<script>
    // window.onload = () => {
    //     $('#upload-bukti').modal('show');
    // }
</script>
@endif
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
@endsection