<div class="container-fluid">
    
    <?php $this->load->view('layouts/_alert') ?>

    <div class="row" id="printBukti">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    Pemasukan Barang Selesai
                </div>
                <div class="card-body">
                    <table class="table-responsive mb-3 no-wrap">
                        <tr>
                            <td>Nomor pemasukan</td>
                            <td>:</td>
                            <td><?= $barang_masuk->id_barang_masuk ?></td>
                        </tr>
                        <tr>
                            <td>NIP Staff</td>
                            <td>:</td>
                            <td><?= $barang_masuk->id_user ?></td>
                        </tr>
                        <tr>
                            <td>Nama Staff</td>
                            <td>:</td>
                            <td><?= $barang_masuk->nama ?></td>
                        </tr>
                        <tr>
                            <td>Waktu</td>
                            <td>:</td>
                            <td><?= date('d/m/Y H:i:s', strtotime($barang_masuk->waktu)) ?></td>
                        </tr>
                    </table>
                    <p>Stok barang berhasil ditambahkan 😊</p>
                    <table class="table table-responsive w-100 d-block d-md-table">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list_barang as $barang) : ?>
                                <tr>
                                    <td>
                                        <strong><?= $barang->nama ?></strong>
                                    </td>
                                    <td class="text-center">
                                        Rp.<?= number_format($barang->harga, 0, ',', '.') ?>,- / 
                                        <small><?= ucfirst(getUnitName($barang->id_satuan)) ?></small>
                                    </td>
                                    <td class="text-center"><?= $barang->qty ?></td>
                                    <td class="text-center">Rp.<?= number_format($barang->subtotal, 0, ',', '.') ?>,-</td>
                                </tr>
                            <?php endforeach ?>
                            <tr>
                                <td colspan="3"><strong>Total:</strong></td>
                                <td class="text-center"><strong>Rp.<?= number_format(array_sum(array_column($list_barang, 'subtotal')), 0, ',', '.') ?>,-</strong></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-2">
                            <a href="<?= base_url('items') ?>" class="btn btn-primary btn-rounded text-white"><i class="fas fa-angle-left"></i> List barang</a>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-2">
                            <button class="btn btn-success btn-rounded float-right" onclick="printDiv('printBukti')">Cetak Bukti <i class="fas fa-angle-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>