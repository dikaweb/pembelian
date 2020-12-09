<!-- Custom styles for this page -->
<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?= base_url('assets/'); ?>vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<!-- session dibawah ini diambil dari helper -->
<?php
$tgl1 = strtotime($this->uri->segment(5));
$tgl1 = date("m/d/Y", $tgl1);
$tgl2 = strtotime($this->uri->segment(6));
$tgl2 = date("m/d/Y", $tgl2);
$tglrange = $tgl1  . " - " . $tgl2
?>
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
                    <td>Tanggal : </td>
                    <td> <input type="text" style="width: 205px" name="dates" id="daterange" class="form-control" value="<?= $tglrange ?>"> </td>
                    <td>&nbsp; &nbsp;&nbsp;</td>

                </tr>
            </table>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="konfirmasiTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>
                                <center>#</center>
                            </th>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Detail</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($konfirmasi as $mr) : ?>
                            <tr>
                                <td width="15%">
                                    <a href="<?= base_url('stock/input_stock/edit/') . $mr['id_input_stock']; ?>" class="badge badge-success clastomboledit">edit</a>
                                    <?php if ($mr['id_user'] == $user['id']) { ?>
                                        <a href="#" class="badge badge-danger clastomboldel" data-status="<?= $mr['status']; ?>" data-user="<?= $mr['nama_lengkap']; ?>" data-id="<?= $mr['id_input_stock']; ?>" data-nomor="<?= $mr['no_input_stock']; ?>" data-tanggal="<?= tgl_indo($mr['tanggal']); ?>" data-toggle="modal" data-target="#deleteMenuModal">delete</a>
                                    <?php } ?>
                                    <!--
                                    <a href="#" class="badge bg-gradient-warning text-gray-100 clastombolview" data-id="<?= $mr['id_transaksi']; ?>">view</a>
                        -->
                                </td>
                                <td><?= $mr['no_input_stock']; ?></td>
                                <td><?= tgl_indo($mr['tanggal']); ?></td>
                                <td>
                                    <?php
                                    $menuId = $mr['id_input_stock'];
                                    $querySubMenu = "SELECT * from trans_input_stock_d a 
                                    inner join m_barang b on a.id_barang = b.id_barang 
                                    inner join m_satuan c on a.id_satuan = c.id_satuan
                                    inner join m_gudang d on a.id_gudang_from = d.id_gudang
                                    where a.id_input_stock = $menuId";
                                    $subMenu = $this->db->query($querySubMenu)->result_array();
                                    $x = 1;
                                    foreach ($subMenu as $m2) :
                                        echo $x . ") " . $m2['jumlah'] . " "  . $m2['nm_satuan'] . " "  . $m2['nm_barang'] . " "  . $m2['kd_gudang'] . "<br>";
                                        $x++;
                                    endforeach;
                                    ?>
                                </td>
                                <td><?= $mr['nama_lengkap']; ?></td>

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

<!-- Modal Delete -->
<div class="modal fade" id="deleteMenuModal" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMenuModalLabel">Hapus Transfer Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('stock/input_stock/delete_m'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="idd" id="idd">
                    <div class="form-group">
                        <input type="text" class="form-control" id="tanggal" name="tanggal" readonly>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="no_transaksi" name="no_transaksi" readonly>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <span id="lblinfo"></span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
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
            'fnDrawCallback': function(oSettings) {
                $('.dataTables_filter').each(function() {
                    $('.tomboltambah').remove();
                    $(this).append('<a class="btn btn-primary mb-2 mt-2 mx-2 btn-sm tomboltambah" id="tomboltambah" href="<?= base_url('stock/input_stock/add'); ?>">Tambah Transaksi</a>');
                });
            },
            fixedColumns: {
                heightMatch: 'none'
            },
        });
    });

    $(function() {
        $('.clastomboldel').on('click', function() {
            const id = $(this).data('id');
            const nama = $(this).data('user');
            const tanggal = $(this).data('tanggal');
            const no_transaksi = $(this).data('nomor');
            const status = $(this).data('status');

            $('#tanggal').val(tanggal);
            $('#nama').val(nama);
            $('#no_transaksi').val(no_transaksi);
            $('#idd').val(id);
            if (status == 1 || status == 0) {
                $(":submit").show();
                $('#lblinfo').text("");
            } else {
                $(":submit").hide();
                $('#lblinfo').text("Konfirmasi selain status CREATE tidak bisa di hapus");
            }
        });
    });

    $('input[name="dates"]').daterangepicker();
    $('#daterange').on('apply.daterangepicker', function(ev, picker) {
        $t1 = picker.startDate.format('YYYY-MM-DD');
        $t2 = picker.endDate.format('YYYY-MM-DD');
        id_company = $('#txt_company').val();
        url = "<?= base_url('stock/input_stock/view/'); ?>" + id_company + '/' + $t1 + '/' + $t2;
        window.location.replace(url);
    });
</script>

</body>

</html>