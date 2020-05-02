<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    
    <?php $this->load->view('layouts/_alert') ?>
    <div class="row">
        <div class="col-md-12">
        <div class="card-group">
                    <div class="card border-right">
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-weight-medium"><?= getJumlahStaff(); ?></h2>
                                    </div>
                                    <a href="<?= base_url('users') ?>" class="btn"><h4 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Staff</h4></a>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i data-feather="user"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-right">
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-weight-medium"><?= getJumlahBarang(); ?></h2>
                                    </div>
                                    <a href="<?= base_url('items') ?>" class="btn"><h4 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Barang</h4></a>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i class="fas fa-boxes"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-right">
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                        <div class="d-inline-flex align-items-center">
                                            <h2 class="text-dark mb-1 font-weight-medium"><?= getJumlahSupplier(); ?></h2>
                                        </div>
                                        <a href="<?= base_url('suppliers') ?>" class="btn"><h4 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Supplier</h4></a>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i class="fas fa-users"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-weight-medium"><?= getJumlahStok(); ?></h2>
                                    </div>
                                    <a href="<?= base_url('items') ?>" class="btn"><h4 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Stok</h4></a>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted"><i class="fas fa-box"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Aktivitas Terakhir Pemasukan Barang</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table no-wrap v-middle mb-0">
                            <thead>
                                <tr class="border-0">
                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">ID Pemasukan</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">Nama Staff</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted px-2 text-center">Waktu Pemasukan</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($barang_masuk as $row) : ?>
                                    <tr>
                                        <td class="border-top-0 px-2 py-4 font-weight-medium"><?= $row->id ?></td>
                                        <td class="border-top-0 text-muted px-2 py-4 font-14"><?= $row->nama ?></td>
                                        <td class="border-top-0 text-muted px-2 py-4 font-14 text-center"><?= date('d-m-Y H:i:s', strtotime($row->waktu)) ?></td>
                                        <td class="border-top-0 text-center text-muted px-2 py-4">
                                            <a href="<?= base_url("inputs/detail/$row->id") ?>" class="btn btn-primary btn-rounded"><i data-feather="shopping-cart"></i>&nbsp;&nbsp;Detail</a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Aktivitas Terakhir Pengeluaran Barang</h4>
                    </div>
                    <div class="table-responsive">
                    <table class="table no-wrap v-middle mb-0">
                            <thead>
                                <tr class="border-0">
                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">ID Pemasukan</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">Nama Staff</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted px-2 text-center">Waktu Pemasukan</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($barang_keluar as $row) : ?>
                                    <tr>
                                        <td class="border-top-0 px-2 py-4 font-weight-medium"><?= $row->id ?></td>
                                        <td class="border-top-0 text-muted px-2 py-4 font-14"><?= $row->nama ?></td>
                                        <td class="border-top-0 text-muted px-2 py-4 font-14 text-center"><?= date('d-m-Y H:i:s', strtotime($row->waktu)) ?></td>
                                        <td class="border-top-0 text-center text-muted px-2 py-4">
                                            <a href="<?= base_url("outputs/detail/$row->id") ?>" class="btn btn-primary btn-rounded"><i data-feather="shopping-cart"></i>&nbsp;&nbsp;Detail</a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->