<div id="layoutSidenav_nav" class=" overflow-auto">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Home</div>
                <a class="nav-link {{ (request()->is('admin/dashboard')) ? 'active' : '' }}" href="{{route('admin.dashboard')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Pengguna</div>
                @if(auth()->user()->role == 'superadmin')
                <a class="nav-link collapsed {{ (request()->is('admin/employee')) ? 'active' : '' }}" href="{{route('admin.employee')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users-cog"></i></div>
                    Admin
                </a>
                @endif
                <a class="nav-link collapsed {{ (request()->is('admin/customer')) ? 'active' : '' }}" href="{{route('admin.customer')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Pelanggan
                </a>
                <a class="nav-link collapsed {{ (request()->is('admin/chat*')) ? 'active' : '' }}" href="{{route('admin.chat')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-comments"></i></div>
                    Pesan
                </a>
                <div class="sb-sidenav-menu-heading">Laporan</div>
                <a class="nav-link collapsed {{ (request()->is('admin/report/monthly')) ? 'active' : '' }}" href="{{route('admin.report.monthly')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Bulanan
                </a>
                <div class="sb-sidenav-menu-heading">Transaksi</div>
                <a class="nav-link {{ (request()->is('admin/orders')) ? 'active' : '' }}" href="{{route('admin.confirmation')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-exchange-alt"></i></div>
                    Pemesanan
                </a>
                <a class="nav-link {{ (request()->is('admin/return')) ? 'active' : '' }}" href="{{route('admin.return')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-sync"></i></div>
                    Pengembalian
                </a>
                <div class="sb-sidenav-menu-heading">Produk</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProduk" aria-expanded="false" aria-controls="collapseProduk">
                    <div class="sb-nav-link-icon"><i class="fas fa-paint-brush"></i></div>
                    Dekorasi
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseProduk" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ (request()->is('admin/decoration-packet')) ? 'active' : '' }}" href="{{route('admin.decoration-packet')}}">Paket</a>
                        <a class="nav-link {{ (request()->is('admin/decoration-item')) ? 'active' : '' }}" href="{{route('admin.decoration-item')}}">Item tambahan</a>
                    </nav>
                </div>
                <a class="nav-link {{ (request()->is('admin/session-package')) ? 'active' : '' }}" href="{{route('admin.session-package')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-camera-retro"></i></div>
                    Paket sesi
                </a>
                <div class="sb-sidenav-menu-heading">Pengiriman</div>
                <a class="nav-link {{ (request()->is('admin/shipping')) ? 'active' : '' }}" href="{{route('admin.shipping')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-truck-loading"></i></div>
                    Biaya ongkir
                </a>
                <div class="sb-sidenav-menu-heading">Tampilan</div>
                <a class="nav-link {{ (request()->is('admin/home-page')) ? 'active' : '' }}" href="{{route('admin.home-page')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                    Halaman depan
                </a>
                <a class="nav-link {{ (request()->is('admin/gallery')) ? 'active' : '' }}" href="{{route('admin.gallery')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-images"></i></div>
                    Galeri
                </a>
                <div class="mb-5"></div>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{auth()->user()->username}}
        </div>
    </nav>
</div>
<script>
    $('.collapsed').on('click', function() {
        $(this).find('i')
            .toggleClass('bi bi-plus-circle')
            .toggleClass('bi bi-dash-circle')
    });
    $(document).ready(function() {
        $('.collapse').has('a.nav-link.active').each(function() {
            $(this).addClass('show');
            $(this).prev().find('i').toggleClass('bi bi-plus-circle').toggleClass('bi bi-dash-circle');
        });
    })
</script>