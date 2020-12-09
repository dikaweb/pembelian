<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->


    <div class="row">
        <div class="col-lg-6">

            <?= $this->session->flashdata('messagez'); ?>


            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">BD</th>
                        <th scope="col">KY</th>
                        <th scope="col">BPR</th>
                        <th scope="col">MDE</th>
                        <th scope="col">LRC</th>
                        <th scope="col">LRS</th>
                        <th scope="col">BBE</th>
                        <th scope="col">AMIRA</th>
                        <th scope="col">TELEINDO</th>
                        <th scope="col">HAYUMI</th>
                        <th scope="col">ANDATU</th>
                        <th scope="col">IMAS</th>
                        <th scope="col">PURITY</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($lokasi as $s) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $s['lokasi']; ?></td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input satu" type="checkbox" <?= check_g_lokasi(1, $s['id']); ?> data-id_company="<?= 1; ?>" data-id_lokasi="<?= $s['id']; ?>" data-lokasi="<?= $s['lokasi']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input dua" type="checkbox" <?= check_g_lokasi(2, $s['id']); ?> data-id_company="<?= 2; ?>" data-id_lokasi="<?= $s['id']; ?>" data-lokasi="<?= $s['lokasi']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input tiga" type="checkbox" <?= check_g_lokasi(3, $s['id']); ?> data-id_company="<?= 3; ?>" data-id_lokasi="<?= $s['id']; ?>" data-lokasi="<?= $s['lokasi']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input empat" type="checkbox" <?= check_g_lokasi(4, $s['id']); ?> data-id_company="<?= 4; ?>" data-id_lokasi="<?= $s['id']; ?>" data-lokasi="<?= $s['lokasi']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input lima" type="checkbox" <?= check_g_lokasi(5, $s['id']); ?> data-id_company="<?= 5; ?>" data-id_lokasi="<?= $s['id']; ?>" data-lokasi="<?= $s['lokasi']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input enam" type="checkbox" <?= check_g_lokasi(6, $s['id']); ?> data-id_company="<?= 6; ?>" data-id_lokasi="<?= $s['id']; ?>" data-lokasi="<?= $s['lokasi']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input tujuh" type="checkbox" <?= check_g_lokasi(7, $s['id']); ?> data-id_company="<?= 7; ?>" data-id_lokasi="<?= $s['id']; ?>" data-lokasi="<?= $s['lokasi']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input delapan" type="checkbox" <?= check_g_lokasi(8, $s['id']); ?> data-id_company="<?= 8; ?>" data-id_lokasi="<?= $s['id']; ?>" data-lokasi="<?= $s['lokasi']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input sembilan" type="checkbox" <?= check_g_lokasi(9, $s['id']); ?> data-id_company="<?= 9; ?>" data-id_lokasi="<?= $s['id']; ?>" data-lokasi="<?= $s['lokasi']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input sepuluh" type="checkbox" <?= check_g_lokasi(10, $s['id']); ?> data-id_company="<?= 10; ?>" data-id_lokasi="<?= $s['id']; ?>" data-lokasi="<?= $s['lokasi']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input sebelas" type="checkbox" <?= check_g_lokasi(11, $s['id']); ?> data-id_company="<?= 11; ?>" data-id_lokasi="<?= $s['id']; ?>" data-lokasi="<?= $s['lokasi']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input duabelas" type="checkbox" <?= check_g_lokasi(12, $s['id']); ?> data-id_company="<?= 12; ?>" data-id_lokasi="<?= $s['id']; ?>" data-lokasi="<?= $s['lokasi']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input tigabelas" type="checkbox" <?= check_g_lokasi(13, $s['id']); ?> data-id_company="<?= 13; ?>" data-id_lokasi="<?= $s['id']; ?>" data-lokasi="<?= $s['lokasi']; ?>">
                                </div>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>


        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>

<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script>
    $('.satu').on('click', function() {
        $.ajax({
            url: "<?= base_url('master/gudang/changesubaccess'); ?>",
            type: 'post',
            data: {
                id_company: 1,
                id_lokasi: $(this).data('id_lokasi'),
                lokasi: $(this).data('lokasi'),
            },
            success: function() {
                document.location.href = "<?= base_url('master/gudang'); ?>";
            }
        });
    });

    $('.dua').on('click', function() {
        $.ajax({
            url: "<?= base_url('master/gudang/changesubaccess'); ?>",
            type: 'post',
            data: {
                id_company: 2,
                id_lokasi: $(this).data('id_lokasi'),
                lokasi: $(this).data('lokasi'),
            },
            success: function() {
                document.location.href = "<?= base_url('master/gudang'); ?>";
            }
        });
    });

    $('.tiga').on('click', function() {
        $.ajax({
            url: "<?= base_url('master/gudang/changesubaccess'); ?>",
            type: 'post',
            data: {
                id_company: 3,
                id_lokasi: $(this).data('id_lokasi'),
                lokasi: $(this).data('lokasi'),
            },
            success: function() {
                document.location.href = "<?= base_url('master/gudang'); ?>";
            }
        });
    });

    $('.empat').on('click', function() {
        $.ajax({
            url: "<?= base_url('master/gudang/changesubaccess'); ?>",
            type: 'post',
            data: {
                id_company: 4,
                id_lokasi: $(this).data('id_lokasi'),
                lokasi: $(this).data('lokasi'),
            },
            success: function() {
                document.location.href = "<?= base_url('master/gudang'); ?>";
            }
        });
    });

    $('.lima').on('click', function() {
        $.ajax({
            url: "<?= base_url('master/gudang/changesubaccess'); ?>",
            type: 'post',
            data: {
                id_company: 5,
                id_lokasi: $(this).data('id_lokasi'),
                lokasi: $(this).data('lokasi'),
            },
            success: function() {
                document.location.href = "<?= base_url('master/gudang'); ?>";
            }
        });
    });

    $('.enam').on('click', function() {
        $.ajax({
            url: "<?= base_url('master/gudang/changesubaccess'); ?>",
            type: 'post',
            data: {
                id_company: 6,
                id_lokasi: $(this).data('id_lokasi'),
                lokasi: $(this).data('lokasi'),
            },
            success: function() {
                document.location.href = "<?= base_url('master/gudang'); ?>";
            }
        });
    });

    $('.tujuh').on('click', function() {
        $.ajax({
            url: "<?= base_url('master/gudang/changesubaccess'); ?>",
            type: 'post',
            data: {
                id_company: 7,
                id_lokasi: $(this).data('id_lokasi'),
                lokasi: $(this).data('lokasi'),
            },
            success: function() {
                document.location.href = "<?= base_url('master/gudang'); ?>";
            }
        });
    });

    $('.delapan').on('click', function() {
        $.ajax({
            url: "<?= base_url('master/gudang/changesubaccess'); ?>",
            type: 'post',
            data: {
                id_company: 8,
                id_lokasi: $(this).data('id_lokasi'),
                lokasi: $(this).data('lokasi'),
            },
            success: function() {
                document.location.href = "<?= base_url('master/gudang'); ?>";
            }
        });
    });

    $('.sembilan').on('click', function() {
        $.ajax({
            url: "<?= base_url('master/gudang/changesubaccess'); ?>",
            type: 'post',
            data: {
                id_company: 9,
                id_lokasi: $(this).data('id_lokasi'),
                lokasi: $(this).data('lokasi'),
            },
            success: function() {
                document.location.href = "<?= base_url('master/gudang'); ?>";
            }
        });
    });

    $('.sepuluh').on('click', function() {
        $.ajax({
            url: "<?= base_url('master/gudang/changesubaccess'); ?>",
            type: 'post',
            data: {
                id_company: 10,
                id_lokasi: $(this).data('id_lokasi'),
                lokasi: $(this).data('lokasi'),
            },
            success: function() {
                document.location.href = "<?= base_url('master/gudang'); ?>";
            }
        });
    });

    $('.sebelas').on('click', function() {
        $.ajax({
            url: "<?= base_url('master/gudang/changesubaccess'); ?>",
            type: 'post',
            data: {
                id_company: 11,
                id_lokasi: $(this).data('id_lokasi'),
                lokasi: $(this).data('lokasi'),
            },
            success: function() {
                document.location.href = "<?= base_url('master/gudang'); ?>";
            }
        });
    });

    $('.duabelas').on('click', function() {
        $.ajax({
            url: "<?= base_url('master/gudang/changesubaccess'); ?>",
            type: 'post',
            data: {
                id_company: 12,
                id_lokasi: $(this).data('id_lokasi'),
                lokasi: $(this).data('lokasi'),
            },
            success: function() {
                document.location.href = "<?= base_url('master/gudang'); ?>";
            }
        });
    });

    $('.tigabelas').on('click', function() {
        $.ajax({
            url: "<?= base_url('master/gudang/changesubaccess'); ?>",
            type: 'post',
            data: {
                id_company: 13,
                id_lokasi: $(this).data('id_lokasi'),
                lokasi: $(this).data('lokasi'),
            },
            success: function() {
                document.location.href = "<?= base_url('master/gudang'); ?>";
            }
        });
    });
</script>
<!-- End of Main Content -- >  
   