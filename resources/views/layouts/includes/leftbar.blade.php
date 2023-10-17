<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info" style="background: #2f1c2e;border-bottom:0">
        <div class="image">
            <img src="{{ url('material') }}/images/user.png" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->nama_pengguna }}</div>
            <div class="email">{{ auth()->user()->email }}</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="javascript:void(0);" onclick="document.getElementById('logoutForm').submit()"><i class="material-icons">input</i>Sign Out</a></li>
                    <form action="{{ route('logout') }}" style="display:none" id="logoutForm" method="POST">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header" style="background: #361c35; color:white">MAIN NAVIGATION</li>
            <li class="{{ (request()->is('dashboard*')) ? 'active' : '' }}">
                <a href="{{ route('service.dashboard') }}">
                    <i class="material-icons">home</i>
                    <span>Dashboard</span>
                </a>
            </li>
            @if( \Helper::hakAkses("master_data", "View") )
            <li>
                <a href="javascript:void(0);" class="menu-toggle {{ (request()->is('pelanggan*', 'item*', 'urusan*', 'kategori-item*', 'jenis_item*', 'teknisi*','sale*','supplier*' ) ) ? 'toggled' : '' }} ">
                    <i class="material-icons">inventory_2</i>
                    <span>Master Data</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="{{ route('pelanggan.index') }}">Pelanggan</a>
                    </li>
                    <li>
                        <a href="{{ route('item.index') }}">Barang</a>
                    </li>
                    <li>
                        <a href="{{ route('kategori-item.index') }}">Kategori Item</a>
                    </li>
                    <li>
                        <a href="{{ route('jenis_item.index') }}">Jenis Item</a>
                    </li>
                    <li>
                        <a href="{{ route('teknisi.index') }}">Teknisi</a>
                    </li>
                    <li>
                        <a href="{{ route('sale.index') }}">Sales</a>
                    </li>
                    <li>
                        <a href="{{ route('supplier.index') }}">Supplier</a>
                    </li>
                </ul>
            </li>
            @endif
            <li>
                <a href="javascript:void(0);" class="menu-toggle {{ (request()->is('penjualan*', 'pembelian*', 'retur_penjualan*', 'retur_pembelian*', 'pembayaran_piutang*', 'pembayaran_hutang*','transaksi_gudang*','pembayaran_service*' ) ) ? 'toggled' : '' }}">
                    <i class="material-icons">shopping_basket</i>
                    <span>Transaksi</span>
                </a>
                <ul class="ml-menu">
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
            <li class="{{ (request()->is('service*')) ? 'active' : '' }}">
                <a href="{{ route('service.index') }}">
                    <i class="material-icons">receipt_long</i>
                    <span>Service</span>
                </a>
            </li>
<!--            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">receipt_long</i>
                    <span>Service</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="{{ route('service.index') }}">Service</a>
                    </li>
                    <li>
                        <a href="{{ route('service.list') }}">List</a>
                    </li>
                    <li>
                        <a href="{{ route('service.list_terpakai') }}">Sparepart Terpakai</a>
                    </li>
                    <li>
                        <a href="{{ route('service.kas') }}">Kas</a>
                    </li>
                    <li>
                        <a href="{{ route('service.garansi') }}">Garansi</a>
                    </li>
                </ul>
            </li>-->
            <li>
                <a href="javascript:void(0);" class="menu-toggle {{ (request()->is('pengguna*','role*','profil*')) ? 'toggled' : '' }}">
                    <i class="material-icons">settings</i>
                    <span>Pengaturan</span>
                </a>
                <ul class="ml-menu">
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
    </div>
    <!-- #Menu -->
    <!-- Footer -->

    <!-- #Footer -->
</aside>
