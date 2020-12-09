<!-- Begin Page Content -->
<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?= base_url('assets/'); ?>vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg">
            <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= $this->session->flashdata('messagez'); ?>

            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">Tambah</a>

            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">Lokasi Group</th>
                                    <th scope="col">Departement</th>
                                    <th scope="col">Kode</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($menu as $m) : ?>
                                    <tr>
                                        <td><?= $m['nm_lokasi_group']; ?></td>
                                        <td><?= $m['nm_dept']; ?></td>
                                        <td><?= $m['nm_kode_jenis_dept']; ?></td>
                                        <td><?= $m['ket_kode_jenis_dept']; ?></td>
                                        <td>
                                            <a href="" data-toggle="modal" data-target="#editMenuModal" data-id_lokasi_group="<?= $m['id_lokasi_group']; ?>" data-nm_kode_jenis_dept="<?= $m['nm_kode_jenis_dept']; ?>" data-id_company="<?= $m['id_company']; ?>" data-id_dept="<?= $m['id_dept']; ?>" data-ket_kode_jenis_dept="<?= $m['ket_kode_jenis_dept']; ?>" data-id="<?= $m['id_kode_jenis_dept']; ?>" class="badge badge-success clastombolubah">edit</a>
                                            <a href="" data-toggle="modal" data-target="#deleteMenuModal" data-nama="<?= $m['nm_kode_jenis_dept']; ?>" data-id="<?= $m['id_kode_jenis_dept']; ?>" class="badge badge-danger clastomboldelete">delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal tambah -->
<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Tambah Jenis Surat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/kode_jenis_dept/save'); ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-2">
                            Company
                        </div>
                        <div class="col-sm">
                            <select name="companyt" id="companyt" class="form-control custom-select">
                                <?php foreach ($company as $urm) : ?>
                                    <option value="<?= $urm['id_company']; ?>"><?= $urm['nm_company']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Lokasi
                        </div>
                        <div class="col-sm">
                            <select name="lokasi_groupt" id="lokasi_groupt" class="form-control custom-select">
                                <?php foreach ($lokasi_group as $urm) : ?>
                                    <option value="<?= $urm['id_lokasi_group']; ?>"><?= $urm['nm_lokasi_group']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Dept
                        </div>
                        <div class="col-sm">
                            <select name="deptt" id="deptt" class="form-control custom-select">
                                <?php foreach ($dept as $urm) : ?>
                                    <option value="<?= $urm['id_dept']; ?>"><?= $urm['nm_dept']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Kode
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="namat" name="namat" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Ket
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="kett" name="kett" autocomplete="off">
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMenuModalLabel">Delete Jenis Surat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/kode_jenis_dept/delete'); ?>" method="post">
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMenuModalLabel">Edit Jenis Surat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/kode_jenis_dept/update'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="id" id="id">
                    <div class="row">
                        <div class="col-sm-2">
                            Company
                        </div>
                        <div class="col-sm">
                            <select name="company" id="company" class="form-control custom-select">
                                <?php foreach ($company as $urm) : ?>
                                    <option value="<?= $urm['id_company']; ?>"><?= $urm['nm_company']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Lokasi
                        </div>
                        <div class="col-sm">
                            <select name="lokasi_group" id="lokasi_group" class="form-control custom-select">
                                <?php foreach ($lokasi_group as $urm) : ?>
                                    <option value="<?= $urm['id_lokasi_group']; ?>"><?= $urm['nm_lokasi_group']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Dept
                        </div>
                        <div class="col-sm">
                            <select name="dept" id="dept" class="form-control custom-select">
                                <?php foreach ($dept as $urm) : ?>
                                    <option value="<?= $urm['id_dept']; ?>"><?= $urm['nm_dept']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Kode
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap-daterangepicker/moment.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>



<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [],
            dom: '<"toolbar">Bfrtip',
            scrollY: '60vh',
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: {
                heightMatch: 'none'
            },
        });
    });


    $(function() {
        $('.clastombolubah').on('click', function() {
            const id = $(this).data('id');
            $('#id').val($(this).data('id'));
            $('#nama').val($(this).data('nm_kode_jenis_dept'));
            $('#ket').val($(this).data('ket_kode_jenis_dept'));
            $('#dept').val($(this).data('id_dept'));
            $('#company').val($(this).data('id_company'));
            $('#lokasi_group').val($(this).data('id_lokasi_group'));
        });

        $('.clastomboldelete').on('click', function() {
            const id = $(this).data('id');
            $('#idd').val($(this).data('id'));
            $('#namad').val($(this).data('nama'));
        });
    });
</script>