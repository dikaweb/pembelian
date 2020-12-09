<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg">
            <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= $this->session->flashdata('messagez'); ?>

            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">Tambah</a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Kota</th>
                        <th scope="col">Kode</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($menu as $m) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $m['nm_company']; ?></td>
                            <td><?= $m['jalan_c']; ?></td>
                            <td><?= $m['kota_c']; ?></td>
                            <td><?= $m['kode_c']; ?></td>
                            <td>
                                <a href="" data-toggle="modal" data-target="#editMenuModal" data-kode="<?= $m['kode_c']; ?>" data-kota="<?= $m['kota_c']; ?>" data-alamat="<?= $m['jalan_c']; ?>" data-id="<?= $m['id_company']; ?>" data-nama="<?= $m['nm_company']; ?>" class="badge badge-success clastombolubah">edit</a>
                                <a href="" data-toggle="modal" data-target="#deleteMenuModal" data-nama="<?= $m['nm_company']; ?>" data-id="<?= $m['id_company']; ?>" class="badge badge-danger clastomboldelete">delete</a>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>


        </div>
    </div>



</div>

<!-- Modal tambah -->
<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Tambah Company baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/company/save'); ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-2">
                            Nama
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="namat" name="namat" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Alamat
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="alamatt" name="alamatt" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Kota
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="kotat" name="kotat" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Kode
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="kodet" name="kodet" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!---------------------------------------------- Modal Delete -------------------------------->
<div class="modal fade" id="deleteMenuModal" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMenuModalLabel">Delete sales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/company/delete'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="idd" id="idd">
                    <div class="form-group">
                        <input type="text" class="form-control" id="namad" name="namad">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!----------------------------------------------------- Modal Edit  --------------------------------->
<div class="modal fade" id="editMenuModal" tabindex="-1" role="dialog" aria-labelledby="editMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMenuModalLabel">Edit company</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/company/edit'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="id" id="id">
                    <div class="row">
                        <div class="col-sm-2">
                            Nama
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="nama" name="nama" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Alamat
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="alamat" name="alamat" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Kota
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="kota" name="kota" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            Kode
                        </div>
                        <div class="col-sm">
                            <input type="text" class="form-control sm" id="kode" name="kode" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('.clastombolubah').on('click', function() {
            const id = $(this).data('id');
            $('#id').val($(this).data('id'));
            $('#nama').val($(this).data('nama'));
            $('#alamat').val($(this).data('alamat'));
            $('#kota').val($(this).data('kota'));
            $('#kode').val($(this).data('kode'));
        });

        $('.clastomboldelete').on('click', function() {
            const id = $(this).data('id');
            $('#idd').val($(this).data('id'));
            $('#namad').val($(this).data('nama'));
        });
    });
</script>