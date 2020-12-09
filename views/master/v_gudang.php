<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg">
            <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= $this->session->flashdata('messagez'); ?>

            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">Tambah</a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">PT</th>
                        <th scope="col">Nama Gudang</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">GD Supplier ?</th>
                        <th scope="col">GD Kapasan ?</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($menu as $m) : ?>
                        <tr>

                            <td><?= $m['nm_company']; ?></td>
                            <td><?= $m['kd_gudang']; ?></td>
                            <td><?= $m['ket_gd']; ?></td>
                            <td><?= $m['alamat_gd']; ?></td>
                            <td><?php if ($m['is_outstanding'] == 1) : ?> Yes <?php else : ?> No <?php endif; ?></td>
                            <td><?php if ($m['is_kapasan'] == 1) : ?> Yes <?php else : ?> No <?php endif; ?></td>
                            <td>
                                <a href="" data-toggle="modal" data-target="#editMenuModal" data-is_kapasan="<?= $m['is_kapasan']; ?>" data-is_outstanding="<?= $m['is_outstanding']; ?>" data-id_company="<?= $m['id_company']; ?>" data-kode="<?= $m['alamat_gd']; ?>" data-ket="<?= $m['ket_gd']; ?>" data-id="<?= $m['id_gudang']; ?>" data-nama="<?= $m['kd_gudang']; ?>" class="badge badge-success clastombolubah">edit</a>
                                <a href="" data-toggle="modal" data-target="#deleteMenuModal" data-nama="<?= $m['kd_gudang']; ?>" data-id="<?= $m['id_gudang']; ?>" class="badge badge-danger clastomboldelete">delete</a>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>



</div>

<!-- Modal tambah -->
<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Tambah sales baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/gudang/save'); ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-2">
                            Nama GD
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="namat" name="namat" autocomplete="off" required="required">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Keterangan
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="kett" name="kett" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Alamat
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="alamatt" name="alamatt" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            PT
                        </div>
                        <div class="col-sm">
                            <select name="txt_companyt" id="txt_companyt" class="form-control" required="required">
                                <option></option>
                                <?php foreach ($company as $urm) : ?>
                                    <option value="<?= $urm['id_company']; ?>"><?= $urm['nm_company']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-2">

                        </div>
                        <div class="col-sm ml-4">
                            <input class="form-check-input" type="checkbox" value="1" name="is_outstandingt" id="is_outstandingt">
                            <label class="form-check-label" for="is_outstandingt">
                                IS Gudang Supplier
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">

                        </div>
                        <div class="col-sm ml-4">
                            <input class="form-check-input" type="checkbox" value="1" name="is_kapasant" id="is_kapasant">
                            <label class="form-check-label" for="is_kapasant">
                                IS Kapasan
                            </label>
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

<!---------------------------------------------- Modal Delete -------------------------------->
<div class="modal fade" id="deleteMenuModal" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMenuModalLabel">Hapus Gudang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/gudang/delete'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="idd" id="idd">
                    <div class="form-group">
                        <input type="text" class="form-control" id="namad" name="namad">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!----------------------------------------------------- Modal Edit  --------------------------------->
<div class="modal fade" id="editMenuModal" tabindex="-1" role="dialog" aria-labelledby="editMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMenuModalLabel">Edit dept</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/gudang/edit'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="id" id="id">
                    <div class="row">
                        <div class="col-sm-2">
                            Nama GD
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="nama" name="nama" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Ket
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="ket" name="ket" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Alamat
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="alamat" name="alamat" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            PT
                        </div>
                        <div class="col-sm">
                            <select name="txt_company" id="txt_company" class="form-control" required="required">
                                <option></option>
                                <?php foreach ($company as $urm) : ?>
                                    <option value="<?= $urm['id_company']; ?>"><?= $urm['nm_company']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-2">

                        </div>
                        <div class="col-sm ml-4">
                            <input class="form-check-input" type="checkbox" value="1" name="is_outstanding" id="is_outstanding">
                            <label class="form-check-label" for="is_outstanding">
                                IS Gudang Supplier
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">

                        </div>
                        <div class="col-sm ml-4">
                            <input class="form-check-input" type="checkbox" value="1" name="is_kapasan" id="is_kapasan">
                            <label class="form-check-label" for="is_kapasan">
                                Is Kapasan
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>



<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('.clastombolubah').on('click', function() {
            const id = $(this).data('id');
            $('#id').val($(this).data('id'));
            $('#nama').val($(this).data('nama'));
            $('#ket').val($(this).data('ket'));
            $('#alamat').val($(this).data('kode'));
            $('#txt_company').val($(this).data('id_company'));
            if ($(this).data('is_outstanding') == 1) {
                $('#is_outstanding').prop("checked", true);
            } else {
                $('#is_outstanding').prop("checked", false);
            };
            if ($(this).data('is_kapasan') == 1) {
                $('#is_kapasan').prop("checked", true);
            } else {
                $('#is_kapasan').prop("checked", false);
            };
        });

        $('.clastomboldelete').on('click', function() {
            const id = $(this).data('id');
            $('#idd').val($(this).data('id'));
            $('#namad').val($(this).data('nama'));
        });
    });
</script>