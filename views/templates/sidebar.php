        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="background:-webkit-linear-gradient(top,#2c0e35 0%,#8f2caa 75%);">
            <!-- Sidebar - Brand -->



            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- QUERY MENU -->
            <?php
            $role_id = $this->session->userdata('role_idz');
            $queryMenu = "SELECT `user_menu`.`id`, `menu`
                            FROM `user_menu` JOIN `user_access_menu`
                              ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                           WHERE `user_access_menu`.`role_id` = $role_id
                        ORDER BY `user_menu`.`no_urut` ASC
                        ";


            $queryMenu = "SELECT a.id, menu
            FROM user_menu a JOIN user_access_menu b
              ON a.id = b.menu_id
           WHERE b.role_id = $role_id
        ORDER BY a.no_urut ASC
        ";

            $menu = $this->db->query($queryMenu)->result_array();
            ?>


            <!-- LOOPING MENU -->
            <?php foreach ($menu as $m) : ?>
                <div class="sidebar-heading">
                    <?= $m['menu']; ?>
                </div>

                <!-- SIAPKAN SUB-MENU SESUAI MENU -->
                <?php
                $menuId = $m['id'];
                $querySubMenu = "SELECT *
                               FROM `user_sub_menu` JOIN `user_menu` 
                                 ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                                 JOIN `user_access_menu`
                                 ON `user_sub_menu`.`id` = `user_access_menu`.`sub_menu_id`
                              WHERE `user_sub_menu`.`menu_id` = $menuId 
                                AND `user_sub_menu`.`is_active` = 1 group by `user_sub_menu`.`id`
                                ORDER BY `user_sub_menu`.`no_urut` ASC
                        ";




                $querySubMenu = "SELECT *
                               FROM user_sub_menu a 
                                JOIN user_menu b ON a.menu_id = b.id
                                 JOIN user_access_menu c ON a.id = c.sub_menu_id
                              WHERE a.menu_id = $menuId AND c.role_id =$role_id and
                              a.is_active = 1 
                              group by a.id
                                ORDER BY a.no_urut ASC
                        ";
                $subMenu = $this->db->query($querySubMenu)->result_array();
                ?>

                <?php foreach ($subMenu as $sm) : ?>
                    <?php if ($title == $sm['title']) : ?>
                        <li class="nav-item active">
                        <?php else : ?>
                        <li class="nav-item">
                        <?php endif; ?>
                        <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
                            <i class="<?= $sm['icon']; ?>"></i>
                            <span><?= $sm['title']; ?>
                                <?php

                                //echo  $sm['sub_menu_id'];

                                if ($sm['sub_menu_id'] == 62) :

                                    $c = $this->db->query("
                                    select * from permintaan_barang a
                                    inner join permintaan_barang_proses g on a.id = g.permintaan_barang_id
                                    where g.status ='submitted' and
                                    (select sum(is_penawaran) from permintaan_barang_detail where permintaan_barang_id = a.id) > 0
                                    and ((select count(is_penawaran) from permintaan_barang_detail where permintaan_barang_id = a.id) <> (select sum(is_po) from permintaan_barang_detail where permintaan_barang_id = a.id)) 
                                    ")->num_rows();

                                    if ($c <> 0) :
                                        echo "(";
                                        echo $c;
                                        echo ")";
                                    endif;
                                endif;


                                if ($sm['sub_menu_id'] == 63) :

                                    $c = $this->db->query('select * from trans_po where status <> 5 and is_voucher <> 1 ')->num_rows();

                                    if ($c <> 0) :
                                        echo "(";
                                        echo $c;
                                        echo ")";
                                    endif;
                                endif;

                                if ($sm['sub_menu_id'] == 52) :
                                    $awal = $user['awal'];
                                    $akhir = $user['akhir'];
                                    $c = $this->db->query(" select a.id_transaksi
                                    ,(sum(f.jumlah*f.harga) * (nilai_pph/100)) + sum(f.jumlah*f.harga) as tt
                                    from trans_po a
                                    left join trans_po_d f on a.id_transaksi = f.id_transaksi
                                    where a.status = 2
                                    group by a.id_transaksi
                                    having tt between $awal and $akhir")->num_rows();

                                    if ($c <> 0) :
                                        echo "(";
                                        echo $c;
                                        echo ")";
                                    endif;
                                endif;
                                ?>



                            </span></a>
                        </li>
                    <?php endforeach; ?>
                    <hr class="sidebar-divider mt-3">
                <?php endforeach; ?>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
                        <i class="fas fa-fw fa-sign-out-alt"></i>
                        <span>Logout</span></a>
                </li>
                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>

        </ul>
        <!-- End  of Sidebar -->

        <!-- ------------------------------Modal Loading ------------------------------------------>
        <div class="modal fade" id="load2Me" tabindex="-1" role="dialog" aria-labelledby="load2MeLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="load2er"></div>
                        <div clas="load2er-txt">
                            <p>Proses sedang berjalan. <br><br><small>Mohon tunggu</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script type="text/javascript">
        </script>