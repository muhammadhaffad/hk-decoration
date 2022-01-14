@extends('admin.layouts.master', ['title' => 'Halaman depan'])
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
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBank">&plus; Tambah</button>
</div>
<h4>Foto</h4>
<hr>
<div class="col-lg-12">
    <table class="table">
        <thead>
            <tr>
                <th>
                    Foto
                </th>
                <th>
                    Judul
                </th>
                <th class="d-none d-lg-table-cell">
                    Deskripsi
                </th>
                <th>
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody>
            @php
            use Illuminate\Support\Str;
            @endphp
            @foreach($foto as $f)
            <tr class="align-middle">
                <td class="col-1">
                    <img id="gambar" src="{{asset('storage/'.$f->media)}}" alt="mdo" class="rounded me-2" style="height: 100px; width: 100px; object-fit: cover">
                </td>
                <td id="judul" judul="{{$f->judul}}" class="col-3 d-lg-table-cell d-none">
                    {{$f->judul}}
                </td>
                <td id="deskripsi" deskripsi="{{$f->deskripsi}}">
                    {!!$f->deskripsi!!}
                </td>
                <td class="col-1">
                    <form action="/admin/home-page/destroy" method="post">
                        @csrf
                        <div class="d-flex">
                            <input type="hidden" name="id" value="{{$f->id}}">
                            <button type="submit" onclick="return confirm('Anda yakin ingin menghapus?')" class="btn btn-danger btn-sm me-2"><i class="fa fa-trash"></i></button>
                            <button type="button" homepage-id="{{$f->id}}" class="btn-update btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailIsi"><i class="fa fa-edit"></i></button>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<h4 class="mt-5">Video</h4>
<hr>
<div class="col-lg-12">
    <table class="table">
        <thead>
            <tr>
                <th>
                    Video
                </th>
                <th>
                    Judul
                </th>
                <th class="d-none d-lg-table-cell">
                    Deskripsi
                </th>
                <th>
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($video as $v)
            <tr class="align-middle">
                @if($v->type == 'link')
                <td class="col-1">
                    <iframe src="{{$v->media}}" style="height: 100px; width: 100px;"></iframe>
                </td>
                @elseif($v->type == 'video')
                <td class="col-1">
                    <video style="height: 100px; width:100px" controls>
                        <source src="{{asset('storage/'.$v->media)}}" type="video/mp4">
                    </video>
                </td>
                @endif
                <td id="judul" judul="{{$v->judul}}" class="col-3 d-lg-table-cell d-none">
                    {{$v->judul}}
                </td>
                <td id="deskripsi" deskripsi="{{$v->deskripsi}}">
                    {!!$v->deskripsi!!}
                </td>
                <td class="col-1">
                    <form action="/admin/home-page/destroy" method="post">
                        @csrf
                        <div class="d-flex">
                            <input type="hidden" name="id" value="{{$v->id}}">
                            <button type="submit" onclick="return confirm('Anda yakin ingin menghapus?')" class="btn btn-danger btn-sm me-2"><i class="fa fa-trash"></i></button>
                            <button type="button" homepage-id="{{$v->id}}" class="btn-update btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailIsi"><i class="fa fa-edit"></i></button>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="addBank" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addBankLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 570px;">
        <div class="modal-content">
            <form action="/admin/home-page/add" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addBankLabel">Tambah isi beranda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Media:</label>
                    <div class="mx-auto">
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-sm btn-check" name="type" value="foto" id="type1" autocomplete="off">
                            <label class="btn-sm btn btn-outline-primary" for="type1">Foto</label>

                            <input type="radio" class="btn-sm btn-check" name="type" value="video" id="type2" autocomplete="off">
                            <label class="btn-sm btn btn-outline-primary" for="type2">Video</label>

                            <input type="radio" class="btn-sm btn-check" name="type" value="link" id="type3" autocomplete="off">
                            <label class="btn-sm btn btn-outline-primary" for="type3">Video embed</label>
                        </div>
                    </div>
                    <div id="foto" class="collapse mb-3">
                        <label for="addPhoto" class="form-label">Foto</label>
                        <input type="file" name="foto" id="addPhoto" class="form-control form-control-sm form-control-file">
                        <small>File harus berupa gambar dengan ukuran kurang dari 1 MB (1024 KB)</small>
                    </div>
                    <div id="video" class="collapse mb-3">
                        <label for="addPhoto" class="form-label">Video</label>
                        <input type="file" name="video" id="addPhoto" class="form-control form-control-sm form-control-file">
                        <small>File harus berupa gambar dengan ukuran kurang dari 1 MB (1024 KB)</small>
                    </div>
                    <div id="link" class="collapse mb-3">
                        <label for="addPhoto" class="form-label">Video embed</label>
                        <input type="text" name="link" id="addPhoto" class="form-control form-control-sm form-control-file">
                    </div>
                    <label for="addTitle" class="form-label">Judul</label>
                    <input type="text" name="judul" id="addTitle" class="form-control form-control-sm mb-3">
                    <input id="addDescription" type="hidden" name="deskripsi">
                    <trix-editor input="addDescription"></trix-editor>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="detailIsi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailIsiLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 570px;">
        <form action="/admin/home-page/update" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailIsiLabel">Detail isi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input id="homepage-id" type="hidden" name="id">
                    <label class="form-label">Media:</label>
                    <div class="mx-auto">
                        <div class="btn-group" role="group">
                            <input type="radio" class="btn-sm btn-check" name="type" value="foto" id="edittype1" autocomplete="off">
                            <label class="btn-sm btn btn-outline-primary" for="edittype1">Foto</label>

                            <input type="radio" class="btn-sm btn-check" name="type" value="video" id="edittype2" autocomplete="off">
                            <label class="btn-sm btn btn-outline-primary" for="edittype2">Video</label>

                            <input type="radio" class="btn-sm btn-check" name="type" value="link" id="edittype3" autocomplete="off">
                            <label class="btn-sm btn btn-outline-primary" for="edittype3">Video embed</label>
                        </div>
                    </div>
                    <div id="editfoto" class="collapse mb-3">
                        <label for="addPhoto" class="form-label">Foto</label>
                        <input type="file" name="foto" id="addPhoto" class="form-control form-control-sm form-control-file">
                        <small>File harus berupa gambar dengan ukuran kurang dari 1 MB (1024 KB)</small>
                    </div>
                    <div id="editvideo" class="collapse mb-3">
                        <label for="addPhoto" class="form-label">Video</label>
                        <input type="file" name="video" id="addPhoto" class="form-control form-control-sm form-control-file">
                        <small>File harus berupa gambar dengan ukuran kurang dari 1 MB (1024 KB)</small>
                    </div>
                    <div id="editlink" class="collapse mb-3">
                        <label for="addPhoto" class="form-label">Video embed</label>
                        <input type="text" name="link" id="addPhoto" class="form-control form-control-sm form-control-file">
                    </div>
                    <label for="editJudul" class="form-label">Judul</label>
                    <input type="text" name="judul" id="editJudul" class="form-control form-control-sm mb-3">
                    <input id="editDeskripsi" type="hidden" name="deskripsi">
                    <trix-editor id="detailModal" input="editDeskripsi"></trix-editor>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Ubah</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('table').DataTable();
    });
</script>
<script>
    document.addEventListener('trix-file-accept', function(e) {
        e.preventDefault();
    });
</script>
<script>
    $('.btn-update').click(function() {
        let row = $(this).closest('tr');
        let judul = row.find('#judul').attr('judul');
        let deskripsi = row.find('#deskripsi').attr('deskripsi');
        $('#editJudul').val(judul);
        $('#detailModal').html(deskripsi);
        $('#homepage-id').val($(this).attr('homepage-id'));
    });
</script>
<script>
    $('[name="type"]').on('change', function() {
        if ($(this).val() === "foto") {
            $('#foto').collapse('show');
            $('#video').collapse('hide');
            $('#link').collapse('hide');
        } else if ($(this).val() === "video") {
            $('#foto').collapse('hide');
            $('#video').collapse('show');
            $('#link').collapse('hide');
        } else if ($(this).val() === "link") {
            $('#foto').collapse('hide');
            $('#video').collapse('hide');
            $('#link').collapse('show');
        }
    });
    $('[name="type"]').on('change', function() {
        if ($(this).val() === "foto") {
            $('#editfoto').collapse('show');
            $('#editvideo').collapse('hide');
            $('#editlink').collapse('hide');
        } else if ($(this).val() === "video") {
            $('#editfoto').collapse('hide');
            $('#editvideo').collapse('show');
            $('#editlink').collapse('hide');
        } else if ($(this).val() === "link") {
            $('#editfoto').collapse('hide');
            $('#editvideo').collapse('hide');
            $('#editlink').collapse('show');
        }
    });
</script>
@endsection