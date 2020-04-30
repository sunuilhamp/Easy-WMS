<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    
    <?php $this->load->view('layouts/_alert') ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    Keranjang Pengeluaran Barang
                </div>
                <div class="card-body">
                    <table class="table table-responsive w-100 d-block d-md-table">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th class="text-center">Jumlah</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($content as $row) : ?>
                                <tr>
                                    <td>
                                        <strong><?= $row->nama ?></strong> / 
                                        <small><?= ucfirst(getUnitName($row->id_satuan)) ?></small>
                                    </td>
                                    <td>
                                        <form action="<?= base_url('cartout/update') ?>" method="POST">
                                            <input type="hidden" name="id" value="<?= $row->id ?>">
                                            <input type="hidden" name="id_barang" value="<?= $row->id_barang ?>">
                                            <div class="input-group">
                                                <input type="number" name="qty_barang_keluar" class="form-control text-center" value="<?= $row->qty_barang_keluar ?>">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-info"><i class="fas fa-check"></i></button>
                                                </div>
                                            </div>
                                            <small class="text-danger mt-1"><?= $this->session->flashdata("qty_cartout_$row->id") ?></small>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="<?= base_url('cartout/delete') ?>" method="POST">
                                            <input type="hidden" name="id" value="<?= $row->id ?>">
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white">
                    <div class="row">
                        <div class="col-md-4 col-sm-12 mb-2">
                            <a href="<?= base_url('items') ?>" class="btn btn-warning btn-rounded text-white"><i class="fas fa-angle-left"></i> List barang</a>
                        </div>
                        <div class="col-md-4 col-sm-12 mb-2 d-flex justify-content-center">
                            <form action="<?= base_url('cartout/drop') ?>" method="POST">
                                <input type="hidden" name="id_pesanan" value="">
                                <button type="submit" class="btn btn-danger btn-rounded text-white"><i class="fas fa-trash"></i> Kosongkan keranjang</button>
                            </form>
                        </div>
                        <div class="col-md-4 col-sm-12 mb-2">
                            <a href="<?= base_url('cartout/checkout') ?>" class="btn btn-success btn-rounded float-right">Checkout <i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->


