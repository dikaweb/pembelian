    <!-- -----------------------------------Data tables list barang detail---------------------------------------------- -->

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Ket Referensi</th>
                        <th>Diterima</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($konfirmasi_d as $mr) : ?>
                        <tr>
                            <td><?= $mr['nm_barang']; ?></td>
                            <td><?= $mr['jumlah']; ?></td>
                            <td><?= $mr['nm_satuan']; ?></td>
                            <td><?= $mr['harga']; ?></td>
                            <td><?php
                                switch ($mr['jenis_reff']) {
                                    case "1":
                                        $menuId = $mr['id_reff'];
                                        $querySubMenu = "SELECT no_permintaan from permintaan_barang_detail a inner join permintaan_barang b on a.permintaan_barang_id = b.id where a.id = $menuId";
                                        $subMenu = $this->db->query($querySubMenu)->row_array();
                                        echo "No. PR : " . $subMenu['no_permintaan'];
                                        break;
                                    case "2":
                                        $menuId = $mr['id_reff'];
                                        $querySubMenu = "SELECT no_permintaan from permintaan_barang_detail a inner join permintaan_barang b on a.permintaan_barang_id = b.id where a.id = $menuId";
                                        $subMenu = $this->db->query($querySubMenu)->row_array();
                                        echo "No. PR : " . $subMenu['no_permintaan'] . "<br>";
                                        break;
                                    case "3":
                                        echo "Tanpa Referensi";
                                        break;
                                }
                                ?></td>
                            <td><?= $mr['jml_dt_konv_terkecil']; ?>
                                <?php
                                if ($mr['id_sat_konv_terakhir'] <> 0) {
                                    $idsat = $mr['id_sat_konv_terakhir'];
                                } else {
                                    $idsat = $mr['id_satuan'];
                                }
                                $qsat = "SELECT nm_satuan from m_satuan where id_satuan = $idsat";
                                $rowsat = $this->db->query($qsat)->row_array();
                                echo  $rowsat['nm_satuan'];
                                //echo 'idsat : ' . $idsat;
                                ?>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>