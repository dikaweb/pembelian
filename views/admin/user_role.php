<!-- Begin Page Content -->
<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?= base_url('assets/'); ?>vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg">
            <?= form_error('email', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('name', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('messagez'); ?>
            <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">UserName</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Group Role</th>
                        <th scope="col">Location</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($u_role as $ur) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $ur['email']; ?></td>
                            <td><?= $ur['name']; ?></td>
                            <td><?= $ur['role']; ?></td>
                            <td><?= $ur['lokasi']; ?></td>


                            <td>
                                <a href="" class="badge badge-success clastombolubah" data-toggle="modal" data-target="#editMenuModal" data-id="<?= $ur['id']; ?>">edit</a>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!----------------------------------------------------- Modal Edit  --------------------------------->
<div class="modal fade" id="editMenuModal" tabindex="-1" role="dialog" aria-labelledby="editMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMenuModalLabel">Edit User Group Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/role/user_role'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="id" id="id">
                    <div class="form-group">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <select name="role" id="role" class="form-control">
                            <?php foreach ($cbo_role as $urm) : ?>
                                <option value="<?= $urm['id']; ?>"><?= $urm['role']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="lokasi" id="lokasi" class="form-control">
                            <?php foreach ($cbo_lokasi as $urm) : ?>
                                <option value="<?= $urm['id']; ?>"><?= $urm['lokasi']; ?></option>
                            <?php endforeach; ?>
                        </select>
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
            $.ajax({
                url: "<?= base_url('admin/role/get_user_role'); ?>",
                data: {
                    id: id,
                },
                method: "post",
                dataType: 'json',
                success: function(data) {
                    $('#email').val(data.email);
                    $('#name').val(data.name);
                    $('#role').val(data.id_role);
                    $('#lokasi').val(data.id_lokasi);
                    $('#id').val(data.id_user);
                }
            });
        });
    });
</script>