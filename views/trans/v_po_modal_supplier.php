<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="modalpilihsupplier" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>UP</th>
                    <th>No. Rek</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($m_supplier as $pn) : ?>
                    <tr>
                        <td width="22%">
                            <button id="btnmdlpilihsupplier" type="button" class="badge badge-primary" data-no_rek="<?= $pn['no_rek']; ?>" data-up_sp="<?= $pn['up_sp']; ?>" data-alamat_sp=" <?= $pn['alamat_sp']; ?>" data-nm_supplier="<?= $pn['nm_supplier']; ?>" data-id="<?= $pn['id_supplier']; ?>" data-dismiss="modal">Pilih</button>
                            <button id="btnmdleditsupplier" type="button" class="badge badge-info" data-no_rek="<?= $pn['no_rek']; ?>" data-up_sp="<?= $pn['up_sp']; ?>" data-alamat_sp="<?= $pn['alamat_sp']; ?>" data-nm_supplier="<?= $pn['nm_supplier']; ?>" data-id="<?= $pn['id_supplier']; ?>" data-dismiss="modal">Edit</button>
                            <button id="btnmdledeletesupplier" type="button" class="badge badge-danger" data-up_sp="<?= $pn['up_sp']; ?>" data-alamat_sp="<?= $pn['alamat_sp']; ?>" data-nm_supplier="<?= $pn['nm_supplier']; ?>" data-id="<?= $pn['id_supplier']; ?>" data-dismiss="modal">Hapus</button>
                        </td>
                        <td><?= $pn['nm_supplier']; ?></td>
                        <td><?= $pn['alamat_sp']; ?> </td>
                        <td><?= $pn['up_sp']; ?> </td>
                        <td><?= $pn['no_rek']; ?> </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-info" onclick="tambahsupplier()">Tambah supplier</button>
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

    function tambahsupplier() {
        $("#supplierModal").modal("hide");
        $("#btnsimpansupplier").html("Simpan");
        $("#supplierModalTittle").html("Tambah supplier");
        $("#btnsimpansupplier").attr("class", "btn btn-info  col-sm-2 mt-1 btn-sm");
        $('#addsupplierModal').modal();
        $('#nm_supplier').val("");
        $('#no_rek').val("");
        $('#alamat_sp').val("");
        $('#up_sp').val("");
        $("#btnsimpansupplier").attr("onclick", "simpansupplier()");
    }
    $('#modalpilihsupplier').on('click', '#btnmdleditsupplier', function() {
        $('#nm_supplier').val("");
        $('#alamat_sp').val("");
        $('#up_sp').val("");

        $("#btnsimpansupplier").html("Update");
        $("#supplierModalTittle").html("Ubah supplier");
        $("#btnsimpansupplier").attr("onclick", "updatesupplier()");
        $("#btnsimpansupplier").attr("class", "btn btn-info  col-sm-2 mt-1 btn-sm");
        $('#alamat_sp').val($(this).data('alamat_sp'));
        $('#up_sp').val($(this).data('up_sp'));
        $('#nm_supplier').val($(this).data('nm_supplier'));
        $('#no_rek').val($(this).data('no_rek'));
        $('#id_supplier').val($(this).data('id'));
        $("#supplierModal").modal("hide");
        $('#addsupplierModal').modal();
    });
    $('#modalpilihsupplier').on('click', '#btnmdledeletesupplier', function() {
        $('#nm_supplier').val("");
        $('#alamat_sp').val("");
        $('#up_sp').val("");

        $("#btnsimpansupplier").html("Hapus?");
        $("#btnsimpansupplier").attr("onclick", "deletesupplier()");
        $("#btnsimpansupplier").attr("class", "btn btn-danger  col-sm-2 mt-1 btn-sm");
        $("#supplierModalTittle").html("Hapus supplier")
        $('#alamat_sp').val($(this).data('alamat_sp'));
        $('#up_sp').val($(this).data('up_sp'));
        $('#nm_supplier').val($(this).data('nm_supplier'));
        $('#id_supplier').val($(this).data('id'));
        $("#supplierModal").modal("hide");
        $('#addsupplierModal').modal();
    });
</script>

<!-------------------------------------- Pilih Rekanan & Barang-------------------------------------- -->