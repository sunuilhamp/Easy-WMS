<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- Submemu Dashboard -->
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="<?= base_url('home') ?>" aria-expanded="false">
                        <i data-feather="home" class="feather-icon"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <li class="list-divider"></li>

                <li class="nav-small-cap"><span class="hide-menu">Manajemen Barang</span></li>
                <?php if ($this->session->userdata('role') == 'admin') : ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?= base_url('item') ?>" aria-expanded="false">
                            <i data-feather="clipboard" class="feather-icon"></i>
                            <span class="hide-menu">Register Barang</span>
                        </a>
                    </li>
                <?php endif ?>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="<?= base_url('items') ?>" aria-expanded="false">
                        <i data-feather="package" class="feather-icon"></i>
                        <span class="hide-menu">List Barang</span>
                    </a>
                </li>
                <?php if ($this->session->userdata('role') == 'admin') : ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?= base_url('unit') ?>" aria-expanded="false">
                            <i data-feather="plus-square" class="feather-icon"></i>
                            <span class="hide-menu">Tambah Satuan</span>
                        </a>
                    </li>
                <?php endif ?>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?= base_url('units') ?>" aria-expanded="false">
                        <i data-feather="box" class="feather-icon"></i>
                        <span class="hide-menu">List Satuan</span>
                    </a>
                </li>

                <li class="list-divider"></li>

                <li class="nav-small-cap"><span class="hide-menu">Manajemen Supplier</span></li>
                <?php if ($this->session->userdata('role') == 'admin') : ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?= base_url('supplier') ?>" aria-expanded="false">
                            <i data-feather="file-plus" class="feather-icon"></i>
                            <span class="hide-menu">Tambah Supplier</span>
                        </a>
                    </li>
                <?php endif ?>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="<?= base_url('suppliers') ?>" aria-expanded="false">
                        <i data-feather="truck" class="feather-icon"></i>
                        <span class="hide-menu">List Supplier</span>
                    </a>
                </li>

                <li class="list-divider"></li>

                <!-- Submemu Kasir -->
                <li class="nav-small-cap"><span class="hide-menu">Barang Masuk</span></li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?= base_url('cartin') ?>" aria-expanded="false">
                        <i data-feather="shopping-cart" class="feather-icon"></i>
                        <span class="hide-menu">Keranjang Masuk</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="<?= base_url('inputs') ?>" aria-expanded="false">
                        <i data-feather="file-text" class="feather-icon"></i>
                        <span class="hide-menu">Catatan Masuk</span>
                    </a>
                </li>

                <li class="list-divider"></li>

                <!-- Submemu Manajemen Inventory -->
                <li class="nav-small-cap"><span class="hide-menu">Barang Keluar</span></li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="<?= base_url('cartout') ?>" aria-expanded="false">
                        <i data-feather="shopping-cart" class="feather-icon"></i>
                        <span class="hide-menu">Keranjang Keluar</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="<?= base_url('outputs') ?>" aria-expanded="false">
                        <i data-feather="file-text" class="feather-icon"></i>
                        <span class="hide-menu">Catatan Keluar</span>
                    </a>
                </li>

                <li class="list-divider"></li>

                <!-- Submemu Manajemen Karyawan -->
                <li class="nav-small-cap"><span class="hide-menu">Manajemen Staff</span></li>
                <li class="sidebar-item"> 
                    <a class="sidebar-link sidebar-link" href="<?= base_url('users') ?>" aria-expanded="false">
                        <i data-feather="users" class="feather-icon"></i>
                        <span class="hide-menu">List Staff</span>
                    </a>
                </li>
                <?php if ($this->session->userdata('role') == 'admin') : ?>
                    <li class="sidebar-item"> 
                        <a class="sidebar-link sidebar-link" href="<?= base_url('register') ?>" aria-expanded="false">
                            <i data-feather="user-plus" class="feather-icon"></i>
                            <span class="hide-menu">Register Staff</span>
                        </a>
                    </li>
                <?php endif ?>
                
                <li class="list-divider"></li>

                <!-- Submemu Extra -->
                <li class="nav-small-cap"><span class="hide-menu">Extra</span></li>
                <li class="sidebar-item"> 
                    <a class="sidebar-link sidebar-link" href="https://github.com/sunudika/Easy-WMS.git" aria-expanded="false">
                        <i data-feather="github" class="feather-icon"></i>
                        <span class="hide-menu">Repository</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="<?= base_url('about') ?>" aria-expanded="false">
                        <i data-feather="info" class="feather-icon"></i>
                        <span class="hide-menu">About us</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->