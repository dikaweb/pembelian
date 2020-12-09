<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->


    <div class="row">
        <div class="col-lg-6">

            <?= $this->session->flashdata('messagez'); ?>

            <h5>Name Group Role : <?= $role['role']; ?></h5>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Access</th>
                        <th scope="col">Sub Menu Access</th>

                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($menu as $m) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $m['menu']; ?></td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" <?= check_access($role['id'], $m['id']); ?> data-role="<?= $role['id']; ?>" data-menu="<?= $m['id']; ?>">
                                </div>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/role/rolesubaccess/') . $role['id'] . '/' . $m['id']; ?>" class="badge badge-warning">Sub Menu access</a>

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
    $('.form-check-input').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');

        $.ajax({
            url: "<?= base_url('admin/role/changeaccess'); ?>",
            type: 'post',
            data: {
                menuId: menuId,
                roleId: roleId
            },
            success: function() {
                document.location.href = "<?= base_url('admin/role/roleaccess/'); ?>" + roleId;
            }
        });

    });
</script>

<!-- End of Main Content -- >     