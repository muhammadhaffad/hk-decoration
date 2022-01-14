@extends('layouts.master')
@section('title')
Keranjang
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
<link rel="stylesheet" href="{{asset('css/carousel.css')}}">
@endsection
@section('content')
<div class="container" style="margin-top: 8rem;">
    <h3>Daftar Keranjang</h3>
    @if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        {!! $message !!}
    </div>
    @endif
    @error('items')
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        Tidak ada item yang dipilih
    </div>
    @enderror
    <div class="row mb-3">
        <form action="/checkout" method="post">
            @csrf
            <div>
                <div class="my-4">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th style="width: 40px;"></th>
                                <th class="col-12 col-lg-4">Produk</th>
                                <th class="col-lg-2 d-none d-lg-table-cell">Harga satuan</th>
                                <th class="col-lg-2 d-none d-lg-table-cell">Kuantitas</th>
                                <th class="col-lg-2 d-none d-lg-table-cell">Total Harga</th>
                                <th class="col-lg-2 d-none d-lg-table-cell text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carts->get() as $item)
                            <tr cart-id="{{$item->id}}">
                                <td class="align-middle text-center" style="width: 30px"><input type="checkbox" name="items[]" value="{{$item->id}}" class="form-check-input checkbox"></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{asset('storage/' . $item->cartable()->first()->gambar)}}" alt="mdo" class="me-2 rounded" height="70" width="70" style="object-fit:cover">
                                        <div class="flex-column">
                                            <!-- <p class="mb-0 d-lg-none text-muted"><small>Rp. 500.000</small></p> -->
                                            <div class="h6 mb-0">{{$item->cartable()->first()->nama}}</div>
                                            <p class="mb-0 d-lg-none text-muted">@currency($item->cartable()->first()->harga)</p>
                                        </div>
                                    </div>
                                    <div class="d-flex d-lg-none justify-content-end align-items-end">
                                        <i class="remove bi bi-trash-fill me-3 fs-5"></i>
                                        <div class="mt-1" style="max-width: 100px;">
                                            <div class="input-group">
                                                <a href="/cart/decQty/{{$item->id}}" class="btn d-lg-none btn-outline-secondary btn-sm" style="width: 30px;"><strong>&minus;</strong></a>
                                                <input type="text" class="form-control form-control-sm text-center" value="{{$item->kuantitas}}">
                                                <a href="/cart/incQty/{{$item->id}}" class="btn d-lg-none btn-outline-secondary btn-sm" style="width: 30px;">&plus;</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="harga-satuan align-middle d-none d-lg-table-cell">@currency($item->cartable()->first()->harga)</td>
                                <td class="align-middle d-none d-lg-table-cell">
                                    <div class="mt-1" style="max-width: 100px;">
                                        <div class="input-group">
                                            <a href="/cart/decQty/{{$item->id}}" class="btn btn-outline-secondary btn-sm" style="width: 30px;"><strong>-</strong></a>
                                            <input type="text" class="form-control form-control-sm text-center" value="{{$item->kuantitas}}">
                                            <a href="/cart/incQty/{{$item->id}}" class="btn btn-outline-secondary btn-sm" style="width: 30px;">+</a>
                                        </div>
                                    </div>
                                </td>
                                <input type="hidden" class="harga-total" value="{{$item->cartable()->first()->harga*$item->kuantitas}}">
                                <td class="align-middle d-none d-lg-table-cell">@currency($item->cartable()->first()->harga*$item->kuantitas)</td>
                                <td class="align-middle d-none d-lg-table-cell text-center">
                                    <div class="remove btn btn-outline-danger">Hapus</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                &numsp;
                <div class="my-4">
                    <div class="align-items-baseline alert alert-secondary" style="border-radius: 0px;">
                        <div class="row">
                            <div class="col-lg-10 fw-bold pe-0 text-lg-end text-start">
                                Jumlah total:
                            </div>
                            <div id="jmltotal" class="col-lg-2 text-start fs-5">
                                0
                            </div>
                            <div class="col-lg-10"></div>
                            <div class="text-end col-lg-2">
                                <div class="btn btn-outline-dark mt-2 w-100" data-bs-toggle="modal" data-bs-target="#sewaModal">Checkout</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="sewaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="sewaModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="sewaModalLabel">Informasi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="fs-5">Isi informasi penyewa,..</p>
                                <label class="form-label" for="nama-penyewa">Nama</label>
                                <input required value="{{ auth()->user()->customer()->first()->nama }}" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama-penyewa" name="nama">
                                @error('nama')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                                <label class="form-label" for="nomor-telepon">Nomor telepon</label>
                                <input required value="{{ auth()->user()->customer()->first()->nomorTelepon }}" type="text" class="form-control @error('notlp') is-invalid @enderror" id="nomor-telepon" name="notlp">
                                @error('notlp')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                                <label class="label-control">Pilih pembayaran,..</label>
                                <div class="btn-group w-100 mt-2" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check" name="bayar" value="Uang muka" id="bayar1" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="bayar1">Uang muka</label>
                                    <input type="radio" class="btn-check" name="bayar" value="Lunas" id="bayar2" autocomplete="off" checked>
                                    <label class="btn btn-outline-primary" for="bayar2">Lunas</label>
                                </div>
                                @error('bayar')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                                <div id="waktuPelunasan" class="mt-2 d-none">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="waktuPelunasan" value="awal" id="waktuPelunasan1">
                                        <label class="form-check-label" for="waktuPelunasan1">
                                            Mulai tanggal sewa
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="waktuPelunasan" value="akhir" id="waktuPelunasan2">
                                        <label class="form-check-label" for="waktuPelunasan2">
                                            Selesai tanggal sewa
                                        </label>
                                    </div>
                                </div>

                                @error('waktuPelunasan')
                                {{$message}}
                                @enderror
                                <hr>
                                <p class="fs-5">Dari tanggal sampai tanggal,..</p>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label" for="tanggal-sewa">Dari tanggal <br> <small>(Pemasangan H-1)</small></label>
                                        <input required type="date" class="form-control @error('tglsewa') is-invalid @enderror" id="tanggal-sewa" name="tglsewa" value="{{ old('tglsewa') }}">
                                        @error('tglsewa')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="tanggal-bongkar">Sampai tanggal <br> <small>(Pembongkaran H+1)</small></label>
                                        <input required type="date" class="form-control @error('tglbongkar') is-invalid @enderror" id="tanggal-bongkar" name="tglbongkar" value="{{ old('tglbongkar') }}">
                                        @error('tglbongkar')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <hr>
                                <p class="fs-5">Tulis alamat Anda,..</p>
                                <div class="row">
                                    <div class="col-lg">
                                        <label class="form-label" for="floatingInput">Ongkir</label>
                                        <select id="ongkir" class="selectpicker w-100 @error('ongkir') is-invalid @enderror" data-live-search="true" name="ongkir">

                                        </select>
                                        @error('ongkir')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <label class="form-label" for="alamat-lengkap">Alamat Lengkap</label>
                                <textarea type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat-lengkap" rows="3" style="resize: none;" name="alamat">{{ auth()->user()->customer()->first()->alamat }}</textarea>
                                @error('alamat')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-outline-dark w-50" value="Checkout">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script>
    $('#bayar1').click(function() {
        $('#waktuPelunasan').removeClass('d-none');
    });
    $('#bayar2').click(function() {
        $('#waktuPelunasan').addClass('d-none');
        $('#waktuPelunasan1').prop('checked', false);
        $('#waktuPelunasan2').prop('checked', false);
    });
</script>
@if (count($errors) > 0)
<script>
    window.onload = () => {
        $('#sewaModal').modal('show');
    }
</script>
@endif
<script>
    $(document).ready(function() {
        var ongkir = $('#ongkir');
        $.getJSON('/shipping', function(json) {
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
        });
    });
</script>
<script>
    $('.remove').click(function() {
        let row = $(this).closest('tr');
        let id = row.attr('cart-id');
        $.ajax({
            type: "GET",
            url: "/cart/remove/" + id,
            success: function(result) {
                location.reload();
            },
            error: function(result) {
                alert('error');
            }
        });
    })
</script>
<script>
    $('tbody').change(function() {
        var values = 0; {
            $('tbody :checked').each(function() {
                let row = $(this).closest('tr');
                let harga = row.find('.harga-total').val();
                values = values + parseInt(harga);
            });
            // console.log(parseFloat(values));
            $('#jmltotal').text(new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR"
            }).format(values));
        }
    });
</script>
@endsection