<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->


    <div class="row">
        <div class="col-lg-6">

            <?= $this->session->flashdata('messagez'); ?>

            <h5>Group Role : <?= $role['role']; ?>, Parent Menu : <?= $menu['menu']; ?></h5>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Sub Menu</th>
                        <th scope="col">Access</th>
                        <th scope="col">Is Read Only? (tidak digunakan)</th>
                        <th scope="col">View all user?(admin)</th>
                        <th scope="col">View all department at his group location? (manager)</th>
                        <th scope="col">View all department?(approve)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($submenu as $s) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $s['title']; ?></td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input satu" type="checkbox" <?= check_sub_access($role['id'], $s['id']); ?> data-role="<?= $role['id']; ?>" data-submenu="<?= $s['id']; ?>" data-menu="<?= $menu['id']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input dua" type="checkbox" <?= check_read_only($role['id'], $s['id']); ?> data-role="<?= $role['id']; ?>" data-submenu="<?= $s['id']; ?>" data-menu="<?= $menu['id']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input tiga" type="checkbox" <?= check_view_all($role['id'], $s['id']); ?> data-role="<?= $role['id']; ?>" data-submenu="<?= $s['id']; ?>" data-menu="<?= $menu['id']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input empat" type="checkbox" <?= check_view_all_lokasi($role['id'], $s['id']); ?> data-role="<?= $role['id']; ?>" data-submenu="<?= $s['id']; ?>" data-menu="<?= $menu['id']; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input lima" type="checkbox" <?= check_view_all_dept($role['id'], $s['id']); ?> data-role="<?= $role['id']; ?>" data-submenu="<?= $s['id']; ?>" data-menu="<?= $menu['id']; ?>">
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
        const submenuId = $(this).data('submenu');
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');
        $.ajax({
            url: "<?= base_url('admin/role/changesubaccess'); ?>",
            type: 'post',
            data: {
                submenuId: submenuId,
                roleId: roleId
            },
            success: function() {
                document.location.href = "<?= base_url('admin/role/rolesubaccess/'); ?>" + roleId + "/" + menuId;
            }
        });

    });

    $('.dua').on('click', function() {
        const submenuId = $(this).data('submenu');
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');
        $.ajax({
            url: "<?= base_url('admin/role/changereadonly'); ?>",
            type: 'post',
            data: {
                submenuId: submenuId,
                roleId: roleId
            },
            success: function() {
                document.location.href = "<?= base_url('admin/role/rolesubaccess/'); ?>" + roleId + "/" + menuId;
            }
        });

    });
    $('.tiga').on('click', function() {
        const submenuId = $(this).data('submenu');
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');
        $.ajax({
            url: "<?= base_url('admin/role/changeviewall'); ?>",
            type: 'post',
            data: {
                submenuId: submenuId,
                roleId: roleId
            },
            success: function() {
                document.location.href = "<?= base_url('admin/role/rolesubaccess/'); ?>" + roleId + "/" + menuId;
            }
        });

    });
    $('.empat').on('click', function() {
        const submenuId = $(this).data('submenu');
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');
        $.ajax({
            url: "<?= base_url('admin/role/changeviewalllokasi'); ?>",
            type: 'post',
            data: {
                submenuId: submenuId,
                roleId: roleId
            },
            success: function() {
                document.location.href = "<?= base_url('admin/role/rolesubaccess/'); ?>" + roleId + "/" + menuId;
            }
        });

    });
    $('.lima').on('click', function() {
        const submenuId = $(this).data('submenu');
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');
        $.ajax({
            url: "<?= base_url('admin/role/changeviewalldept'); ?>",
            type: 'post',
            data: {
                submenuId: submenuId,
                roleId: roleId
            },
            success: function() {
                document.location.href = "<?= base_url('admin/role/rolesubaccess/'); ?>" + roleId + "/" + menuId;
            }
        });

    });
</script>
<!-- End of Main Content -- >  
   