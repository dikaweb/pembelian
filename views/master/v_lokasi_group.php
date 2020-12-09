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
                                    <th scope="col">Nama Group</th>

                                    <!-- 
                                    <th scope="col">Separator</th> -->
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($menu as $m) : ?>
                                    <tr>
                                        <td><?= $m['nm_lokasi_group']; ?></td>
                                        <td>
                                            <a href="<?= base_url('master/lokasi_group/detil/') . $m['id_lokasi_group']; ?>" class="badge badge-warning">detil</a>
                                            <a href="" data-toggle="modal" data-target="#editMenuModal" data-id="<?= $m['id_lokasi_group']; ?>" data-nm_lokasi_group="<?= $m['nm_lokasi_group']; ?>" class="badge badge-success clastombolubah">edit</a>
                                            <a href="" data-toggle="modal" data-target="#deleteMenuModal" data-id="<?= $m['id_lokasi_group']; ?>" data-nm_lokasi_group="<?= $m['nm_lokasi_group']; ?>" class="badge badge-danger clastomboldelete">delete</a>
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
                <h5 class="modal-title" id="newMenuModalLabel">Tambah nama jenis group lokasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/lokasi_group/save'); ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">
                            Nama Lokasi Group
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="nm_lokasi_group" name="nm_lokasi_group" autocomplete="off">
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
                <h5 class="modal-title" id="deleteMenuModalLabel">Delete sales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/lokasi_group/delete'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="idd" id="idd">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nm_lokasi_groupd" name="nm_lokasi_groupd">
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
                <h5 class="modal-title" id="editMenuModalLabel">Edit Kode Surat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/lokasi_group/edit'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="ide" id="ide">
                    <div class="row">
                        <div class="col-sm-3">
                            Nama Lokasi Group
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="nm_lokasi_groupe" name="nm_lokasi_groupe" autocomplete="off">
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
            $('#ide').val($(this).data('id'));
            $('#nm_lokasi_groupe').val($(this).data('nm_lokasi_group'));

        });

        $('.clastomboldelete').on('click', function() {
            const id = $(this).data('id');
            $('#idd').val($(this).data('id'));
            $('#nm_lokasi_groupd').val($(this).data('nm_lokasi_group'));
        });
    });
</script>