@extends('admin.layouts.master', ['title' => 'Dashboard'])
@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">Sudah Bayar</div>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-3 border-light">
                {{$count['paid']}}
            </span>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="/admin/confirmation?status=Belum dikonfirmasi">Lihat selengkapnya...</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">Belum bayar</div>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-3 border-light">
                {{$count['unpaid']}}
            </span>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="/admin/unpaid">Lihat selengkapnya...</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-secondary text-white mb-4">
            <div class="card-body">Kedaluwarsa</div>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-3 border-light">
                {{$count['expired']}}
            </span>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="/admin/confirmation?status=Sudah dikonfirmasi">Lihat selengkapnya...</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">Gagal</div>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-3 border-light">
                {{$count['failed']}}
            </span>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="/admin/confirmation?status=Gagal dikonfirmasi">Lihat selengkapnya...</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>
@endsection