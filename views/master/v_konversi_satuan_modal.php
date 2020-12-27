<form action="<?= base_url('master/konversi_satuan/update_barang'); ?>" method="post">
    <div class="modal-body">
        <input type="hidden" name="id_barang" id="id_barang" value="<?= $brg['id_barang']; ?>">
        <div class="row">
            <div class="col-sm-2">
                Kode
            </div>
            <div class="col-sm">
                <input type="text" class="form-control border border-primary" id="kd_barang" name="kd_barang" autocomplete="off" value="<?= $brg['kd_barang']; ?>">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-2">
                Nama
            </div>
            <div class="col-sm">
                <input type="text" class="form-control border border-primary" id="nm_barang" name="nm_barang" autocomplete="off" value="<?= $brg['nm_barang']; ?>">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-2">
                Jenis
            </div>
            <div class="col-sm-3">

                <select class="border border-primary custom-select" name="jenis" id="jenis">
                    <option value="BARANG" <?php if ($brg['jenis'] == 'BARANG') {
                                                echo "selected";
                                            } ?>>BARANG</option>
                    <option value="JASA" <?php if ($brg['jenis'] == 'JASA') {
                                                echo "selected";
                                            } ?>>JASA</option>
                </select>


            </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-2">
                Kelompok
            </div>
            <div class="col-sm">
                <input type="text" class="form-control border border-primary" id="kelompok" name="kelompok" autocomplete="off" value="<?= $brg['kelompok']; ?>">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-2">
                Status
            </div>
            <div class="col-sm-3">

                <select class="border border-primary custom-select" name="status" id="status" value="<?= $brg['status']; ?>">
                    <option value="AKTIF" <?php if ($brg['status'] == 'AKTIF') {
                                                echo "selected";
                                            } ?>>AKTIF</option>
                    <option value="TIDAK AKTIF" <?php if ($brg['status'] == 'TIDAK AKTIF') {
                                                    echo "selected";
                                                } ?>>TIDAK AKTIF</option>
                </select>

            </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-2">
                Satuan
            </div>
            <div class="col-sm-3">
                <select class="border border-primary custom-select" name="id_satuan" id="id_satuan" required="required">
                    <option></option>
                    <?php foreach ($m_satuan as $mc) : ?>
                        <option value="<?= $mc['id_satuan']; ?>" <?php if ($brg['id_satuan'] == $mc['id_satuan']) {
                                                                        echo "selected";
                                                                    } ?>><?= $mc['nm_satuan']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</form>