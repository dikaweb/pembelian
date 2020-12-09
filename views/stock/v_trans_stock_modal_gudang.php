<input type="hidden" name="txtjenis" id="txtjenis" value="<?= $jenis; ?>">
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="modalpilihgudang" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Nama</th>
                    <th>PT</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($m_gudang as $pn) : ?>
                    <tr>
                        <td width="8%" align="center">
                            <button id="btnmdlpilihgudang" type="button" class="btn btn-primary" data-nm_company="<?= $pn['nm_company']; ?>" data-kd_gudang="<?= $pn['kd_gudang']; ?>" data-id="<?= $pn['id_gudang']; ?>" data-dismiss="modal">Pilih</button>
                        </td>
                        <td><?= $pn['kd_gudang']; ?></td>
                        <td><?= $pn['nm_company']; ?> </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<script type="text/javascript">
    $('#modalpilihgudang').DataTable({
        scrollY: '50vh',
        scrollX: true,
        scrollCollapse: true,
        paging: false
    });

    $(document).on('shown.bs.modal', '.modal', function() {
        $($.fn.dataTable.tables(true)).DataTable().draw();
    });

    $('#modalpilihgudang').on('click', '#btnmdlpilihgudang', function() {
        if ($('#txtjenis').val() == "to") {
            $('#lblkd_gudang_to').text($(this).data('kd_gudang'));
            $('#lblpt_gudang_to').text($(this).data('nm_company'));
            $('#txtid_gudang_to').val($(this).data('id'));
        } else {
            $('#lblkd_gudang_from').text($(this).data('kd_gudang'));
            $('#lblpt_gudang_from').text($(this).data('nm_company'));
            $('#txtid_gudang_from').val($(this).data('id'));
        }
    });
</script>