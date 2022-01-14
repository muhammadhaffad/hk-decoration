@extends('layouts.master', ['noMenu' => true])
@section('title')
Receipt - {{$order->kodeSewa}}
@endsection
@section('content')
<div class="container" style="margin-top: 6rem">
    <div class="d-flex align-items-center justify-content-between">
        <h3>Struk</h3>
        <button type="submit" style="height:100%" class="ms-1 btn btn-sm btn-primary" onclick="printDiv('printableArea')"><i class="bi bi-printer"></i> Print</button>
    </div>
    <hr>
    <div id="printableArea" class="container">
        <div class="px-lg-5">
            <div class="mt-3">
                <div class="row">
                    <div class="col">
                        <div class="h4 mb-0 fw-bold">
                            Struk Pembayaran
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex h3">
                            <div class="fw-bold me-1 text-danger">HK</div> DECORATION
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="fs-5">Referensi Transaksi: {{$order->kodeSewa}}</div>
                    <p class="mb-0"><small>Berikut adalah struk pembayaran untuk transaksi Anda di HK Decoration</small></p>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col">
                    <div class="mb-2">
                        Diberikan untuk
                    </div>
                    <small class="fw-bold">
                        {{$order->namaPenyewa}}
                        <br>
                        {{$order->user()->first()->customer()->first()->nomorTelepon}}
                    </small>
                </div>
                <div class="col">
                    <div class="mb-2">
                        Dibayarkan pada
                    </div>
                    <small class="fw-bold">
                        {{$order->payment()->first()->tanggalKirim}}
                    </small>
                </div>
                <div class="col">
                    <div class="mb-2">
                        Jenis pembayaran
                    </div>
                    <small class="fw-bold">
                        @if($order->jenis == 'DP')
                        {{$order->jenis}} <br>
                        <p class="fw-normal mb-0"> Akan dibayar lunas pada </p>
                        @if($order->waktuPelunasan == 'awal')
                        {{date('j F, Y', strtotime($order->tanggalSewa))}}
                        @else
                        {{date('j F, Y', strtotime($order->tanggalBongkar))}}
                        @endif
                        @else
                        {{$order->jenis}}
                        @endif
                    </small>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="mb-2">
                        Alamat email
                    </div>
                    <small class="fw-bold">
                        {{$order->user()->first()->email}}
                    </small>
                </div>
            </div>
            <div class="table-responsive mt-3">
                <table class="table">
                    <thead>

                        <tr>
                            <th scope="col" class="col-1">No.</th>
                            <th scope="col" class="col">Nama</th>
                            <th scope="col" class="col">Harga satuan</th>
                            <th scope="col" class="col">Kuantitas</th>
                            <th scope="col" class="col">Tambah hari</th>
                            <th scope="col" class="col">Harga tambah hari</th>
                            <th scope="col" class="col">Harga subtotal</th>
                        </tr>

                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach($order->orderitems()->get() as $item)
                        <tr>
                            <th scope="row">{{$no++}}</th>
                            <td>{{$item->orderable()->first()->nama}}</td>
                            <td>@currency($item->orderable()->first()->harga)</td>
                            <td class="text-center">{{$item->kuantitas}}</td>
                            <td>
                                @if($item->lamaSewa != 0)
                                {{$item->lamaSewa}} Hari
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                @if($item->lamaSewa != 0)
                                {{$item->lamaSewa}}&Cross;@currency($item->hargaSewa)
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                <small>{{$item->kuantitas}}&Cross;(@currency($item->orderable()->first()->harga)&plus;{{$item->lamaSewa}}&Cross;@currency($item->hargaSewa))</small>
                                <br>
                                = @currency($item->subtotal)
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="align-items-baseline alert alert-info me-0">
                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-3">
                            <div class="text-start">
                                Jenis pembayaran:
                            </div>
                            <div class="fw-bold text-start">
                                {{$order->jenis}}
                            </div>
                            <div class="text-start">
                                Biaya ongkir:
                            </div>
                            <div class="fw-bold text-start">
                                @currency($order->ongkir)
                            </div>
                            <div class="text-start">
                                Jumlah total yang sudah dibayar:
                            </div>
                            @if($order->jenis == 'DP')
                            <div class="fw-bold text-start">
                                <del class="fw-normal">@currency(($order->total * 2) + $order->ongkir)</del> <br> @currency($order->total + $order->ongkir)
                            </div>
                            @else
                            <div class="fw-bold text-start">
                                @currency($order->total + $order->ongkir)
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
@endsection