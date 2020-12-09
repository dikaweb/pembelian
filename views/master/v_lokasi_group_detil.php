<!-- Begin Page Content -->

<div class="container-fluid">
    <div class="row">
        <div class="col-lg">
            <a href="" class="btn btn-primary mb-3 clastomboladd" data-toggle="modal" data-id="<?= $id_kode ?>" data-target="#newMenuModal">Tambah</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Nama Group</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menu as $m) : ?>
                        <tr>
                            <td><?= $m['lokasi']; ?></td>
                            <td><?= $m['nm_lokasi_group']; ?></td>
                            <td>
                                <a href="" data-toggle="modal" data-target="#deleteMenuModal" data-nm_lokasi="<?= $m['lokasi']; ?>" data-id="<?= $m['id_detail']; ?>" data-idmd="<?= $m['id_lokasi_group']; ?>" class="badge badge-danger clastomboldelete">hapus</a>
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
                <h5 class="modal-title" id="deleteMenuModalLabel">Hapus Lokasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/lokasi_group/delete_d'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="idd" id="idd">
                    <input type="hidden" class="form-control" name="idmd" id="idmd">
                    <div class="row">
                        <div class="col-sm-3">
                            Lokasi
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control" id="lokasid" name="lokasid">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal tambah -->
<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Tambah lokasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/lokasi_group/save_d'); ?>" method="post">
                <input type="hidden" class="form-control" name="idm" id="idm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">
                            Lokasi
                        </div>
                        <div class="col-sm">
                            <select name="lokasit" id="lokasit" class="form-control custom-select">
                                <?php foreach ($lokasi as $urm) : ?>
                                    <option value="<?= $urm['id']; ?>"><?= $urm['lokasi']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
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
            $('#idd').val($(this).data('id'));
            $('#idmd').val($(this).data('idmd'));
            $('#lokasid').val($(this).data('nm_lokasi'));
        });

        $('.clastomboladd').on('click', function() {
            const id = $(this).data('id');
            $('#idm').val($(this).data('id'));
        });
    });
</script>