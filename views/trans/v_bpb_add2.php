<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?= base_url('assets/'); ?>vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
<style type="text/css">
    .hiddentext {
        background-color: rgba(0, 0, 0, 0);
        color: white;
        border: none;
        outline: none;
        height: 30px;
        width: 1px;
        transition: height 1s;
        -webkit-transition: height 1s;
    }
</style>
<input type="hidden" name="txtid_user" id="txtid_user" value="<?= $user['id']; ?>">
<input type="hidden" name="txt_company" id="txt_company" value="<?= $konfirmasi_m['id_company']; ?>">
<?= form_open_multipart('trans/bpb/save_m/' . $konfirmasi_m['id_transaksi'], array('id' => 'submit')); ?>

<body>
    <div class="container">
        <div class="col-md-6 col-table mt-1 mb-1">
            <a class="btn btn-info  col-sm-2 mt-1 btn-sm" id="baru" href="<?= base_url('trans/bpb/add'); ?>">Kembali</a>
            <button class="btn btn-success col-sm-2 mt-1 btn-sm" id=" btn_upload" type="submit">Simpan</button>

        </div>

        <!-- -----------------------------------------Card Gambar -------------------------------------------- -->


        <div class=" table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>

                        <td>

                            <div class="form-group row row-table ml-1  mt-n2">
                                <div class="col-sm-2">
                                    <label for="basic-url">Foto gambar</label>
                                </div>
                                <div class="col-sm-7  input-group input-group-sm">
                                    <a href="" data-toggle="modal" data-target="#fotoModal" data-nm_jenis="bukti" data-nama="Foto Bukti" class=" badge badge-success clastombolfoto">...</a>

                                    <input type="text" class="hiddentext" id="is_sp" name="is_sp" required="required" value="<?= $this->session->userdata('nm_file'); ?>">
                                    <?php if (!$this->session->userdata('nm_file')) {
                                        echo "Belum ada gambar";
                                    } ?>
                                    <?php if ($this->session->userdata('nm_file')) { ?>
                                        <a href="#" data-nm_file="<?= $this->session->userdata('nm_file'); ?>" class=" clastombolemail" data-toggle="modal" data-target="#emailMenuModal">
                                            <img src="<?= base_url('assets/img/') . 'checklist.png'; ?>"> </a>
                                    <?php } ?>

                                </div>
                            </div>
                            <div class="form-group row row-table ml-1 mt-n2">
                                <input type="hidden" name="txtid_transaksi" id="txtid_transaksi" value="<?= $konfirmasi_m['id_transaksi']; ?>">
                                <div class="col-sm-2 ">
                                    <label for="basic-url">Jenis gambar</label>
                                </div>

                                <div class="col-sm-2  input-group input-group-sm">
                                    <select class="border border-primary custom-select" name="txtjenis" id="txtjenis" required="required">
                                        <option value=""></option>
                                        <option value="PO">PO</option>
                                        <option value="SJ">SJ</option>
                                        <option value="INV">Invoice / Nota</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row row-table ml-1 mt-n2 mb-n2">
                                <div class="col-sm-2">
                                    <label for="basic-url">Keterangan</label>
                                </div>
                                <div class="col-sm-7  input-group input-group-sm">
                                    <div class="custom-file">
                                        <input type="text" class="form-control-sm border border-primary" id="txtket" name="txtket" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </thead>
            </table>
        </div>



        <div class="row row-table mb-1">
            <div class="col-md-4 col-table mt-1 mb-1">
                <div class="panel panel-primary col-content bg border border-primary ">
                    <h5>
                        <div class="panel-heading text-white bg-gradient-primary">
                            Supplier
                        </div>

                        <div class="panel-body my-1 mx-1 mb-n2">
                            <span class="text-body" id="lblkd_rekanan1"><?= $konfirmasi_m['nm_supplier']; ?></span>
                            <input type="hidden" name="txtid_rekanan1" id="txtid_rekanan1" value="<?= $konfirmasi_m['id_supplier']; ?>">
                        </div>
                    </h5>
                    <h6>
                        <div class="panel-body my-1 mx-1 mb-n2">
                            <span class="text-body" id="lblnm_rekanan1"><?= $konfirmasi_m['alamat_sp']; ?></span>
                        </div>
                        <div class="panel-body my-1 mx-1">
                            <span class="text-body" id="lblalamat1"></span>
                        </div>
                    </h6>
                    <br>
                    <div class="panel-body my-1 mx-1">Gudang :
                        <select class="form-control-sm " name="id_gudang" id="id_gudang" required="required">
                            <option></option>
                            <?php foreach ($m_gudang as $mc) : ?>
                                <option value="<?= $mc['id_gudang']; ?>"><?= $mc['kd_gudang']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
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
            <div class="col-md-6 col-table mt-1 mb-1">
                <div class="panel panel-primary col-content bg border border-primary">
                    <div class="row row-table">
                        <div class="panel-sm panel-primary-sm col-content ml-1 col-sm-5  mt-1 mr-1 ">
                            <div class="panel-body  text-white bg-gradient-primary border border-primary">
                                Tanggal PO/SPK
                            </div>
                            <div class="panel-body ">
                                <input type="text" readonly class="form-control border border-primary tglpicker" name="tgl_awal" id="tgl_awal">
                                <input type="hidden" name="tgl" id="tgl" value="<?= $konfirmasi_m['tanggal']; ?>">
                            </div>
                        </div>
                        <div class="panel panel-primary col-content  col-sm-5  ml-1 mt-1 mr-1 ">
                            <div class="panel-heading text-white bg-gradient-primary border border-primary ">
                                No. Penerimaan
                            </div>
                            <div>
                                <input type="text" readonly class="form-control border border-primary" name="txtno_transaksi" id="txtno_transaksi" autocomplete="off" value="<?= $konfirmasi_m['no_transaksi']; ?>">
                                <input type="hidden" name="id_transaksi" id="id_transaksi" value="<?= $konfirmasi_m['id_transaksi']; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- -----------------------------------Data tables list barang detail---------------------------------------------- -->
    <?= $this->session->flashdata('messagez'); ?>
    <div class="" id="detail-area">
        <div class=" mx-4">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>

                            <th>Item</th>

                            <th>Sisa</th>
                            <th>Jumlah Diterima</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $x = 0;
                        foreach ($konfirmasi_d as $mr) : ?>
                            <tr>
                                <td><?= rp($mr['jumlah']); ?> <?= $mr['nm_satuan']; ?> <?= $mr['nm_barang']; ?>
                                </td>
                                <td>
                                    <?php
                                    if ($mr['jml_konv_terkecil'] <> 0) {
                                        $jmlh = $mr['jml_konv_terkecil'];
                                    } else {
                                        $jmlh = $mr['jumlah'];
                                    };
                                    ?>
                                    <?= $jmlh - $mr['jml_dt_konv_terkecil']; ?>

                                    <?php
                                    if ($mr['id_sat_konv_terakhir'] <> 0) {
                                        $idsat = $mr['id_sat_konv_terakhir'];
                                    } else {
                                        $idsat = $mr['id_satuan'];
                                    }
                                    $querySubMenu = "SELECT * from m_satuan where id_satuan = $idsat";
                                    $subMenu = $this->db->query($querySubMenu)->row_array();
                                    echo $subMenu['nm_satuan'] ?>
                                    <input type="hidden" name="id_po_d[<?= $x ?>]" id="id_po_d[<?= $x ?>]" value="<?= $mr['id_detail']; ?>">
                                    <input type="hidden" name="nm_barang[<?= $x ?>]" id="nm_barang[<?= $x ?>]" value="<?= $mr['nm_barang']; ?>">
                                    <input type="hidden" name="harga[<?= $x ?>]" id="harga[<?= $x ?>]" value="<?= $mr['harga']; ?>">
                                    <input type="hidden" name="id_barang[<?= $x ?>]" id="id_barang[<?= $x ?>]" value="<?= $mr['id_barang']; ?>">
                                    <input type="hidden" name="id_satuan[<?= $x ?>]" id="id_satuan[<?= $x ?>]" value="<?= $mr['id_satuan']; ?>">
                                </td>
                                <td> <input type="text" size="2" name="jml_input[<?= $x ?>]" id="jml_input[<?= $x ?>]" autocomplete="off" value="" required="required">
                                </td>
                            </tr>
                        <?php
                            $x++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</form>
<!---------------------------------------------- Modal Email -------------------------------->
<div class="modal fade" id="emailMenuModal" tabindex="-1" role="dialog" aria-labelledby="emailMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailMenuModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div style="text-align:center;">
                    <embed id="pdfscan" src="" type="application/pdf" width="1024" height="550" />
                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>

    </div>
</div>
<!-- ------------------------------------------------------------------Modal Foto------------------------------------------ -->

<div class="modal fade" id="fotoModal" tabindex="-1" role="dialog" aria-labelledby="fotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fotoModalLabel">te</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- DataTables Example -->
            <div class="card shadow mb-1" id="foto-area">
                <style>
                    input {
                        margin-top: 1px;
                    }

                    @media handheld and (orientation: landscape) {
                        .wrapper {
                            position: relative;
                            width: 320px;
                            height: 240px;
                            -moz-user-select: none;
                            -webkit-user-select: none;
                            -ms-user-select: none;
                            user-select: none;
                        }

                        .signature-pad {
                            position: absolute;
                            left: 0;
                            top: 0;
                            width: 320px;
                            height: 240px;
                        }
                    }

                    @media handheld and (orientation: portrait) {
                        .wrapper {
                            position: relative;
                            width: 240px;
                            height: 320px;
                            -moz-user-select: none;
                            -webkit-user-select: none;
                            -ms-user-select: none;
                            user-select: none;
                        }

                        .signature-pad {
                            position: absolute;
                            left: 0;
                            top: 0;
                            width: 240px;
                            height: 320px;
                        }
                    }
                </style>
                <div class="card shadow mb-1" id="foto-area">
                    <div class="card-body">
                        <form method="POST" onsubmit="simpan()">

                            <input type="hidden" name="datauri" id="datauri">
                            <p>Ambil Gambar</p>
                            <div>
                                <div id="camera">
                                </div>
                                <div class="wrapper" id="idsignature">
                                    <canvas id="signature-pad" class="signature-pad"></canvas>
                                </div>
                            </div>
                            <div id="webcam">
                                <input type=button value="Foto" onClick="preview()">
                            </div>
                            <div id="simpan" style="display:none">
                                <input type=button value="Ulangi" onClick="batal()">
                                <input type=button value="Upload" onClick="upload()">
                                <input type=button value="Hapus tanda" onClick="undo()">
                            </div>

                        </form>
                        <div>


                        </div>

                        <div id="hasil"></div>
                    </div>

                </div>
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
<script src="<?= base_url('assets/'); ?>js/signature_pad.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/jquery/webcam.js"></script>
<!---------------------------------------------------- Date Picture-------------------------------------------- -->
<script type="text/javascript">
    $(function() {

        $('.clastombolemail').on('click', function() {
            $('#emailMenuModalLabel').text($(this).data('email'));
            $path = "<?= base_url('assets/bpb_temp/'); ?>" + $('#is_sp').val();
            console.log($('#is_sp').val());
            var parent = $('embed#pdfscan').parent();
            var newImage = "<embed id=\"pdfscan\" src=\"" + $path + "\" type=\"image/jpeg\"  width=\"320\" />";
            var newElement = $(newImage);
            $('embed#pdfscan').remove();
            parent.append(newElement);
        });


        $('.tglpicker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'dd MM yyyy',
            language: 'id'
        })
        $('#tgl_awal').datepicker('setDate', new Date($('#tgl').val()));

        $('.clastombolfoto').on('click', function() {

            $('#fotoModalLabel').text($(this).data('nama'));

            $.ajax({
                url: "<?= base_url('trans/bpb/set_session'); ?>",
                data: {
                    id: $('#id_transaksi').val()
                },
                method: "post",
                dataType: 'json',
                success: function(data) {

                },
            });

            $("#foto-area").show();
            Webcam.unfreeze();
            document.getElementById('webcam').style.display = '';
            document.getElementById('simpan').style.display = 'none';
            if (screen.height <= screen.width) {
                // Landscape
                Webcam.set({
                    width: 320,
                    height: 240,
                });

            } else {
                // Portrait
                Webcam.set({
                    width: 240,
                    height: 320,
                });
            }
            Webcam.set({
                image_format: 'jpeg',
                jpeg_quality: 100,
                constraints: {
                    video: true,
                    facingMode: "environment"
                }
            });
            Webcam.attach('#camera');
        });
    });
</script>


<script language="Javascript">
    $("#idsignature").hide();
    // konfigursi webcam
    var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
        penColor: 'rgb(255, 0, 0)'
    });

    function undo() {
        var canvas = document.getElementById("signature-pad"),
            ctx = canvas.getContext("2d");

        if (screen.height <= screen.width) {
            canvas.width = 320;
            canvas.height = 240;
        } else {
            canvas.width = 240;
            canvas.height = 320;
        }


        data = $('#datauri').val();

        var background = new Image();
        background.src = data;
        background.onload = function() {
            ctx.drawImage(background, 0, 0);
        }
    }


    function foto() {
        $("#is_foto-area").hide();
        $("#foto-area").show();
        Webcam.unfreeze();
        document.getElementById('webcam').style.display = '';
        document.getElementById('simpan').style.display = 'none';
        if (screen.height <= screen.width) {
            // Landscape
            Webcam.set({
                width: 320,
                height: 240,
            });

        } else {
            // Portrait
            Webcam.set({
                width: 240,
                height: 320,

            });
        }
        Webcam.set({
            image_format: 'jpeg',
            jpeg_quality: 100,
            //force_flash: true,
            constraints: {
                video: true,
                facingMode: "environment"
            }
        });
        Webcam.attach('#camera');
    }

    function upload() {
        $("#loadMe").modal({
            backdrop: "static", //remove ability to close modal with click
            keyboard: false, //remove option to close with keyboard
            show: true //Display loader!
        });
        var data = signaturePad.toDataURL('image/png');

        //console.log(data);
        Webcam.upload(data, '<?= base_url('trans/bpb/upload_bukti'); ?>', function(code, text) {});
        setTimeout(function() {
            url = "<?= base_url('trans/bpb/add2/'); ?>" + $('#id_transaksi').val();
            window.location.replace(url);
            $("#target").submit();
        }, 3500);
    }

    function preview() {
        $('#camera').hide();
        $("#idsignature").show();
        // untuk preview gambar sebelum di upload
        Webcam.freeze();
        // ganti display webcam menjadi none dan simpan menjadi terlihat
        document.getElementById('webcam').style.display = 'none';
        document.getElementById('simpan').style.display = '';

        var canvas = document.getElementById("signature-pad"),
            ctx = canvas.getContext("2d");

        if (screen.height <= screen.width) {
            canvas.width = 320;
            canvas.height = 240;
        } else {
            canvas.width = 240;
            canvas.height = 320;
        }

        Webcam.snap(function(data_uri) {
            data = data_uri;
        });
        var background = new Image();
        background.src = data;
        background.onload = function() {
            ctx.drawImage(background, 0, 0);
        }
        $('#datauri').val(data);
    }

    function batal() {
        // batal preview
        $('#camera').show();
        $("#idsignature").hide();
        Webcam.unfreeze();
        // ganti display webcam dan simpan seperti semula
        document.getElementById('webcam').style.display = '';
        document.getElementById('simpan').style.display = 'none';
    }
</script>