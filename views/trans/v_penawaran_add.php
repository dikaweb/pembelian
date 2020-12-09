<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<style type="text/css">
    .modal-lg {
        max-width: 95% !important;
    }
</style>

<body>
    <form class="form-horizontal" id="submit">
        <div class="container">
            <div class="col-md-6 col-table mt-1 mb-1">
                <a class="btn btn-info  col-sm-2 mt-1 btn-sm" href="<?= base_url('trans/penawaran'); ?>">Kembali</a>
            </div>
            <div class="row row-table mb-1">
                <div class="col-md col-table mt-1 mb-1">
                    <div class="panel panel-primary col-content bg border border-primary ">
                        <h5>
                            <div class="panel-heading text-white bg-gradient-primary">
                                <?= $data_m['no_permintaan']; ?>
                            </div>

                            <div class="panel-body my-1 mx-1">

                                <input type="hidden" name="txtIdPr" id="txtIdPr" value="<?= $data_m['id']; ?>">
                                <input type="hidden" name="no_pr" id="no_pr" value="<?= $data_m['no_permintaan']; ?>">

                            </div>
                        </h5>
                        <div class="panel-body my-1 mx-1 mb-n2">
                            <table>

                                <tr>
                                    <td>Tgl PR &nbsp;</td>
                                    <td>:</td>
                                    <td> <span class="text-body" id="lblTgl"><?= tgl_indo($data_m['tgl']); ?></span></td>
                                </tr>
                                <tr>
                                    <td>User</td>
                                    <td>:</td>
                                    <td> <span class="text-body" id="lblUser"><?= $data_m['nama_lengkap']; ?></span></td>
                                </tr>
                                <tr>
                                    <td>Keterangan</td>
                                    <td>:</td>
                                    <td> <span class="text-body" id="lblKeterangan"><?= $data_m['ket_m']; ?></span></td>
                                </tr>
                                <tr>
                                    <td>PT<br><br></td>
                                    <td>:<br><br></td>
                                    <td>
                                        <select class="custom-select" name="txt_company" id="txt_company" <?php if ($data_m['id_company'] != 0) {
                                                                                                                echo "disabled";
                                                                                                            } ?>>
                                            <?php foreach ($m_company as $mc) : ?>
                                                <option value="<?= $mc['id_company']; ?>" <?php if ($data_m['id_company'] == $mc['id_company']) {
                                                                                                echo "selected";
                                                                                            } ?>><?= $mc['nm_company']; ?></option>
                                            <?php endforeach; ?>
                                        </select><br><br>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>

                </div>

            </div>

        </div>
        <!-- -----------------------------------------Card Pilih Barang-------------------------------------------- -->

        <div class="container">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td style="width:40%" style="vertical-align:middle">
                                <h5>
                                    <a href="#" class="badge bg-gradient-primary text-gray-100" onclick="openModalsupplier()">Pilih supplier</a>

                                </h5>
                                <h6>
                                    <div class="panel-body ">

                                        <input type="hidden" name="txtid_rekanan1" id="txtid_rekanan1">
                                    </div>
                                    <div class="panel-body ">
                                        <span id="lblnm_rekanan1"></span>
                                    </div>
                                    <div class="panel-body ">
                                        <span id="lblkd_rekanan1"></span>
                                    </div>
                                    <div class="panel-body ">
                                        <span id="txtup"></span>
                                    </div>
                                </h6>
                            </td>
                            <td style="width:60%">
                                <div class="form-group row row-table ml-1 mt-2 ">
                                    <div class="col-sm-3 mb-1 mb-sm-0 mt-2 ">
                                        <label for="basic-url">Surat Penawaran</label>
                                    </div>
                                    <div class="col-sm-9  input-group input-group-sm">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input border border-primary" name="is_sp" id="is_sp" accept=".jpg,.jpeg">
                                            <label class="custom-file-label border border-primary" for="is_sp">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row row-table ml-1 mt-2 ">
                                    <div class="col-sm-3 mb-1 mb-sm-0 mt-2 ">
                                        <label for="basic-url">TOP</label>
                                    </div>
                                    <div class="col-sm-6 input-group input-group-sm">
                                        <div class="custom-file">
                                            <input type="text" class="form-control sm" id="top" name="top" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- -----------------------------------------Card Pilih Barang-------------------------------------------- -->

        <div class="mb-1">
            <div class="mx-4 table-responsive">
                <?php $arr = 0;
                foreach ($data_d as $m2) : ?>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="<?= $m2['id']; ?>" name="id_pr_d[]" id="id_pr_d[<?= $arr; ?>]" <?php if ($m2['is_po'] == 1) {
                                                                                                                                                        echo "disabled";
                                                                                                                                                    } ?>>
                            <label class="form-check-label" for="id_pr_d[<?= $arr; ?>]">
                                <?= $m2['qty'] . ' ' . $m2['satuan'] . ' ' . $m2['item'] . ', ' . $m2['spesifikasi'] . ', ' . $m2['keterangan'] . ' ' . ' ' . $m2['catatan_purchasing'] . ' ' . "<br>"; ?>
                            </label>
                            <?php
                            $x = 0;
                            $menuId = $m2['id'];
                            $querySubMenu = "SELECT * from permintaan_barang_penawaran a
                            inner join gbr_penawaran b on a.id_penawaran = b.id_penawaran
                            inner join m_supplier c on b.id_supplier = c.id_supplier
                            where id_pr_d = $menuId";
                            $subMenu = $this->db->query($querySubMenu)->result_array();
                            $x = 1;
                            foreach ($subMenu as $m) :
                            ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="#" class="badge badge-warning clastombolapp" data-id="<?= $m['id_penawaran']; ?>"> <?php echo $x . ". " . $m['nm_supplier']; ?></a>


                            <?php $x++;
                            endforeach; ?>
                            <a href="<?= base_url('trans/penawaran/edit_d/') . $m2['id']; ?>" class="badge badge-success clastomboledit">edit</a>
                        </div>
                    </div>
                <?php $arr++;
                endforeach; ?>
                <button class="btn btn-primary" id="btn_upload" type="submit">Simpan</button>
            </div>
        </div>

    </form>

</body>



<!-- ------------------------------------------------------------------Modal Pilih Tujuan/supplier------------------------------------------- -->
<div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="supplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="supplierModalLabel">Pilih supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- DataTables Example -->
            <div class="card shadow mb-4" id="supplier-area">
            </div>
        </div>
    </div>
</div>
<!-- ------------------------------------------------------------------Modal Pilih Barang ------------------------------------------- -->

<div class="modal fade" id="barangModal" tabindex="-1" role="dialog" aria-labelledby="barangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="barangModalLabel">Pilih PR</h5>
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
<!-- ------------------------------Modal supplier add/edit------------------------------------------>
<div class="modal fade" id="addsupplierModal" tabindex="-1" role="dialog" aria-labelledby="supplierLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="supplierModalTittle">Tambah supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-3">
                        Nama
                    </div>
                    <div class="col-sm">
                        <input type="text" class="form-control sm" id="nm_supplier" name="nm_supplier" autocomplete="off">
                        <input type="text " id="id_supplier" name="id_supplier" autocomplete="off">
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-3">
                        Alamat
                    </div>
                    <div class="col-sm">
                        <input type="text" class="form-control sm" id="alamat_sp" name="alamat_sp" autocomplete="off">
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-3">
                        UP
                    </div>
                    <div class="col-sm">
                        <input type="text" class="form-control sm" id="up_sp" name="up_sp" autocomplete="off">
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-3">
                        No Rek
                    </div>
                    <div class="col-sm">
                        <input type="text" class="form-control sm" id="no_rek" name="no_rek" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="" id="btnsimpansupplier" onclick="">SIMPAN</a>
            </div>
        </div>
    </div>
</div>

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
<!-- ------------------------------------footer-------------------------------------------------------------------------------------------- -->

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
    function openModalsupplier() {
        $('#supplier-area').load("<?= base_url('trans/penawaran/pilihsupplier'); ?>");
        $('#supplierModal').modal();
    }

    function openModalBarang() {
        // if ($('#txtid_rekanan1').val() == "") {
        //    alert("Pilih Dulu supplier");
        // } else {
        $('#barang-area').load("<?= base_url('trans/penawaran/pilihpr/tambahpnw'); ?>");
        $('#barangModal').modal();
        // };
    }

    function simpansupplier() {
        $.ajax({
            url: "<?= base_url('trans/penawaran/save_supplier'); ?>",
            data: {
                nm_supplier: $('#nm_supplier').val(),
                alamat_sp: $('#alamat_sp').val(),
                up_sp: $('#up_sp').val(),
                no_rek: $('#no_rek').val(),
            },
            method: "post",
            dataType: 'json',
        });
        $('#addsupplierModal').modal("hide");
    };

    function updatesupplier() {
        $.ajax({
            url: "<?= base_url('trans/penawaran/update_supplier'); ?>",
            data: {
                id_supplier: $('#id_supplier').val(),
                nm_supplier: $('#nm_supplier').val(),
                alamat_sp: $('#alamat_sp').val(),
                up_sp: $('#up_sp').val(),
                no_rek: $('#no_rek').val(),
            },
            method: "post",
            dataType: 'json',
            success: function(data) {
                if (data != 0) {
                    alert("supplier sudah pernah digunakan, tidak bisa di rubah");
                };
            }
        });
        $('#addsupplierModal').modal("hide");
    };

    function deletesupplier() {
        $.ajax({
            url: "<?= base_url('trans/penawaran/delete_supplier'); ?>",
            data: {
                id_supplier: $('#id_supplier').val()
            },
            method: "post",
            dataType: 'json',
            success: function(data) {
                if (data != 0) {
                    alert("supplier sudah pernah digunakan, tidak bisa di hapus");
                };
            }
        });
        $('#addsupplierModal').modal("hide");
    };

    var container = $('div.containererreurtotal');
    $("#submit").validate({
        rules: {
            txtIdPr: {
                required: true
            },
            txt_company: {
                required: true
            },
            txtid_rekanan1: {
                required: true
            },
            is_sp: {
                required: true
            }
        },
        errorPlacement: function(error, element) {
            return false;
        }, //<---missing comma here
        highlight: function(element, errorClass, validClass) {
            return false;
        },
    });

    $('#submit').submit(function(e) {
        if ($(":checkbox[name='id_pr_d[]']").is(":checked")) {
            //if ($("#id_pr_d input:checkbox:checked").length > 0) {
            //($(":checkbox[name='choices']", form).is(":checked")) {
            //alert("Belum ada item yang di pilih1");
            //return true;
        } else {
            alert("Belum ada item yang di pilih, silahkan pilih item dahulu");
            return true;
        }


        if ($('#txtIdPr').val() == "") {
            alert("Silahkan Pilih PR");
            return true;
        }
        if ($('#txt_company').val() == "") {
            alert("Silahkan Pilih PT");
            return true;
        }

        if ($('#txtid_rekanan1').val() == "") {
            alert("Silahkan Pilih Supplier");
            return true;
        }


        if ($('#is_sp').val() == "") {
            alert("Pilih gambar terlebih dahulu");
            return true;
        }



        $("#loadMe").modal({
            backdrop: "static", //remove ability to close modal with click
            keyboard: false, //remove option to close with keyboard
            show: true //Display loader!
        });


        ////////////////////////////////////////////////////////////////////////////////////

        //////////////////////////////////////////////////////////////////////////////////////

        var formData = new FormData(this);

        $(":submit").hide();
        setTimeout(function() {
            $.ajax({
                url: "<?= base_url('trans/penawaran/save_m'); ?>",
                type: "post",
                //data: new FormData(this),
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                success: function(data) {
                    url = "<?= base_url('trans/penawaran/'); ?>";
                    //console.log(data);
                    window.location.replace(url);
                }
            });
        }, 0);

    });

    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    $(document).on('click', '.clastombolapp', function() {
        $id_trans = $(this).data('id');
        //console.log($id_trans);
        //console.log("$id_trans");
        $('#view-area').load("<?= base_url('/trans/penawaran/gbr_penawaran_d/'); ?>" + $id_trans);
        $('#viewModal').modal();
    });
</script>