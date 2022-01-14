@extends('admin.layouts.master', ['title' => 'Laporan bulanan'])
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content')
<div class="d-flex justify-content-end flex-wrap align-items-center pt-3 pb-2 mb-3">
    <form action="" method="get">
        <div class="d-flex">
            <div class="col pe-1 input-group">
                <input type='text' name="date" placeholder="Pilih bulan" class="form-control" id='datepicker'>
                <input type="submit" value="Lihat" class="btn btn-primary">
            </div>
            <a href="/admin/report/monthly/export?date={{ (request()->get('date')) ? request()->get('date') : date('Y-m') }}" class="btn btn-secondary"><i class="fa fa-file-excel"></i> Excel</a>
        </div>
    </form>
</div>
<div class="">
    <table id="report_monthly" class="display table table-bordered">
        <thead>
            <tr class="align-middle text-center">
                <th class="text-center" rowspan="2">
                    Kode Sewa
                </th>
                <th class="text-center" rowspan="2">
                    Nama Produk
                </th>
                <th class="text-center" rowspan="2">
                    Harga (1 Hari)
                </th>
                <th class="text-center" rowspan="2">
                    Jumlah
                </th>
                <th class="text-center" rowspan="2">
                    Tanggal Transaksi
                </th>
                <th class="text-center" colspan="3">
                    Penyewa
                </th>
                <th class="text-center" colspan="2">
                    Tanggal Sewa
                </th>
                <th class="text-center" rowspan="2">
                    Tambah hari
                </th>
                <th class="text-center" rowspan="2">
                    Harga tambah hari
                </th>
                <th class="text-center" rowspan="2">
                    Harga subtotal
                    <br>
                    <small>
                        jml&Cross;(harga&plus;(tambah hari&Cross;harga tambah hari))
                    </small>
                </th>
                <th class="text-center" rowspan="2">
                    Tanggal Kembali
                </th>
                <th class="text-center" rowspan="2">
                    Jenis Pembayaran
                </th>
                <th class="text-center" rowspan="2">
                    Waktu Pelunasan
                </th>
                <th class="text-center" rowspan="2">
                    Total Pemesanan
                </th>
                <th class="text-center" rowspan="2">
                    Biaya Ongkir
                </th>
            </tr>
            <tr class="align-middle">
                <th class="text-center">
                    Nama Lengkap
                </th>
                <th class="text-center">
                    No. Telepon
                </th>
                <th class="text-center">
                    Alamat
                </th>
                <th class="text-center">
                    Mulai dari
                </th>
                <th class="text-center">
                    Sampai dengan
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            @php $print = true @endphp
            @foreach($order->orderitems as $orderitem)
            <tr>
                <td>
                    {{$order->kodeSewa}}
                </td>
                <td>
                    {{$orderitem->orderable()->first()->nama}}
                </td>
                <td>
                    {{$orderitem->orderable()->first()->harga}}
                </td>
                <td>
                    {{$orderitem->kuantitas}}
                </td>
                <td>
                    {{$order->tanggalTransaksi}}
                </td>
                <td>
                    {{$order->namaPenyewa}}
                </td>
                <td>
                    {{$order->noTlpPenyewa}}
                </td>
                <td>
                    {{$order->alamatPenyewa}}
                </td>
                <td>
                    {{$order->tanggalSewa}}
                </td>
                <td>
                    {{$order->tanggalBongkar}}
                </td>
                <td>
                    {{$orderitem->lamaSewa}}
                </td>
                <td>
                    {{$orderitem->hargaSewa}}
                </td>
                <td>
                    {{$orderitem->subtotal}}
                </td>
                <td>
                    {{$order->tanggalKembali}}
                </td>
                <td>
                    {{$order->jenis}}
                </td>
                <td>
                    {{($order->waktuPelunasan != null) ? $order->waktuPelunasan : '-'}}
                </td>
                <td>
                    {{$order->total}}
                </td>
                <td>{{$order->ongkir}}</td>
            </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>
</div>

@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('#report_monthly').DataTable({
            scrollX: true,
            columnDefs: [{
                    width: '300px',
                    targets: [12],
                    className: 'text-center'
                },
                {
                    width: '150px',
                    targets: [13],
                    className: 'text-center'
                },
                {
                    width: '150px',
                    targets: [0, 1, 2, 4, 5, 6, 7, 8, 9],
                    className: 'text-start'
                }
            ],
        }).columns.adjust();
    });
</script>
<script>
    document.addEventListener('trix-file-accept', function(e) {
        e.preventDefault();
    });
</script>
<script>
    $('.btn-detail-bank').click(function() {
        let row = $(this).closest('tr');
        let gambar = row.find('#gambar').attr('src');
        let nama = row.find('#nama').text();
        let keterangan = row.find('#keterangan').attr('keterangan');
        $('#editBankName').val(nama);
        $('#detailModal').html(keterangan);
        $('#bank_id').val($(this).attr('bank-id'));
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#datepicker').datepicker({
            viewMode: "months",
            minViewMode: "months",
            format: 'yyyy-m'
        });
    });
</script>
@endsection