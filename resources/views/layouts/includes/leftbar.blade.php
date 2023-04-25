<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="{{ url('material') }}/images/user.png" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->nama_pengguna }}</div>
            <div class="email">{{ auth()->user()->email }}</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                    <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                    <li role="separator" class="divider"></li>
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
            <li class="header">MAIN NAVIGATION</li>
            <li class="active">
                <a href="{{ url("/") }}">
                    <i class="material-icons">home</i>
                    <span>Home</span>
                </a>
            </li>
   
          
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">bar_chart</i>
                    <span>Laporan</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="#">Ringkasan Penjualan</a>
                    </li>
                    <li>
                        <a href="#">Penjualan Berdasarkan Barang</a>
                    </li>
                    <li>
                        <a href="#">Penjualan Berdasarkan Kategori</a>
                    </li>
                    <li>
                        <a href="#">Penjualan Berdasarkan Karyawan</a>
                    </li>
                    <li>
                        <a href="#">Penjualan Berdasarkan Karyawan</a>
                    </li>
                    <li>
                        <a href="#">Penjualan Berdasarkan Jenis Pembayaran</a>
                    </li>
                    <li>
                        <a href="#">Struk</a>
                    </li>
                    <li>
                        <a href="#">Penjualan berdasarkan pengubah</a>
                    </li>
                    <li>
                        <a href="#">Diskon</a>
                    </li>
                    <li>
                        <a href="#">Pajak</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">shopping_basket</i>
                    <span>Barang</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="{{ route('item.index') }}">Daftar Barang</a>
                    </li>
                    <li>
                        <a href="{{ route('kategori-item.index') }}">Kategori</a>
                    </li>
                    <li>
                        <a href="#">Pengubah</a>
                    </li>
                    <li>
                        <a href="#">Diskon</a>
                    </li>
                </ul>
            </li>



            <li>
                <a href="#">
                    <i class="material-icons">inventory</i>
                    <span>Pengelolaan Inventaris</span>
                </a>
            </li>
           
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; 2016 - 2017 <a href="javascript:void(0);">AdminBSB - Material Design</a>.
        </div>
        <div class="version">
            <b>Version: </b> 1.0.5
        </div>
    </div>
    <!-- #Footer -->
</aside>