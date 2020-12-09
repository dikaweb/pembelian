<div class="" id="detail-area">
    <div class=" mx-4">
        <div class="panel-body my-1 mx-1">
            No. PO : <span class="text-body" id="lblno_po"><?= $konfirmasi_m['no_po_spk']; ?></span>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>

                        <th>Nama Barang</th>
                        <th>Jumlah</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($konfirmasi_d as $mr) : ?>
                        <tr>
                            <td><?= $mr['nm_barang']; ?></td>
                            <td><?= $mr['jumlah']; ?> <?= $mr['nm_satuan']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- -----------------------------------Data tables list barang detail---------------------------------------------- -->
<div class=" mx-4">
    <div class=" ">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>

                        <th>Ket</th>
                        <th>Gambar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gbr as $gb) : ?>
                        <tr>

                            <td>Jenis : <?= $gb['jenis']; ?><br><?= $gb['ket']; ?></td>
                            <td>
                                <div class="col-sm">
                                    <?php $path = base_url('assets/bpb/') . $gb['nm_file']; ?>
                                    <img src="<?= $path; ?>" type="image/jpeg" width="726">
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>