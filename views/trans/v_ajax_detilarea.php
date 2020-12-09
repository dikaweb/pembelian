<?php $arr = 0;
foreach ($detil as $m2) : ?>
    <div class="form-group">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="<?= $m2['id']; ?>" name="id_pr_d[<?= $arr; ?>]" id="id_pr_d[<?= $arr; ?>]">
            <label class="form-check-label" for="is_secretary">
                <?= $m2['qty'] . ' ' . $m2['satuan'] . ' ' . $m2['item'] . ' ' . $m2['spesifikasi'] . ' ' . ' ' . $m2['keterangan'] . ' ' . ' ' . $m2['catatan_purchasing'] . ' ' . "<br>"; ?>
            </label>
        </div>
    </div>
<?php $arr++;
endforeach; ?>