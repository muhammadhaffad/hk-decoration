@extends('admin.layouts.master', ['title' => 'Admin'])
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
<div class="col-lg-8">
    <div class="d-flex justify-content-end mb-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdmin"><span data-feather="plus"></span>Tambah</button>
    </div>
    <table id="admin-user" class="table table-borderless">
        <thead>
            <tr class="align-middle">
                <th class="left">
                    Username
                </th>
                <th>
                    Email
                </th>
                <th class="right col-1">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins->get() as $admin)
            <tr class="bg-gray align-middle">
                <td class="left" id="username" username="{{$admin->username}}">
                    {{$admin->username}}
                </td>
                <td id="email" email="{{$admin->email}}">
                    {{$admin->email}}
                </td>
                <td class="right">
                    <button type="button" class="btn btn-primary" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-ellipsis-h"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <button admin-id="{{$admin->id}}" class="btn-detail-admin astext w-100 text-start" data-bs-toggle="modal" data-bs-target="#detailAdmin">
                            <li>
                                <a class="dropdown-item">
                                    <i class="fa fa-eye"></i> Lihat
                                </a>
                            </li>
                        </button>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <form action="/admin/employee/delete" method="post">
                            @csrf
                            <input type="hidden" name="admin_id" value="{{$admin->id}}">
                            <button type="submit" class="astext w-100 text-start" onclick="return confirm('Yakin Anda ingin menghapus akun ini?')">
                                <li>
                                    <a class="dropdown-item">
                                        <i class="fa fa-trash"></i> Hapus
                                    </a>
                                </li>
                            </button>
                        </form>
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="modal fade" id="addAdmin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addAdminLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/admin/employee/add" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addAdminLabel">Tambah Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="addAdminUsername" class="form-label mb-1">Username</label>
                    <input type="text" name="username" id="addAdminUsername" class="form-control form-control-sm @if($errors->add_admin->first('username')) is-invalid @endif" value="@if($errors->hasBag('add_admin')){{old('username')}}@endif">
                    <div class="invalid-feedback">
                        {{$errors->add_admin->first('username')}}
                    </div>
                    <label for="addAdminEmail" class="form-label mb-1">Email</label>
                    <input type="email" name="email" id="addAdminEmail" class="form-control form-control-sm @if($errors->add_admin->first('email')) is-invalid @endif" value="@if($errors->hasBag('add_admin')){{old('email')}}@endif">
                    <div class="invalid-feedback">
                        {{$errors->add_admin->first('email')}}
                    </div>
                    <label for="addAdminPassword" class="form-label mb-1">Password</label>
                    <input type="password" name="password" id="addAdminPassword" class="form-control form-control-sm @if($errors->add_admin->first('password')) is-invalid @endif">
                    <div class="invalid-feedback">
                        {{$errors->add_admin->first('password')}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="detailAdmin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailAdminLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/admin/employee/update" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="detailAdminLabel">Detail Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="admin-id" name="admin_id">
                    <label for="detailAdminUsername" class="form-label mb-1">Username</label>
                    <input type="text" name="username" id="detailAdminUsername" class="form-control form-control-sm @if($errors->update_admin->first('username')) is-invalid @endif" value="@if($errors->hasBag('update_admin')){{old('username')}}@endif">
                    <div class="invalid-feedback">
                        {{$errors->update_admin->first('username')}}
                    </div>
                    <label for="detailAdminEmail" class="form-label mb-1">Email</label>
                    <input type="email" name="email" id="detailAdminEmail" class="form-control form-control-sm @if($errors->update_admin->first('email')) is-invalid @endif" value="@if($errors->hasBag('update_admin')){{old('email')}}@endif">
                    <div class="invalid-feedback">
                        {{$errors->update_admin->first('email')}}
                    </div>
                    <label for="detailAdminPassword" class="form-label mb-1">Password</label>
                    <input type="password" name="password" id="detailAdminPassword" class="form-control form-control-sm @if($errors->update_admin->first('password')) is-invalid @endif">
                    <div class="invalid-feedback">
                        {{$errors->update_admin->first('password')}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#admin-user').DataTable();
    });
</script>
@if ($errors->hasBag('add_admin'))
<script>
    window.onload = () => {
        $('#addAdmin').modal('show');
    }
</script>
@endif
@if ($errors->hasBag('update_admin'))
<script>
    window.onload = () => {
        $('#detailAdmin').modal('show');
    }
</script>
@endif
@endsection
@section('js')
<script>
    $('.btn-detail-admin').click(function() {
        let row = $(this).closest('tr');
        let username = row.find('#username').attr('username');
        let email = row.find('#email').attr('email');
        $('#detailAdminUsername').val(username);
        $('#detailAdminEmail').val(email);
        $('#admin-id').val($(this).attr('admin-id'));
    });
</script>
@endsection