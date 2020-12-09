<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?= base_url('assets/'); ?>vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
<input type="hidden" name="txtid_user" id="txtid_user" value=" <?= $user['id']; ?>">

<body>

    <div class="container">
        <div class="col-md-6 col-table mt-1 mb-1">
            <a class="btn btn-info  col-sm-2 mt-1 btn-sm" href="<?= base_url('stock/trans_stock'); ?>">Kembali</a>
            <a class="btn btn-info  col-sm-2 mt-1 btn-sm" id="baru" href="<?= base_url('stock/trans_stock/add'); ?>">baru</a>
            <?php if ($konfirmasi_m['id_user'] == $user['id']) { ?>
                <a class="btn btn-info  col-sm-2 mt-1 btn-sm" href="#" onclick="cetak()">Cetak</a>
            <?php } ?>
        </div>

        <div class="row row-table mb-1">
            <div class="col-md-6 col-table mt-1 mb-1">
                <form class="user" id="validasi" method="post" action="<?= base_url('stock/trans_stock/update_m'); ?>">
                    <div class="panel panel-info col-content bg border border-info ">
                        <h5>
                            <div class="panel-heading text-white bg-gradient-info">
                                Keterangan
                            </div>
                            <div class="form-group row row-table ml-1 mb-1 mt-3 mr-1">

                                <div class="col-md col-table  input-group input-group-sm mb-1">
                                    <input type="text" value="<?= $konfirmasi_m['note']; ?>" class="form-control border border-primary" name="txtnote" id="txtnote" autocomplete="off">
                                    <input type="hidden" name="txtid_transaksi" id="txtid_transaksi" value="<?= $konfirmasi_m['id_transfer_stock']; ?>">
                                </div>
                            </div>
                            <?php if ($konfirmasi_m['id_user'] == $user['id']) { ?>
                                <button type="submit" class="btn btn-info col-sm-4 btn-sm mt-1 ml-2">Simpan Keterangan</button>
                            <?php } ?>
                    </div>
                </form>
            </div>
            <div class="col-md-1 col-table mt-1 mb-1">
                <div class="panel panel-primary col-content bg">
                    <div class="panel-heading">

                    </div>
                    <div class="panel-body">
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-table mt-1 mb-1">
                <div class="panel panel-primary col-content bg">
                    <div class="panel-heading">

                    </div>
                    <div class="panel-body">
                        <h5>
                            No Transaksi : <?= $konfirmasi_m['no_transfer_stock']; ?>

                        </h5>
                    </div>
                </div>
            </div>
        </div>


        <div class="row row-table mb-1">
            <div class="col-md-3 col-table mt-1 mb-1">
                <div class="panel panel-primary col-content bg border border-primary ">
                    <h5>
                        <div class="panel-heading text-white bg-gradient-primary">
                            Gudang Awal
                        </div>
                        <div class="panel-body my-1 mx-1">
                            <a href="#" class="badge bg-gradient-primary text-gray-100" id="btngudangfrom" onclick="pilihgudangfrom()">Pilih gudang</a>
                        </div>
                        <div class="panel-body my-1 mx-1 mb-n2">
                            <span class="text-body" id="lblkd_gudang_from"></span>
                            <input type="hidden" name="txtid_gudang_from" id="txtid_gudang_from" required="required">
                        </div>
                    </h5>
                    <h6>
                        <div class="panel-body my-1 mx-1 mb-n2">
                            <span class="text-body" id="lblpt_gudang_from"></span>
                        </div>
                    </h6>
                </div>
            </div>
            <div class="col-md-1 col-table mt-1 mb-1">
                <div class="panel panel-primary col-content bg">
                    <div class="panel-heading">

                    </div>
                    <div class="panel-body">
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-table mt-1 mb-1">
                <div class="panel panel-primary col-content bg border border-primary ">
                    <h5>
                        <div class="panel-heading text-white bg-gradient-primary">
                            Barang
                        </div>
                        <div class="panel-body my-1 mx-1">
                            <a href="#" id="pilihsup" class="badge bg-gradient-primary text-gray-100" onclick="pilihbarang()">Pilih barang</a>
                        </div>
                        <div class="panel-body my-1 mx-1 mb-n2">
                            <span class="text-body" id="lblnm_barang"></span>
                            <span class="text-body" id="lblsatuan"></span>

                            <input type="hidden" name="txtid_barang" id="txtid_barang" required="required">
                        </div>
                    </h5>
                    <table>
                        <tr>
                            <td>Jumlah</td>
                            <td>
                                <div class="field">
                                    <input type="text" class="form-control-sm border border-primary uang" name="txt_jumlah" id="txt_jumlah" autocomplete="off" required="required">
                                    <span id="lbl_jumlah" class="ml-3"></span>
                                </div>
                            </td>
                        <tr>
                            <td width="35%">Satuan</td>
                            <td width="65%">
                                <div class="field" id="satuan-area">

                                </div>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>


            <div class="col-md-1 col-table mt-1 mb-1">
                <div class="panel panel-primary col-content bg">
                    <div class="panel-heading">

                    </div>
                    <div class="panel-body">
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-table mt-1 mb-1">
                <div class="panel panel-primary col-content bg border border-primary ">
                    <h5>
                        <div class="panel-heading text-white bg-gradient-primary">
                            Gudang Tujuan
                        </div>
                        <div class="panel-body my-1 mx-1">
                            <a href="#" class="badge bg-gradient-primary text-gray-100" onclick="pilihgudangto()">Pilih gudang</a>
                        </div>
                        <div class="panel-body my-1 mx-1 mb-n2">
                            <span class="text-body" id="lblkd_gudang_to"></span>
                            <input type="hidden" name="txtid_gudang_to" id="txtid_gudang_to" required="required">
                        </div>
                    </h5>
                    <h6>
                        <div class="panel-body my-1 mx-1 mb-n2">
                            <span class="text-body" id="lblpt_gudang_to"></span>
                        </div>
                    </h6>

                    <?php if ($konfirmasi_m['id_user'] == $user['id']) { ?>
                        <a href="#" class="btn bg-gradient-primary text-gray-100 ml-1 my-1" onclick="tambahBarang()">Simpan</a>
                    <?php } ?>
                </div>
            </div>

        </div>

        <!-- -----------------------------------Data tables list barang detail---------------------------------------------- -->
        <?= $this->session->flashdata('messagez'); ?>
        <div class="" id="detail-area">

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Gudang Asal</th>
                            <th>Gudang Tujuan</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($konfirmasi_d as $mr) : ?>
                            <tr>
                                <td width="7%">
                                    <?php if ($konfirmasi_m['id_user'] == $user['id']) { ?>
                                        <a href="#" class="badge badge-danger clastomboldel" data-id_detail="<?= $mr['id_transfer_stock_d']; ?>" data-nm_barang="<?= $mr['nm_barang']; ?>" data-jumlah="<?= $mr['jumlah']; ?>" data-id_transaksi="<?= $mr['id_transfer_stock']; ?>" data-toggle="modal" data-target="#deleteMenuModal">delete</a>
                                    <?php } ?>
                                </td>
                                <td><?= $mr['nm_barang']; ?></td>
                                <td><?= $mr['jumlah']; ?></td>
                                <td><?= $mr['nm_satuan']; ?></td>
                                <td><?= $mr['kd_gudang']; ?></td>
                                <td>
                                    <?php
                                    $menuId = $mr['id_gudang_to'];
                                    $querySubMenu = "SELECT * from m_gudang where id_gudang = $menuId";
                                    $subMenu = $this->db->query($querySubMenu)->row_array();
                                    echo $subMenu['kd_gudang'];
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
</body>

<!-- ------------------------------------------------------------------Modal Pilih Barang ------------------------------------------- -->

<div class="modal fade" id="barangModal" tabindex="-1" role="dialog" aria-labelledby="barangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="barangModalLabel">Pilih Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- DataTables Example -->
            <div class="card shadow mb-4" id="barang-area">

            </div>
        </div>
    </div>
</div>
<!-- ------------------------------------------------------------------Modal Pilih Gudang ------------------------------------------- -->

<div class="modal fade" id="gudangModal" tabindex="-1" role="dialog" aria-labelledby="gudangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gudangModalLabel">Pilih Gudang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- DataTables Example -->
            <div class="card shadow mb-4" id="gudang-area">

            </div>
        </div>
    </div>
</div>


<!-- ------------------------------Modal Loading ------------------------------------------>
<div class="modal fade" id="loadMe" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="loader"></div>
                <div clas="loader-txt">
                    <p>Proses sedang berjalan. <br><br><small>Mohon tunggu</small></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!------------------------------------------------------------- Modal Delete -->
<div class="modal fade" id="deleteMenuModal" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMenuModalLabel">Hapus Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('stock/trans_stock/delete_d'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="idd" id="idd">
                    <input type="hidden" class="form-control" name="idt" id="idt">

                    <div class="form-group">
                        <input type="text" class="form-control" id="tanggal" name="tanggal" readonly>
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


<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.mask.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datepicker/locales/bootstrap-datepicker.id.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>
<!-- Page level plugins -->
<script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script src="<?= base_url('assets/'); ?>js/v_po.js"></script>
<!---------------------------------------------------- Date Picture-------------------------------------------- -->
<script type="text/javascript">
    $(function() {
        $('.tglpicker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'dd MM yyyy',
            language: 'id'
        })
        $('#tgl_awal').datepicker('setDate', "+0d");
    });
</script>

<!-------------------------------------- Pilih Rekanan & Barang-------------------------------------- -->
<script type="text/javascript">
    function pilihbarang() {
        if ($('#txtid_gudang_from').val() == "") {
            alert("Pilih Dulu Gudang Asal");
        } else {
            $id_po = $('#txtid_gudang_from').val();
            $('#barang-area').load("<?= base_url('stock/trans_stock/pilihbarang/'); ?>" + $id_po);
            $('#barangModal').modal();
        };
    }



    function tambahBarang() {
        if ($('#txtid_gudang_from').val() == "") {
            alert("Silahkan Pilih Gudang Awal");
            return true;
        }



        if ($('#txtid_satuan').val() == "") {
            alert("Silahkan Pilih Satuan");
            return true;
        }

        if ($('#txtid_barang').val() == "") {
            alert("Silahkan Pilih Barang");
            return true;
        }

        if ($('#txt_jumlah').val() == "") {
            alert("Isi jumlah terlebih dahulu");
            return true;
        }

        if ($('#txt_jumlah-error').html() == "Format angka salah") {
            alert("Edit dulu format angka yang salah pada kolom jumlah");
            return true;
        }

        if ($('#txtid_gudang_to').val() == "") {
            alert("Silahkan Pilih Gudang Tujuan");
            return true;
        }
        //$("#loadMe").modal({
        // backdrop: "static", //remove ability to close modal with click
        //keyboard: false, //remove option to close with keyboard
        //show: true //Display loader!
        //});


        $.ajax({
            url: "<?= base_url('stock/trans_stock/save_d'); ?>",
            method: 'post',
            data: {
                id_transaksi: $('#txtid_transaksi').val(),
                id_gudang_from: $('#txtid_gudang_from').val(),
                id_barang: $('#txtid_barang').val(),
                jumlah: parseFloat($('#txt_jumlah').val()),
                id_satuan: $('#txtid_satuan').val(),
                id_gudang_to: $('#txtid_gudang_to').val(),
            },

            dataType: 'json',
            success: function(data) {
                $id_transaksi = data;

                url = "<?= base_url('stock/trans_stock/edit/'); ?>" + $id_transaksi;
                window.location.replace(url);
            },
            error: function(jqxhr, status, exception) {
                alert('Exception:', exception);
            }
        });
    };


    function pilihgudangfrom() {
        $('#gudang-area').load("<?= base_url('stock/trans_stock/pilihgudang/from'); ?>");
        $('#gudangModal').modal();
    }

    function pilihgudangto() {
        $('#gudang-area').load("<?= base_url('stock/trans_stock/pilihgudang/to'); ?>");
        $('#gudangModal').modal();
    }

    $('.clastomboldel').on('click', function() {
        $('#tanggal').val($(this).data('nm_barang'));
        $('#nama').val("Jumlah : " + $(this).data('jumlah'));
        //$('#total').val(total);
        $('#idd').val($(this).data('id_detail'));
        $('#idt').val($(this).data('id_transaksi'));
    });
</script>