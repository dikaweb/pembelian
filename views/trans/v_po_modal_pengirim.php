<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="modalpilihpengirim" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No. Telp</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($m_pengirim as $mr) : ?>
                    <tr>
                        <td valign="center">
                            <button id="btnmdlpilihpengirim" type="button" class="btn btn-primary" data-kota_kab="<?= $mr['alamat_pg1']; ?> <?= $mr['alamat_pg2']; ?>" data-province="<?= $mr['no_telp']; ?>" data-lokasi="<?= $mr['nm_pengirim']; ?>" data-id="<?= $mr['id_pengirim']; ?>" data-dismiss="modal">Pilih</button>
                        </td>
                        <td><?= $mr['nm_pengirim']; ?></td>
                        <td><?= $mr['alamat_pg1']; ?>&nbsp<?= $mr['alamat_pg1']; ?> </td>
                        <td><?= $mr['no_telp']; ?></td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $('#modalpilihpengirim').on('click', '#btnmdlpilihpengirim', function() {
        $('#lblnm_rekanan').text($(this).data('kota_kab'));
        $('#lblalamat').text($(this).data('province'));
        $('#lblkd_rekanan').text($(this).data('lokasi'));
        $('#txtid_rekanan').val($(this).data('id'));
    });

    function tambahPengirim() {
        $("#penerimaModal").modal("hide");
        console.log("crut");
        $('#addpenerimaModal').modal();
    }
</script>