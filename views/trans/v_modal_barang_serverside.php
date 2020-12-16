<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="modalpilihbarang" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Actions</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th>Kelompok</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-info" onclick="tambahbarangbaru()">Tambah Barang</button>
    </div>
</div>

<script type="text/javascript">
    //datatables
    table = $('#modalpilihbarang').DataTable({

        "processing": true,
        "serverSide": true,
        "order": [],
        scrollY: '50vh',
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        "ajax": {
            "url": "<?php echo site_url('trans/po/get_data_barang') ?>",
            "type": "POST"
        },


        "columnDefs": [{
            "targets": [0],
            "orderable": false,
        }, ],

    });




    $(document).on('shown.bs.modal', '.modal', function() {
        $($.fn.dataTable.tables(true)).DataTable().draw();
    });

    $('#modalpilihbarang').on('click', '#btnmdlpilihbarang', function() {
        $('#lblnm_barang').text($(this).data('nm'));
        $('#txtid_barang').val($(this).data('id'));
        $('#satuan-area').load("<?= base_url('no_logged/pilihsatuan/'); ?>" + $(this).data('id'));
    });

    function tambahbarangbaru() {
        $("#btnsimpanbarang").html("Simpan");
        $("#barangModalTittle").html("Tambah barang");
        $("#btnsimpanbarang").attr("class", "btn btn-info  col-sm-2 mt-1 btn-sm");
        $("#btnsimpanbarang").attr("onclick", "simpanbarang()");
        $('#nm_barang').val("");
        $('#kd_barang').val("");
        $('#kelompok').val("");
        $('#satuan').val(1);
        $("#barangModal").modal("hide");
        $('#addbarangModal').modal();
    }
</script>