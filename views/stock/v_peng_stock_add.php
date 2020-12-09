<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?= base_url('assets/'); ?>vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
<input type="hidden" name="txtid_user" id="txtid_user" value=" <?= $user['id']; ?>">

<body>
    <form class="user" id="validasi" method="post" action="">
        <div class="container">
            <div class="col-md-6 col-table mt-1 mb-1">
                <a class="btn btn-info  col-sm-2 mt-1 btn-sm" href="<?= base_url('stock/peng_stock'); ?>">Kembali</a>
            </div>
            <div class="row row-table mb-1">
                <div class="col-md-4 col-table mt-1 mb-1">
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
                <div class="col-md-2 col-table mt-1 mb-1">
                    <div class="panel panel-primary col-content bg">
                        <div class="panel-heading">

                        </div>
                        <div class="panel-body">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-table mt-1 mb-1">
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
            </div>


            <div class="row row-table mb-1">

                <div class="col-md-10 col-table mt-1 mb-1">
                    <div class="panel panel-primary col-content bg border border-primary ">
                        <h5>
                            <div class="panel-heading text-white bg-gradient-primary">
                                Note
                            </div>

                        </h5>

                        <div class="form-group row row-table ml-1 mb-1 mt-3">
                            <div class="col-sm-1 ml-n1">
                                <label for="basic-url">Note </label>
                            </div>

                            <div class="col-md col-table  input-group input-group-sm mb-1">
                                <input type="text" class="form-control border border-primary" name="txtnote" id="txtnote" autocomplete="off">
                            </div>
                        </div>
                        <a href="#" class="btn bg-gradient-primary text-gray-100 ml-1 my-1" onclick="tambahBarang()">Simpan</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- -----------------------------------Data tables list barang detail---------------------------------------------- -->

    <div class="" id="detail-area">
        <div class=" mx-4">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>

                        </tr>
                    </thead>
                </table>
            </div>
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


        //$("#loadMe").modal({
        // backdrop: "static", //remove ability to close modal with click
        //keyboard: false, //remove option to close with keyboard
        //show: true //Display loader!
        //});


        $.ajax({
            url: "<?= base_url('stock/peng_stock/save_m'); ?>",
            method: 'post',
            data: {
                //tanggal: tgl,
                id_user: $('#txtid_user').val(),

                id_gudang_from: $('#txtid_gudang_from').val(),
                id_barang: $('#txtid_barang').val(),
                jumlah: parseFloat($('#txt_jumlah').val()),
                id_satuan: $('#txtid_satuan').val(),
                note: $('#txtnote').val(),
            },

            dataType: 'json',
            success: function(data) {
                $id_transaksi = data;
                //console.log($id_transaksi);
                url = "<?= base_url('stock/peng_stock/edit/'); ?>" + $id_transaksi;
                window.location.replace(url);
            },
            error: function(jqxhr, status, exception) {
                alert('Exception:', exception);
            }
        });
    };


    function pilihgudangfrom() {
        $('#gudang-area').load("<?= base_url('stock/trans_stock/pilihgudang/peng_from'); ?>");
        $('#gudangModal').modal();
    }
</script>