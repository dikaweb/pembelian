<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?= base_url('assets/'); ?>vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
<input type="hidden" name="txtid_user" id="txtid_user" value="<?= $user['id']; ?>">
<input type="hidden" name="txt_company" id="txt_company" value="<?= $konfirmasi_m['id_company']; ?>">
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

<body>
    <input type="hidden" name="txtid_gudang" id="txtid_gudang" value="<?= $konfirmasi_m['id_gudang']; ?>">
    <div class="container">
        <div class="col-md-6 col-table mt-1 mb-1">
            <a class="btn btn-info  col-sm-2 mt-1 btn-sm" href="<?= base_url('trans/bpb'); ?>">Kembali</a>
            <a class="btn btn-info  col-sm-2 mt-1 btn-sm" id="baru" href="<?= base_url('trans/bpb/add'); ?>">baru</a>
            <a class="btn btn-info  col-sm-2 mt-1 btn-sm" href="#" onclick="cetak()">Cetak</a>
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
                    <h6>
                        <div class="panel-body my-1 mx-1 mb-n2">
                            <span class="text-body" id="lblnm_rekanan1">Gudang : <?= $konfirmasi_m['kd_gudang']; ?></span>
                        </div>

                    </h6>
                    <div class="form-check my-1 mx-1 ">
                        <input class="form-check-input lima" type="checkbox" <?= check_bpb_is_complete($konfirmasi_m['id_transaksi']); ?> data-id="<?= $konfirmasi_m['id_transaksi']; ?>" id="is_complete">
                        <label class="form-check-label" for="is_complete">
                            Upload Berkas Selesai
                        </label>
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
                                Tanggal Penerimaan
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

                            </div>
                        </div>
                    </div>
                    <div class="panel-body my-1 mx-1 mb-n2">
                        <span class="text-body" id="lblno_po"><?= $konfirmasi_m['no_po_spk']; ?></span>
                        <input type="hidden" name="id_po_spk" id="id_po_spk" value="<?= $konfirmasi_m['id_po']; ?>">
                    </div>

                    <div class=" panel-body my-1 mx-1 ">
                        <span class=" text-body" id="lbltgl_po"><?= tgl_indo($konfirmasi_m['tgl_po_spk']); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- -----------------------------------------Card Pilih Barang-------------------------------------------- -->
    <div class="mb-1">
        <div class=" mx-4">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td style="width:10%" style="vertical-align:middle">
                                <h5>
                                    <a href="#" class="badge bg-gradient-primary text-gray-100" onclick="openModalBarang()">Pilih Barang</a>
                                    <br>
                                    <div class="panel-body ">
                                        <span id="lblnm_barang"></span>
                                        <input type="hidden" name="txtid_barang" id="txtid_barang">
                                        <input type="hidden" name="txtid_po_d" id="txtid_po_d">
                                        <input type="hidden" name="nm_barang" id="nm_barang">
                                        <input type="hidden" name="harga" id="harga">
                                    </div>

                                    <div class="panel-body ">
                                        <span id="lbljumlah"></span>

                                    </div>
                                    <!--
                                    <div class="panel-body ">
                                        <span id="lblsatuan"></span>
                                    </div>
-->
                                </h5>


                            </td>
                            <td style="width:5%">
                                <h6>
                                    Jumlah
                                    <div class="field">
                                        <input type="text" size="5" class="form-control-sm border border-primary uang" name="txt_jumlah" id="txt_jumlah" autocomplete="off">
                                        <span id="lbl_jumlah" class="ml-3"></span>
                                    </div>
                                </h6>
                            </td>
                            <td style="width:5%">
                                <h6>
                                    Satuan
                                    <div class="field" id="satuan-area">

                                    </div>
                                </h6>
                            </td>
                            <td style="width:10%">
                                <h5>
                                    <?php if ($konfirmasi_m['id_user'] == $user['id']) { ?>
                                        <a href="#" class="badge bg-gradient-primary text-gray-100" onclick="tambahBarang()">Tambah</a>
                                    <?php } ?>
                                </h5>
                            </td>
                        </tr>
                    </thead>
                </table>
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
                            <th>Action</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($konfirmasi_d as $mr) : ?>
                            <tr>
                                <td width="7%">
                                    <?php if ($konfirmasi_m['id_user'] == $user['id']) { ?>
                                        <a href="#" class="badge badge-danger clastomboldel" data-id_detail="<?= $mr['id_detail']; ?>" data-nm_barang="<?= $mr['nm_barang']; ?>" data-jumlah="<?= $mr['jumlah']; ?>" data-id_transaksi="<?= $mr['id_bpb']; ?>" data-toggle="modal" data-target="#deleteMenuModal">delete</a>
                                    <?php } ?>
                                </td>
                                <td><?= $mr['nm_barang']; ?></td>
                                <td><?= rp($mr['jumlah']); ?> <?= $mr['nm_satuan']; ?></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- -----------------------------------------Card Gambar -------------------------------------------- -->
    <form class="user" id="validasi" method="post" action="<?= base_url('trans/bpb/upload_d'); ?>" enctype="multipart/form-data">
        <div class=" mx-4">
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
                                            <option value="LAI">Lain - lain</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row row-table ml-1 mt-n2">
                                    <div class="col-sm-2">
                                        <label for="basic-url">Ket</label>
                                    </div>
                                    <div class="col-sm-7  input-group input-group-sm">
                                        <div class="custom-file">
                                            <input type="text" class="form-control-sm border border-primary" id="txtket" name="txtket" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row row-table ml-1 mt-n2 mb-n3">
                                    <div class="col-sm-2">
                                        <label for="basic-url"></label>
                                    </div>
                                    <div class="col-sm-7  input-group input-group-sm  ml-1">
                                        <div class="form-group row row-table ">

                                            <button class="btn btn-success" id="btn_upload" type="submit">Tambahkan Gambar</button>

                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </form>

    <!-- -----------------------------------Data tables list barang detail---------------------------------------------- -->

    <div class=" mx-4">
        <div class=" ">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ket</th>
                            <th>Gambar</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($gbr as $gb) : ?>
                            <tr>

                                <td>
                                    <?php if ($gb['id_user'] == $user['id']) { ?>
                                        <a href="#" class="badge badge-danger clastomboldelete" data-id="<?= $gb['id_transaksi']; ?>" data-pt_customer="<?= $gb['jenis']; ?>" data-ket="<?= $gb['ket']; ?>" data-toggle="modal" data-target="#deletegbr">delete</a>
                                    <?php } ?>
                                </td>
                                <td>
                                    Jenis : <?= $gb['jenis']; ?><br><?= $gb['ket']; ?><br>
                                    User : <?= $gb['nama_lengkap']; ?>

                                </td>
                                <td>
                                    <div class="col-sm">
                                        <?php $path = base_url('assets/bpb/') . $gb['nm_file']; ?>
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

    <!------------------------------------------------------------- Modal Delete barang -->
    <div class="modal fade" id="deleteMenuModal" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteMenuModalLabel">Hapus barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('trans/bpb/delete_d'); ?>" method="post">
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

    <!-- ------------------------------------------------------------------Modal Delete gambar------------------------------------------- -->
    <div class="modal fade" id="deletegbr" tabindex="-1" role="dialog" aria-labelledby="deletegbrLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletegbrLabel">Hapus Gambar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('trans/bpb/delete_gbr'); ?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="idhm" name="idhm">
                        <input type="hidden" id="idhd" name="idhd">
                        <div class="row">
                            <div class="col-sm-3 mt-1">
                                Jenis
                            </div>
                            <div class="col-sm  input-group input-group-sm">
                                <label id="pt_customerh"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 mt-1">
                                Ket
                            </div>
                            <div class="col-sm  input-group input-group-sm">
                                <label id="keth"></label>
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
</body>
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
<script src="<?= base_url('assets/'); ?>js/signature_pad.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/jquery/webcam.js"></script>

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
        $('#tgl_awal').datepicker('setDate', new Date($('#tgl').val()));

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

        $('.clastombolfoto').on('click', function() {

            $('#fotoModalLabel').text($(this).data('nama'));

            $.ajax({
                url: "<?= base_url('trans/bpb/set_session'); ?>",
                data: {
                    id: $('#txtid_transaksi').val()
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

<!-------------------------------------- Pilih Rekanan & Barang-------------------------------------- -->
<script type="text/javascript">
    function openModalBarang() {
        $('#barang-area').load("<?= base_url('trans/bpb/pilihbarang/'); ?>" + $('#id_po_spk').val());
        $('#barangModal').modal();
    }

    $('.clastomboldel').on('click', function() {
        $('#nomor').val($(this).data('kd_barang'));
        $('#tanggal').val($(this).data('nm_barang'));
        $('#nama').val($(this).data('jumlah'));
        //$('#total').val(total);
        $('#idd').val($(this).data('id_detail'));
        $('#idt').val($(this).data('id_transaksi'));
    });

    $('.clastomboldelete').on('click', function() {
        $id_trans = $(this).data('id');
        $pt_customer = $(this).data('pt_customer');
        $ket = $(this).data('ket');
        $('#idhd').val($id_trans);
        $('#idhm').val($('#txtid_transaksi').val());
        $('#pt_customerh').text($pt_customer);
        $('#keth').text($ket);
    });

    $('#btn_upload').on('click', function() {
        if ($('#is_sp').val() == "") {
            alert("Pilih gambar terlebih dahulu");
            return true;
        }
    });

    function tambahBarang() {

        if ($('#txtid_satuan').val() == "") {
            alert("Pilih satuan terlebih dahulu");
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


        $("#loadMe").modal({
            backdrop: "static", //remove ability to close modal with click
            keyboard: false, //remove option to close with keyboard
            show: true //Display loader!
        });

        $.ajax({
            url: "<?= base_url('trans/bpb/save_d'); ?>",
            data: {
                id_transaksi: $('#txtid_transaksi').val(),
                id_po_d: $('#txtid_po_d').val(),
                id_barang: $('#txtid_barang').val(),
                id_satuan: $('#txtid_satuan').val(),
                id_gudang: $('#txtid_gudang').val(),
                nm_barang: $('#nm_barang').val(),
                harga: $('#harga').val(),
                jumlah: parseFloat($('#txt_jumlah').val()),
            },
            method: "post",
            dataType: 'json',
            success: function(data) {
                $id_transaksi = data;
                console.log($id_transaksi);
                url = "<?= base_url('trans/bpb/edit/'); ?>" + $id_transaksi;
                window.location.replace(url);
            }
        });

    };

    $('.lima').on('click', function() {
        const id = $(this).data('id');
        $.ajax({
            url: "<?= base_url('trans/bpb/is_complete'); ?>",
            type: 'post',
            data: {
                id: id
            },
            success: function() {
                document.location.href = "<?= base_url('trans/bpb/edit/'); ?>" + $('#txtid_transaksi').val();
            }
        });

    });

    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    function cetak() {
        id_trans = $('#txtid_transaksi').val();
        url = "<?= base_url('trans/bpb/cetak2/'); ?>" + id_trans;
        window.open(url, '_blank')
    }
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
            url = "<?= base_url('trans/bpb/edit/'); ?>" + $('#txtid_transaksi').val();
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