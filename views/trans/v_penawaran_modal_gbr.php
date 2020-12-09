<div class="card-body">
    <div class="card mb-1 border-left-info">
        <div class="card-body">
            <?php
            $no_sup = 1;
            foreach ($detil as $sp) : ?>

                <div class="row">
                    <div class="col-sm-10">
                        <h5>
                            <bold>
                                <p class="text-success">Penawaran <?= $no_sup; ?> : <?= $sp['nm_supplier']; ?></p>
                                <p class="text-success">TOP : <?= $sp['top']; ?></p>
                            </bold>
                        </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <?php $path = base_url('assets/penawaran/') . $sp['nm_file']; ?>
                        <img src="<?= $path; ?>" type="image/jpeg" width="100%">
                    </div>
                </div>
                <br><br><br>
            <?php
                $no_sup = $no_sup + 1;
            endforeach; ?>
        </div>
    </div>
</div>

</script>