@extends('admin.layouts.master', ['title' => 'Pengembalian'])
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
<div class="d-flex justify-content-end mb-2">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
        Tampilkan status...
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
        <li><a class="dropdown-item" href="?status=false">Belum kembali</a></li>
        <li><a class="dropdown-item" href="?status=true">Sudah kembali</a></li>
    </ul>
</div>
<table id="table-return" class="table">
    <thead>
        <tr>
            <th>
                <div class="d-flex justify-content-between">
                    <p class="mb-0">
                        Daftar Transaksi
                    </p>
                </div>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders->get() as $order)
        <tr>
            <td>
                <div class="d-flex justify-content-between align-items-center p-2" style="background-color:#e2e3e5">
                    @csrf
                    <strong>
                        KODE TRANSAKSI &NestedGreaterGreater; #{{$order->kodeSewa}}
                    </strong>
                    <div class="btn-group d-block text-end ">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Aksi
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if($order->tanggalKembali == null)
                            <form action="/admin/return/confirm" method="post">
                                @csrf
                                <input type="hidden" name="kodeSewa" value="{{$order->kodeSewa}}">
                                <button href="#" class="astext w-100 text-start" onclick="return confirm('Anda yakin ingin konfirmasi?')">
                                    <li>
                                        <a class="dropdown-item">
                                            <i class="fa fa-sign-in-alt"></i> Konfirmasi kembali
                                        </a>
                                    </li>
                                </button>
                            </form>
                            @else
                            <li>
                                <a class="dropdown-item">
                                    <i class="fa fa-check-circle"></i> Sudah kembali
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
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
                        @endif
                        <span class="badge @if($order->jenis == 'DP') bg-secondary @else bg-primary @endif">
                            @if($order->jenis == 'DP') UANG MUKA @else Bayar LUNAS @endif
                        </span>
                        <br>
                        <strong>Nama penyewa:</strong>
                        <br>
                        {{$order->namaPenyewa}}
                        <br>
                        <strong>Nomor telepon:</strong>
                        <br>
                        {{$order->noTlpPenyewa}}
                        <br>
                        <strong>Alamat:</strong>
                        <br>
                        {{$order->alamatPenyewa}}
                        <br>
                    </div>
                    <div>
                        <strong>Tanggal penyewaan:</strong>
                        <br>
                        <small>{{date('d, F Y', strtotime($order->tanggalSewa))}} s/d {{date('d, F Y', strtotime($order->tanggalBongkar))}}</small>
                        <br>
                        <strong>Tambah hari:</strong>
                        {{$order->lamaSewa}} Hari
                        <br>
                        <div class="fw-bold pe-0 text-start">
                            Biaya ongkir: @currency($order->ongkir)
                        </div>
                        <div class="fw-bold pe-0 text-start">
                            Total pembayaran: @currency($order->total)
                        </div>
                    </div>
                </div>
                <a class="show-orders btn btn-sm btn-primary text-decoration-none" data-bs-toggle="collapse" href="#{{$order->kodeSewa}}" role="button">Tampilkan daftar order...</a>
                <div id="{{$order->kodeSewa}}" class="mt-3 collapse">
                    <table class="table-items table table-bordered w-100 ">
                        <thead class=" table-secondary">
                            <tr class=" text-center align-middle">
                                <th class="col-12 align-middle">Produk</th>
                                <th class="d-none d-lg-table-cell">Harga satuan</th>
                                <th class="d-none d-lg-table-cell">Kuantitas</th>
                                <th class="d-none d-lg-table-cell">Tambah hari</th>
                                <th class="d-none d-lg-table-cell">Harga tambah hari</th>
                                <th class="d-none d-lg-table-cell">Harga subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderitems as $item)
                            <tr class="align-middle">
                                <td class="col-12 col-lg-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{asset('storage/' . $item->orderable()->first()->gambar)}}" alt="mdo" class="rounded me-2" width="70" height="70" style="object-fit:cover">
                                        <div class="flex-column">
                                            <p class="mb-0 d-lg-none text-muted"><small>@currency($item->orderable()->first()->harga)</small></p>
                                            <div class="h6 mb-0">{{$item->orderable()->first()->nama}}</div>
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
                                <td class="d-none d-lg-table-cell harga-satuan d-none d-lg-table-cell">@currency($item->orderable()->first()->harga)</td>

                                <td class="d-none d-lg-table-cell d-none d-lg-table-cell text-center">
                                    {{$item->kuantitas}}
                                </td>
                                <td class="d-none d-lg-table-cell d-none d-lg-table-cell text-center">
                                    @if($item->lamaSewa != 0)
                                    {{$item->lamaSewa}} Hari
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="d-none d-lg-table-cell d-none d-lg-table-cell">
                                    @if($item->lamaSewa != 0)
                                    {{$item->lamaSewa}}&Cross;@currency($item->hargaSewa)
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="d-none d-lg-table-cell d-none d-lg-table-cell">
                                    <small>{{$item->kuantitas}}&Cross;(@currency($item->orderable()->first()->harga)&plus;{{$item->lamaSewa}}&Cross;@currency($item->hargaSewa))</small>
                                    <br>
                                    = @currency($item->subtotal)
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-secondary fw-bold">
                            <tr>
                                <td class="text-end" colspan="5">Biaya ongkir:</td>
                                <td>@currency($order->ongkir)</td>
                            </tr>
                            <tr>
                                <td class="text-end" colspan="5">Biaya transfer:</td>
                                <td>@currency($order->biayaTransfer)</td>
                            </tr>
                            <tr>
                                <td class="text-end" colspan="5">Total:</td>
                                <td>@currency($order->total)</td>
                            </tr>
                        </tfoot>
                    </table>
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
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('#table-return').DataTable({
            lengthChange: false,
            dom: "<'row'<'col-lg-12 col-md-12 col-xs-12'f><'col-lg-2 col-md-2 col-xs-12'l>>" +
                "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            language: {
                search: '',
                searchPlaceholder: "Cari kustomer/kode referensi..."
            },
        });
        $('.dataTables_filter label').css({
            'width': '50%',
            'margin-left': 0,
            'display': 'inline-block'
        });
        $('.dataTables_filter input[type="search"]').css({
            'width': '50%',
            'display': 'inline-block'
        });
        $('.table-items').DataTable();
    });
</script>
<script>
    $('.lihat-detail').click(function() {
        let order_id = $(this).attr('order-id');
        $.getJSON('/admin/order?id=' + order_id, function(data) {
            $('#detailOrderLabel').text('Detail #' + data.kodeSewa);
            $('#detailOrderNama').val(data.namaPenyewa);
            $('#detailOrderNoTlp').val(data.noTlpPenyewa);
            $('#detailOrderDariTgl').val(data.tanggalSewa);
            $('#detailOrderSampaiTgl').val(data.tanggalBongkar);
            $('#detailOrderAlamat').text(data.alamatPenyewa);
        })
    });
</script>
<script>
    $('.lihat-bukti').click(function() {
        let url = $(this).attr('gambar');
        $('#tampilBukti').attr('src', url);
    });
</script>
@endsection