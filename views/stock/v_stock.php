<!-- Custom styles for this page -->
<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?= base_url('assets/'); ?>vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<!-- session dibawah ini diambil dari helper -->

<input type="hidden" id="txt_company" value="<?= $this->uri->segment(4); ?>">
<!-- Begin Page Content -->
<div class="container-fluid">

    <?= form_error('nama', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= $this->session->flashdata('messagez'); ?>
    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <table>
                <tr>
                    <td>Gudang : &nbsp;</td>
                    <td><select class="custom-select" style="width:250px" name="txt_company2" id="txt_company2" onchange="pilihcompany()">
                            <option value="0">ALL</option>
                            <?php foreach ($tombol as $mc) : ?>
                                <option value="<?= $mc['id_gudang']; ?>" <?php if ($mc['id_gudang'] == $this->uri->segment(4)) {
                                                                                echo 'selected';
                                                                            } ?>><?= $mc['kd_gudang']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            </table>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="konfirmasiTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Gudang</th>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th>Satuan</th>
                            <th>PT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($konfirmasi as $mr) : ?>
                            <tr>
                                <td width="15%">
                                    <a href="#" class="badge bg-gradient-warning text-gray-100 clastombolview" data-id="<?= $mr['id_barang']; ?>" data-id_gudang="<?= $mr['id_gudang']; ?>">view</a>
                                    <!--
                                    <a href="<?= base_url('stock/stock/edit/') . $mr['id_transaksi']; ?>" class="badge badge-success clastomboledit">edit</a>
                                    <a href="#" class="badge badge-danger clastomboldel" data-status="<?= $mr['status']; ?>" data-user="<?= $mr['name']; ?>" data-lokasi="<?= $mr['nm_supplier']; ?>" data-id="<?= $mr['id_transaksi']; ?>" data-nomor="<?= $mr['no_bpb']; ?>" data-tanggal="<?= $mr['tanggal']; ?>" data-toggle="modal" data-target="#deleteMenuModal">delete</a>
                        -->
                                </td>
                                <td><?= $mr['kd_gudang']; ?></td>
                                <td><?= $mr['nm_barang']; ?></td>
                                <td><?= $mr['qty']; ?></td>
                                <td><?= $mr['nm_satuan']; ?></td>
                                <td><?= $mr['nm_company']; ?></td>
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
                <h5 class="modal-title" id="viewModalLabel">Detail Barang</h5>
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
                "width": "11%",
                "targets": 0
            }],
            fixedColumns: {
                heightMatch: 'none'
            },
        });
    });

    $('.clastombolview').on('click', function() {
        $id_trans = $(this).data('id');
        $id_gudang = $(this).data('id_gudang');
        $('#view-area').load("<?= base_url('stock/stock/modal_view/'); ?>" + $id_trans + "/" + $id_gudang);
        $('#viewModal').modal();
    });

    function pilihcompany() {
        id_company = $('#txt_company2').val();
        url = "<?= base_url('stock/stock/view/') ?>" + id_company;
        console.log(url);
        window.location.replace(url);
    };
</script>

</body>

</html>