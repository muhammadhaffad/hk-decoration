@extends('admin.layouts.master', ['title' => 'Belum bayar'])
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
@endsection
@section('content')
<table id="table-unpaid" class="table">
    <thead>
        <tr>
            <th>
                <div class="d-flex justify-content-between">
                    <p class="mb-0">
                        Daftar Transaksi
                    </p>
                </div>
            </th>
            <th class="col-1 d-none d-lg-table-cell">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php $count = 0 @endphp
        @foreach($payments->get() as $payment)
        @php $count += 1 @endphp
        <tr>
            <td>
                <table class="table-items table table-borderless w-100">
                    <thead>
                        <tr>
                            <th class="col-12 col-lg-4 align-middle">
                                <form action="@if($payment->status === 'Sudah dikonfirmasi') /receipt @else /invoice @endif" method="post">
                                    @csrf
                                    KODE TRANSAKSI ❯ #{{$payment->order()->first()->kodeSewa}}
                                    @if($payment->status === null)
                                    <span class="badge bg-warning text-wrap">Belum dibayar</span>
                                    @endif
                                    <input type="hidden" name="kodeSewa" value="{{$payment->order()->first()->kodeSewa}}">
                                    <button type="submit" class="badge btn btn-sm btn-danger text-white">Tampil tagihan</button>
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
                <div class="row my-3">
                    <p class="mb-0 d-lg-none text-muted">Biaya ongkir: @currency($payment->order()->first()->ongkir)</p>
                    <div class="d-none d-lg-block col-lg-9 fw-bold pe-0 text-lg-end text-start">
                        Biaya ongkir:
                    </div>
                    <div class="d-none d-lg-block col-lg-3 text-start">
                        @currency($payment->order()->first()->ongkir)
                    </div>
                    <div class="col-lg-9 fw-bold pe-0 text-lg-end text-start">
                        Total pembayaran:
                    </div>
                    <div class="col-lg-3 text-start">
                        @currency($payment->order()->first()->total + $payment->order()->first()->ongkir) <span class="badge @if($payment->order()->first()->jenis == 'DP') bg-secondary @else bg-primary @endif">@if($payment->order()->first()->jenis == 'DP') Uang muka @else Bayar lunas @endif</span>
                    </div>
                    <div class="d-block d-lg-none mt-3">
                        <form action="{{route('admin.unpaid.destroy')}}" method="post">
                            @csrf
                            <div class="block mt-2">
                                <input type="hidden" name="payment_id" value="{{$payment->id}}">
                                <button href="#" class="btn text-decoration-none btn-danger" onclick="return confirm('Anda yakin ingin menghapus?')">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </td>
            <td class="col-1 d-lg-table-cell d-none align-middle">
                <form action="{{route('admin.unpaid.destroy')}}" method="post">
                    @csrf
                    <div class="block mt-2">
                        <input type="hidden" name="payment_id" value="{{$payment->id}}">
                        <button href="#" class="btn text-decoration-none btn-danger" onclick="return confirm('Anda yakin ingin menghapus?')">
                            <i class="fa fa-trash"></i> Hapus
                        </button>
                    </div>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Bukti pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ms-auto me-auto">
                <img id="tampilBukti" src="{{asset('images/slide2.jpg')}}" alt="Bukti pembayaran" style="max-width: 100%;">
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
    $(document).ready(function() {
        $('#table-unpaid').DataTable({
            bFilter: false,
            lengthChange: false
        });
        $('.table-items').DataTable();
    });
</script>
<script>
    $('.lihat-bukti').click(function() {
        let url = $(this).attr('gambar');
        $('#tampilBukti').attr('src', url);
    });
</script>
@endsection