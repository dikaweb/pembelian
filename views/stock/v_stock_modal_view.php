    <!-- -----------------------------------Data tables list barang detail---------------------------------------------- -->

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No. Transaksi</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($konfirmasi as $mr) : ?>
                        <tr>
                            <td><?= $mr['date_d']; ?></td>
                            <td><?= $mr['no_trans']; ?></td>
                            <td><?= $mr['jml_t']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>