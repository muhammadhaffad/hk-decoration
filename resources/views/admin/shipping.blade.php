@extends('admin.layouts.master', ['title' => 'Biaya ongkir'])
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection
@section('content')
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h4>Daftar kabupaten</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRegency">&plus; Tambah</button>
        </div>
        <table class="table">
            <thead>
                <tr class="align-middle">
                    <th>
                        Kabupaten
                    </th>
                    <th class="col-1">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($regencies as $regency)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="flex-column">
                                <div class="mb-0">{{$regency->nama}}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-start align-items-end">
                            <form action="/admin/shipping/delete-regency" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$regency->id}}">
                                <button class="btn btn-danger btn-sm me-2" onclick="confirm('Apakah Anda yakin menghapus data ini?')"><i class="fa fa-trash"></i></button>
                            </form>
                            <button kabupaten_id="{{$regency->id}}" kabupaten_nama="{{$regency->nama}}" class="btn-kab btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailRegency"><i class="fa fa-edit"></i></button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="col-12 col-lg-6">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h4>Daftar kecamatan</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDistrict">&plus; Tambah</button>
        </div>
        <table class="table">
            <thead>
                <tr class="align-middle">
                    <th>
                        <div class="">kecamatan</div>
                    </th>
                    <th class="col-1">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($districts as $district)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="flex-column">
                                <div class="mb-0">{{$district->nama}}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-start align-items-end">
                            <form action="/admin/shipping/delete-district" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$district->id}}">
                                <button class="btn btn-danger btn-sm me-2" onclick="confirm('Apakah Anda yakin menghapus data ini?')"><i class="fa fa-trash"></i></button>
                            </form>
                            <button kecamatan_id="{{$district->id}}" kecamatan_nama="{{$district->nama}}" class="btn-kec btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailDistrict"><i class="fa fa-edit"></i></button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addRegency" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addRegencyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/admin/shipping/add-regency" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addRegencyLabel">Tambah kabupaten</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="addRegencyName" class="form-label">Nama kabupaten</label>
                    <input type="text" name="kabupaten" id="addRegencyName" class="form-control form-control-sm">
                    <!-- <label for="addRegencyDesc" class="form-label">Keterangan</label>
                    <input type="text" name="" id="addRegencyDesc" class="form-control form-control-sm"> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="detailRegency" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailRegencyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/admin/shipping/update-regency" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="detailRegencyLabel">Detail kabupaten</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input id="kabupaten_id" type="hidden" name="kabupaten_id">
                    <label for="kabupaten_nama" class="form-label">Nama kabupaten</label>
                    <input type="text" name="kabupaten_nama" id="kabupaten_nama" class="form-control form-control-sm">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addDistrict" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addDistrictLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/admin/shipping/add-district" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addDistrictLabel">Tambah kecamatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="addDistrictName" class="form-label">Nama kecamatan</label>
                    <input type="text" name="kecamatan" id="addDistrictName" class="form-control form-control-sm">
                    <!-- <label for="addDistrictDesc" class="form-label">Keterangan</label>
                    <input type="text" name="" id="addDistrictDesc" class="form-control form-control-sm"> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="detailDistrict" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailDistrictLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/admin/shipping/update-district" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="detailDistrictLabel">Detail kecamatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input id="kecamatan_id" type="hidden" name="kecamatan_id">
                    <label for="kecamatan_nama" class="form-label">Nama kecamatan</label>
                    <input type="text" name="kecamatan_nama" id="kecamatan_nama" class="form-control form-control-sm">
                    <!-- <label for="editBankDesc" class="form-label">Keterangan</label>
                    <input type="text" name="" id="editBankDesc" class="form-control form-control-sm"> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 mt-5 border-bottom">
    <h4>Daftar ongkir</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addShipping">&plus; Tambah</button>
</div>
<div class="col-12">
    <table class="table">
        <thead>
            <tr>
                <th class="col align-middle">
                    Kabupaten
                </th>
                <th class="col align-middle">
                    Kecamatan
                </th>
                <th class="col align-middle">
                    Ongkir
                </th>
                <th class="col-1">
                    Aksi    
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($shippings as $shipping)
            <tr>
                <td class="col">
                    <div class="d-flex align-items-center">
                        <div class="flex-column">
                            <div class="mb-0">{{$shipping->regency()->first()->nama}}</div>
                        </div>
                    </div>
                </td>
                <td class="col">
                    <div class="d-flex align-items-center">
                        <div class="flex-column">
                            <div class="mb-0">{{$shipping->district()->first()->nama}}</div>
                        </div>
                    </div>
                </td>
                <td class="col">
                    <div class="d-flex align-items-center">
                        <div class="flex-column">
                            <div class="mb-0">@currency($shipping->harga)</div>
                        </div>
                    </div>
                </td>
                <td class="col-1">
                    <div class="d-flex justify-content-start align-items-end">
                        <form action="/admin/shipping/delete-shipping" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$shipping->id}}">
                            <button class="btn btn-danger btn-sm me-2" onclick="confirm('Apakah Anda yakin menghapus data ini?')"><i class="fa fa-trash"></i></button>
                        </form>
                        <button id_ongkir="{{$shipping->id}}" kabupaten_id="{{$shipping->regency_id}}" kecamatan_id="{{$shipping->district_id}}" harga="{{$shipping->harga}}" class="btn-ongkir btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailShipping"><i class="fa fa-edit"></i></button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="addShipping" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addShippingLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/admin/shipping/add-shipping" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addShippingLabel">Tambah ongkir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mt-1 mb-1">
                        <div class="col-6">
                            <label class="form-label">Kabupaten</label>
                            <select name="kabupaten" class="selectpicker w-100" title="Pilih...">
                                @foreach($regencies as $regency)
                                <option value="{{$regency->id}}">{{$regency->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Kecamatan</label>
                            <select name="kecamatan" class="selectpicker w-100" title="Pilih...">
                                @foreach($districts as $district)
                                <option value="{{$district->id}}">{{$district->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <label for="addShippingPrice" class="form-label">Harga</label>
                    <input type="text" name="harga" id="addShippingPrice" class="form-control form-control-sm">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="detailShipping" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailShippingLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/admin/shipping/update-shipping" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="detailShippingLabel">Detail ongkir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mt-1 mb-1">
                        <input id="id_ongkir" type="hidden" name="id_ongkir">
                        <div class="col-6">
                            <label class="form-label">Kabupaten</label>
                            <select id="kabupaten" name="kabupaten" class="selectpicker w-100" title="Pilih...">
                                @foreach($regencies as $regency)
                                <option value="{{$regency->id}}">{{$regency->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Kecamatan</label>
                            <select id="kecamatan" name="kecamatan" class="selectpicker w-100" title="Pilih...">
                                @foreach($districts as $district)
                                <option value="{{$district->id}}">{{$district->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <label for="harga" class="form-label">Harga</label>
                    <input type="text" name="harga" id="harga" class="form-control form-control-sm">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('.table').DataTable();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/i18n/defaults-*.min.js"></script>
<script>
    $('.my-select').selectpicker();
</script>
<script>
    $('.btn-kab').click(function() {
        let id = $(this).attr('kabupaten_id');
        let nama = $(this).attr('kabupaten_nama');
        $('#kabupaten_id').val(id);
        $('#kabupaten_nama').val(nama);
    });
    $('.btn-kec').click(function() {
        let id = $(this).attr('kecamatan_id');
        let nama = $(this).attr('kecamatan_nama');
        $('#kecamatan_id').val(id);
        $('#kecamatan_nama').val(nama);
    });
    $('.btn-ongkir').click(function() {
        let id = $(this).attr('id_ongkir');
        let kabupaten = $(this).attr('kabupaten_id');
        let kecamatan = $(this).attr('kecamatan_id');
        let harga = $(this).attr('harga');
        $('#id_ongkir').val(id);
        $('#kabupaten').selectpicker('val', kabupaten);
        $('#kecamatan').selectpicker('val', kecamatan);
        $('#harga').val(harga);
    });
</script>
@endsection