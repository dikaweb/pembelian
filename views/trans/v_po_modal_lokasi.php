    <!-- -----------------------------------Data tables list barang detail---------------------------------------------- -->

    <div class="card-body">

        <form action="<?= base_url('no_logged/update_lokasi'); ?>" method="post">
            <input type="hidden" id="pospk" name="pospk" value="<?= $pospk; ?>">
            <input type="hidden" id="id_transaksi" name="id_transaksi" value=" <?= $konfirmasi_m['id_transaksi']; ?>">
            <div class="modal-body">

                <div class="form-group">
                    <?= $konfirmasi_m['no_transaksi']; ?>
                </div>
                <div class="form-group">
                    <?= $konfirmasi_m['nm_supplier']; ?>
                </div>
                <div class="form-group">
                    <?= tgl_indo($konfirmasi_m['tanggal']); ?>
                </div>
                <div class="form-group">
                    <?= $konfirmasi_m['nm_company']; ?>
                </div>
                <div class="form-group row row-table mt-1 mb-n1">


                    <div class="col-md col-table  input-group input-group-sm mb-1">
                        <select class="form-control border border-primary" name="id_lokasi_penerima" id="id_lokasi_penerima" required="required">
                            <option></option>
                            <?php foreach ($lokasi_penerima as $mc) : ?>
                                <option value="<?= $mc['id']; ?>" <?php if ($konfirmasi_m['id_lokasi_penerima'] == $mc['id']) {
                                                                        echo "selected";
                                                                    } ?>><?= $mc['lokasi']; ?> || <?= $mc['kota_kab']; ?> || <?= $mc['province']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span id="lblinfo"></span>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>