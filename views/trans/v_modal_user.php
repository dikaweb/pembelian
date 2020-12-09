<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="modalpilihuserpenerima" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">Nama</th>
                    <th scope="col">Location</th>
                    <th scope="col">KD Loc</th>
                    <th scope="col">Company</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userpenerima as $ur) : ?>
                    <tr>
                        <td>
                            <button id="btnmdlpilihuserpenerima" type="button" class="btn btn-primary" data-idpen="<?= $ur['id']; ?>" data-nama="<?= $ur['name']; ?>" data-dismiss="modal">Pilih</button>
                        </td>
                        <td><?= $ur['name']; ?></td>
                        <td><?= $ur['lokasi']; ?></td>
                        <td><?= $ur['kd_lokasi']; ?></td>
                        <td><?= $ur['nm_company']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $('#modalpilihuserpenerima').DataTable({
        scrollY: '50vh',
        scrollX: true,
        scrollCollapse: true,
        paging: false
    });

    $(document).on('shown.bs.modal', '.modal', function() {
        $($.fn.dataTable.tables(true)).DataTable().draw();
    });

    $('#modalpilihuserpenerima').on('click', '#btnmdlpilihuserpenerima', function() {
        console.log($(this).data('idpen'));
        $('#txtid_user_penerima').val($(this).data('idpen'));
        $('#lblnm_user_penerima').text($(this).data('nama'));
    });
</script>