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
</style>

<!-- Custom styles for this page -->
<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?= base_url('assets/'); ?>vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<!-- session dibawah ini diambil dari helper -->

<!-- Begin Page Content -->
<div class="container-fluid">

    Pilih PO/SPK yang akan di serah terima
    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <a class="btn btn-info  col-sm-2 mt-1 btn-sm" href="<?= base_url('trans/bpb'); ?>">Kembali</a>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="konfirmasiTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>Supplier</th>
                            <th>PT</th>
                            <th>Item</th>
                            <th>Tanggal</th>
                            <th>No. PO</th>
                            <th>Nama Lengkap</th>
                            <th>No. Permintaan</th>
                            <th>Lokasi</th>
                            <th>Jenis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($konfirmasi as $mr) : ?>
                            <tr>
                                <td class="details-control"></td>
                                <td>
                                    <a href="<?= base_url('trans/bpb/add2/') . $mr['id_transaksi']; ?>" class="badge badge-primary clastomboledit">Pilih</a>
                                </td>

                                <td><?= $mr['nm_supplier']; ?></td>
                                <td><?= $mr['nm_company']; ?></td>

                                <td>
                                    <?php
                                    $menuId = $mr['id_transaksi'];

                                    $querySubMenu = "SELECT * from trans_po_d a
                                    inner join  m_gudang b on a.id_gudang = b.id_gudang
                                    inner join  m_satuan c on a.id_satuan = c.id_satuan
                                    left join permintaan_barang_detail d on a.id_reff = d.id
                                    left join permintaan_barang e on d.permintaan_barang_id = e.id
                                    left join user f on e.user_id = f.id
                                    left join lokasi g on e.lokasi_id = g.id
                                    where id_transaksi = $menuId order by e.id asc";

                                    $subMenu = $this->db->query($querySubMenu)->result_array();
                                    foreach ($subMenu as $m) : ?>
                                        <?php
                                        echo rp($m['jumlah']) . " "  . $m['nm_barang'] . " "  . $m['spesifikasi']  . " " . $m['keterangan'] . " ";
                                        $nama_lengkap = $m['nama_lengkap'];
                                        $no_permintaan = $m['no_permintaan'];
                                        $lokasi = $m['lokasi'];
                                        ?>
                                        <br>

                                    <?php endforeach; ?>
                                </td>
                                <td><?= tgl_indo($mr['tanggal']); ?></td>
                                <td><?= $mr['no_transaksi']; ?></td>
                                <td><?= $no_permintaan; ?></td>
                                <td><?= $nama_lengkap; ?></td>
                                <td><?= $lokasi; ?></td>
                                <td><?= $mr['jenis']; ?></td>
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
    function format(d) {
        return '<center><table cellpadding="0"  cellspacing="0" border="0" style="padding-top:1000px;" width="75%" class="topics">' +
            '<tr>' +
            '<td width="25%">Tgl PO</td>' +
            '<td>' + d[5] + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>No PO</td>' +
            '<td>' + d[6] + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>No PR</td>' +
            '<td>' + d[7] + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>User PR</td>' +
            '<td>' + d[8] + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Lokasi</td>' +
            '<td>' + d[9] + '</td>' +
            '</tr>' +
            '</table><center>';
    }

    $(document).ready(function() {

        var table = $('#konfirmasiTable').DataTable({
            scrollY: '50vh',
            "order": [],
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            "columnDefs": [{
                "targets": [5, 6, 7, 8, 9],
                "visible": false,
            }, ],
        });



        $(document).on('shown.bs.modal', '.modal', function() {
            $($.fn.dataTable.tables(true)).DataTable().draw();
        });


        // Add event listener for opening and closing details
        $('#konfirmasiTable tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();

                tr.removeClass('shown');
            } else {
                // Open this row
                //console.log(row.data());
                row.child(format(row.data())).show();

                tr.addClass('shown');
            }
        });
    });
</script>

</body>

</html>