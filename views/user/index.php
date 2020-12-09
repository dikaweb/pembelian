<!-- Begin Page Content -->


<div class="container-fluid">

    <!-- Page Heading -->

    <div class="row">
        <div class="col-lg">
            <?= $this->session->flashdata('messagez'); ?>

        </div>
    </div>

    <div class="card mb-3 col-lg-8">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="card-img">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= $user['nama_lengkap']; ?></h5>
                    <p class="card-text">User ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?= $user['username']; ?></p>
                    <p class="card-text">Lokasi&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?= $user2['lokasi']; ?></p>
                    <p class="card-text">Role &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?= $user2['role']; ?></p>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->