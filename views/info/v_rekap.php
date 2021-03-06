<!-- Custom styles for this page -->
<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?= base_url('assets/'); ?>vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<!-- session dibawah ini diambil dari helper -->
<input type="hidden" id="readon" value="<?= $this->session->flashdata('roz'); ?>">
<input type="hidden" id="reado" value="<?= $this->session->flashdata('v_allz'); ?>">
<style type="text/css">
    .contoh1 {
        line-height: 10px;
    }

    .contoh2 {

        line-height: 17px;
    }
</style>
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
                            <th>PT</th>
                            <th>Supplier</th>
                            <th>Tgl PO</th>
                            <th>No. PO</th>
                            <th>No. Penerimaan</th>
                            <th>No. Invoice</th>
                            <th>No. Voucher & BN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($konfirmasi as $mr) : ?>
                            <tr>
                                <td><?= $mr['nm_company']; ?></td>
                                <td><?= $mr['nm_supplier']; ?></td>
                                <td>
                                    <p class="contoh1">
                                        <font size="2"><?= tgl_indo2($mr['tanggal']); ?></font>
                                    </p>
                                </td>
                                <td>
                                    <p class="contoh1">
                                        <font size="2"> <a href="#" class="clastombolapp" data-jenis="<?= $mr['jenis']; ?>" data-id="<?= $mr['id_transaksi']; ?>" data-toggle="modal"><?= $mr['no_transaksi']; ?></a></font>
                                    </p>
                                </td>
                                <td>
                                    <p class="contoh1">
                                        <font size="2">
                                            <?php
                                            $menuId = $mr['id_transaksi'];
                                            $querySubMenu = "SELECT * from trans_bpb where id_po_spk = $menuId order by no_urut";
                                            $subMenu = $this->db->query($querySubMenu)->result_array();
                                            $x = 1;
                                            foreach ($subMenu as $m) : ?>
                                                <?php
                                                echo $x . '. ' . $m['no_bpb'];
                                                $x++;
                                                ?>
                                                <br>
                                            <?php endforeach; ?>
                                        </font>
                                    </p>
                                </td>
                                <td>
                                    <?php
                                    $menuId = $mr['id_transaksi'];
                                    $querySubMenu = "SELECT * from trans_voucher_d where jenis = 'PO/SPK' and id_reff = $menuId";
                                    $subMenu = $this->db->query($querySubMenu)->result_array();
                                    $x = 1;
                                    foreach ($subMenu as $m) : ?>
                                        <?php
                                        echo $x . '. ' . $m['keterangan'];
                                        $x++;
                                        ?>
                                        <br>
                                    <?php endforeach; ?>

                                    <?php
                                    $querySubMenu = "SELECT * from trans_bpb where id_po_spk = $menuId order by no_urut";
                                    $bpb = $this->db->query($querySubMenu)->result_array();
                                    foreach ($bpb as $b) : ?>
                                        <?php
                                        $id_bpb = $b['id_bpb'];
                                        $querySubMenu = "SELECT * from trans_voucher_d where jenis = 'BPB' and id_reff = $id_bpb";
                                        $ada = $this->db->query($querySubMenu)->num_rows();
                                        if ($ada > 0) {
                                            $voucher_d = $this->db->query($querySubMenu)->row_array();
                                            echo $x . '. ' . $voucher_d['keterangan'];
                                            $x++;
                                        }
                                        ?>
                                        <br>
                                    <?php endforeach; ?>
                                </td>
                                <td>
                                    <?php
                                    $menuId = $mr['id_transaksi'];
                                    $querySubMenu = "SELECT * from trans_voucher_d where jenis = 'PO/SPK' and id_reff = $menuId";
                                    $subMenu = $this->db->query($querySubMenu)->result_array();
                                    $x = 1;
                                    foreach ($subMenu as $m) : ?>
                                        <?php
                                        $id_voucher = $m['id_voucher'];
                                        $querySubMenu = "SELECT * from trans_voucher where id_voucher = $id_voucher";
                                        $ada = $this->db->query($querySubMenu)->num_rows();
                                        if ($ada > 0) {
                                            $voucher = $this->db->query($querySubMenu)->row_array();
                                            echo $x . '. ' . $voucher['no_voucher'] . ' ' . $voucher['no_nv'];
                                            $x++;
                                        }
                                        ?>
                                        <br>
                                    <?php endforeach; ?>

                                    <?php
                                    $querySubMenu = "SELECT * from trans_bpb where id_po_spk = $menuId order by no_urut";
                                    $bpb = $this->db->query($querySubMenu)->result_array();
                                    foreach ($bpb as $b) : ?>
                                        <?php
                                        $id_bpb = $b['id_bpb'];
                                        $querySubMenu = "SELECT * from trans_voucher_d where jenis = 'BPB' and id_reff = $id_bpb";
                                        $ada = $this->db->query($querySubMenu)->num_rows();
                                        if ($ada > 0) {
                                            $voucher_d = $this->db->query($querySubMenu)->row_array();
                                            $id_voucher = $voucher_d['id_voucher'];
                                            $querySubMenu = "SELECT * from trans_voucher where id_voucher = $id_voucher";
                                            $ada = $this->db->query($querySubMenu)->num_rows();
                                            if ($ada > 0) {
                                                $voucher = $this->db->query($querySubMenu)->row_array();
                                                echo $x . '. ' . $voucher['no_voucher'] . ' ' . $voucher['no_nv'];
                                                $x++;
                                            }
                                        }
                                        ?>
                                        <br>
                                    <?php endforeach; ?>
                                </td>
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
            'fnDrawCallback': function(oSettings) {
                $('.dataTables_filter').each(function() {
                    $('.tomboltambah').remove();
                    $(this).append('<a class="btn btn-primary mb-2 mt-2 mx-2 btn-sm tomboltambah" href="<?= base_url('trans/po/export/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . $this->uri->segment(6)); ?>">Export Excel</a>');
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
            id_company = $('#txt_company').val();
            url = "<?= base_url('trans/po/view/'); ?>" + id_company + '/' + $t1 + '/' + $t2;
            window.location.replace(url);
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
                $('#viewModalLabel').text('Data PO');
                $('#view-area').load("<?= base_url('info/rekap/modal_po/'); ?>" + $id_trans);
            } else {
                $('#viewModalLabel').text('Data SPK');
                $('#view-area').load("<?= base_url('info/rekap/modal_spk/'); ?>" + $id_trans);
            }


            $('#viewModal').modal();
        });
    });
</script>

</html>