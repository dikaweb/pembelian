<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="modalpilihpo" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>No PO</th>
                    <th>Tanggal</th>
                    <th>Nama Supplier</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($po as $pn) : ?>
                    <tr>
                        <td width="8%" align="center">
                            <button id="btnmdlpilihpo" type="button" class="btn btn-primary" data-no_transaksi="<?= $pn['no_transaksi']; ?>" data-id="<?= $pn['id_transaksi']; ?>" data-tanggal=" <?= tgl_indo($pn['tanggal']); ?>" data-nm_supplier="<?= $pn['nm_supplier']; ?>" data-dismiss="modal">Pilih</button>
                        </td>
                        <td><?= $pn['no_transaksi']; ?> </td>
                        <td><?= tgl_indo($pn['tanggal']); ?> </td>
                        <td><?= $pn['nm_supplier']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $('#modalpilihpo').DataTable({
        scrollY: '50vh',
        scrollX: true,
        scrollCollapse: true,
        paging: false
    });

    $(document).on('shown.bs.modal', '.modal', function() {
        $($.fn.dataTable.tables(true)).DataTable().draw();
    });

    $('#modalpilihpo').on('click', '#btnmdlpilihpo', function() {
        $('#lblno_po').text("No. PO   : " + $(this).data('no_transaksi'));
        $('#lbltgl_po').text("Tgl PO : " + $(this).data('tanggal'));
        $('#txtid_po').val($(this).data('id'));
        $('#pilihsup').hide();
        $('#txt_company').attr("disabled", true);



    });
</script>

<!-------------------------------------- Pilih Rekanan & Barang-------------------------------------- -->