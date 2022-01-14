<!DOCTYPE html>
<html lang="en">

<!-- head -->
@include('newadmin.layouts.head', ['title' => $title])
@section('style')
    @yield('style')
@endsection

<!-- body -->
<body>
    <!-- navbar -->
    @include('newadmin.layouts.navbar')

    <div id="layoutSidenav">
        <!-- sidebar -->
        @include('newadmin.layouts.sidebar')

        <!-- content -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">{{$title}}</h1>
                    <hr>
                    @yield('content')
                </div>
            </main>

            <!-- footer -->
            @include('newadmin.layouts.footer')

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="/admin/js/scripts.js"></script>
    @yield('js')
</body>

</html>