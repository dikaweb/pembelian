<!-- Custom styles for this page -->
<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?= base_url('assets/'); ?>vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<!-- session dibawah ini diambil dari helper -->
<input type="hidden" id="readon" value="<?= $this->session->flashdata('roz'); ?>">
<input type="hidden" id="reado" value="<?= $this->session->flashdata('v_allz'); ?>">
<?php
$tgl1 = strtotime($this->uri->segment(5));
$tgl1 = date("m/d/Y", $tgl1);
$tgl2 = strtotime($this->uri->segment(6));
$tgl2 = date("m/d/Y", $tgl2);
$tglrange = $tgl1  . " - " . $tgl2
?>

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
                    <td>PT : &nbsp;</td>
                    <td><select class="custom-select" style="width:250px" name="txt_company2" id="txt_company2" onchange="pilihcompany()">
                            <option value="0">ALL</option>
                            <?php foreach ($tombol as $mc) : ?>
                                <option value="<?= $mc['id_company']; ?>" <?php if ($mc['id_company'] == $this->uri->segment(4)) {
                                                                                echo 'selected';
                                                                            } ?>><?= $mc['nm_company']; ?></option>
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
                            <th>No. Pengiriman</th>
                            <th>Tanggal</th>
                            <th>Penerima</th>
                            <th>Status</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($konfirmasi as $mr) : ?>
                            <tr>
                                <td width="15%">
                                    <a href="<?= base_url('trans/sj/edit/') . $mr['id_transaksi']; ?>" class="badge badge-success clastomboledit">edit</a>
                                    <a href="#" class="badge bg-gradient-warning text-gray-100 clastombolview" data-id="<?= $mr['id_transaksi']; ?>">view</a>
                                    <?php if ($mr['id_user'] == $user['id']) { ?>
                                        <a href="#" class="badge badge-danger clastomboldel" data-status="<?= $mr['status']; ?>" data-user="<?= $mr['name']; ?>" data-lokasi="<?= $mr['nm_penerima']; ?>" data-id="<?= $mr['id_transaksi']; ?>" data-nomor="<?= $mr['no_transaksi']; ?>" data-tanggal="<?= $mr['tanggal']; ?>" data-toggle="modal" data-target="#deleteMenuModal">delete</a>
                                    <?php } ?>
                                </td>
                                <td><?= $mr['no_transaksi']; ?></td>
                                <td><?= tgl_indo($mr['tanggal']); ?></td>
                                <td><?= $mr['nm_penerima']; ?></td>
                                <td><?= $mr['nm_status']; ?></td>
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

<!-- Modal Delete -->
<div class="modal fade" id="deleteMenuModal" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMenuModalLabel">Hapus Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('trans/sj/delete_m'); ?>" method="post">

                <div class="modal-body">
                    <input type="hidden" class="form-control" name="idd" id="idd">
                    <div class="form-group">
                        <input class="form-control" id="nomor" name="nomor" readonly>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="tanggal" name="tanggal" readonly>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" readonly>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="total" name="total" readonly>
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
            'fnDrawCallback': function(oSettings) {
                $('.dataTables_filter').each(function() {
                    $('.tomboltambah').remove();
                    $(this).append('<a class="btn btn-primary mb-2 mt-2 mx-2 btn-sm tomboltambah" href="<?= base_url('trans/sj/export/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . $this->uri->segment(6)); ?>">Export Excel</a>');
                    $(this).append('<a class="btn btn-primary mb-2 mt-2 mx-2 btn-sm tomboltambah" id="tomboltambah" href="<?= base_url('trans/sj/add/'); ?>">Tambah Transaksi</a>');
                });
            },
            fixedColumns: {
                heightMatch: 'none'
            },
        });

        $('input[name="dates"]').daterangepicker();
        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
            $t1 = picker.startDate.format('YYYY-MM-DD');
            $t2 = picker.endDate.format('YYYY-MM-DD');
            id_company = $('#txt_company2').val();
            url = "<?= base_url('trans/sj/view/'); ?>" + id_company + '/' + $t1 + '/' + $t2;
            window.location.replace(url);
        });

        const readon = $('#readon').val();
        if (readon == 1) {
            $('.clastomboldel').hide();
            $('.clastomboledit').hide();
            $('#tomboltambah').hide();
        };

    });
</script>

</body>


<script type="text/javascript">
    $(function() {
        $('.clastomboldel').on('click', function() {
            const id = $(this).data('id');
            const nomor = $(this).data('nomor');
            const nama = $(this).data('user');
            const tanggal = $(this).data('tanggal');
            const total = $(this).data('lokasi');
            const status = $(this).data('status');
            $('#nomor').val(nomor);
            $('#tanggal').val(tanggal);
            $('#nama').val(nama);
            $('#total').val(total);
            $('#idd').val(id);
            if (status == 1 || status == 0) {
                $(":submit").show();
                $('#lblinfo').text("");
            } else {
                $(":submit").hide();
                $('#lblinfo').text("Konfirmasi selain status CREATE tidak bisa di hapus");
            }
        });

        $('.clastombolview').on('click', function() {
            $id_trans = $(this).data('id');
            $('#view-area').load("<?= base_url('trans/sj/modal_view/'); ?>" + $id_trans);
            $('#viewModal').modal();
        });
    });

    function pilihcompany() {
        id_company = $('#txt_company2').val();
        url = "<?= base_url('trans/sj/view/') ?>" + id_company + '/' + "<?= $this->uri->segment(5) ?>" + '/' + "<?= $this->uri->segment(6); ?>";
        console.log(url);
        window.location.replace(url);
    };
</script>


</html>