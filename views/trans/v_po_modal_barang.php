<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="modalpilihbarang" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Actions</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th>Kelompok</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($barang as $mr) : ?>
                    <tr>
                        <td width="22%">
                            <button id="btnmdlpilihbarang" type="button" class="badge badge-primary" data-nm_satuan="<?= $mr['nm_satuan']; ?>" data-id="<?= $mr['id_barang']; ?>" data-nm_barang="<?= $mr['nm_barang']; ?>" data-satuan="<?= $mr['id_satuan']; ?>" data-dismiss="modal">Pilih</button>
                            <button id="btnmdleditbarang" type="button" class="badge badge-info" data-kelompok="<?= $mr['kelompok']; ?>" data-kd_barang="<?= $mr['kd_barang']; ?>" data-id="<?= $mr['id_barang']; ?>" data-nm_barang="<?= $mr['nm_barang']; ?>" data-satuan="<?= $mr['id_satuan']; ?>" data-dismiss="modal">Edit</button>
                            <button id="btnmdledeletebarang" type="button" class="badge badge-danger" data-kd_barang="<?= $mr['kd_barang']; ?>" data-id="<?= $mr['id_barang']; ?>" data-nm_barang="<?= $mr['nm_barang']; ?>" data-satuan="<?= $mr['id_satuan']; ?>" data-dismiss="modal">Hapus</button>
                        </td>
                        <td><?= $mr['kd_barang']; ?></td>
                        <td><?= $mr['nm_barang']; ?></td>
                        <td><?= $mr['nm_satuan']; ?></td>
                        <td><?= $mr['kelompok']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-info" onclick="tambahbarangbaru()">Tambah Barang</button>
    </div>
</div>

<script type="text/javascript">
    $('#modalpilihbarang').DataTable({
        scrollY: '50vh',
        scrollX: true,
        scrollCollapse: true,
        paging: true
    });

    $(document).on('shown.bs.modal', '.modal', function() {
        $($.fn.dataTable.tables(true)).DataTable().draw();
    });

    $('#modalpilihbarang').on('click', '#btnmdlpilihbarang', function() {
        $('#lblnm_barang').text($(this).data('nm_barang'));
        $('#lblsatuan').text("Satuan         : " + $(this).data('nm_satuan'));
        $('#txtid_barang').val($(this).data('id'));
        $('#txtid_satuan').val($(this).data('satuan'));
        $('#satuan-area').load("<?= base_url('no_logged/pilihsatuan/'); ?>" + $(this).data('id'));
    });

    function tambahbarangbaru() {

        $("#btnsimpanbarang").html("Simpan");
        $("#barangModalTittle").html("Tambah barang");
        $("#btnsimpanbarang").attr("class", "btn btn-info  col-sm-2 mt-1 btn-sm");
        $("#btnsimpanbarang").attr("onclick", "simpanbarang()");
        $('#nm_barang').val("");
        $('#kd_barang').val("");
        $('#kelompok').val("");
        $('#satuan').val(1);
        $("#barangModal").modal("hide");
        $('#addbarangModal').modal();
    }
    $('#modalpilihbarang').on('click', '#btnmdleditbarang', function() {
        $("#btnsimpanbarang").html("Update");
        $("#barangModalTittle").html("Ubah barang");
        $("#btnsimpanbarang").attr("onclick", "updatebarang()");
        $("#btnsimpanbarang").attr("class", "btn btn-info  col-sm-2 mt-1 btn-sm");

        $('#kelompok').val($(this).data('kelompok'));
        $('#satuan').val($(this).data('satuan'));
        $('#nm_barang').val($(this).data('nm_barang'));
        $('#kd_barang').val($(this).data('kd_barang'));
        $('#id_barang').val($(this).data('id'));
        $("#barangModal").modal("hide");
        $('#addbarangModal').modal();
    });
    $('#modalpilihbarang').on('click', '#btnmdledeletebarang', function() {
        $("#btnsimpanbarang").html("Hapus?");
        $("#btnsimpanbarang").attr("onclick", "deletebarang()");
        $("#btnsimpanbarang").attr("class", "btn btn-danger  col-sm-2 mt-1 btn-sm");
        $("#barangModalTittle").html("Hapus barang")

        $('#kd_barang').val($(this).data('kd_barang'));
        $('#satuan').val($(this).data('satuan'));
        $('#nm_barang').val($(this).data('nm_barang'));
        $('#id_barang').val($(this).data('id'));
        $("#barangModal").modal("hide");
        $('#addbarangModal').modal();
    });
</script>