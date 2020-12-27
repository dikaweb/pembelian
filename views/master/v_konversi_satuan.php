<!-- Begin Page Content -->
<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg">
            <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= $this->session->flashdata('messagez'); ?>


            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="konfirmasiTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>

                            <th scope="col">Nama Barang</th>
                            <th scope="col">Jenis</th>
                            <th scope="col">Kelompok</th>
                            <th scope="col">Status</th>
                            <th scope="col">Satuan Terkecil</th>
                            <th scope="col">Konversi Satuan</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($menu as $m) : ?>
                            <tr>

                                <td><?= $m['nm_barang']; ?></td>
                                <td><?= $m['jenis']; ?></td>
                                <td><?= $m['kelompok']; ?></td>
                                <td><?= $m['status']; ?></td>
                                <td><?= $m['nm_satuan']; ?></td>
                                <td>
                                    <?php
                                    $menuId = $m['id_barang'];
                                    $querySubMenu = "SELECT * from m_satuan_konversi where id_barang = $menuId order by no_urut";
                                    $subMenu = $this->db->query($querySubMenu)->result_array();
                                    foreach ($subMenu as $m) : ?>
                                        <?php
                                        $menuId = $m['from_satuan'];
                                        $querySubMenu = "SELECT * from m_satuan where id_satuan = $menuId";
                                        $subMenu = $this->db->query($querySubMenu)->row_array();
                                        echo '1 ' . $subMenu['nm_satuan'] . " = ";
                                        ?>
                                        <?= $m['nilai']; ?>
                                        <?php
                                        $menuId = $m['to_satuan'];
                                        $querySubMenu = "SELECT * from m_satuan where id_satuan = $menuId";
                                        $subMenu2 = $this->db->query($querySubMenu)->row_array();
                                        echo $subMenu2['nm_satuan'];
                                        ?>
                                        <br>

                                    <?php endforeach; ?>


                                </td>
                                <td>
                                    <a href="#" class="badge bg-gradient-warning text-gray-100 clastombolubah" data-id="<?= $m['id_barang']; ?>">Edit</a>
                                    <a href="<?= base_url('master/konversi_satuan/edit/') . $m['id_barang']; ?>" class="badge badge-success clastomboledit">Tambah Konversi</a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
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
<script type="text/javascript">
    $(function() {
        $('.clastombolubah').on('click', function() {
            $id = $(this).data('id');
            $('#view-area').load("<?= base_url('master/konversi_satuan/modal_view/'); ?>" + $id);
            $('#viewModal').modal();

        });
    });
</script>

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
            fixedColumns: {
                heightMatch: 'none'
            },
        });
    });
</script>