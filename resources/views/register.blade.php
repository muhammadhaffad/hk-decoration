<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>HK Decoration | Daftar</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/sign-in/">



    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
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


    <!-- Custom styles for this template -->
    <link href="{{asset('css/signin.css')}}" rel="stylesheet">
</head>

<body class="py-0">
    <div class="row w-100 m-0 h-100">
        <div class="col d-none d-lg-block px-0">
            <img src="{{asset('images/slide1.jpg')}}" class="w-100 h-100" style="object-fit: cover;" alt="">
        </div>
        <div class="col mt-auto mb-auto">
            <main class="form-signin p-4" style="max-width: 512px;">
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    {!! $message !!}
                </div>
                @endif
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <h1 class="text-center"><strong class="text-danger">HK</strong>DECORATION</h1>
                    <p class="mb-3 fw-normal">Isi form di bawah ini dengan benar</p>

                    <div>
                        <label class="form-label">Nama lengkap</label>
                        <input name="nama" value="{{old('nama')}}" type="text" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama lengkap">
                    </div>
                    <div class="row">
                        <div class="col-6 pe-0">
                            <div class="mt-2">
                                <label class="form-label">Tanggal lahir</label>
                                <input name="tglLahir" value="{{old('tglLahir')}}" type="date" class="form-control @error('tglLahir') is-invalid @enderror" placeholder="Tanggal lahir">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mt-2">
                                <label class="form-label">Nomor telepon</label>
                                <input name="nomorTlp" value="{{old('nomorTlp')}}" type="text" class="form-control @error('nomorTlp') is-invalid @enderror" placeholder="08XXXXXXXX">
                            </div>
                        </div>
                    </div>
                    <div class=" mt-2">
                        <label class="form-label">Alamat</label>
                        <input name="alamat" value="{{old('alamat')}}" type="text" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat">
                    </div>
                    <div class="row">
                        <div class="col pe-0">
                            <div class=" mt-2">
                                <label class="form-label">Email</label>
                                <input name="email" value="{{old('email')}}" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                            </div>
                        </div>
                        <div class="col">
                            <div class=" mt-2">
                                <label class="form-label">Username</label>
                                <input name="username" value="{{old('username')}}" type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username">
                            </div>
                        </div>
                    </div>
                    <div class=" mt-2">
                        <label class="form-label" for="floatingInput">Password</label>
                        <input name="password" value="{{old('password')}}" type="password" class="form-control @error('password') is-invalid @enderror" id="floatingInput" placeholder="Password">
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6 pe-0">
                            <div class="mt-2">
                                <label class="form-label" class="form-label text-start">Foto KTP</label>
                                <input name="fotoKtp" type="file" class="form-control form-control-sm @error('fotoKtp') is-invalid @enderror" placeholder="Foto KTP">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mt-2">
                                <label class="form-label" class="form-label text-start">Foto profil</label>
                                <input name="fotoProfil" type="file" class="form-control form-control-sm @error('fotoProfil') is-invalid @enderror" placeholder="Foto profil">
                            </div>
                        </div>
                        <p><small>File harus berupa gambar dengan ukuran kurang dari 1 MB (1024 KB)</small></p>
                    </div>
                    <div class="mt-3 mb-3">
                        <label>
                            Silahkan <a href="/login">masuk</a>, jika sudah mempunyai akun.
                        </label>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">Sign Up</button>
                    </div>
                </form>
            </main>
        </div>
    </div>
</body>

</html>