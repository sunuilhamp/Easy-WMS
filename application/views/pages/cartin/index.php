<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    
    <?php $this->load->view('layouts/_alert') ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    Keranjang Pesanan
                </div>
                <div class="card-body">
                    <table class="table table-responsive w-100 d-block d-md-table">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($content as $row) : ?>
                                <tr>
                                    <td>
                                        <strong><?= $row->nama ?></strong>
                                    </td>
                                    <td class="text-center">Rp.<?= number_format($row->harga, 0, ',', '.') ?>,-</td>
                                    <td>
                                        <form action="<?= base_url('cartin/update') ?>" method="POST">
                                            <input type="hidden" name="id_barang" value="<?= $row->id_barang ?>">
                                            <div class="input-group">
                                                <input type="number" name="qty_pesanan" class="form-control text-center" value="<?= $row->qty_barang_masuk ?>">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-info"><i class="fas fa-check"></i></button>
                                                </div>
                                            </div>
                                            <small class="text-danger mt-1"><?= $this->session->flashdata("qty_cartin_$row->id") ?></small>
                                        </form>
                                    </td>
                                    <td class="text-center">Rp.<?= number_format($row->subtotal, 0, ',', '.') ?>,-</td>
                                    <td>
                                        <form action="<?= base_url('cartin/delete') ?>" method="POST">
                                            <input type="hidden" name="id" value="<?= $row->id ?>">
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            <tr>
                                <td colspan="3"><strong>Total:</strong></td>
                                <td class="text-center"><strong>Rp.<?= number_format(array_sum(array_column($content, 'subtotal')), 0, ',', '.') ?>,-</strong></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white">
                    <div class="row">
                        <div class="col-md-4 col-sm-12 mb-2">
                            <a href="<?= base_url('items') ?>" class="btn btn-warning btn-rounded text-white"><i class="fas fa-angle-left"></i> Kembali ke kasir</a>
                        </div>
                        <div class="col-md-4 col-sm-12 mb-2 d-flex justify-content-center">
                            <form action="<?= base_url('cartin/drop') ?>" method="POST">
                                <input type="hidden" name="id_pesanan" value="">
                                <button type="submit" class="btn btn-danger btn-rounded text-white"><i class="fas fa-trash"></i> Reset pesanan</button>
                            </form>
                        </div>
                        <div class="col-md-4 col-sm-12 mb-2">
                            <a href="<?= base_url('cartin/checkout') ?>" class="btn btn-success btn-rounded float-right">Pembayaran <i class="fas fa-angle-right"></i></a>
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


