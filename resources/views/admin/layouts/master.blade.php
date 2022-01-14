<!DOCTYPE html>
<html lang="en">

<!-- head -->
@include('admin.layouts.head', ['title' => $title])
@section('style')
    @yield('style')
@endsection

<!-- body -->
<body class="sb-nav-fixed">
    <!-- navbar -->
    @include('admin.layouts.navbar')

    <div id="layoutSidenav">
        <!-- sidebar -->
        @include('admin.layouts.sidebar')

        <!-- content -->
        <div id="layoutSidenav_content">
            <main style="height: 100%;">
                <div class="container-fluid px-4 h-100">
                    <h3 class="mt-4">{{$title}}</h3>
                    <hr>
                    @yield('content')
                </div>
            </main>

            <!-- footer -->
            @include('admin.layouts.footer')

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="/admin/js/scripts.js"></script>
    @yield('js')
</body>

</html>