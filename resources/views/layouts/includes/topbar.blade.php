<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="index.html">{{ env("APP_NAME") }}</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('service.dashboard') }}">Dashboard</a>
                </li>
               <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            Master Data
                        </a>
                        <ul class="dropdown-menu">
                            <li class="body">
                                <ul class="menu tasks" style="overflow:hidden;">
                                    <li>
                                        <a href="{{ route('pelanggan.index') }}">
                                            Pelanggan
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('item.index') }}">
                                           Barang
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('kategori-item.index') }}">
                                           Kategori Item
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('jenis_item.index') }}">
                                           Jenis Item
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('teknisi.index') }}">
                                           Teknisi
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('sale.index') }}">
                                           Sales
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('supplier.index') }}">
                                           Supplier
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

               <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                           Transaksi
                        </a>
                        <ul class="dropdown-menu">
                            <li class="body">
                                <ul class="menu tasks" style="overflow:hidden;">
                                    <li>
                                        <a href="{{ route('penjualan.index') }}">Penjualan</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('pembelian.index') }}">Pembelian</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('retur_penjualan.index') }}">Retur Penjualan</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('retur_pembelian.index') }}">Retur Pembelian</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('pembayaran_piutang.index') }}">Pembayaran Piutang</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('pembayaran_hutang.index') }}">Pembayaran Hutang</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('transaksi_gudang.index') }}">Transaksi Gudang</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('service.index') }}">Service</a>
                </li>

               <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                           Transaksi
                        </a>
                        <ul class="dropdown-menu">
                            <li class="body">
                                <ul class="menu tasks" style="overflow:hidden;">
                                    <li>
                                        <a href="{{ route('pengguna.index') }}">Pengguna</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('role.index') }}">Role Pengguna</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('profil.index') }}">Profil Toko</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
            </ul>

        </div>
    </div>
</nav>
