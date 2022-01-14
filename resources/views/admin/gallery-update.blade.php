@extends('admin.layouts.master', ['title' => $gallery->nama])
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
<div class="d-flex justify-content-end flex-wrap flex-md-nowrap align-items-center pt-2 pb-2 mb-3">
    <div class="d-flex">
        <a href="/admin/gallery" class="btn btn-secondary me-1">Kembali</a>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahGambar">+ Tambah</button>
    </div>
</div>
<div class="row">
    @foreach($gallery->photos()->get() as $index => $photo)
    <div class="col-lg-6 mb-4">
        <div class="card">
            <img src="{{asset('storage/' . $photo->foto)}}" class="d-block w-100" alt="..." style="height: 270px; object-fit: cover;">
            <div class="card-body">
                <div class="">
                    <h6>Deskripsi:</h6>
                    {{$photo->deskripsi}}
                </div>
            </div>
            <form action="/admin/gallery/{{$gallery->slug}}/delete" method="post">
                @csrf
                <div class="card-footer d-flex justify-content-end">
                    <input type="hidden" name="foto-id" value="{{$photo->id}}">
                    <button type="submit" onclick="return confirm('Apakah anda yakin menghapusnya?')" class="btn btn-danger me-2">Hapus</button>
                    <button foto-id="{{$photo->id}}" foto-deskripsi="{{$photo->deskripsi}}" type="button" class="btn-ubah btn btn-success" data-bs-toggle="modal" data-bs-target="#detailGambar">Ubah</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</div>

<div class="modal fade" id="detailGambar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailGambarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/admin/gallery/{{$gallery->slug}}/update" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailGambarLabel">Ubah gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div id="tambah-foto">
                        <input id="foto-id" type="hidden" name="id">
                        <label for="" class="form-label">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control form-control-sm">
                        <label for="" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" style="resize: none;" class="form-control form-control-sm mb-3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">Ubah gambar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahGambar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tambahGambarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahGambarLabel">Tambah gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div id="tambah-foto">
                        <input id="foto-id" type="hidden" name="id">
                        <label for="" class="form-label">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control form-control-sm">
                        <label for="" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" style="resize: none;" class="form-control form-control-sm mb-3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">Tambah gambar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $('.btn-ubah').click(function() {
        let id = $(this).attr('foto-id');
        let deskripsi = $(this).attr('foto-deskripsi');
        $('#foto-id').val(id);
        $('#deskripsi').text(deskripsi);
    });
</script>
@endsection