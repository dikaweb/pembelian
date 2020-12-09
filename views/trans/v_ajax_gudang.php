<select class="form-control-sm " name="txtid_gudang" id="txtid_gudang">
    <?php foreach ($m_gudang as $mc) : ?>
        <option value="<?= $mc['id_gudang']; ?>"><?= $mc['kd_gudang']; ?></option>
    <?php endforeach; ?>
</select>