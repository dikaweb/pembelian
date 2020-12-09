<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?= base_url('assets/'); ?>vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
<input type="hidden" name="txtid_user" id="txtid_user" value=" <?= $user['id']; ?>">
<input type="hidden" name="txt_company" id="txt_company" value="<?= $konfirmasi_m['id_company']; ?>">

<body>
    <form method="post" action="<?= base_url('trans/sj/update_m'); ?>">
        <div class=" container">
            <div class="col-md-6 col-table mt-1 mb-1">
                <a class="btn btn-info  col-sm-2 mt-1 btn-sm" href="<?= base_url('trans/sj'); ?>">Kembali</a>
                <a class="btn btn-info  col-sm-2 mt-1 btn-sm" id="baru" href="<?= base_url('trans/sj/add'); ?>">baru</a>
                <?php if ($konfirmasi_m['id_user'] == $user['id']) { ?>
                    <a class="btn btn-info  col-sm-2 mt-1 btn-sm" href="#" onclick="cetak()">Cetak</a>
                    <button type="submit" class="btn btn-info col-sm-2 btn-sm mt-1">Simpan</button>
                <?php } ?>
            </div>
            <div class="row row-table mb-1">
                <div class="col-md-4 col-table mt-1 mb-1">
                    <div class="panel panel-primary col-content bg border border-primary ">
                        <h5>
                            <div class="panel-heading text-white bg-gradient-primary">
                                Penerima
                            </div>
                            <div class="panel-body my-1 mx-1">
                                <a href="#" class="badge bg-gradient-primary text-gray-100" onclick="openModalpenerima()">Pilih penerima</a>
                            </div>
                            <div class="panel-body my-1 mx-1 mb-n2">
                                <span class="text-body" id="lblkd_pn"><?= $konfirmasi_m['nm_penerima']; ?></span>
                                <input type="hidden" name="txtid_pn" id="txtid_pn" value="<?= $konfirmasi_m['id_penerima']; ?>">
                            </div>

                        </h5>
                        <h6>
                            <div class="panel-body my-1 mx-1 mb-n2">
                                <span class="text-body" id="lblnm_pn"></span>
                            </div>
                            <div class="panel-body my-1 mx-1">
                                <span class="text-body" id="lblalamat_pn"><?= $konfirmasi_m['alamat_pn1']; ?></span>
                            </div>
                            <div class="form-group row row-table ml-1 mt-3 ">
                                <div class="col-sm-1 ml-n1 mt-1 ">
                                    <label for="basic-url">UP </label>
                                </div>

                                <div class="col-sm-5  input-group input-group-sm">
                                    <input type="text" value="<?= $konfirmasi_m['up_pn']; ?>" class="form-control border border-primary" name="txtup" id="txtup" autocomplete="off">

                                </div>
                            </div>
                        </h6>

                    </div>

                    <div class="panel panel-primary col-content bg border border-primary mt-1 ">
                        <h5>
                            <div class="panel-heading text-white bg-gradient-primary">
                                Pengirim
                            </div>
                            <div class="panel-body my-1 mx-1">
                                <a href="#" class="badge bg-gradient-primary text-gray-100" onclick="openModalpengirim()">Pilih pengirim</a>
                            </div>
                            <div class="panel-body my-1 mx-1 mb-n2">
                                <span class="text-body" id="lblkd_kr"><?= $pengirim['nm_penerima']; ?></span>
                                <input type="hidden" name="txtid_kr" id="txtid_kr" value="<?= $pengirim['id_penerima']; ?>">
                            </div>

                        </h5>
                        <h6>
                            <div class="panel-body my-1 mx-1 mb-n2">
                                <span class="text-body" id="lblnm_kr"></span>
                            </div>
                            <div class="panel-body my-1 mx-1">
                                <span class="text-body" id="lblalamat_kr"><?= $pengirim['alamat_pn1']; ?></span>
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
                <div class="col-md-6 col-table mt-1 mb-1">
                    <div class="panel panel-primary col-content bg border border-primary">
                        <div class="row row-table">
                            <div class="panel-sm panel-primary-sm col-content ml-1 col-sm-4  mt-1 mr-1 ">
                                <div class="panel-body  text-white bg-gradient-primary border border-primary">
                                    Tanggal Transaksi
                                </div>
                                <div class="panel-body ">
                                    <input type="text" readonly class="form-control border border-primary tglpicker" name="tgl_awal" id="tgl_awal">
                                    <input type="hidden" name="tgl" id="tgl" value="<?= $konfirmasi_m['tanggal']; ?>">
                                </div>
                            </div>
                            <div class="panel panel-primary col-content  col-sm-4  ml-1 mt-1 mr-1 ">
                                <div class="panel-heading text-white bg-gradient-primary border border-primary ">
                                    No. Transaksi
                                </div>
                                <div>
                                    <input type="text" readonly value="<?= $konfirmasi_m['no_transaksi']; ?>" class="form-control border border-primary" name="txtno_transaksi" id="txtno_transaksi" autocomplete="off">
                                    <input type="hidden" name="txtid_transaksi" id="txtid_transaksi" value="<?= $konfirmasi_m['id_transaksi']; ?>">
                                </div>
                            </div>
                        </div>


                        <div class="form-group row row-table ml-1 mt-3">
                            <div class="col-sm ml-n1">
                                <h5>
                                    <label for="basic-url">Gudang Tujuan : <?= $konfirmasi_m['kd_gudang']; ?></label>
                                </h5>
                                <input type="hidden" name="txtid_gudang" id="txtid_gudang" value="<?= $konfirmasi_m['id_gudang']; ?>">
                            </div>

                        </div>

                        <div class="form-group row row-table ml-1">
                            <div class="col-sm-2 ml-n1">
                                <label for="basic-url">Note </label>
                            </div>
                            <div class="col-sm col-table  input-group input-group-sm mb-1">
                                <input type="text" value="<?= $konfirmasi_m['note_sj_gd']; ?>" class="form-control border border-primary" name="txtnote" id="txtnote" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- -----------------------------------------Card Pilih Barang-------------------------------------------- -->

            <div class="mb-1">
                <div class=" table-responsive">
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
                                    </h6>
                                </td>
                                <td style="width:10%">
                                    <h5>
                                        <?php if ($konfirmasi_m['id_user'] == $user['id']) { ?>
                                            <a href="#" id="btntambah" class="badge bg-gradient-primary text-gray-100" onclick="tambahBarang()">Tambah</a>
                                        <?php } ?>
                                    </h5>
                                </td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- -----------------------------------Data tables list barang detail---------------------------------------------- -->
            <?= $this->session->flashdata('messagez'); ?>
            <div class="" id="detail-area">
                <div class="">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Referensi</th>
                                    <th>Ket Referensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($konfirmasi_d as $mr) : ?>
                                    <tr>
                                        <td width="7%">
                                            <?php if ($konfirmasi_m['id_user'] == $user['id']) { ?>
                                                <a href="#" class="badge badge-danger clastomboldel" data-id_detail="<?= $mr['id_detail']; ?>" data-nm_barang="<?= $mr['nm_barang']; ?>" data-jumlah="<?= $mr['jumlah']; ?>" data-id_transaksi="<?= $mr['id_transaksi']; ?>" data-toggle="modal" data-target="#deleteMenuModal">delete</a>
                                            <?php } ?>
                                        </td>
                                        <td><?= $mr['nm_barang']; ?></td>
                                        <td><?= $mr['jumlah']; ?></td>
                                        <td><?= $mr['nm_satuan']; ?></td>
                                        <td><?php
                                            switch ($mr['jenis_reff']) {
                                                case "1":
                                                    echo "PR";
                                                    break;
                                                case "2":
                                                    echo "Penawaran";
                                                    break;
                                                case "3":
                                                    echo "Tanpa Referensi";
                                                    break;
                                            }
                                            ?></td>
                                        <td><?php
                                            switch ($mr['jenis_reff']) {
                                                case "1":
                                                    $menuId = $mr['id_reff'];
                                                    $querySubMenu = "SELECT no_permintaan from permintaan_barang_detail a inner join permintaan_barang b on a.permintaan_barang_id = b.id where a.id = $menuId";
                                                    $subMenu = $this->db->query($querySubMenu)->row_array();
                                                    echo "No. PR : " . $subMenu['no_permintaan'];
                                                    break;
                                                case "2":
                                                    $menuId = $mr['id_reff'];
                                                    $querySubMenu = "SELECT no_permintaan from permintaan_barang_detail a inner join permintaan_barang b on a.permintaan_barang_id = b.id where a.id = $menuId";
                                                    $subMenu = $this->db->query($querySubMenu)->row_array();
                                                    //echo "No. Penawaran : " . $subMenu['no_penawaran'] . "<br>";
                                                    echo "No. PR : " . $subMenu['no_permintaan'] . "<br>";
                                                    break;
                                            }
                                            ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
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
                    <textarea class="md-textarea form-control" rows="3" name="txt_keterangan" id="txt_keterangan"><?= $konfirmasi_m['keterangan']; ?></textarea>
                </div>
            </div>

        </div>
        <div class="col-md-4 col-table mt-1 mb-1">
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
                    <textarea class="md-textarea form-control" rows="3" name="txt_keterangan2" id="txt_keterangan2"><?= $konfirmasi_m['keterangan2']; ?></textarea>
                </div>
            </div>

        </div>
    </div>
    </form>


    <!-- ------------------------------------------------------------------Modal Pilih Tujuan/penerima------------------------------------------- -->
    <div class="modal fade" id="penerimaModal" tabindex="-1" role="dialog" aria-labelledby="penerimaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="penerimaModalLabel">Pilih penerima</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- DataTables Example -->
                <div class="card shadow mb-4" id="penerima-area">
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
    <!-- ------------------------------Modal penerima add/edit------------------------------------------>
    <div class="modal fade" id="addpenerimaModal" tabindex="-1" role="dialog" aria-labelledby="penerimaLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="penerimaModalTittle">Tambah penerima</h5>
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
                            <input type="text" class="form-control sm" id="nm_penerima" name="nm_penerima" autocomplete="off">
                            <input type="hidden" id="id_penerima" name="id_penerima" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-sm-3">
                            Alamat
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="alamat_pn1" name="alamat_pn1" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-sm-3">
                            UP
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="up_pn" name="up_pn" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="" id="btnsimpanpenerima" onclick="">SIMPAN</a>
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
                            Nama
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
                <form action="<?= base_url('trans/sj/delete_d'); ?>" method="post">
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
        $(function() {
            $('.tglpicker').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'dd MM yyyy',
                language: 'id'
            })
            $('#tgl_awal').datepicker('setDate', new Date($('#tgl').val()));
        });

        $(document).ready(function() {
            $('#tgl_awal').datepicker()
                .on('changeDate', function(e) {
                    // `e` here contains the extra attributes
                    console.log("res");
                    $('#tgl').val($("#tgl_awal").data('datepicker').getFormattedDate('yyyy-m-d'));
                });
            $('#tgl_awal').datepicker()
                .on('keyup change', function(e) {
                    // `e` here contains the extra attributes
                    console.log("res");
                    $('#tgl').val($("#tgl_awal").data('datepicker').getFormattedDate('yyyy-m-d'));
                });
        });
    </script>

    <!-------------------------------------- Pilih Rekanan & Barang-------------------------------------- -->
    <script type="text/javascript">
        function openModalpenerima() {
            $('#penerima-area').load("<?= base_url('trans/sj/pilihpenerima'); ?>");
            $('#penerimaModal').modal();
        }

        function openModalpengirim() {
            $('#penerima-area').load("<?= base_url('trans/sj/pilihpengirim'); ?>");
            $('#penerimaModal').modal();
        }

        function openModalBarang() {
            if ($('#txtid_gudang').val() == "") {
                alert("Silahkan Pilih Gudang tujuan");
                return true;
            }

            if ($('#txtid_rekanan').val() == "") {
                alert("Pilih Dulu Pengirim");
            } else if ($('#txtid_rekanan1').val() == "") {
                alert("Pilih Dulu penerima");
            } else {
                id_gd = parseInt($('#txtid_gudang').val());
                $('#barang-area').load("<?= base_url('trans/sj/pilihbarang/'); ?>" + id_gd);
                $('#barangModal').modal();
            };
        }

        function simpanpenerima() {
            $.ajax({
                url: "<?= base_url('trans/sj/save_penerima'); ?>",
                data: {
                    nm_penerima: $('#nm_penerima').val(),
                    alamat_pn1: $('#alamat_pn1').val(),
                    up_pn: $('#up_pn').val(),
                },
                method: "post",
                dataType: 'json',
            });
            $('#addpenerimaModal').modal("hide");
        };

        function updatepenerima() {
            $.ajax({
                url: "<?= base_url('trans/sj/update_penerima'); ?>",
                data: {
                    id_penerima: $('#id_penerima').val(),
                    nm_penerima: $('#nm_penerima').val(),
                    alamat_pn1: $('#alamat_pn1').val(),
                    up_pn: $('#up_pn').val(),
                },
                method: "post",
                dataType: 'json',
                success: function(data) {
                    if (data != 0) {
                        alert("penerima sudah pernah digunakan, tidak bisa di rubah");
                    };
                }
            });
            $('#addpenerimaModal').modal("hide");
        };

        function deletepenerima() {
            $.ajax({
                url: "<?= base_url('trans/sj/delete_penerima'); ?>",
                data: {
                    id_penerima: $('#id_penerima').val()
                },
                method: "post",
                dataType: 'json',
                success: function(data) {
                    if (data != 0) {
                        alert("penerima sudah pernah digunakan, tidak bisa di hapus");
                    };
                }
            });
            $('#addpenerimaModal').modal("hide");
        };

        function tambahBarang() {
            if ($('#txtid_barang').val() == "") {
                alert("Silahkan Pilih Barang");
                return true;
            }

            if (!$('input[type="radio"]').is(':checked')) {
                alert("Silahkan Pilih Referensi");
                return true;
            }

            if ($('#cashRadio').is(':checked')) {
                if ($('#txtIdPr').val() == "") {
                    alert("Pilih PR terlebih dahulu");
                    return true;
                }
                id_reff = $('#txtIdPr_d').val();

                jenis_reff = 1;
            }
            if ($('#transferRadio').is(':checked')) {
                if ($('#txtIdPenawaran').val() == "") {
                    alert("Pilih Penawaran terlebih dahulu");
                    return true;
                }

                id_reff = $('#txtIdPr_d1').val();
                jenis_reff = 2;

            }
            if ($('#giroRadio').is(':checked')) {
                id_reff = 0;
                jenis_reff = 3;

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


            id_company = $('#txt_company').val();
            $.ajax({
                url: "<?= base_url('trans/sj/save_d'); ?>",
                method: 'post',
                data: {
                    id_transaksi: $('#txtid_transaksi').val(),
                    id_gudang: $('#txtid_gudang').val(),
                    id_barang: $('#txtid_barang').val(),
                    id_satuan: $('#txtid_satuan').val(),
                    id_company: id_company,
                    jumlah: parseFloat($('#txt_jumlah').val()),
                    jenis_reff: jenis_reff,
                    nm_barang: $('#lblnm_barang').text(),
                    id_reff: id_reff
                },

                dataType: 'json',
                success: function(data) {
                    $id_transaksi = data;
                    console.log($id_transaksi);
                    url = "<?= base_url('trans/sj/edit/'); ?>" + $id_transaksi;
                    window.location.replace(url);
                },
                error: function(jqxhr, status, exception) {
                    alert('Exception:', exception);
                }
            });
        };

        $(document).ready(function() {
            $('input[type="radio"]').click(function() {
                var inputValue = $(this).attr("value");
                var targetBox = $("." + inputValue);
                $(".selectt").not(targetBox).hide();
                $(targetBox).show();
            });
            $(".selectt").hide();

        });

        function pilihgudang() {
            $.ajax({
                url: "<?= base_url('trans/sj/pilihgudang'); ?>",
                method: 'post',
                data: {
                    id_gudang: $('#txtid_gudang').val(),
                },

                dataType: 'json',
                success: function(data) {
                    $('#txt_company').val(data)
                },
                error: function(jqxhr, status, exception) {
                    alert('Gudang tujuan tidak bisa dikosongi', exception);
                }
            });
        }

        function pilihpr() {
            if ($('#txt_company').val() == "") {
                alert("Pilih Dulu Gudang Tujuan");
                return true;
            }
            $('#pr-area').load("<?= base_url('no_logged/pilihpr/sj-pr/0/'); ?>" + $('#txt_company').val());
            $("#loadMe").modal({
                backdrop: "static", //remove ability to close modal with click
                keyboard: false, //remove option to close with keyboard
                show: true //Display loader!
            });
            setTimeout(function() {
                $("#loadMe").modal("hide");
                $('#prModal').modal();
            }, 2500);
        }

        function pilihpenawaran() {
            if ($('#txt_company').val() == "") {
                alert("Pilih Dulu Gudang Tujuan");
                return true;
            }
            $('#pr-area').load("<?= base_url('no_logged/pilihpr/sj-pnw/0/'); ?>" + $('#txt_company').val());
            $('#prModal').modal();
        }

        $('.clastomboldel').on('click', function() {
            $('#nomor').val($(this).data('kd_barang'));
            $('#tanggal').val($(this).data('nm_barang'));
            $('#nama').val($(this).data('jumlah'));
            //$('#total').val(total);
            $('#idd').val($(this).data('id_detail'));
            $('#idt').val($(this).data('id_transaksi'));
            if (status == 1 || status == 0) {
                $(":submit").show();
                $('#lblinfo').text("");
            } else {
                $(":submit").hide();
                $('#lblinfo').text("Konfirmasi selain status CREATE tidak bisa di hapus");
            }
        });

        function cetak() {
            id_trans = $('#txtid_transaksi').val();
            url = "<?= base_url('trans/sj/cetak/'); ?>" + id_trans;
            window.open(url, '_blank')
        }
    </script>