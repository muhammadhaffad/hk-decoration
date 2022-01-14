@extends('admin.layouts.master', ['title'=>'Kategori'])
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
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h4>Daftar kategori</h4>
</div>
<div class="col-lg-6">
    <table class="table">
        <thead>
            <tr>
                <th class="col-9 align-middle">
                    <div class="">Kategori</div>
                </th>
                <th>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addCategory"><span data-feather="plus"></span>Tambah</button>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="col-9">
                    <div class="d-flex align-items-center">
                        <div class="flex-column">
                            <div class="h6 mb-0">BRI</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="d-flex justify-content-start align-items-end">
                        <button class="btn btn-danger btn-sm me-2"><span data-feather="trash-2"></span></button>
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailCategory"><span data-feather="edit"></span></button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryLabel">Tambah kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="addCategoryName" class="form-label">Nama kategori</label>
                <input type="text" name="" id="addCategoryName" class="form-control form-control-sm">
                <!-- <label for="addCategoryDesc" class="form-label">Keterangan</label>
                <input type="text" name="" id="addCategoryDesc" class="form-control form-control-sm"> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Tambah</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailCategoryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailCategoryLabel">Detail kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="editBankName" class="form-label">Nama kategori</label>
                <input type="text" name="" id="editBankName" class="form-control form-control-sm">
                <!-- <label for="editBankDesc" class="form-label">Keterangan</label>
                <input type="text" name="" id="editBankDesc" class="form-control form-control-sm"> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success">Ubah</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')

@endsection