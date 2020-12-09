<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg">
            <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= $this->session->flashdata('messagez'); ?>


            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Satuan Terkecil</th>
                        <th scope="col">Konversi Satuan</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($menu as $m) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $m['nm_barang']; ?></td>
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
                                <a href="<?= base_url('master/konversi_satuan/edit/') . $m['id_barang']; ?>" class="badge badge-success clastomboledit">edit</a>
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
                <h5 class="modal-title" id="editMenuModalLabel">Edit dept</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/dept/edit'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="id" id="id">
                    <div class="row">
                        <div class="col-sm-2">
                            Nama
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="nama" name="nama" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Konversi
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="ket" name="ket" autocomplete="off">
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



<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('.clastombolubah').on('click', function() {
            const id = $(this).data('id');
            $('#id').val($(this).data('id'));
            $('#nama').val($(this).data('nama'));
            $('#ket').val($(this).data('ket'));
            $('#kode').val($(this).data('kode'));

        });
    });
</script>