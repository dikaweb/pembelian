<div class="card-body">

    <form action="<?= base_url('approve/price_app/app_price'); ?>" method="post">

        <input type="hidden" id="id_transaksi" name="id_transaksi" value="<?= $data_m['id_bpb']; ?>">
        <div class="card mb-1 border-left-primary">
            <div class="card-body">

                <table class="" width="100%" cellspacing="0">
                    <tr>
                        <td>No. </td>
                        <td>:</td>
                        <td><?= $data_m['no_bpb']; ?></td>
                    </tr>
                    <tr>
                        <td> Supplier</td>
                        <td>:</td>
                        <td><?= $data_m['nm_supplier']; ?></td>
                    </tr>
                    <tr>
                        <td>PT</td>
                        <td>:</td>
                        <td><?= $data_m['nm_company']; ?></td>
                    </tr>
                    <tr>
                        <td>PPN</td>
                        <td>:</td>
                        <td><?= $data_m['nm_ppn']; ?></td>
                    </tr>
                </table>
                <div class="table-responsive">
                    <table class="table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Barang</th>
                                <th>Harga PO</th>
                                <th>Harga Inv</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $x = 1;
                            foreach ($data_d as $dt) : ?>
                                <tr>
                                    <td>
                                        <?= $x; ?>
                                    </td>
                                    <td><?= $dt['nm_barang']; ?></td>
                                    <td><?= rp($dt['hrg_po']); ?></td>
                                    <td><?= rp($dt['hrg_bpb']); ?></td>
                                </tr>
                            <?php $x++;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Approve</button>
        </div>
    </form>
</div>