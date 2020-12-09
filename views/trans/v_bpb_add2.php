<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?= base_url('assets/'); ?>vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
<input type="hidden" name="txtid_user" id="txtid_user" value="<?= $user['id']; ?>">
<input type="hidden" name="txt_company" id="txt_company" value="<?= $konfirmasi_m['id_company']; ?>">
<?= form_open_multipart('trans/bpb/save_m/' . $konfirmasi_m['id_transaksi'], array('id' => 'submit')); ?>

<body>
    <div class="container">
        <div class="col-md-6 col-table mt-1 mb-1">
            <a class="btn btn-info  col-sm-2 mt-1 btn-sm" id="baru" href="<?= base_url('trans/bpb/add'); ?>">Kembali</a>
            <button class="btn btn-success col-sm-2 mt-1 btn-sm" id=" btn_upload" type="submit">Simpan</button>

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



    <!-- -----------------------------------------Card Gambar -------------------------------------------- -->

    <div class=" mx-4">
        <div class=" table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>

                        <td>
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
                            <div class="form-group row row-table ml-1  mt-n2">
                                <div class="col-sm-2">
                                    <label for="basic-url">Pilih gambar</label>
                                </div>
                                <div class="col-sm-7  input-group input-group-sm">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="is_sp" id="is_sp" accept=".jpg,.jpeg" required="required">
                                        <label class="custom-file-label border border-primary" for="is_sp" required="required">Choose file</label>
                                    </div>
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
                                <td><?= $mr['jumlah']; ?> <?= $mr['nm_satuan']; ?> <?= $mr['nm_barang']; ?>
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
        $('#tgl_awal').datepicker('setDate', new Date($('#tgl').val()));
    });
</script>

<!-------------------------------------- Pilih Rekanan & Barang-------------------------------------- -->
<script type="text/javascript">
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>