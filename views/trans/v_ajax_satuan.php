<select class="form-control-sm " name="txtid_satuan" id="txtid_satuan" required="required">
    <option></option>
    <?php foreach ($m_satuan as $mc) : ?>
        <option value="<?= $mc['id_satuan']; ?>"><?= $mc['nm_satuan']; ?>
            <?php if ($jenis == 1) {
                $menuId = $mc['id_satuan'];
                $id_barang = $mc['id_barang'];
                $querySubMenu = "SELECT * from m_satuan_konversi a inner join m_satuan b on a.to_satuan = b.id_satuan where from_satuan = $menuId and id_barang = $id_barang";
                $jika = $this->db->query($querySubMenu)->num_rows();
                if ($jika > 0) {
                    $subMenu = $this->db->query($querySubMenu)->row_array();
                    echo " ( 1 " . $mc['nm_satuan'] . " = " . rp($subMenu['nilai']) . " " . $subMenu['nm_satuan'] . " )";
                }
            };
            ?>
        </option>
    <?php endforeach; ?>
</select>