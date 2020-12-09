<div class="card-body">

    <form action="<?= base_url('approve/app_po/void_po'); ?>" method="post">

        <input type="hidden" id="id_transaksi" name="id_transaksi" value="<?= $data_m['id_transaksi']; ?>">
        <div class="card mb-1 border-left-primary">
            <div class="card-body">
                <h3>
                    <bold>
                        <p class="text-primary" id="judul"><u><?= $judul; ?></u></p>
                    </bold>
                </h3>
                <table class="" width="100%" cellspacing="0">
                    <tr>
                        <td>No. PO</td>
                        <td>:</td>
                        <td><?= $data_m['no_transaksi']; ?></td>
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
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Referensi</th>
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
                                    <td><?= rp($dt['jumlah']); ?></td>
                                    <td><?= $dt['nm_satuan']; ?></td>
                                    <td><?= rp($dt['harga']); ?></td>

                                    <td><?php
                                        switch ($dt['jenis_reff']) {
                                            case "1":
                                                echo "PR";
                                                break;
                                            case "2":
                                                echo "Penawaran";
                                                break;
                                            case "3":
                                                echo "Tanpa Referensi";
                                                break;
                                        }
                                        ?></td>


                                </tr>
                            <?php $x++;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php $x = 1;
        foreach ($data_d as $mr) : ?>
            <?php if ($mr['jenis_reff'] == 1) { ?>
                <div class="card mb-1 border-left-info">
                    <div class="card-body">
                        <h5>
                            <bold>
                                <div class="row">

                                    <div class="col-sm">
                                        <p class="text-danger"><b><label>Item : <?= $x; ?> </label> </b></p>
                                        <p class="text-primary"><b><label><?= rp($mr['jumlah']); ?> <?= $mr['nm_satuan']; ?> <?= $mr['nm_barang']; ?>, Harga @ <?= rp($mr['harga']); ?> Rupiah</label>
                                            </b></p>
                                    </div>
                                </div>
                            </bold>
                        </h5>
                        <!-- --------------------------------------------------------------------------------------------------------- -->

                        <div class="row">
                            <div class="col-sm mt-1">
                                <h5><b>Referensi PR </b></h5>
                            </div>
                        </div>

                        <?php
                        $menuId = $mr['id_reff'];
                        $querySubMenu = "SELECT a.id,b.id as id_d,SUBSTRING(a.date_time,1,10) as tgl, no_permintaan,no_pol,nama_lengkap,lokasi,a.keterangan as ket_m
                                    ,item,qty,satuan,spesifikasi,b.keterangan as ket_d,catatan_purchasing
                                     FROM permintaan_barang a 
                                    inner join permintaan_barang_detail b on a.id = b.permintaan_barang_id
                                    inner join user c on a.user_id = c.id
                                    inner join lokasi d on a.lokasi_id = d.id
                                      where  b.id = $menuId";
                        $subMenu = $this->db->query($querySubMenu)->row_array();

                        ?>


                        <table class="" width="100%" cellspacing="0">
                            <tr>
                                <td>No. PR</td>
                                <td>:</td>
                                <td><?= $subMenu['no_permintaan']; ?></td>
                            </tr>
                            <tr>
                                <td>User. PR</td>
                                <td>:</td>
                                <td><?= $subMenu['nama_lengkap']; ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>:</td>
                                <td><?= tgl_indo($subMenu['tgl']); ?></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td><?= $subMenu['ket_m']; ?></td>
                            </tr>
                            <tr>
                                <td>Item</td>
                                <td>:</td>
                                <td><?= $subMenu['item']; ?></td>
                            </tr>
                            <tr>
                                <td>Jumlah</td>
                                <td>:</td>
                                <td><?= $subMenu['qty']; ?></td>
                            </tr>
                            <tr>
                                <td>Spesifikasi</td>
                                <td>:</td>
                                <td><?= $subMenu['spesifikasi']; ?></td>
                            </tr>
                            <tr>
                                <td>Ket. Item</td>
                                <td>:</td>
                                <td><?= $subMenu['ket_d']; ?></td>
                            </tr>
                        </table>

                    </div>
                </div>



                <!-- --------------------------------------------------------------------------------------------------------- -->
            <?php };
            if ($mr['jenis_reff'] == 2) { ?>
                <div class="card mb-1 border-left-info">
                    <div class="card-body">
                        <h5>
                            <bold>
                                <div class="row">

                                    <div class="col-sm">
                                        <p class="text-danger"><b><label>Item : <?= $x; ?> </label> </b></p>
                                        <p class="text-primary"><b><label><?= rp($mr['jumlah']); ?> <?= $mr['nm_satuan']; ?> <?= $mr['nm_barang']; ?>, Harga @ <?= rp($mr['harga']); ?> Rupiah</label>
                                            </b></p>
                                    </div>
                                </div>
                            </bold>
                        </h5>

                        <div class="row">
                            <div class="col-sm mt-1">
                                <h5><b>Referensi PR </b></h5>
                            </div>
                        </div>

                        <?php
                        $menuId = $mr['id_reff'];
                        // $querySubMenu = "select * from permintaan_barang_penawaran where  id = $menuId";
                        // $penawaran = $this->db->query($querySubMenu)->row_array();
                        // $menuId = $penawaran['id_pr_d'];
                        ?>

                        <?php

                        $querySubMenu = "SELECT a.id,b.id as id_d,SUBSTRING(a.date_time,1,10) as tgl, no_permintaan,no_pol,nama_lengkap,lokasi,a.keterangan as ket_m
                                    ,item,qty,satuan,spesifikasi,b.keterangan as ket_d,catatan_purchasing
                                     FROM permintaan_barang a 
                                    inner join permintaan_barang_detail b on a.id = b.permintaan_barang_id
                                    inner join user c on a.user_id = c.id
                                    inner join lokasi d on a.lokasi_id = d.id
                                      where  b.id = $menuId";
                        $subMenu = $this->db->query($querySubMenu)->row_array();

                        ?>


                        <table class="" width="100%" cellspacing="0">
                            <tr>
                                <td>No. PR</td>
                                <td>:</td>
                                <td><?= $subMenu['no_permintaan']; ?></td>
                            </tr>
                            <tr>
                                <td>User. PR</td>
                                <td>:</td>
                                <td><?= $subMenu['nama_lengkap']; ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>:</td>
                                <td><?= tgl_indo($subMenu['tgl']); ?></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td><?= $subMenu['ket_m']; ?></td>
                            </tr>
                            <tr>
                                <td>Item</td>
                                <td>:</td>
                                <td><?= $subMenu['item']; ?></td>
                            </tr>
                            <tr>
                                <td>Jumlah</td>
                                <td>:</td>
                                <td><?= $subMenu['qty']; ?></td>
                            </tr>
                            <tr>
                                <td>Spesifikasi</td>
                                <td>:</td>
                                <td><?= $subMenu['spesifikasi']; ?></td>
                            </tr>
                            <tr>
                                <td>Ket. Item</td>
                                <td>:</td>
                                <td><?= $subMenu['ket_d']; ?></td>
                            </tr>

                        </table>

                        <br>


                        <?php
                        $menuId = $mr['id_reff'];
                        $querySubMenu = "select * from permintaan_barang_penawaran a
                            inner join gbr_penawaran b on a.id_penawaran = b.id_penawaran
                            inner join m_supplier c on b.id_supplier = c.id_supplier where  a.id_pr_d = $menuId";
                        $supplier = $this->db->query($querySubMenu)->result_array();
                        $no_sup = 1;
                        foreach ($supplier as $sp) : ?>

                            <div class="row">
                                <div class="col-sm-10">
                                    <h5>
                                        <bold>
                                            <p class="text-success">Penawaran <?= $no_sup; ?> : <?= $sp['nm_supplier']; ?></p>
                                            <p class="text-success">TOP : <?= $sp['top']; ?></p>
                                        </bold>
                                    </h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm">
                                    <?php $path = base_url('assets/penawaran/') . $sp['nm_file']; ?>
                                    <img src="<?= $path; ?>" type="image/jpeg" width="100%">
                                </div>
                            </div>
                            <br><br><br>
                        <?php
                            $no_sup = $no_sup + 1;
                        endforeach; ?>
                    </div>
                </div>
            <?php }; ?>



        <?php
            $x = $x + 1;
        endforeach; ?>
        <br>
        Keterangan Void : <input type="text" required="required" class="form-control border border-primary" name="txtnote_void" id="txtnote_void" autocomplete="off">
        <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Void</button>
            <a href="#" onclick="approve()" id="btnapprove" class="btn btn-primary">Approve</a>
        </div>
    </form>
</div>

<script type="text/javascript">
    function approve() {

        $.ajax({
            url: "<?= base_url('approve/app_po/approve_po'); ?>",
            data: {
                id_transaksi: $('#id_transaksi').val(),
            },
            method: "post",
            dataType: 'json',
            success: function(data) {

                location.reload(); // then reload the page.(3)
            }
        });


        $("#btnapprove").hide();
    }
</script>