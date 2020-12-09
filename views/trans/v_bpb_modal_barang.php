<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="modalpilihbarang" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Nama Barang</th>
                    <th>Jumlah PO</th>
                    <th>Jumlah Sisa</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($barang as $mr) : ?>
                    <tr>
                        <td width="8%">
                            <button id="btnmdlpilihbarang" type="button" class="badge badge-primary" data-id_po_d="<?= $mr['id_detail']; ?>" data-id_satuan="<?= $mr['id_satuan']; ?>" data-jumlah="<?= $mr['jumlah']; ?>" data-id="<?= $mr['id_barang']; ?>" data-nm_barang="<?= $mr['nm_barang']; ?>" data-harga="<?= $mr['harga']; ?>" data-satuan="<?= $mr['nm_satuan']; ?>" data-dismiss="modal">Pilih</button>
                        </td>
                        <td><?= $mr['nm_barang']; ?></td>
                        <td><?= qtyrp($mr['jumlah']); ?> <?= $mr['nm_satuan']; ?></td>
                        <td><?= qtyrp($mr['jml_konv_terkecil'] - $mr['jml_dt_konv_terkecil']);  ?> <?php
                                                                                                    $menuId = $mr['id_sat_konv_terakhir'];
                                                                                                    $querySubMenu = "SELECT * from m_satuan where id_satuan = $menuId";
                                                                                                    $subMenu2 = $this->db->query($querySubMenu)->row_array();
                                                                                                    //$konversi = $konversi . ' ' . $subMenu2['nm_satuan'];
                                                                                                    echo $subMenu2['nm_satuan'];
                                                                                                    ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $('#modalpilihbarang').DataTable({
        scrollY: '50vh',
        scrollX: true,
        scrollCollapse: true,
        paging: false
    });

    $(document).on('shown.bs.modal', '.modal', function() {
        $($.fn.dataTable.tables(true)).DataTable().draw();
    });

    $('#modalpilihbarang').on('click', '#btnmdlpilihbarang', function() {
        $('#lblnm_barang').text($(this).data('nm_barang'));
        $('#lbljumlah').text("Jumlah         : " + $(this).data('jumlah') + " " + $(this).data('satuan'));
        $('#txtid_barang').val($(this).data('id'));
        $('#txtid_po_d').val($(this).data('id_po_d'));
        $('#nm_barang').val($(this).data('nm_barang'));
        $('#harga').val($(this).data('harga'));
        $('#satuan-area').load("<?= base_url('no_logged/pilihsatuan/'); ?>" + $(this).data('id') + "/" + $(this).data('id_po_d'));
    });
</script>