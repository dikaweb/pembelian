<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="modalpilihbarang" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Stock</th>
                    <th>Satuan</th>
                    <th>Gudang</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($barang as $mr) : ?>
                    <tr>
                        <td width="22%">
                            <button id="btnmdlpilihbarang" type="button" class="btn btn-primary" data-id_gudang="<?= $mr['id_gudang']; ?>" data-qty="<?= $mr['qty']; ?>" data-nm_satuan="<?= $mr['nm_satuan']; ?>" data-id="<?= $mr['id_barang']; ?>" data-nm_barang="<?= $mr['nm_barang']; ?>" data-satuan="<?= $mr['id_satuan']; ?>" data-dismiss="modal">Pilih</button>
                        </td>
                        <td><?= $mr['nm_barang']; ?></td>
                        <td><?= $mr['qty']; ?></td>
                        <td><?= $mr['nm_satuan']; ?></td>
                        <td><?= $mr['kd_gudang']; ?></td>
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
        $('#lblsatuan').text("Stock         : " + $(this).data('qty') + " " + $(this).data('nm_satuan'));
        $('#txtid_barang').val($(this).data('id'));
        $('#btngudangfrom').hide();
        $('#txtid_satuan').val($(this).data('satuan'));
        $('#txtid_gudang_asal').val($(this).data('id_gudang'));
        $('#satuan-area').load("<?= base_url('no_logged/pilihsatuan/'); ?>" + $(this).data('id'));
    });
</script>