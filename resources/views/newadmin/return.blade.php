@extends('newadmin.layouts.master', ['title' => 'Pengembalian'])
@section('content')
<div class="row">
    <table class="table">
        <thead>
            <tr>
                <th class="col-10">
                    <div class="d-flex justify-content-between">
                        <p class="mb-0">
                            Daftar Transaksi
                        </p>
                    </div>
                </th>
                <th class="col-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $count = 0 @endphp
            @foreach($payments->get() as $payment)
            @php $count += 1 @endphp
            <tr>
                <td colspan="col-10">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th class="col-12 col-lg-4 align-middle">
                                    <form action="@if($payment->status === 'Sudah dikonfirmasi') /receipt @else /invoice @endif" method="post">
                                        @csrf
                                        KODE TRANSAKSI ❯ #{{$payment->order()->first()->kodeSewa}}
                                        @if($payment->status === 'Sudah dikonfirmasi')
                                        <span class="badge bg-success text-wrap">Sudah dikonfirmasi</span>
                                        @endif
                                        <input type="hidden" name="kodeSewa" value="{{$payment->order()->first()->kodeSewa}}">
                                        @if($payment->status !== 'Gagal dikonfirmasi')
                                        @if($payment->status === 'Sudah dikonfirmasi')
                                        <button type="submit" class="badge btn btn-sm btn-primary text-white">Tampil struk</button>
                                        @else
                                        <button type="submit" class="badge btn btn-sm btn-danger text-white">Tampil tagihan</button>
                                        @endif
                                        @endif
                                    </form>
                                </th>
                                <th class="col-lg d-none d-lg-table-cell">Harga satuan</th>
                                <th class="col-lg d-none d-lg-table-cell">Kuantitas</th>
                                <th class="col-lg d-none d-lg-table-cell">Tambah hari</th>
                                <th class="col-lg d-none d-lg-table-cell">Harga tambah hari</th>
                                <th class="col-lg d-none d-lg-table-cell">Harga subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payment->order()->first()->orderitems()->get() as $item)
                            <tr class="align-middle">
                                <td class="col-12 col-lg-4">
                                    <div class="d-flex align-items-center">
                                        <img src="{{asset('storage/' . $item->orderable()->first()->gambar)}}" alt="mdo" class="rounded me-2" style="width: 100px; height: 100px; object-fit:cover">
                                        <div class="flex-column">
                                            <p class="mb-0 d-lg-none text-muted"><small>@currency($item->orderable()->first()->harga)</small></p>
                                            <div class="h6 mb-0">{{$item->orderable()->first()->nama}}</div>
                                            <div class="">#{{$payment->order()->first()->kodeSewa}}</div>
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
                                <td class="col-lg d-none d-lg-table-cell d-none d-lg-table-cell">
                                    <small>{{$item->kuantitas}}&Cross;(@currency($item->orderable()->first()->harga)&plus;{{$item->lamaSewa}}&Cross;@currency($item->hargaSewa))</small>
                                    <br>
                                    = @currency($item->subtotal)
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <!-- <div class="col-lg-9 pe-0 text-lg-end text-start">
                        Ongkir:
                    </div>
                    <div class="col-lg-3 text-start">
                        @currency(20000)
                    </div>
                    <div class="col-lg-9 pe-0 text-lg-end text-start">
                        Total pemesanan:
                    </div>
                    <div class="col-lg-3 text-start">
                        @currency($payment->order()->first()->total)
                    </div> -->
                        <p class="mb-0 d-lg-none text-muted">Biaya ongkir: @currency($payment->order()->first()->ongkir)</p>
                        <div class="col-lg-9 fw-bold pe-0 text-lg-end text-start">
                            Total pembayaran:
                        </div>
                        <div class="col-lg-3 text-start">
                            @currency($payment->order()->first()->total + $payment->order()->first()->ongkir) <span class="badge @if($payment->order()->first()->jenis == 'DP') bg-secondary @else bg-primary @endif">@if($payment->order()->first()->jenis == 'DP') Uang muka @else Bayar lunas @endif</span>
                        </div>
                    </div>
                </td>
                <td class="col-2 pt-5">
                    <div class="block">
                        <a href="#" order-id="{{$payment->order()->first()->id}}" data-bs-toggle="modal" data-bs-target="#detailOrder" class="lihat-detail text-decoration-none text-primary">
                            <i class="bi bi-card-list"></i> Lihat detail
                        </a>
                    </div>
                    <div class="block mt-2">
                        @if($payment->order()->first()->tanggalKembali == null)
                        <form action="/admin/return/confirm" method="post">
                            @csrf
                            <input type="hidden" name="order_id" value="{{$payment->order()->first()->id}}">
                            <button type="submit" onclick="return confirm('Anda yakin ingin mengkonfirmasi?')" class="lihat-bukti astext text-start text-decoration-none text-success">
                                <i class="bi bi-box-arrow-in-right"></i> Konfirmasi pengembalian
                            </button>
                        </form>
                        @else
                        <span class="badge bg-success text-wrap">Sudah kembali</span>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="detailOrder" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailOrderLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailOrderLabel">Detail Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="detailOrderNama" class="form-label">Nama Penyewa</label>
                    <input disabled type="text" class="form-control mb-2" id="detailOrderNama">
                    <label for="detailOrderNoTlp" class="form-label">Nomor Telepon</label>
                    <input disabled type="text" class="form-control mb-2" id="detailOrderNoTlp">
                    <label for="detailOrderDariTgl" class="form-label">Dari Tanggal</label>
                    <input disabled type="date" class="form-control mb-2" id="detailOrderDariTgl">
                    <label for="detailOrderSampaiTgl" class="form-label">Sampai Tanggal</label>
                    <input disabled type="date" class="form-control mb-2" id="detailOrderSampaiTgl">
                    <label for="detailOrderAlamat" class="form-label">Alamat Penyewa</label>
                    <textarea disabled class="form-control mb-2" id="detailOrderAlamat" cols="30" rows="5"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection