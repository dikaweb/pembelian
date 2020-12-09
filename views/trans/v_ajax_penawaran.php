<?php foreach ($m_penawaran as $mc) : ?>
    <a href="#" class="badge badge-warning clastombolemail" data-nm_file="<?= $mc['nm_file']; ?>" data-toggle="modal" data-target="#emailMenuModal">
        <?= $mc['nm_supplier']; ?></a> <br>
<?php endforeach; ?>

<script type="text/javascript">
    $('.clastombolemail').on('click', function() {
        $path = "<?= base_url('assets/penawaran/'); ?>" + $(this).data('nm_file');
        var parent = $('embed#pdfscan').parent();
        var newImage = "<embed id=\"pdfscan\" src=\"" + $path + "\" type=\"image/jpeg\"  width=\"100%\" />";
        var newElement = $(newImage);
        $('embed#pdfscan').remove();
        parent.append(newElement);

    });
</script>