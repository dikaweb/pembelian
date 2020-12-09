<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg">
            <form action="<?= base_url('master/konversi_satuan/save'); ?>" method="post">
                <input type="hidden" id="txtid_barang" name="txtid_barang" value="<?= $data_m['id_barang']; ?>">
                <h1><?= $data_m['nm_barang']; ?> </h1>
                <h5>Satuan Terkecil : <?= $data_m['nm_satuan']; ?> </h5>
                <table>
                    <tr>
                        <td align="center">Dari satuan</td>
                        <td></td>
                        <td align="center">Nilai satuan</td>
                        <td align="center">Ke satuan</td>
                        <td align="center">No. Urut</td>
                    </tr>
                    <tr>
                        <td align="center">
                            1 <select class="form-control-sm " name="cbofrom" id="cbofrom">
                                <?php foreach ($m_satuan as $mc) : ?>
                                    <option value="<?= $mc['id_satuan']; ?>"><?= $mc['nm_satuan']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <h1>=</h1>
                        </td>
                        <td align="center">
                            <input type="text" size="2" id="txtnilai" name="txtnilai" autocomplete="off" required="required">
                        </td>
                        <td align="center">
                            <select class="form-control-sm " name="cboto" id="cboto">
                                <?php foreach ($m_satuan as $mc) : ?>
                                    <option value="<?= $mc['id_satuan']; ?>"><?= $mc['nm_satuan']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td align="center">
                            <input type="text" size="2" id="txtno_urut" name="txtno_urut" autocomplete="off" required="required">
                        </td>
                    </tr>
                </table>
                <button type="submit" class="btn btn-primary">Tambahkan</button>
            </form>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No Urut</th>
                        <th>Konversi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($data_d as $m) : ?>
                        <tr>
                            <td scope="row"><?= $m['no_urut']; ?></td>
                            <td>
                                <?php
                                $menuId = $m['from_satuan'];
                                $querySubMenu = "SELECT * from m_satuan where id_satuan = $menuId";
                                $subMenu = $this->db->query($querySubMenu)->row_array();
                                $konversi =  '1 ' . $subMenu['nm_satuan'] . " = ";
                                ?>
                                <?php $konversi = $konversi . $m['nilai']; ?>
                                <?php
                                $menuId = $m['to_satuan'];
                                $querySubMenu = "SELECT * from m_satuan where id_satuan = $menuId";
                                $subMenu2 = $this->db->query($querySubMenu)->row_array();
                                $konversi = $konversi . ' ' . $subMenu2['nm_satuan'];
                                echo $konversi;
                                ?>
                            </td>
                            <td>
                                <a href="#" class="badge badge-danger clastomboldel" data-id_sat_from="<?= $m['from_satuan']; ?>" data-id_sat_to="<?= $m['to_satuan']; ?>" data-id_barang="<?= $m['id_barang']; ?>" data-no_urut="<?= $m['no_urut']; ?>" data-konversi="<?= $konversi; ?>" data-id="<?= $m['id']; ?>" data-toggle="modal" data-target="#deleteMenuModal">delete</a>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>


        </div>
    </div>



</div>


<!---------------------------------------------- Modal Delete -------------------------------->
<div class="modal fade" id="deleteMenuModal" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMenuModalLabel">Delete Konversi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/konversi_satuan/delete'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="idd" id="idd">
                    <input type="hidden" class="form-control" name="id_barang" id="id_barang">
                    <input type="hidden" class="form-control" name="id_sat_to" id="id_sat_to">
                    <input type="hidden" class="form-control" name="id_sat_from" id="id_sat_from">
                    <div class="form-group">
                        <label id="namad" name="namad"></label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('.clastomboldel').on('click', function() {
            const id = $(this).data('id');
            $('#idd').val($(this).data('id'));
            $('#id_barang').val($(this).data('id_barang'));
            $('#id_sat_to').val($(this).data('id_sat_to'));
            $('#id_sat_from').val($(this).data('id_sat_from'));
            $('#namad').text('No Urut : ' + $(this).data('no_urut') + ', Konversi :  ' + $(this).data('konversi'));
        });
    });
</script>