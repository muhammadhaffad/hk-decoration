@extends('layouts.master')
@section('title')
Checkout
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
    <div class="p-3 card shadow-sm my-4">
        <h3>Informasi penyewa</h3>
        <div class="container">
            <div class="row mb-3">
                <div class="col-lg-2 mb-2">
                    <label class="fw-bold"><small>Nama penyewa</small></label>
                    <div class="fw-bold text-wrap">
                        {{$checkout['nama']}} ({{$checkout['notlp']}})
                    </div>
                </div>
                <div class="col-lg-5 mb-2">
                    <label class="fw-bold"><small>Alamat penyewa</small></label>
                    <div class="">
                        {{$checkout['alamat']}}
                    </div>
                </div>
                <div class="col-lg-5 mb-2">
                    <div class="row">
                        <div class="col-lg-6 pe-lg-2">
                            <label class="fw-bold"><small>Mulai tanggal</small></label>
                            <input type="date" value="{{$checkout['tglsewa']}}" class="form-control" disabled>
                        </div>
                        <div class="col-lg-6 ps-lg-2">
                            <label class="fw-bold"><small>Sampai tanggal</small></label>
                            <input type="date" value="{{$checkout['tglbongkar']}}" class="form-control" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button class="btn btn-outline-dark" style="width: 150px;" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Ubah</button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/checkout/change" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <p class="fs-5">Isi informasi penyewa,..</p>
                        <label class="form-label" for="nama-penyewa">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama-penyewa" value="{{$checkout['nama']}}" name="nama">
                        @error('nama')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                        <label class="form-label" for="nomor-telepon">Nomor telepon</label>
                        <input type="text" class="form-control @error('notlp') is-invalid @enderror" id="nomor-telepon" value="{{$checkout['notlp']}}" name="notlp">
                        @error('notlp')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                        <hr>
                        <p class="fs-5">Mulai dan sampai tanggal,..</p>
                        <div class="row">
                            <div class="col-6">
                                <label for="tanggal-sewa">Dari tanggal <br> <small>(Pemasangan H-1)</small></label>
                                <input type="date" class="form-control @error('tglsewa') is-invalid @enderror" id="tanggal-sewa" value="{{$checkout['tglsewa']}}" name="tglsewa">
                                @error('tglsewa')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="tanggal-bongkar">Sampai tanggal <br> <small>(Pembongkaran H+1)</small></label>
                                <input type="date" class="form-control @error('tglbongkar') is-invalid @enderror" id="tanggal-bongkar" value="{{$checkout['tglbongkar']}}" name="tglbongkar">
                                @error('tglbongkar')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <p class="fs-5">Tulis alamat pengiriman,..</p>
                        <div class="row">
                            <div class="col-lg">
                                <label for="floatingInput">Ongkir</label>
                                <select id="ongkir" class="selectpicker w-100 @error('ongkir') is-invalid @enderror" data-live-search="true" value="{{$checkout['ongkir']}}" name="ongkir">
                                </select>
                                @error('ongkir')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <label for="alamat-lengkap">Alamat Lengkap</label>
                        <textarea type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat-lengkap" rows="3" style="resize: none;" name="alamat">{{$checkout['alamat']}}</textarea>
                        @error('alamat')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn w-25 btn-outline-dark">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <h3>Checkout</h3>
    <div class="row my-4">
        <div class="col">
            @if ($message = Session::get('warning'))
            <div class="alert alert-warning alert-dismissible fade show">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {!! $message !!}
            </div>
            @endif
            <table class="table table-borderless">
                <thead>
                    <tr class="text-center">
                        <th class="col-12 col-lg-3 text-start">Produk</th>
                        <th class="col-lg d-none d-lg-table-cell">Harga satuan</th>
                        <th class="col-lg d-none d-lg-table-cell">Kuantitas</th>
                        <th class="col-lg d-none d-lg-table-cell">Tambah hari</th>
                        <th class="col-lg d-none d-lg-table-cell">Harga tambah hari</th>
                        <th class="col-lg d-none d-lg-table-cell">Harga subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $checkout['hargaSewa'] = explode(',', $checkout['hargaSewa']) @endphp
                    @foreach($items as $index => $item)
                    <tr class="text-center align-middle">
                        <td>
                            <div class="d-flex align-items-center text-start">
                                <img src="{{asset('storage/' . $item->cartable()->first()->gambar)}}" alt="mdo" class="me-2 rounded" width="70" height="70" style="object-fit:cover">
                                <div class="flex-column">
                                    <p class="mb-0 d-lg-none text-muted"><small>@currency($item->cartable()->first()->harga)</small></p>
                                    <div class="h6 mb-0">{{$item->cartable()->first()->nama}}</div>
                                    <small>
                                        <p class="mb-0 d-lg-none text-muted">Tambah hari: {{$checkout['lamaSewa']}} Hari</p>
                                        <p class="mb-0 d-lg-none text-muted">Harga tambah hari: @currency($checkout['hargaSewa'][$index])</p>
                                    </small>
                                    <p class="mb-0 d-lg-none text-muted">Subtotal: {{$item->kuantitas}}&Cross;(@currency($item->cartable()->first()->harga)&plus;{{$checkout['lamaSewa']}}&Cross;@currency($checkout['hargaSewa'][$index])) = @currency($item->kuantitas*($item->cartable()->first()->harga + ($checkout['lamaSewa']*$checkout['hargaSewa'][$index])))</p>
                                </div>
                            </div>
                            <div class="d-flex d-lg-none justify-content-end align-items-end">
                                Jumlah: {{$item->kuantitas}}
                            </div>
                        </td>
                        <td class="harga-satuan d-none d-lg-table-cell">@currency($item->cartable()->first()->harga)</td>
                        <td class="d-none d-lg-table-cell">
                            {{$item->kuantitas}}
                        </td>
                        <td class="d-none d-lg-table-cell">
                            @if($checkout['lamaSewa'] != 0)
                            {{$checkout['lamaSewa']}} Hari
                            @else
                            -
                            @endif
                        </td>
                        <td class="d-none d-lg-table-cell">
                            @if($checkout['lamaSewa'] != 0)
                            {{$checkout['lamaSewa']}}&Cross;@currency($checkout['hargaSewa'][$index])
                            @else
                            -
                            @endif
                        </td>
                        <td class="harga-total d-none d-lg-table-cell text-start">
                            <small>{{$item->kuantitas}}&Cross;(@currency($item->cartable()->first()->harga)&plus;{{$checkout['lamaSewa']}}&Cross;@currency($checkout['hargaSewa'][$index]))</small>
                            <br>
                            = @currency($item->kuantitas*($item->cartable()->first()->harga + ($checkout['lamaSewa']*$checkout['hargaSewa'][$index])))
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="align-items-baseline alert alert-secondary me-0 my-4">
        <div class="row">
            <div class="col-lg-10 fw-bold pe-0 text-lg-end text-start">
                Jenis pembayaran:
            </div>
            <div class="col-lg-2 text-start">
                @if($checkout['bayar']=='Uang muka')
                <span class="badge bg-secondary">UANG MUKA</span>
                @else
                <span class="badge bg-primary">LUNAS</span>
                @endif
            </div>
            <div class="col-lg-10 fw-bold pe-0 text-lg-end text-start">
                Total pemesanan:
            </div>
            <div class="col-lg-2 text-start">
                @currency($checkout['total'])
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 fw-bold pe-0 text-lg-end text-start">
                Biaya ongkir:
            </div>
            <div class="col-lg-2 text-start">
                @currency($checkout['biayaongkir'])
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 fw-bold pe-0 text-lg-end text-start">
                Total pembayaran:
            </div>
            <div class="col-lg-2 text-start">
                @currency($checkout['total']+$checkout['biayaongkir'])
            </div>
        </div>
    </div>
    <div class="my-4 card shadow-sm p-3">
        <h3 class="">Metode pembayaran</h3>
        <div class="row">
            <label for="payment-method" class="form-label fw-bold">Pilih bank</label>
        </div>
        <form action="/myorder" method="post" enctype="multipart/form-data">
            <div class="d-flex gap-2 mb-3 align-items-center">
                @foreach($channels as $channel)
                @if($channel->active)
                <input type="radio" class="form-check-input" name="method" value="{{$channel->code}}" id="{{$channel->code}}">
                <div class="d-flex flex-column align-items-center me-4">
                    <img class="text-light" src="{{$channel->icon_url}}" width="100" height="40" alt="">
                    <small>
                        {{$channel->name}}
                    </small>
                    <small>
                        <strong>
                            + @currency($channel->fee_customer->flat) + {{$channel->fee_customer->percent}}%
                        </strong>
                    </small>
                </div>
                @endif
                @endforeach
            </div>
            <div class="text-danger">
                @error('method') {{$message}} @enderror
            </div>
            <p class="text-danger">
                *batas waktu pembayaran 1x24 jam
            </p>
            <div class="text-end col-lg-2 ms-auto">
                @csrf
                <div class="row">
                    <div class="col ps-1">
                        <button type="submit" name="bayar" value="bayar-sekarang" class="btn btn-outline-dark mt-2 w-100">Bayar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        var ongkir = $('#ongkir');
        $.getJSON('shipping', function(json) {
            ongkir.html('');
            str = "<option value=''>&ltKabupaten&gt, &ltKecamatan&gt</option>";
            ongkir.append(str);
            $.each(json, function(index, value) {
                // darle un option con los valores asignados a la variable select
                str = `<option value='${value.id}'>${value.kabupaten}, ${value.kecamatan}</option>`;
                ongkir.append(str);
            });
            str = `<option value='999'>Lainnya...</option>`;
            ongkir.append(str);
            ongkir.selectpicker('refresh');
            $('#ongkir').selectpicker('val', "{{$checkout['ongkir']}}")
        });
    });
</script>

@if(count($errors) > 0)
<script>
    window.onload = () => {
        $('#staticBackdrop').modal('show');
    }
</script>
@enderror
@endsection