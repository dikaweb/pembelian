<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?= base_url('assets/'); ?>vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
<input type="hidden" name="txtid_user" id="txtid_user" value=" <?= $user['id']; ?>">
<style type="text/css">
    .modal-lg {
        max-width: 95% !important;
    }
</style>

<form class="user" id="validasi" method="post" action="<?= base_url('penjualan/konfirmasi/update'); ?>">

    <body>
        <div class="container">
            <div class="row row-table mb-1">
                <div class="col-md col-table mt-1 mb-1">
                    <a class="btn btn-info  col-sm-2 mt-1 btn-sm" href="<?= base_url('trans/po'); ?>">Kembali</a>
                </div>
            </div>
            <div class="row row-table mb-1">
                <div class="col-md-4 col-table mt-1 mb-1">

                    <div class="panel panel-primary col-content bg border border-primary ">
                        <h5>
                            <div class="panel-heading text-white bg-gradient-primary">
                                Supplier
                            </div>
                            <div class="panel-body my-1 mx-1">
                                <a href="#" class="badge bg-gradient-primary text-gray-100" id="btnmodalsupplier" onclick="openModalsupplier()">Pilih supplier</a>
                            </div>
                            <div class="panel-body my-1 mx-1 mb-n2">
                                <span class="text-body" id="lblkd_rekanan1"></span>
                                <input type="hidden" name="txtid_rekanan1" id="txtid_rekanan1">
                            </div>
                        </h5>
                        <h6>
                            <div class="panel-body my-1 mx-1 mb-n2">
                                <span class="text-body" id="lblnm_rekanan1"></span>
                            </div>
                            <div class="panel-body my-1 mx-1">
                                <span class="text-body" id="lblalamat1"></span>
                            </div>
                        </h6>

                        <div class="row">
                            <div class="col-sm-2 mt-3 ml-2">
                                PT
                            </div>
                            <div class="col-sm  mt-2 mb-1">
                                <label>: </label>
                                <select class="custom-select" style="width:250px" name="txt_company" id="txt_company">
                                    <option value="0"></option>
                                    <?php foreach ($m_company as $mc) : ?>
                                        <option value="<?= $mc['id_company']; ?>"><?= $mc['nm_company']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                &nbsp;&nbsp;&nbsp;&nbsp;<label style="font-size:10px;color: black; padding: 1px">PT Tidak perlu diisi bila referensi PR/Penawaran</label>
                            </div>
                        </div>
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

                <div class="col-md-7 col-table mt-1 mb-1">
                    <div class="panel panel-primary col-content bg border border-primary">
                        <div class="row row-table">
                            <div class="panel-sm panel-primary-sm col-content ml-1 col-sm-4  mt-1 mr-1 ">
                                <!--
                                <div class="panel-body  text-white bg-gradient-primary border border-primary">
                                    Tanggal Transaksi
                                </div>
-->
                                <div class="panel-body ">
                                    <input type="hidden" class="form-control border border-primary tglpicker" name="tgl_awal" id="tgl_awal">
                                </div>
                            </div>
                            <div class="panel panel-primary col-content  col-sm-4  ml-1 mt-1 mr-1 ">
                                <!--
                                <div class="panel-heading text-white bg-gradient-primary border border-primary ">
                                    No. Transaksi
                                </div>
-->
                                <div>
                                    <input type="hidden" class="form-control border border-primary" name="txtno_transaksi" id="txtno_transaksi" autocomplete="off">
                                    <input type="hidden" name="txtid_transaksi" id="txtid_transaksi">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row row-table ml-1 mt-1 mb-n1">
                            <div class="col-sm-2 ml-n1 mt-1 ">
                                <label for="basic-url"> PPN</label>
                            </div>

                            <div class="col-sm-5  input-group input-group-sm">
                                <select class="border border-primary custom-select" name="txt_ppn" id="txt_ppn">
                                    <option value=""></option>
                                    <option value="1">Include PPN</option>
                                    <option value="2">Exclude PPN</option>
                                    <option value="3">Tanpa PPN</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row row-table ml-1 mt-1 mb-n1">
                            <div class="col-sm-2 ml-n1 mt-1 ">
                                <label for="basic-url"> Jenis Bayar</label>
                            </div>

                            <div class="col-sm-5  input-group input-group-sm">
                                <select class="border border-primary custom-select" name="txtjenis_bayar" id="txtjenis_bayar">
                                    <option value=""></option>
                                    <option value="1">Tempo</option>
                                    <option value="2">Cash</option>
                                </select>
                            </div>
                        </div>




                        <div class="form-group row row-table ml-1 mt-1 ">
                            <div class="col-sm-2 ml-n1 mt-1 ">
                                <label for="basic-url">UP </label>
                            </div>

                            <div class="col-sm-5  input-group input-group-sm">
                                <input type="text" class="form-control border border-primary" name="txtup" id="txtup" autocomplete="off">

                            </div>
                        </div>
                        <div class="form-group row row-table ml-1 mt-n3 mb-n1">
                            <div class="col-sm-2 ml-n1">
                                <label for="basic-url">Note </label>
                            </div>

                            <div class="col-md col-table  input-group input-group-sm mb-1">
                                <input type="text" class="form-control border border-primary" name="txtnote_po" id="txtnote_po" autocomplete="off">
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- -----------------------------------------Card Pilih Barang-------------------------------------------- -->

        <div class="mb-1">
            <div class="mx-4 table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td style="width:20%">

                                <div>
                                    <label for="basic-url">Referensi &nbsp;: &nbsp;</label>

                                    <label>
                                        <input type="radio" name="pilihRadio" id="cashRadio" value="1"> PR &nbsp;&nbsp;</label>
                                    <label>
                                        <input type="radio" name="pilihRadio" id="transferRadio" value="2"> Penawaran &nbsp;&nbsp;</label>
                                    <label>
                                        <input type="radio" name="pilihRadio" id="giroRadio" value="3"> Tanpa Ref </label>
                                </div>
                                <div class="1 selectt">
                                    <div class="panel panel-primary col-content bg border border-primary ">

                                        <div class="panel-heading text-white bg-gradient-primary">
                                            Purchase Requisition
                                        </div>
                                        <div class="panel-body my-1 mx-1">
                                            <a href="#" class="badge bg-gradient-primary text-gray-100" onclick="pilihpr()">Pilih PR</a>
                                        </div>
                                        <input type="hidden" name="txtIdPr_d" id="txtIdPr_d">
                                        <div class="row">
                                            <div class="col-sm-2 mt-1">
                                                No. PR
                                            </div>
                                            <div class="col-sm">
                                                <label>: </label>
                                                <label id="lblNoPr"> </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2 mt-1">
                                                Tanggal
                                            </div>
                                            <div class="col-sm">
                                                <label>: </label>
                                                <label id="lblTgl"> </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2 mt-1">
                                                User
                                            </div>
                                            <div class="col-sm">
                                                <label>: </label>
                                                <label id="lblUser"> </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2 mt-1">
                                                Ket
                                            </div>
                                            <div class="col-sm">
                                                <label>:</label>
                                                <label id="lblKeterangan"></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2 mt-1">
                                                Item
                                            </div>
                                            <div class="col-sm">
                                                <label>: </label>
                                                <label id="lblItem"> </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2 mt-1">
                                                Jumlah
                                            </div>
                                            <div class="col-sm">
                                                <label>: </label>
                                                <label id="lblJumlah"> </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2 mt-1">
                                                Spesifikasi
                                            </div>
                                            <div class="col-sm">
                                                <label>: </label>
                                                <label id="lblSpesifikasi"> </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2 mt-1">
                                                Ket. Item
                                            </div>
                                            <div class="col-sm">
                                                <label>: </label>
                                                <label id="lblKetItem"></label>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="2 selectt">
                                    <div class="panel panel-primary col-content bg border border-primary ">

                                        <div class="panel-heading text-white bg-gradient-primary">
                                            Penawaran
                                        </div>
                                        <div class="panel-body my-1 mx-1">
                                            <a href="#" class="badge bg-gradient-primary text-gray-100" onclick="pilihpenawaran()">Pilih Penawaran</a>
                                            <input type="hidden" name="txtIdPr_d1" id="txtIdPr_d1">
                                        </div>
                                        <div class="row">
                                            <div class="col-sm mt-1" n id="listpenawaran-area">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2 mt-1">
                                                No. PR
                                            </div>
                                            <div class="col-sm">
                                                <label>: </label>
                                                <label id="lblNoPr1"> </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2 mt-1">
                                                Tanggal
                                            </div>
                                            <div class="col-sm">
                                                <label>: </label>
                                                <label id="lblTgl1"> </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2 mt-1">
                                                User
                                            </div>
                                            <div class="col-sm">
                                                <label>: </label>
                                                <label id="lblUser1"> </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2 mt-1">
                                                Ket
                                            </div>
                                            <div class="col-sm">
                                                <label>:</label>
                                                <label id="lblKeterangan1"></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2 mt-1">
                                                Item
                                            </div>
                                            <div class="col-sm">
                                                <label>: </label>
                                                <label id="lblItem1"> </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2 mt-1">
                                                Jumlah
                                            </div>
                                            <div class="col-sm">
                                                <label>: </label>
                                                <label id="lblJumlah1"> </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2 mt-1">
                                                Spesifikasi
                                            </div>
                                            <div class="col-sm">
                                                <label>: </label>
                                                <label id="lblSpesifikasi1"> </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2 mt-1">
                                                Ket. Item
                                            </div>
                                            <div class="col-sm">
                                                <label>: </label>
                                                <label id="lblKetItem1"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td style="width:10%" style="vertical-align:middle">
                                <h5>
                                    <a href="#" class="badge bg-gradient-primary text-gray-100" onclick="openModalBarang()">Pilih Barang</a>
                                    <br>
                                    <div class="panel-body ">
                                        <span id="lblnm_barang"></span>
                                        <input type="hidden" name="txtid_barang" id="txtid_barang">
                                    </div>
                                    <!--
                                    <div class="panel-body ">
                                        <span id="lblsatuan"></span>
                                    </div>
-->
                                </h5>

                                <h6>
                                    Satuan
                                    <div class="field" id="satuan-area">

                                    </div>
                                </h6>
                            </td>
                            <td style="width:5%">
                                <h6>
                                    Jumlah
                                    <div class="field">
                                        <input type="text" size="5" class="form-control-sm border border-primary uang" name="txt_jumlah" id="txt_jumlah" autocomplete="off">
                                        <span id="lbl_jumlah" class="ml-3"></span>
                                    </div>
                                    Harga
                                    <div class="field">
                                        <input type="text" size="15" class="form-control-sm border border-primary uang" name="txt_harga" id="txt_harga" autocomplete="off">
                                        <span id="lbl_harga" class="ml-3"></span>
                                    </div>

                                </h6>
                            </td>
                            <td style="width:10%">
                                <h5>
                                    <a href="#" id="btntambah" class="badge bg-gradient-primary text-gray-100" onclick="tambahBarang()">Tambah</a>
                                </h5>
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
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

    <!-- ------------------------------------------------------------------Keterangan------------------------------------------- -->
    <div class="container">
        <div class="row row-table mb-1">
            <div class="col-md-6 col-table mt-1 mb-1">
                <div class="panel panel-primary col-content bg border border-primary ">
                    <h5>
                        <div class="panel-heading text-white bg-gradient-primary">
                            Keterangan
                        </div>
                    </h5>
                    <div class="panel-body my-1 mx-1">

                        <textarea class="md-textarea form-control" rows="3" name="txt_keterangan" id="txt_keterangan"></textarea>
                    </div>
                </div>

            </div>
            <div class="col-md-4 col-table mt-1 mb-1">
            </div>
            <div class="col-md-2 col-table mt-1 mb-1">
                <h5>
                    <div class="panel-heading text-white  bg-gradient-primary">
                        Total
                    </div>
                </h5>
                <div class="panel-body my-1 mx-1">
                    <input type="text" style="text-align:right;" class="form-control border border-primary uang" name="txt_total" id="txt_total" readonly>
                </div>
            </div>

        </div>


        <div class="row row-table mb-1">
            <div class="col-md-6 col-table mt-1 mb-1">
                <div class="panel panel-primary col-content bg border border-primary ">
                    <h5>
                        <div class="panel-heading text-white bg-gradient-primary">
                            Keterangan 2
                        </div>
                    </h5>
                    <div class="panel-body my-1 mx-1">

                        <textarea class="md-textarea form-control" rows="3" name="txt_keterangan2" id="txt_keterangan2"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>


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

<!-- ------------------------------Modal barang add/edit------------------------------------------>
<div class="modal fade" id="addbarangModal" tabindex="-1" role="dialog" aria-labelledby="barangLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="barangModalTittle">Tambah barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-3">
                        Kode
                    </div>
                    <div class="col-sm">
                        <input type="text" class="form-control sm" id="kd_barang" name="kd_barang" autocomplete="off">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        Nama Barang
                    </div>
                    <div class="col-sm">
                        <input type="text" class="form-control sm" id="nm_barang" name="nm_barang" autocomplete="off">
                        <input type="hidden" id="id_barang" name="id_barang" autocomplete="off">
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-3">
                        Satuan
                    </div>
                    <div class="col-sm">
                        <select class="custom-select" name="satuan" id="satuan">
                            <?php foreach ($m_satuan as $mc) : ?>
                                <option value="<?= $mc['id_satuan']; ?>"><?= $mc['nm_satuan']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        Kelompok
                    </div>
                    <div class="col-sm">
                        <input type="text" class="form-control sm" id="kelompok" name="kelompok" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="" id="btnsimpanbarang" onclick="">SIMPAN</a>
            </div>
        </div>
    </div>
</div>

<!-- ------------------------------------------------------------------Modal Pilih PR ------------------------------------------- -->

<div class="modal fade" id="prModal" tabindex="-1" role="dialog" aria-labelledby="prModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="prModalLabel">Pilih PR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- DataTables Example -->
            <div class="card shadow mb-4" id="pr-area">

            </div>
        </div>
    </div>
</div>
<!-- ------------------------------------------------------------------Modal Pilih Penawaran ------------------------------------------- -->

<div class="modal fade" id="penawaranModal" tabindex="-1" role="dialog" aria-labelledby="penawaranModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="penawaranModalLabel">Pilih penawaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- DataTables Example -->
            <div class="card shadow mb-4" id="penawaran-area">

            </div>
        </div>
    </div>
</div>

<!---------------------------------------------- Gambar -------------------------------->
<div class="modal fade" id="emailMenuModal" tabindex="-1" role="dialog" aria-labelledby="emailMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailMenuModalLabel">Penawaran</h5>
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

<script src="<?= base_url('assets/'); ?>js/v_po.js"></script>
<!---------------------------------------------------- Date Picture-------------------------------------------- -->
<script type="text/javascript">
    $('#txt_harga').on('keyup', function() {
        $('#lbl_harga').text(rp($('#txt_harga').val()));
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
        $('#supplier-area').load("<?= base_url('trans/po/pilihsupplier'); ?>");
        $('#supplierModal').modal();
    }

    function openModalBarang() {
        if ($('#txtid_rekanan').val() == "") {
            alert("Pilih Dulu Pengirim");
        } else if ($('#txtid_rekanan1').val() == "") {
            alert("Pilih Dulu supplier");
        } else {
            $('#barang-area').load("<?= base_url('trans/po/pilihbarang0'); ?>");
            $('#barangModal').modal();
        };
    }

    function simpansupplier() {
        $.ajax({
            url: "<?= base_url('trans/po/save_supplier'); ?>",
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
            url: "<?= base_url('trans/po/update_supplier'); ?>",
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
            url: "<?= base_url('trans/po/delete_supplier'); ?>",
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

    ///////////////////////////////////////////////////////////barang/////////
    function simpanbarang() {
        $.ajax({
            url: "<?= base_url('trans/po/save_barang'); ?>",
            data: {
                nm_barang: $('#nm_barang').val(),
                satuan: $('#satuan').val(),
                kd_barang: $('#kd_barang').val(),
                jenis: 'BARANG',
                kelompok: $('#kelompok').val(),
            },
            method: "post",
            dataType: 'json',
        });
        $('#addbarangModal').modal("hide");
    };

    function updatebarang() {
        $.ajax({
            url: "<?= base_url('trans/po/update_barang'); ?>",
            data: {
                id_barang: $('#id_barang').val(),
                nm_barang: $('#nm_barang').val(),
                kd_barang: $('#kd_barang').val(),
                satuan: $('#satuan').val(),
                kelompok: $('#kelompok').val(),
            },
            method: "post",
            dataType: 'json',
            success: function(data) {
                if (data != 0) {
                    alert("Barang sudah pernah digunakan, tidak bisa di rubah");
                };
            }
        });
        $('#addbarangModal').modal("hide");
    };

    function deletebarang() {
        $.ajax({
            url: "<?= base_url('trans/po/delete_barang'); ?>",
            data: {
                id_barang: $('#id_barang').val()
            },
            method: "post",
            dataType: 'json',
            success: function(data) {
                if (data != 0) {
                    alert("Barang sudah pernah digunakan, tidak bisa di hapus");
                };
            }
        });
        $('#addbarangModal').modal("hide");
    };



    function tambahBarang() {
        $('#btntambah').hide();
        if ($('#txt_company').val() == 0) {
            alert("Pilih PT terlebih dahulu");
            $('#btntambah').show();
            return true;
        }

        if (!$('input[type="radio"]').is(':checked')) {
            alert("Silahkan Pilih Referensi");
            $('#btntambah').show();
            return true;
        }

        if ($('#cashRadio').is(':checked')) {
            if ($('#txtIdPr_d').val() == "") {
                alert("Pilih PR terlebih dahulu");
                $('#btntambah').show();
                return true;
            }
            id_reff = $('#txtIdPr_d').val();
            jenis_reff = 1;
        }
        if ($('#transferRadio').is(':checked')) {
            if ($('#txtIdPr_d1').val() == "") {
                alert("Pilih Penawaran terlebih dahulu");
                $('#btntambah').show();
                return true;
            }
            id_reff = $('#txtIdPr_d1').val();
            jenis_reff = 2;

        }
        if ($('#giroRadio').is(':checked')) {
            id_reff = 0;
            jenis_reff = 3;
        }

        if ($('#txtid_barang').val() == "") {
            alert("Silahkan Pilih Barang");
            $('#btntambah').show();
            return true;
        }

        if ($('#txtid_satuan').val() == "") {
            alert("Pilih satuan terlebih dahulu");
            $('#btntambah').show();
            return true;
        }
        if ($('#txt_jumlah').val() == "") {
            alert("Isi jumlah terlebih dahulu");
            $('#btntambah').show();
            return true;
        }


        if ($('#txt_jumlah-error').html() == "Format angka salah") {
            alert("Edit dulu format angka yang salah pada kolom jumlah");
            $('#btntambah').show();
            return true;
        }
        if ($('#txt_harga').val() == "") {
            alert("Isi harga terlebih dahulu");
            $('#btntambah').show();
            return true;
        }
        if ($('#txtjenis_bayar').val() == "") {
            alert("Isi jenis bayar terlebih dahulu");
            $('#btntambah').show();
            return true;
        }

        if ($('#txt_ppn').val() == "") {
            alert("Pilih PPN terlebih dahulu");
            $('#btntambah').show();
            return true;
        }

        if ($('#txt_harga-error').html() == "Format angka salah") {
            alert("Edit dulu format angka yang salah pada kolom harga");
            $('#btntambah').show();
            return true;
        }
        //console.log($('#txt_company').val());
        //return true;
        //$("#loadMe").modal({
        // backdrop: "static", //remove ability to close modal with click
        //keyboard: false, //remove option to close with keyboard
        //show: true //Display loader!
        //});

        var tgl = $("#tgl_awal").data('datepicker').getFormattedDate('yyyy-m-d');
        $.ajax({
            url: "<?= base_url('trans/po/save_m'); ?>",
            method: 'post',
            data: {
                tanggal: tgl,
                id_user: $('#txtid_user').val(),
                no_transaksi: $('#txtno_transaksi').val(),
                id_rekanan1: $('#txtid_rekanan1').val(),
                id_barang: $('#txtid_barang').val(),
                id_satuan: $('#txtid_satuan').val(),
                note_po: $('#txtnote_po').val(),
                nm_barang: $('#lblnm_barang').text(),
                txtup: $('#txtup').val(),
                txt_keterangan: $('#txt_keterangan').val(),
                txt_keterangan2: $('#txt_keterangan2').val(),
                txtjenis_bayar: $('#txtjenis_bayar').val(),
                ppn: $('#txt_ppn').val(),
                jumlah: parseFloat($('#txt_jumlah').val()),
                harga: parseFloat($('#txt_harga').val()),
                id_company: $('#txt_company').val(),
                jenis_reff: jenis_reff,
                id_reff: id_reff
            },

            dataType: 'json',
            success: function(data) {

                if (data == 0) {
                    $nm_company = $('#txt_company').text();
                    alert("GUDANG OTSTANDING " + $nm_company + " belum dibuat. Silahkan buat gudang terlebih dahulu");
                } else {
                    $id_transaksi = data;
                    url = "<?= base_url('trans/po/edit/'); ?>" + $id_transaksi;
                    window.location.replace(url);
                }
            }
        });

    };
</script>


<!-------------------------------------- Show Radio-------------------------------------- -->
<script type="text/javascript">
    $(document).ready(function() {
        $('input[type="radio"]').click(function() {
            var inputValue = $(this).attr("value");
            var targetBox = $("." + inputValue);
            $(".selectt").not(targetBox).hide();
            $(targetBox).show();
        });
        $(".selectt").hide();

    });

    function pilihpr() {

        $('#pr-area').load("<?= base_url('no_logged/pilihpr/po-pr/0/0'); ?>");
        $("#loadMe").modal({
            backdrop: "static", //remove ability to close modal with click
            keyboard: false, //remove option to close with keyboard
            show: true //Display loader!
        });
        setTimeout(function() {
            $("#loadMe").modal("hide");

            $('#prModal').modal();
        }, 1500);

    }

    function pilihpenawaran() {
        if ($('#txtid_rekanan1').val() == "") {
            alert("Pilih Dulu Supplier");
            return true;
        }

        $('#pr-area').load("<?= base_url('no_logged/pilihpr/po-pnw/'); ?>" + $('#txtid_rekanan1').val() + '/0');
        $('#prModal').modal();
    }
</script>