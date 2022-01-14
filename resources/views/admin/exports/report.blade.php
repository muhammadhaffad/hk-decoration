<table>
    <thead>
        <tr>
            <th rowspan="2">
                No.
            </th>
            <th rowspan="2">
                Kode Sewa
            </th>
            <th rowspan="2">
                Nama Produk
            </th>
            <th rowspan="2">
                Harga (1 Hari)
            </th>
            <th rowspan="2">
                Jumlah
            </th>
            <th rowspan="2">
                Tanggal Transaksi
            </th>
            <th colspan="3">
                Penyewa
            </th>
            <th colspan="2">
                Tanggal Sewa
            </th>
            <th rowspan="2">
                Tambah hari
            </th>
            <th rowspan="2">
                Harga tambah hari
            </th>
            <th rowspan="2">
                Harga subtotal
                <br>
                <small>
                    jml*(harga+(tambah hari*harga tambah hari))
                </small>
            </th>
            <th rowspan="2">
                Tanggal Kembali
            </th>
            <th rowspan="2">
                Jenis Pembayaran
            </th>
            <th rowspan="2">
                Waktu Pelunasan
            </th>
            <th rowspan="2">
                Total Pemesanan
            </th>
            <th rowspan="2">
                Biaya Ongkir
            </th>
        </tr>
        <tr>
            <th>
                Nama Lengkap
            </th>
            <th>
                No. Telepon
            </th>
            <th>
                Alamat
            </th>
            <th>
                Mulai dari
            </th>
            <th>
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
                {{$loop->iteration}}
            </td>
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
            @if($print)
            <td rowspan="{{count($order->orderitems)}}">
                {{$order->total}}
            </td>
            <td rowspan="{{count($order->orderitems)}}">
                {{$order->ongkir}}
            </td>
            @php $print=false @endphp
            @endif
        </tr>
        @endforeach
        @endforeach
    </tbody>
</table>