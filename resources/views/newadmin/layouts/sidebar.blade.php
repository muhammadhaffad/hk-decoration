<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Home</div>
                <a class="nav-link" href="index.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Pengguna</div>
                <a class="nav-link collapsed" href="#">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Admin
                </a>
                <div class="sb-sidenav-menu-heading">Laporan</div>
                <a class="nav-link collapsed" href="#">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Bulanan
                </a>
                <div class="sb-sidenav-menu-heading">Transaksi</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTransaksi" aria-expanded="false" aria-controls="collapseTransaksi">
                    <div class="sb-nav-link-icon"><i class="fas fa-hand-holding-usd"></i></div>
                    Pemesanan
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseTransaksi" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="layout-static.html">Konfirmasi</a>
                        <a class="nav-link" href="layout-sidenav-light.html">Belum bayar</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#">
                    <div class="sb-nav-link-icon"><i class="fas fa-exchange-alt"></i></div>
                    Pengembalian
                </a>
                <a class="nav-link collapsed" href="#">
                    <div class="sb-nav-link-icon"><i class="fas fa-credit-card"></i></div>
                    Bank
                </a>
                <div class="sb-sidenav-menu-heading">Produk</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProduk" aria-expanded="false" aria-controls="collapseProduk">
                    <div class="sb-nav-link-icon"><i class="fas fa-paint-brush"></i></div>
                    Dekorasi
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseProduk" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="layout-static.html">Paket</a>
                        <a class="nav-link" href="layout-sidenav-light.html">Item tambahan</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#">
                    <div class="sb-nav-link-icon"><i class="fas fa-camera-retro"></i></div>
                    Paket sesi
                </a>
                <div class="sb-sidenav-menu-heading">Pengiriman</div>
                <a class="nav-link collapsed" href="#">
                    <div class="sb-nav-link-icon"><i class="fas fa-truck-loading"></i></div>
                    Biaya ongkir
                </a>
                <div class="sb-sidenav-menu-heading">Tampilan</div>
                <a class="nav-link collapsed" href="#">
                    <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                    Halaman depan
                </a>
                <a class="nav-link collapsed" href="#">
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