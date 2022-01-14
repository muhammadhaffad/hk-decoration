@extends('newadmin.layouts.master', ['title' => 'Item dekorasi'])
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
<div class="row">
    <div class="col-lg-12">
        <table class="table">
            <thead>
                <tr>
                    <th class="col-lg-3 d-none d-lg-table-cell ">Nama dekorasi</th>
                    <th class="col-lg-3 d-none d-lg-table-cell">Keterangan</th>
                    <th class="col-lg-1 d-none d-lg-table-cell">Harga</th>
                    <th class="col-lg-1 d-none d-lg-table-cell">Stok</th>
                    <th class="col-lg-1 d-none d-lg-table-cell">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($decorationitems->get() as $decoration)
                <tr class="align-middle">
                    <td class="col-12 col-lg-3 d-lg-table-cell">
                        <div class="d-none d-lg-flex align-items-center">
                            <img src="{{asset('storage/' . $decoration->gambar)}}" alt="Gambar" style="width: 100px; height: 100px; object-fit:cover">
                            <div class="ms-2">{{$decoration->nama}}</div>
                        </div>
                        <div class="d-lg-none">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{asset('storage/' . $decoration->gambar)}}" alt="Gambar" style="width: 100px; height: 100px; object-fit:cover">
                                </div>
                                <div class="col-8">
                                    <small>Harga: </small>
                                    <p class="mb-0 text-truncate">@currency($decoration->harga)</p>
                                    <h6 class="mb-0">{{$decoration->nama}}</h6>
                                </div>
                            </div>
                            <div class="block">
                                <small>Deskripsi:</small>
                                <p class="block-ellipsis">
                                    {{strip_tags($decoration->keterangan)}}
                                </p>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-danger btn-sm me-2"></span><i class="bi bi-trash"></i></button>
                                <button decor-id="{{$decoration->id}}" class="btn-update btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailDecoration"><i class="bi bi-pencil-square"></i></span></button>
                            </div>
                        </div>
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
                        <form action="/admin/decoration-item/destroy" method="post">
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
            <form action="/admin/decoration-item/store" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDecorationLabel">Tambah item dekorasi</h5>
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
            <form action="/admin/decoration-item/update" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailDecorationLabel">Detail item dekorasi</h5>
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
</div>
@endsection
@section('js')
@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/i18n/defaults-*.min.js"></script>
<script>
    $('.my-select').selectpicker();
</script>
<script>
    $('.btn-update').click(function() {
        let id = $(this).attr('decor-id');
        $.getJSON('/decoration/item/getdata?id=' + id, function(data) {
            $('#decor-id').val(data.id);
            $('#detailDecorName').val(data.nama);
            $('#detailDecorStock').val(data.stok);
            $('#detailDecorPrice').val(data.harga);
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