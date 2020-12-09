<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Lokasi Group</th>
                        <!-- 
                        <th scope="col">Departement</th>
-->
                        <th scope="col">Urut</th>
                        <th scope="col">Tipe Kode</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menu as $m) : ?>
                        <tr>
                            <td><?= $m['nm_company']; ?></td>
                            <!-- 
                            <td><?= $m['nm_dept']; ?></td>
                    -->
                            <td><?= $m['no_urut']; ?></td>
                            <td><?= $m['nm_kode_tipe']; ?></td>
                            <td>
                                <a href="" data-toggle="modal" data-target="#deleteMenuModal" data-idm="<?= $m['id_kode']; ?>" data-id_kode_tipe="<?= $m['id_kode_tipe']; ?>" data-no_urut="<?= $m['no_urut']; ?>" data-id="<?= $m['id_kode_d']; ?>" class="badge badge-primary clastomboldelete">ubah</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!---------------------------------------------- Modal Delete -------------------------------->
<div class="modal fade" id="deleteMenuModal" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMenuModalLabel">Ubah tipe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/kode_surat/save_detil'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="idd" id="idd">
                    <input type="hidden" class="form-control" name="idm" id="idm">
                    <div class="row">
                        <div class="col-sm-3">
                            No Urut
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="namad" name="namad">
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-3">
                            Tipe
                        </div>
                        <div class="col-sm">
                            <select name="dept" id="dept" class="form-control custom-select">
                                <?php foreach ($kode_tipe as $urm) : ?>
                                    <option value="<?= $urm['id_kode_tipe']; ?>" selected><?= $urm['nm_kode_tipe']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('.clastomboldelete').on('click', function() {
            const id = $(this).data('id');
            $('#idm').val($(this).data('idm'));
            $('#idd').val($(this).data('id'));
            $('#namad').val($(this).data('no_urut'));
            $('#dept').val($(this).data('id_kode_tipe'));
        });
    });
</script>