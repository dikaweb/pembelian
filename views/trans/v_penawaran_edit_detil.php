<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<style type="text/css">
    .modal-lg {
        max-width: 95% !important;
    }
</style>

<body>
    <?php echo form_open_multipart('', 'id="submits"'); ?>

    <div class="container">
        <div class="row row-table mb-1">
            <div class="col-md-6 col-table mt-1 mb-1">
                <a class="btn btn-info  col-sm-2 mt-1 btn-sm" href="<?= base_url('trans/penawaran'); ?>">Kembali</a>
            </div>
            <div class="col-md col-table mt-1 mb-1 ">
                <label id="lblinfo" style="color: red;"></label>
            </div>
            <?php if ($this->session->flashdata('messagey')) : ?>
                <div class="messages mt-1" style="opacity: 1000; ">
                    <div class="success">
                        <div class="alert alert-success "><button type="button" class="close" data-dismiss="alert">×</button>
                            <?php echo $this->session->flashdata('messagey'); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="row row-table mb-1">
            <div class="col-md-4 col-table mt-1 mb-1">
                <div class="panel panel-primary col-content bg border border-primary ">
                    <h5>
                        <div class="panel-heading text-white bg-gradient-primary">
                            Permintaan Pembelian
                        </div>

                        <div class="panel-body my-1 mx-1">

                            <input type="hidden" name="txtIdPr" id="txtIdPr" value="<?= $data_m['id_pr']; ?>">
                            <input type="hidden" name="txtIdPr_d" id="txtIdPr_d" value="<?= $data_m['id_pr_d']; ?>">
                        </div>
                    </h5>
                    <div class="panel-body my-1 mx-1 mb-n2">
                        <table>
                            <tr>
                                <td>No</td>
                                <td>:</td>
                                <td> <span class="text-body" id="lblNoPr"><?= $data_m['no_permintaan']; ?></span></td>
                            </tr>
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
                                <td>PT<br><br></td>
                                <td>:<br><br></td>
                                <td>
                                    <select class="custom-select" name="txt_company" id="txt_company">
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
            <div class="col-md-1 col-table mt-1 mb-1">
                <br>
                <br>
                <br>

                <div class="d-flex justify-content-center">
                    <?php
                    if ($data_m['is_po'] == 1) {
                        $path = base_url('assets/img/po.jpg');
                    ?>
                        <img src="<?= $path; ?>" type="image/jpeg" width="100">
                    <?php } ?>

                </div>

            </div>
            <div class="col-md-7 col-table mt-1 mb-1">
                <div class="panel panel-primary col-content bg border border-primary">

                    <h6>
                        <table>
                            <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td> <span class="text-body" id="lblKeterangan"><?= $data_m['ket_m']; ?></span></td>
                            </tr>
                            <tr>
                                <td>Item</td>
                                <td>:</td>
                                <td> <span class="text-body" id="lblItem"><?= $data_m['item']; ?></span></td>
                            </tr>
                            <tr>
                                <td>Jumlah</td>
                                <td>:</td>
                                <td> <span class="text-body" id="lblJumlah"><?= $data_m['qty']; ?></span></td>
                            </tr>
                            <tr>
                                <td>Spesifikasi</td>
                                <td>:</td>
                                <td> <span class="text-body" id="lblSpesifikasi"><?= $data_m['spesifikasi']; ?></span></td>
                            </tr>
                            <tr>
                                <td>Ket. Item</td>
                                <td>:</td>
                                <td> <span class="text-body" id="lblKetItem"><?= $data_m['ket_d']; ?></span></td>
                            </tr>

                        </table>
                    </h6>
                </div>
            </div>
        </div>


        <!-- -----------------------------------------Card Pilih Barang-------------------------------------------- -->


        <div class=" table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <td style="width:1%" style="vertical-align:middle">
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

                        <td>
                            <div class="form-group row row-table ml-1 mt-2 ">
                                <div class="col-sm-4 mb-1 mb-sm-0 mt-2 ">
                                    <label for="basic-url">Surat Penawaran</label>
                                </div>
                                <div class="col-sm-7  input-group input-group-sm">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input border border-primary" name="is_sp" id="is_sp" accept=".jpg,.jpeg">
                                        <label class="custom-file-label border border-primary" for="is_sp">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row row-table ml-1 mt-2 ">
                                <div class="col-sm-4 mb-1 mb-sm-0 mt-2 ">
                                    <label for="basic-url">TOP</label>
                                </div>
                                <div class="col-sm-7  input-group input-group-sm">
                                    <div class="custom-file">
                                        <input type="text" class="form-control sm" id="top" name="top" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td style="width:10%">
                            <h5>
                                <?php
                                if ($data_m['is_po'] == 0) {
                                ?>
                                    <button class="btn btn-success" id="btn_upload" type="submit">Tambahkan Supplier</button>
                                <?php } ?>

                            </h5>
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
        </form>

        <!-- -----------------------------------Data tables list barang detail---------------------------------------------- -->

        <div class="" id="detail-area">
            <div class=" ">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Supplier</th>
                                <th>Gambar</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($data_d as $mr) : ?>
                                <tr>
                                    <td>
                                        <?php
                                        if ($data_m['is_po'] == 0) {
                                        ?>
                                            <a href="#" class="badge badge-danger clastomboldelete" data-id="<?= $mr['id_hapus']; ?>" data-pt_customer="<?= $mr['nm_supplier']; ?>" data-toggle="modal" data-target="#deleteMenuModal">delete</a>
                                        <?php } ?>
                                    </td>
                                    <td><?= $mr['nm_supplier']; ?><br> TOP : <?= $mr['top']; ?></td>
                                    <td>
                                        <div class="col-sm">
                                            <?php $path = base_url('assets/penawaran/') . $mr['nm_file']; ?>
                                            <img src="<?= $path; ?>" type="image/jpeg" width="726">
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</body>


<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
</body>

<!-- ------------------------------------------------------------------Modal Delete------------------------------------------- -->
<div class="modal fade" id="deleteMenuModal" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMenuModalLabel">Hapus Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('trans/penawaran/delete_d'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" id="idhm" name="idhm">
                    <input type="hidden" id="idhd" name="idhd">
                    <div class="row">
                        <div class="col-sm-3 mt-1">
                            Supplier
                        </div>
                        <div class="col-sm  input-group input-group-sm">
                            <label id="pt_customerh"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
<!-- ------------------------------------------------------------------Modal Pilih PR ------------------------------------------- -->

<!-- <div class="modal fade" id="barangModal" tabindex="-1" role="dialog" aria-labelledby="barangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="barangModalLabel">Pilih PR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
           
            <div class="card shadow mb-4" id="barang-area">

            </div>
        </div>
    </div>
</div> -->

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
                        <input type="hidden" id="id_supplier" name="id_supplier" autocomplete="off">
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
            </div>
            <div class="modal-footer">
                <a href="#" class="" id="btnsimpansupplier" onclick="">SIMPAN</a>
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
    $('#txt_company').attr('disabled', true);
    $('.clastomboldelete').on('click', function() {
        $id_trans = $(this).data('id');
        $pt_customer = $(this).data('pt_customer');
        $('#idhd').val($id_trans);
        $('#idhm').val($('#txtIdPr_d').val());
        $('#pt_customerh').text($pt_customer);
    });
    $('.clastombolupload').on('click', function() {
        $id_trans = $(this).data('id');
        $pt_customer = $(this).data('pt_customer');
        $('#idd').val($id_trans);
        $('#nm_file').val($(this).data('nm_file'));
        $('#idm').val($('#id_penawaran').val());
        $('#pt_customer').text($pt_customer);
    });
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

    function simpansupplier() {
        $.ajax({
            url: "<?= base_url('trans/penawaran/save_supplier'); ?>",
            data: {
                nm_supplier: $('#nm_supplier').val(),
                alamat_sp: $('#alamat_sp').val(),
                up_sp: $('#up_sp').val(),
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
    $("#submits").validate({
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
        submitHandler: function(form) {},
        errorPlacement: function(error, element) {
            return false;
        }, //<---missing comma here
        highlight: function(element, errorClass, validClass) {
            return false;
        }
    });

    $('#submits').submit(function(e) {
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
                url: "<?= base_url('trans/penawaran/save_detil_d'); ?>",
                type: "post",
                //data: new FormData(this),
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                success: function(data) {
                    $id_transaksi = data;
                    url = "<?= base_url('trans/penawaran/edit_d/'); ?>" + $id_transaksi;
                    window.location.replace(url);
                }
            });
        }, 0);
    });

    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    $(".messages").fadeTo(3000, 1000).slideUp(1000, function() {
        $(".messages").slideUp(1000);
    });



    $(document).ready(function() {
        const status = $('#txt_status').val();
        //if (status != 1 || status != 0 || status != 6) {
        if (status > 2) {
            $(":submit").hide();
            $('#lblinfo').text("Penawaran yang sudah diapprove, tidak bisa di edit");
            $('.tbl_simpan').hide();
            $('.clastomboldelete').hide();
            $('.clastombolupload').hide();
            $('#kirim').hide();
        } else {

            $(":submit").show();
            $('#lblinfo').text("");
            $('.tbl_simpan').show();
        }

        const readon = $('#readon').val();
        if (readon == 1) {
            $(":submit").hide();
            $('#lblinfo').text("Anda hanya mempunyai hak akses read only");
            $('.tbl_simpan').hide();
            $('.clastomboldelete').hide();
            $('.clastombolupload').hide();
            $('#kirim').hide();
        };
    });
</script>