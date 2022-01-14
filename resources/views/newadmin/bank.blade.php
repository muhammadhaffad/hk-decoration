@extends('newadmin.layouts.master', ['title' => 'Bank'])
@section('content')
<div class="row">
    <div class="col-lg-6">
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th class="col-12 align-middle">
                        <div class="d-flex justify-content-between">
                            <div class="">Bank</div>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addBank"><span data-feather="plus"></span>Tambah</button>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                use Illuminate\Support\Str;
                @endphp
                @foreach($banks->get() as $bank)
                <tr>
                    <td class="col-12">
                        <div class="d-flex align-items-center">
                            <img id="gambar" src="{{asset('storage/'.$bank->logo)}}" alt="mdo" class="rounded me-2 w-25" style="max-width: 100px;">
                            <div class="flex-column">
                                <div id="nama" class="h6 mb-0">{{$bank->nama}}</div>
                                <p id="keterangan" class="mb-0 text-muted" keterangan="{{$bank->keterangan}}">{{Str::limit(strip_tags($bank->keterangan), 40)}}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end align-items-end">
                            <form action="/admin/bank/delete" method="post">
                                @csrf
                                <input type="hidden" name="bank_id" value="{{$bank->id}}">
                                <button type="submit" class="btn btn-danger btn-sm me-2" onclick="return confirm('Yakin Anda ingin menghapus rekening bank ini?')"><i class="fa fa-trash"></i></button>
                            </form>
                            <button bank-id="{{$bank->id}}" class="btn-detail-bank btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#detailBank"><i class="fa fa-eye"></i></button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="addBank" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addBankLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 570px;">
            <div class="modal-content">
                <form action="/admin/bank/add" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBankLabel">Tambah bank</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="addBankLogo" class="form-label">Tambah logo bank</label>
                        <input type="file" name="logo" id="addBankLogo" class="form-control form-control-sm form-control-file">
                        <small>File harus berupa gambar dengan ukuran kurang dari 1 MB (1024 KB)</small>
                        <br>
                        <label for="addBankName" class="form-label">Nama bank</label>
                        <input type="text" name="nama" id="addBankName" class="form-control form-control-sm mb-3">
                        <input id="addBankDesc" type="hidden" name="keterangan">
                        <trix-editor input="addBankDesc"></trix-editor>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailBank" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailBankLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 570px;">
            <form action="/admin/bank/update" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailBankLabel">Detail bank</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input id="bank_id" type="hidden" name="bank_id">
                        <label for="editBankLogo" class="form-label">Ubah logo bank</label>
                        <input type="file" name="logo" id="editBankLogo" class="form-control form-control-sm form-control-file">
                        <small>File harus berupa gambar dengan ukuran kurang dari 1 MB (1024 KB)</small>
                        <br>
                        <label for="editBankName" class="form-label">Nama bank</label>
                        <input type="text" name="nama" id="editBankName" class="form-control form-control-sm mb-3">
                        <input id="editBankDesc" type="hidden" name="keterangan">
                        <trix-editor id="detailModal" input="editBankDesc"></trix-editor>
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
<script>
    document.addEventListener('trix-file-accept', function(e) {
        e.preventDefault();
    });
</script>
<script>
    $('.btn-detail-bank').click(function() {
        let row = $(this).closest('tr');
        let gambar = row.find('#gambar').attr('src');
        let nama = row.find('#nama').text();
        let keterangan = row.find('#keterangan').attr('keterangan');
        $('#editBankName').val(nama);
        $('#detailModal').html(keterangan);
        $('#bank_id').val($(this).attr('bank-id'));
    });
</script>
@endsection