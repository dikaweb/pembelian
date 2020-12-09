<style type="text/css">
    .kecil {
        line-height: 14px;
    }

    td.details-control {
        background: url('<?= base_url('assets/img/open.png'); ?>') no-repeat center center;
        cursor: pointer;
    }

    tr.shown td.details-control {
        background: url('<?= base_url('assets/img/minus.png'); ?>') no-repeat center center;
    }

    .topics tr {
        line-height: 14px;
    }
</style>
<input type="hidden" name="txtjenis" id="txtjenis" value="<?= $jenis; ?>">
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="tablepilihpr" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th></th>
                    <th>Action</th>
                    <th>User</th>
                    <th>Lokasi</th>
                    <th>NO.POL / Lok</th>
                    <th>Keterangan</th>
                    <th>PT</th>
                    <th>Item</th>
                    <th>Tanggal</th>
                    <th>NO. PR</th>
                    <th>Spek Item</th>
                    <th>Ket Item</th>
                    <th>Cat Purch</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($barang as $mr) : ?>
                    <tr>
                        <td class="details-control"></td>
                        <td>
                            <button id="btnmdlpilihbarang" type="button" class="badge badge-primary" data-ketitem="<?= $mr['ketitem']; ?>" data-spesifikasi="<?= $mr['spesifikasi']; ?>" data-qty="<?= $mr['qty']; ?>" data-item="<?= $mr['item']; ?>" data-id_company="<?= $mr['id_company']; ?>" data-id_pr_d="<?= $mr['id_pr_d']; ?>" data-nopr="<?= $mr['no_permintaan']; ?>" data-tgl="<?= tgl_indo($mr['tgl']); ?>" data-user="<?= $mr['nama_lengkap']; ?>" data-ket_m="<?= $mr['ket_m']; ?>">Pilih</button>
                        </td>


                        <td>
                            <p class="kecil"><?= $mr['nama_lengkap']; ?>
                        </td>
                        <td>
                            <p class="kecil"><?= $mr['lokasi']; ?></p>
                        </td>
                        <td>
                            <p class="kecil"><?= $mr['no_pol']; ?> <?= $mr['nm_nopol']; ?></p>
                        </td>
                        <td>
                            <p class="kecil"><?= $mr['ket_m']; ?></p>
                        </td>
                        <td>
                            <p class="kecil"><?= $mr['nm_company']; ?></p>
                        </td>
                        <td>
                            <p class="kecil">
                                <?php
                                echo $mr['qty'] . ' ' . $mr['satuan'] . ' ' . $mr['item'];
                                ?>
                            </p>
                        </td>
                        <td><?= tgl_indo($mr['tgl']); ?></td>
                        <td><?= $mr['no_permintaan']; ?></td>
                        <td><?= $mr['spesifikasi']; ?></td>
                        <td><?= $mr['ketitem']; ?></td>
                        <td><?= $mr['catatan_purchasing']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    function format(d) {
        return '<center><table cellpadding="0"  cellspacing="0" border="0" style="padding-top:1000px;" width="75%" class="topics">' +
            '<tr>' +
            '<td width="25%">Tgl PR</td>' +
            '<td>' + d[8] + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>No PR</td>' +
            '<td>' + d[9] + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Spesifikasi Item</td>' +
            '<td>' + d[10] + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Keterangan Item</td>' +
            '<td>' + d[11] + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Catatan Purchasing</td>' +
            '<td>' + d[12] + '</td>' +
            '</tr>' +
            '</table><center>';
    }

    $(document).ready(function() {

        var table = $('#tablepilihpr').DataTable({
            scrollY: '50vh',
            "order": [],
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            "columnDefs": [{
                "targets": [8, 9, 10, 11, 12],
                "visible": false,
            }, ],
        });



        $(document).on('shown.bs.modal', '.modal', function() {
            $($.fn.dataTable.tables(true)).DataTable().draw();
        });


        // Add event listener for opening and closing details
        $('#tablepilihpr tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();

                tr.removeClass('shown');
            } else {
                // Open this row
                console.log(row.data());
                row.child(format(row.data())).show();

                tr.addClass('shown');
            }
        });
    });



    $('#tablepilihpr').on('click', '#btnmdlpilihbarang', function() {
        if ($('#txtjenis').val() == 'sj-pr' || $('#txtjenis').val() == 'po-pr' || $('#txtjenis').val() == 'po-edpr') {
            $('#txtIdPr_d').val($(this).data('id_pr_d'));
            $('#lblNoPr').text($(this).data('nopr'));
            $('#lblTgl').text($(this).data('tgl'));
            $('#lblUser').text($(this).data('user'));
            $('#lblKeterangan').text($(this).data('ket_m'));
            $('#lblItem').text($(this).data('item'));
            $('#lblJumlah').text($(this).data('qty'));
            $('#lblSpesifikasi').text($(this).data('spesifikasi'));
            $('#lblKetItem').text($(this).data('ketitem'));
            if ($('#txtjenis').val() == 'po-pr') {
                $('#txt_company').val($(this).data('id_company'));
                if ($(this).data('id_company') != 0) {
                    $('#txt_company').prop('disabled', 'disabled');
                } else {
                    $('#txt_company').removeAttr('disabled');
                }
            }
        }
        if ($('#txtjenis').val() == 'po-pnw' || $('#txtjenis').val() == 'po-edpnw' || $('#txtjenis').val() == 'sj-pnw') {
            $('#txtIdPr_d1').val($(this).data('id_pr_d'));
            $('#lblNoPr1').text($(this).data('nopr'));
            $('#lblTgl1').text($(this).data('tgl'));
            $('#lblUser1').text($(this).data('user'));
            $('#lblKeterangan1').text($(this).data('ket_m'));
            $('#lblItem1').text($(this).data('item'));
            $('#lblJumlah1').text($(this).data('qty'));
            $('#lblSpesifikasi1').text($(this).data('spesifikasi'));
            $('#lblKetItem1').text($(this).data('ketitem'));
            if ($('#txtjenis').val() == 'po-pnw') {
                $('#txt_company').val($(this).data('id_company'));
                if ($(this).data('id_company') != 0) {
                    $('#txt_company').prop('disabled', 'disabled');
                } else {
                    $('#txt_company').removeAttr('disabled');
                }
            }
            if ($('#txtjenis').val() != 'sj-pnw') {
                $('#listpenawaran-area').load("<?= base_url('trans/po/listpenawaran/'); ?>" + $(this).data('id_pr_d'));
            }
        }



        $('#prModal').modal('toggle');
    });
</script>