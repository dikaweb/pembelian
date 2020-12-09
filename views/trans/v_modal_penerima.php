<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="modalpilihpenerima" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>UP</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($m_penerima as $pn) : ?>
                    <tr>
                        <td width="22%">
                            <button id="btnmdlpilihpenerima" type="button" class="badge badge-primary" data-up_pn="<?= $pn['up_pn']; ?>" data-alamat_pn="<?= $pn['alamat_pn1']; ?> <?= $pn['alamat_pn2']; ?>" data-nm_penerima="<?= $pn['nm_penerima']; ?>" data-id="<?= $pn['id_penerima']; ?>" data-dismiss="modal">Pilih</button>
                            <button id="btnmdleditpenerima" type="button" class="badge badge-info" data-up_pn="<?= $pn['up_pn']; ?>" data-alamat_pn1="<?= $pn['alamat_pn1']; ?>" data-nm_penerima="<?= $pn['nm_penerima']; ?>" data-id="<?= $pn['id_penerima']; ?>" data-dismiss="modal">Edit</button>
                            <button id="btnmdledeletepenerima" type="button" class="badge badge-danger" data-up_pn="<?= $pn['up_pn']; ?>" data-alamat_pn1="<?= $pn['alamat_pn1']; ?>" data-nm_penerima="<?= $pn['nm_penerima']; ?>" data-id="<?= $pn['id_penerima']; ?>" data-dismiss="modal">Hapus</button>
                        </td>
                        <td><?= $pn['nm_penerima']; ?></td>
                        <td><?= $pn['alamat_pn1']; ?> <?= $pn['alamat_pn2']; ?></td>
                        <td><?= $pn['up_pn']; ?> </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-info" onclick="tambahpenerima()">Tambah penerima</button>
    </div>
</div>

<script type="text/javascript">
    $('#modalpilihpenerima').DataTable({
        scrollY: '50vh',
        scrollX: true,
        scrollCollapse: true,
        paging: false
    });

    $(document).on('shown.bs.modal', '.modal', function() {
        $($.fn.dataTable.tables(true)).DataTable().draw();
    });

    $('#modalpilihpenerima').on('click', '#btnmdlpilihpenerima', function() {
        $('#lblalamat_pn1').text($(this).data('alamat_pn'));
        $('#lblnm_pn').text($(this).data('nm_penerima'));
        $('#txtid_penerima').val($(this).data('id'));
        $('#txtup_pn').val($(this).data('up_pn'));
    });

    function tambahpenerima() {
        $("#penerimaModal").modal("hide");
        $("#btnsimpanpenerima").html("Simpan");
        $("#penerimaModalTittle").html("Tambah penerima");
        $("#btnsimpanpenerima").attr("class", "btn btn-info  col-sm-2 mt-1 btn-sm");
        $('#addpenerimaModal').modal();
        $('#nm_penerima').val("");
        $('#alamat_pn1').val("");
        $('#up_pn').val("");
        $("#btnsimpanpenerima").attr("onclick", "simpanpenerima()");
    }
    $('#modalpilihpenerima').on('click', '#btnmdleditpenerima', function() {
        $('#nm_penerima').val("");
        $('#alamat_pn1').val("");
        $('#up_pn').val("");

        $("#btnsimpanpenerima").html("Update");
        $("#penerimaModalTittle").html("Ubah penerima");
        $("#btnsimpanpenerima").attr("onclick", "updatepenerima()");
        $("#btnsimpanpenerima").attr("class", "btn btn-info  col-sm-2 mt-1 btn-sm");
        $('#alamat_pn1').val($(this).data('alamat_pn1'));
        $('#up_pn').val($(this).data('up_pn'));
        $('#nm_penerima').val($(this).data('nm_penerima'));
        $('#id_penerima').val($(this).data('id'));
        $("#penerimaModal").modal("hide");
        $('#addpenerimaModal').modal();
    });
    $('#modalpilihpenerima').on('click', '#btnmdledeletepenerima', function() {
        $('#nm_penerima').val("");
        $('#alamat_pn1').val("");
        $('#up_pn').val("");

        $("#btnsimpanpenerima").html("Hapus?");
        $("#btnsimpanpenerima").attr("onclick", "deletepenerima()");
        $("#btnsimpanpenerima").attr("class", "btn btn-danger  col-sm-2 mt-1 btn-sm");
        $("#penerimaModalTittle").html("Hapus penerima")
        $('#alamat_pn1').val($(this).data('alamat_pn1'));
        $('#up_pn').val($(this).data('up_pn'));
        $('#nm_penerima').val($(this).data('nm_penerima'));
        $('#id_penerima').val($(this).data('id'));
        $("#penerimaModal").modal("hide");
        $('#addpenerimaModal').modal();
    });
</script>

<!-------------------------------------- Pilih Rekanan & Barang-------------------------------------- -->