<!-- Custom styles for this page -->
<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?= base_url('assets/'); ?>vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<!-- session dibawah ini diambil dari helper 
<style type="text/css">
    .modal-lg {
        max-width: 65% !important;
    }
</style>
-->
<!-- Begin Page Content -->
<div class="container-fluid">

    <?= form_error('nama', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= $this->session->flashdata('messagez'); ?>
    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="konfirmasiTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No. PO/SPK</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th>PT</th>
                            <th>Jenis</th>
                            <th>Total</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($konfirmasi as $mr) : ?>
                            <tr>
                                <td>
                                    <a href="#" class="badge badge-success clastombolapp" data-jenis="<?= $mr['jenis']; ?>" data-id="<?= $mr['id_transaksi']; ?>" data-toggle="modal">Approve</a>
                                </td>
                                <td><?= $mr['no_transaksi']; ?></td>
                                <td><?= tgl_indo($mr['tanggal']); ?></td>
                                <td><?= $mr['nm_supplier']; ?></td>
                                <td><?= $mr['nm_company']; ?></td>
                                <td><?= $mr['jenis']; ?></td>
                                <td align="right"><?= rp($mr['tt']); ?></td>
                                <td><?= $mr['name']; ?></td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->




<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>


<!-- ------------------------------------------------------------------Modal View------------------------------------------- -->

<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Approve Penawaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- DataTables Example -->
            <div class="card shadow mb-4" id="view-area">

            </div>

        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap-daterangepicker/moment.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts 
<script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>
-->
<script type="text/javascript">
    $(document).ready(function() {
        $('#konfirmasiTable').DataTable({
            "order": [],
            //dom: 'lfrtip',
            dom: '<"toolbar">Bfrtip',

            scrollY: '60vh',
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            "columnDefs": [{
                "targets": 0
            }],
            fixedColumns: {
                heightMatch: 'none'
            },
        });
    });
</script>

</body>


<script type="text/javascript">
    $(function() {
        $('.clastombolapp').on('click', function() {
            $id_trans = $(this).data('id');
            jenis = $(this).data('jenis');

            if (jenis == "PO") {
                $('#viewModalLabel').text('Approve PO');
                $('#view-area').load("<?= base_url('approve/app_po/modal_approve_po/'); ?>" + $id_trans);
            } else {
                $('#viewModalLabel').text('Approve SPK');
                $('#view-area').load("<?= base_url('approve/app_po/modal_approve_spk/'); ?>" + $id_trans);
            }


            $('#viewModal').modal();
        });
    });
</script>


</html>