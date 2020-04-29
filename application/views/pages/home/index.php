<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    
    <?php $this->load->view('layouts/_alert') ?>
    
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
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->