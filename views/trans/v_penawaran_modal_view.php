    <!-- -----------------------------------Data tables list barang detail---------------------------------------------- -->

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($konfirmasi_d as $mr) : ?>
                        <tr>
                            <td><?= $mr['id_barang']; ?></td>
                            <td><?= $mr['nm_barang']; ?></td>
                            <td><?= $mr['jumlah']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>