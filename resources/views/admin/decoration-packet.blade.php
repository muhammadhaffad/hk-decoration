@extends('admin.layouts.master', ['title' => 'Paket dekorasi'])
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

    .block-ellipsis {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection
@section('content')
<div class="d-flex justify-content-end flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDecoration">&plus;Tambah</button>
</div>
<div class="col-lg-12">
    <table id="table-decoration-packet" class="table w-100">
        <thead>
            <tr>
                <th class="col-lg-3 col-12 d-lg-table-cell">Nama dekorasi</th>
                <th class="col-lg d-none d-lg-table-cell">Kategori</th>
                <th class="col-lg-3 d-none d-lg-table-cell">Keterangan</th>
                <th class="col-lg d-none d-lg-table-cell">Harga</th>
                <th class="col-lg d-none d-lg-table-cell">Stok</th>
                <th class="col-lg d-none d-lg-table-cell">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($decorationpackets->get() as $decoration)
            <tr class="align-middle">
                <td class="col-12 col-lg-3 d-lg-table-cell">
                    <div class="d-none d-lg-flex align-items-center">
                        <img src="{{asset('storage/' . $decoration->gambar)}}" class="rounded" alt="Gambar" style="width: 70px; height: 70px; object-fit: cover;">
                        <div class="ms-2">{{$decoration->nama}}</div>
                    </div>
                    <div class="d-lg-none my-3">
                        <div class="d-flex">
                            <div class="me-3">
                                <img src="{{asset('storage/' . $decoration->gambar)}}" class="rounded" alt="Gambar" style="width: 120px; height: 120px; object-fit: cover">
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <small>Harga: </small>
                                <p class="mb-0 text-truncate">@currency($decoration->harga)</p>
                                <h6 class="mb-0">{{$decoration->nama}}</h6>
                                <small>Kategori: </small>
                                <p class="mb-0 text-truncate">{{$decoration->category()->first()->nama}}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-danger btn-sm me-2"></span><i class="fa fa-trash"></i></button>
                            <button decor-id="{{$decoration->id}}" class="btn-update btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailDecoration"><i class="fa fa-edit"></i></span></button>
                        </div>
                    </div>
                </td>
                <td class="d-none d-lg-table-cell">
                    {{$decoration->category()->first()->nama}}
                </td>
                <td class="d-none d-lg-table-cell">
                    <p class="block-ellipsis mb-0">{{strip_tags($decoration->keterangan)}}</p>
                </td>
                <td class="d-none d-lg-table-cell">
                    @currency($decoration->harga)
                </td>
                <td class="d-none d-lg-table-cell">
                    <div class="text-center">{{$decoration->stok}}</div>
                </td>
                <td class="d-none d-lg-table-cell">
                    <form action="/admin/decoration-packet/destroy" method="post">
                        @csrf
                        <div class="d-flex">
                            <input type="hidden" name="id" value="{{$decoration->id}}">
                            <button type="submit" onclick="return confirm('Anda yakin ingin menghapus?')" class="btn btn-danger btn-sm me-2"><i class="fa fa-trash"></i></button>
                            <button type="button" decor-id="{{$decoration->id}}" class="btn-update btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailDecoration"><i class="fa fa-edit"></i></button>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="addDecoration" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addDecorationLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 720px;">
        <form action="/admin/decoration-packet/store" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDecorationLabel">Tambah dekorasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="addDecorImg" class="form-label">Ubah gambar produk</label>
                    <input type="file" name="gambar" id="addDecorImg" class="form-control form-control-sm form-control-file">
                    <small>File harus berupa gambar dengan ukuran kurang dari 1 MB (1024 KB)</small>
                    <div class="row mt-1">
                        <div class="col-8 pe-0">
                            <label for="addDecorName" class="form-label">Nama produk</label>
                            <input type="text" name="nama" id="addDecorName" class="form-control form-control-sm">
                        </div>
                        <div class="col-4">
                            <label for="addDecorStock" class="form-label">Stok</label>
                            <input type="number" min="0" name="stok" id="addDecorStock" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-6">
                            <label class="form-label">Kategori</label>
                            <select id="addDecorCat" name="kategori" class="selectpicker w-100" title="Pilih...">
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Harga</label>
                            <input type="text" name="harga" id="addDecorPrice" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-1 mb-3">
                    </div>
                    <input id="addDecorDesc" type="hidden" name="keterangan">
                    <trix-editor id="addModal" input="addDecorDesc"></trix-editor>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Produk -->
<div class="modal fade" id="detailDecoration" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailDecorationLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 720px;">
        <form action="/admin/decoration-packet/update" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailDecorationLabel">Detail dekorasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="decor-id">
                    <label for="detailDecorImg" class="form-label">Ubah gambar produk</label>
                    <input type="file" name="gambar" id="detailDecorImg" class="form-control form-control-sm form-control-file">
                    <small>File harus berupa gambar dengan ukuran kurang dari 1 MB (1024 KB)</small>
                    <div class="row mt-1">
                        <div class="col-8 pe-0">
                            <label for="detailDecorName" class="form-label">Nama produk</label>
                            <input type="text" name="nama" id="detailDecorName" class="form-control form-control-sm">
                        </div>
                        <div class="col-4">
                            <label for="detailDecorStock" class="form-label">Stok</label>
                            <input type="number" min="0" name="stok" id="detailDecorStock" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-6">
                            <label class="form-label">Kategori</label>
                            <select id="detailDecorCat" name="kategori" class="selectpicker w-100" title="Pilih...">
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Harga</label>
                            <input type="text" name="harga" id="detailDecorPrice" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-1 mb-3">
                    </div>
                    <input id="detailDecorDesc" type="hidden" name="keterangan">
                    <trix-editor id="detailModal" input="detailDecorDesc"></trix-editor>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Ubah</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- <div class="modal fade" id="addDecoration" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addDecorationLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDecorationLabel">Tambah dekorasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="addDecorImg" class="form-label">Ubah gambar produk</label>
                <input type="file" name="" id="addDecorImg" class="form-control form-control-sm form-control-file">
                <div class="row mt-1">
                    <div class="col-8 pe-0">
                        <label for="addDecorName" class="form-label">Nama produk</label>
                        <input type="text" name="" id="addDecorName" class="form-control form-control-sm">
                    </div>
                    <div class="col-4">
                        <label for="addDecorStock" class="form-label">Stok</label>
                        <input type="number" min="0" name="" id="addDecorStock" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="form-label">Kategori</label>
                        <select class="selectpicker w-100" title="Pilih..." data-selected-text-format="count > 3">
                            <option>Mustard</option>
                            <option>Ketchup</option>
                            <option>Relish</option>
                            <option>Onions</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Harga</label>
                        <input type="text" name="" id="addDecorPrice" class="form-control">
                    </div>
                </div>
                <div class="row mt-1 mb-3">
                </div>
                <input id="addDecorDesc" type="hidden" name="content" value="abcd">
                <trix-editor input="addDecorDesc"></trix-editor>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success">Ubah</button>
            </div>
        </div>
    </div>
</div> -->

@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('#table-decoration-packet').DataTable();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/i18n/defaults-*.min.js"></script>
<script>
    $('.my-select').selectpicker();
</script>
<script>
    $('.btn-update').click(function() {
        let id = $(this).attr('decor-id');
        $.getJSON('/decoration/packet/getdata?id=' + id, function(data) {
            $('#decor-id').val(data.id);
            $('#detailDecorName').val(data.nama);
            $('#detailDecorStock').val(data.stok);
            $('#detailDecorPrice').val(data.harga);
            $('#detailDecorCat').selectpicker('val', data.category_id.toString());
            $('#detailModal').html(data.keterangan);
        });
    });
</script>
<script>
    document.addEventListener('trix-file-accept', function(e) {
        e.preventDefault();
    });
</script>
@endsection