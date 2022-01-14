@extends('admin.layouts.master', ['title' => 'Galeri'])
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
<div class="d-flex justify-content-end flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahGaleri">&plus; Tambah</button>
</div>
<div class="row">
    @foreach($galleries as $gallery)
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div id="{{$gallery->slug}}" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($gallery->photos()->get() as $index => $photo)
                    <div class="carousel-item {{$index == 0 ? 'active' : ''}}">
                        <img src="{{asset('storage/' . $photo->foto)}}" class="d-block w-100" alt="..." style="height: 270px; object-fit: cover; object-fit: cover;">
                        <div class="carousel-caption d-block" style="background: rgba(33,37,41, 0.6); right: 0; left: 0; bottom: 0;">
                            {{$photo->deskripsi}}
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#{{$gallery->slug}}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#{{$gallery->slug}}" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5>{{$gallery->nama}}</h5>
                    <form action="/admin/gallery/delete" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $gallery->id }}">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin menghapus galeri ini?')">Hapus</button>
                        <a href="{{route('admin.gallery-view', ['slug' => $gallery->slug])}}" class="btn btn-primary">Lihat</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="d-flex justify-content-end">
    {{$galleries->links()}}
</div>

<div class="modal fade" id="tambahGaleri" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="tambahGaleriLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahGaleriLabel">Tambah galeri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <label for="" class="form-label">Nama galeri</label>
                    <input type="text" name="nama_galeri" id="nama_galeri" class="form-control form-control-sm">
                    <label for="" class="form-label">Slug</label>
                    <input readonly type="text" name="slug_galeri" id="slug_galeri" class="form-control form-control-sm">
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" id="btn-tambah-foto" class="btn btn-primary">+ Tambah foto</button>
                    </div>
                    <div id="foto">
                        <div id="tambah-foto">
                            <label for="" class="form-label">Foto</label>
                            <input type="file" name="foto[]" id="" class="form-control form-control-sm">
                            <label for="" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi[]" id="" rows="3" style="resize: none;" class="form-control form-control-sm mb-3"></textarea>
                            <div class="d-flex justify-content-end mb-3">
                                <button onclick="return confirm('Apakah Anda yakin ingin mengapusnya?')" class="btn-hapus btn btn-danger">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">Tambah galeri</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    var counter = 0;
    $('#btn-tambah-foto').click(function() {
        $('#tambah-foto').clone().find("input,textarea").val("").end().appendTo('#foto');
        counter += 1;
    });
    $("#foto").delegate(".btn-hapus", "click", function() {
        if (counter > 0) {
            $(this).closest('#tambah-foto').remove();
            counter -= 1;
        } else {
            alert('gagal untuk dihapus');
        }
    });
    $("#nama_galeri").change(function() {
        let nama = $("#nama_galeri").val();
        let slug = nama.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
        $("#slug_galeri").val(slug);
    });
</script>
@endsection