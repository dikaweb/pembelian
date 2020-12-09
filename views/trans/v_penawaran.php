<style type="text/css">
    .kecil {
        line-height: 16px;
    }

    td.details-control {
        background: url('<?= base_url('assets/img/open.png'); ?>') no-repeat center center;
        cursor: pointer;
    }

    tr.shown td.details-control {
        background: url('<?= base_url('assets/img/minus.png'); ?>') no-repeat center center;
    }

    .topics tr {
        line-height: 14px;
    }
</style>
<!-- Custom styles for this page -->
<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?= base_url('assets/'); ?>vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<!-- session dibawah ini diambil dari helper -->
<input type="hidden" id="no_pr" value="<?= $this->session->flashdata('no_pr'); ?>">

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
                <table class="table table-striped table-bordered display" id="examples" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>No. PR</th>
                            <th>Lokasi</th>
                            <th class="kecil">No Pol/Lok Pemakaian</th>
                            <th>Keterangan</th>
                            <th>PT</th>
                            <th>User</th>
                            <th>Tanggal</th>
                            <th>id</th>
                            <th>Penawaran</th>
                            <th>PO/SPK</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($konfirmasi as $mr) : ?>
                            <tr class="kecil">
                                <td class="details-control"></td>
                                <td>
                                    <a href="<?= base_url('trans/penawaran/edit/') . $mr['id']; ?>" class="badge badge-primary clastomboledit">edit</a>
                                    <!--
                                    <a href="#" class="badge badge-danger clastomboldel" data-status="<?= $mr['status']; ?>" data-user="<?= $mr['nama_lengkap']; ?>" data-lokasi="<?= $mr['item']; ?>" data-id="<?= $mr['id_penawaran']; ?>" data-nomor="<?= $mr['no_permintaan']; ?>" data-tanggal="<?= tgl_indo($mr['tanggal']); ?>" data-toggle="modal" data-target="#deleteMenuModal">delete</a>
                        -->
                                </td>
                                <td><?= $mr['no_permintaan']; ?></td>
                                <td><?= $mr['lokasi']; ?></td>
                                <td><?= $mr['no_pol']; ?> <?= $mr['nm_nopol']; ?></td>
                                <td><?= $mr['keterangan']; ?></td>
                                <td><?= $mr['nm_company']; ?></td>
                                <td><?= $mr['nama_lengkap']; ?></td>
                                <td><?= tgl_indo($mr['tgl_pr']); ?></td>
                                <td><?= $mr['id']; ?></td>
                                <td><?php if ($mr['jml_penawaran'] == 0) {
                                        $path = base_url('assets/img/empty.jpg');
                                        $tampil = 'Belum Ada';
                                    } else if ($mr['jml_penawaran'] == $mr['jml_detil']) {
                                        $path = base_url('assets/img/complete.jpg');
                                        $tampil = 'Lengkap';
                                    } else if ($mr['jml_penawaran'] > 0) {
                                        $path = base_url('assets/img/incomplete.jpg');
                                        $tampil = 'Sebagian';
                                    }
                                    ?>
                                    <img src="<?= $path; ?>" type="image/jpeg" width="70">
                                    <label style="font-size:10px;color: black; padding: 1px"><?= $tampil; ?></label>
                                </td>
                                <td><?php if ($mr['jml_po'] == 0) {
                                        $path = base_url('assets/img/empty.jpg');
                                        $tampil = 'Belum Ada';
                                    } else if (($mr['jml_po'] <> 0) and ($mr['jml_penawaran'] < $mr['jml_po'])) {
                                        $path = base_url('assets/img/incomplete.jpg');
                                        $tampil = 'Sebagian';
                                    } else if ($mr['jml_penawaran'] == $mr['jml_po']) {
                                        $path = base_url('assets/img/complete.jpg');
                                        $tampil = 'Lengkap';
                                    }
                                    ?>
                                    <img src="<?= $path; ?>" type="image/jpeg" width="70">
                                    <label style="font-size:10px;color: black; padding: 1px"><?= $tampil; ?></label>
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
                <h5 class="modal-title" id="viewModalLabel">Data Penawaran</h5>
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
<!-- ------------------------------------------------------------------Modal Legend------------------------------------------- -->

<div class="modal fade" id="legendModal" tabindex="-1" role="dialog" aria-labelledby="legendModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="legendModalLabel">Info Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="text-align:center;">
                    <img src="<?= base_url('assets/img/penawaran_legend.jpg'); ?>" type="image/jpeg" height="100%">
                </div>
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

</body>

<script type="text/javascript">
    function format(d) {
        //console.log(d);
        var trs = ''; //just a variable to construct
        var spasi = ' '; //just a variable to construct
        var koma = ', '; //just a variable to construct
        var i;
        for (i = 0; i < d.length; ++i) {
            $.each($(d[i]), function(key, value) {
                trs += '<tr><td><a href="http://' + window.location.host +
                    '/trans/penawaran/edit_d/' + d[i].id +
                    '" class="badge badge-success clastomboledit">edit</a></td><td>' +
                    d[i].qty + spasi + d[i].satuan + spasi + d[i].item + koma +
                    d[i].spesifikasi + koma + d[i].keterangan +
                    '</td><td>' + d[i].jml_penawaran +
                    '</td><td><a href="#" id="aa" data-id="' + d[i].id +
                    '" class="badge badge-warning clastombolapp" data-toggle="modal" >lihat</a></td>' +
                    '<td>' + d[i].is_pospk + '</td>' +
                    '</tr>';
                //loop through each product and append it to trs and am hoping that number of price 
                //values in array will be equal to number of products
            })
        }
        // `d` is the original data object for the row
        return '<center><b><u>' + d[0].no_permintaan + '</u></b><table width="90%" class="kecil">' +
            '<th>Aksi</th>' +
            '<th>Item</th>' +
            '<th>Jml Penawaran</th>' +
            '<th>Data Penawaran</th>' +
            '<th>PO/SPK</th>' +

            trs +
            '</table><center>';
    }





    $(document).ready(function() {
        var table = $('#examples').DataTable({
            "order": [],
            dom: '<"toolbar">Bfrtip',
            scrollY: '60vh',
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            "columnDefs": [{
                "targets": [2, 9],
                "visible": false,
            }],
            'fnDrawCallback': function(oSettings) {
                $('.dataTables_filter').each(function() {
                    $('.tomboltambah').remove();

                });
            },
            fixedColumns: {
                heightMatch: 'none'
            },

        });
        //$("div.toolbar").html('');
        $('input[name="dates"]').daterangepicker();
        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
            $t1 = picker.startDate.format('YYYY-MM-DD');
            $t2 = picker.endDate.format('YYYY-MM-DD');
            id_company = $('#txt_company').val();
            url = "<?= base_url('trans/penawaran/view/'); ?>" + id_company + '/' + $t1 + '/' + $t2;
            window.location.replace(url);
        });

        // Add event listener for opening and closing details
        $('#examples tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();

                tr.removeClass('shown');
            } else {
                // Open this row
                $.ajax({
                    url: "<?= base_url('trans/penawaran/list_detil'); ?>",
                    data: {
                        id: row.data()[9],
                    },
                    method: "post",
                    dataType: 'json',
                    success: function(data) {
                        row.child(format(data)).show();
                        tr.addClass('shown');
                    }
                });
            }
        });

        $('input[type=search]').val($('#no_pr').val());
        table.search($('#no_pr').val()).draw();

        //$('.clastombolapp').on('click', function() {
        $(document).on('click', '.clastombolapp', function() {
            $id_trans = $(this).data('id');
            $('#view-area').load("<?= base_url('/trans/penawaran/gbr_penawaran/'); ?>" + $id_trans);
            $('#viewModal').modal();
        });
    });

    function pilihcompany() {
        id_company = $('#txt_company2').val();
        url = "<?= base_url('trans/penawaran/view/') ?>" + id_company + '/' + "<?= $this->uri->segment(5) ?>" + '/' + "<?= $this->uri->segment(6); ?>";
        console.log(url);
        window.location.replace(url);
    };
</script>


</html>