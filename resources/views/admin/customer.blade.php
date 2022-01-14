@extends('admin.layouts.master', ['title' => 'Pelanggan'])
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
<div class="col-lg-12">
    <table id="customer-user" class="table table-borderless">
        <thead>
            <tr class="align-middle">
                <th class="left">
                    Username
                </th>
                <th>
                    Email
                </th>
                <th>
                    Nama
                </th>
                <th>
                    Tanggal lahir
                </th>
                <th>
                    Nomor telepon
                </th>
                <th>
                    Alamat
                </th>
                <th>
                    Status
                </th>
                <th class="right col-1">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers->get() as $c)
            @php
            $bio = $c->customer()->first();
            @endphp
            <tr class="bg-gray align-middle">
                <td class="left" id="username" username="{{$c->username}}">
                    <img src="{{asset('storage/'.$bio->fotoProfil)}}" class="rounded-circle bg-dark me-1" height="50" width="50" style="object-fit:cover">
                    {{$c->username}}
                </td>
                <td id="email" email="{{$c->email}}">
                    {{$c->email}}
                </td>
                <td id="nama">
                    {{$bio->nama}}
                </td>
                <td id="taggallahir">
                    {{$bio->tanggalLahir}}
                </td>
                <td id="nomortelepon">
                    {{$bio->nomorTelepon}}
                </td>
                <td id="alamat">
                    {{$bio->alamat}}
                </td>
                <td id="status">
                    {{$c->status}}
                </td>
                <td class="right">
                    <button type="button" class="btn btn-primary" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-ellipsis-h"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <button ktp="{{asset('storage/'.$bio->fotoKtp)}}" class="lihatKTP astext w-100 text-start" data-bs-toggle="modal" data-bs-target="#KTP">
                            <li>
                                <a class="dropdown-item">
                                    <i class="fa fa-id-card"></i> Lihat KTP
                                </a>
                            </li>
                        </button>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        @if($c->status == 'active')
                        <form action="{{route('admin.customer.inactive')}}" method="post">
                            @csrf
                            <input type="hidden" name="customer_id" value="{{$c->id}}">
                            <button type="submit" class="astext w-100 text-start" onclick="return confirm('Yakin Anda ingin menonaktifkan akun ini?')">
                                <li>
                                    <a class="dropdown-item">
                                        <i class="fa fa-times-circle"></i> Inactive
                                    </a>
                                </li>
                            </button>
                        </form>
                        @else
                        <form action="{{route('admin.customer.active')}}" method="post">
                            @csrf
                            <input type="hidden" name="customer_id" value="{{$c->id}}">
                            <button type="submit" class="astext w-100 text-start" onclick="return confirm('Yakin Anda ingin mengaktifkan akun ini?')">
                                <li>
                                    <a class="dropdown-item">
                                        <i class="fa fa-check-circle"></i> Active
                                    </a>
                                </li>
                            </button>
                        </form>
                        @endif
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="detailCustomer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailCustomerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('admin.customer.update')}}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="detailCustomerLabel">Detail Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="customer-id" name="customer_id">
                    <label for="detailCustomerUsername" class="form-label mb-1">Username</label>
                    <input type="text" name="username" id="detailCustomerUsername" class="form-control form-control-sm @if($errors->update_customer->first('username')) is-invalid @endif" value="@if($errors->hasBag('update_customer')){{old('username')}}@endif">
                    <div class="invalid-feedback">
                        {{$errors->update_customer->first('username')}}
                    </div>
                    <label for="detailCustomerEmail" class="form-label mb-1">Email</label>
                    <input type="email" name="email" id="detailCustomerEmail" class="form-control form-control-sm @if($errors->update_customer->first('email')) is-invalid @endif" value="@if($errors->hasBag('update_customer')){{old('email')}}@endif">
                    <div class="invalid-feedback">
                        {{$errors->update_customer->first('email')}}
                    </div>
                    <label for="detailCustomerPassword" class="form-label mb-1">Password</label>
                    <input type="password" name="password" id="detailCustomerPassword" class="form-control form-control-sm @if($errors->update_customer->first('password')) is-invalid @endif">
                    <div class="invalid-feedback">
                        {{$errors->update_customer->first('password')}}
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
<div class="modal fade" id="KTP" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="KTPLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="KTPLabel">Foto KTP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ms-auto me-auto">
                <img id="tampilKTP" src="{{asset('images/slide2.jpg')}}" alt="Foto KTP" style="max-width: 100%;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#customer-user').DataTable();
    });
</script>
@if ($errors->hasBag('add_customer'))
<script>
    window.onload = () => {
        $('#addcustomer').modal('show');
    }
</script>
@endif
@if ($errors->hasBag('update_customer'))
<script>
    window.onload = () => {
        $('#detailCustomer').modal('show');
    }
</script>
@endif
@endsection
@section('js')
<script>
    $('.btn-detail-customer').click(function() {
        let row = $(this).closest('tr');
        let username = row.find('#username').attr('username');
        let email = row.find('#email').attr('email');
        $('#detailCustomerUsername').val(username);
        $('#detailCustomerEmail').val(email);
        $('#customer-id').val($(this).attr('customer-id'));
    });
    $('.lihatKTP').click(function() {
        let url = $(this).attr('ktp');
        $('#tampilKTP').attr('src', url);
    });
</script>
@endsection