<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="modalpilihsupplier" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Nama</th>
                    <th>Alamat</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($m_supplier as $pn) : ?>
                    <tr>
                        <td width="8%" align="center">
                            <button id="btnmdlpilihsupplier" type="button" class="btn btn-primary" data-up_sp="<?= $pn['up_sp']; ?>" data-alamat_sp=" <?= $pn['alamat_sp']; ?>" data-nm_supplier="<?= $pn['nm_supplier']; ?>" data-id="<?= $pn['id_supplier']; ?>" data-dismiss="modal">Pilih</button>
                        </td>
                        <td><?= $pn['nm_supplier']; ?></td>
                        <td><?= $pn['alamat_sp']; ?> </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<script type="text/javascript">
    $('#modalpilihsupplier').DataTable({
        scrollY: '50vh',
        scrollX: true,
        scrollCollapse: true,
        paging: false
    });

    $(document).on('shown.bs.modal', '.modal', function() {
        $($.fn.dataTable.tables(true)).DataTable().draw();
    });

    $('#modalpilihsupplier').on('click', '#btnmdlpilihsupplier', function() {
        $('#lblnm_rekanan1').text($(this).data('alamat_sp'));
        $('#lblkd_rekanan1').text($(this).data('nm_supplier'));
        $('#txtid_rekanan1').val($(this).data('id'));
        $('#txtup').val($(this).data('up_sp'));
    });
</script>

<!-------------------------------------- Pilih Rekanan & Barang-------------------------------------- -->