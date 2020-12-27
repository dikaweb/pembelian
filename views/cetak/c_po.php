<?php
$pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetTitle('Nota Konfirmasi');
$pdf->SetHeaderMargin(0);
$pdf->SetTopMargin(0);
$pdf->setFooterMargin(0);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Author');
$pdf->SetDisplayMode('real', 'default');
$pdf->SetMargins(10, 5, 10, true);
$pdf->SetFont('helvetica', '', 11, '', 'default', true);

$pdf->AddPage();
$html = '';
if ($master['status'] < 3 or $master['status'] == 9) {

  $html = '<table cellspacing="0" width="100%" cellpadding="0" border="0">
  <tr>
    <td><div align="center"><img src="/assets/img/example.jpg">
    </div></td>
  </tr>
</table>';
}
$html .= '



<table cellspacing="0" width="100%" cellpadding="0" border="0">
  <tr>
  
    <td><div align="center"><img src="/assets/img/logo/' . $master['kode_c'] . '.png"></div></td>
  </tr>
  <tr>
    <td><div align="center"><font size="14"><strong>' . $master['nm_company'] . '
    </strong></font><br><hr height="3" /></div></td>
  
  <td><br><br><br><br><br><br><br><br><br><br></td>
    </tr>
</table>

<table cellspacing="0" width="100%" cellpadding="0" border="0">
  <tr height="25">
    <td colspan="3" ><div align="center"><font size="12"><strong>' . $judul . ' <br><br><br></strong></font></div></td>
  </tr>
  
  <tr height="20" >
    <td width="15%">Tanggal</td>
    <td width="2%">:</td>
    <td width=""><font size="12" ><strong>' . tgl_indo($master['tanggal']) . '</strong></font></td>
  </tr>
  <tr height="20">
    <td>No. PO</td>
    <td>:</td>
    <td colspan="2"><font size="12"><strong>' . $master['no_transaksi'] . '</strong></font></td>
  </tr>
  <tr height="20">
    <td>Kepada Yth</td>
    <td>:</td>
    <td>' . $master['nm_supplier']  . '</td>
  </tr>
  <tr height="20">
    <td></td>
    <td>:</td>
    <td>' . $master['alamat_sp']  . '</td>
  </tr>
  <tr height="20">
    <td>UP</td>
    <td>:</td>
    <td>' . $master['up_sp'] . '</td>
  </tr>
  <!--
  <tr height="20">
    <td>Fax</td>
    <td>:</td>
    <td>' . $master['fax'] . '</td>
  </tr>
  -->
  <tr height="20">
    <td>Note</td>
    <td>:</td>
    <td>' . $master['note_po'] . '</td>
  </tr>
</table>

<br>
<br>

<table border="1" cell cellpadding="2" >
						<tr bgcolor="#ffffff" >
						
							<th width="5%" align="center">No</th>
							<th width="40%" align="center">Nama Barang</th>
							<th width="10%" align="center">Qty</th>
							<th width="15%" align="center">Satuan</th>
							<th width="15%" align="center">Harga</th>
							<th width="15%" align="center">Jumlah</th>
            </tr>';
$i = 1;
$tampil_jml = 0;
foreach ($detail as $row) {

  $html .= '<tr bgcolor="#ffffff">
							
							<td align="center">' . $i . '</td>
							<td>' . $row['nm_barang'] . '</td>
							<td align="center">' . rupiah($row['jumlah']) . '</td>
							<td align="center">' . $row['nm_satuan'] . '</td>
							<td align="right">' . rupiah($row['harga']) . '</td>
              <td align="right" >' . rupiah($row['harga'] * $row['jumlah']) . '</td>
            </tr>';
  $i++;
  $tampil_jml = $tampil_jml + ($row['jumlah'] * $row['harga']);
}
$html .= '
<tr bgcolor="#ffffff" >
						
							<th align="center"></th>
							<th >' . $master['keterangan'] . '</th>
							<th align="center"></th>
							<th align="center"></th>
							<th align="center"></th>
							<th align="center"></th>
            </tr>

</table>

<table border = "0"  width="95%" cell cellpadding="0" >
  <tr>
    <td width="66.47%">
      <table border="0" cell cellpadding="0">
        <tr >
        <td height="30" width="18%"></td>
        <td width="84.7%"></td>
        </tr>
        <tr>
        <td colspan="2"></td>
        </tr>
      </table>
    </td>
    <td>
      <table border="0" cell cellpadding="1">
        <tr>
          <td  align="right" width="45.77%">';
if ($jenis == 'po') {
  if ($master['id_ppn_pph'] == 1) {
    $dpptampil = number_format((100 / 110) * $tampil_jml, 2, ",", ".");
  } else if ($master['id_ppn_pph'] == 2) {
    $dpptampil = number_format($tampil_jml, 2, ",", ".");
  } else if ($master['id_ppn_pph'] == 3) {
    $dpptampil = 0;
  }
  $html .= '
          <br>Total sebelum PPN :
          <br>PPN 10 % :';
} else {
  if ($master['id_ppn_pph'] == 1) {
    $dpptampil = number_format((100 / 110) * $tampil_jml, 2, ",", ".");
  } else if ($master['id_ppn_pph'] == 2) {
    $dpptampil = number_format($tampil_jml, 2, ",", ".");
  } else if ($master['id_ppn_pph'] == 3) {
    $dpptampil = 0;
  }
  $html .= '
  <br>Total sebelum PPH :
  <br>PPH ' . $master['nilai_pph'] . ' % :';
}
$html .= '<br>Total :
          </td>
          <td align="right"  width="31.43%">' . $dpptampil;
if ($master['id_ppn_pph'] == 1) {
  if ($jenis == 'po') {
    $pajak = number_format((($tampil_jml / 1.1) * 10) / 100, 2, ",", ".");
    $total_ppn = $tampil_jml;
  } else {
    $total_ppn = $tampil_jml;
    $pajak = number_format(($tampil_jml * (10 / ($master['nilai_pph'] + 100))), 2, ",", ".");
  }
} else if ($master['id_ppn_pph'] == 2) {
  $dpp = $tampil_jml;
  if ($jenis == 'po') {
    $pajak = number_format(($tampil_jml * 10) / 100, 2, ",", ".");
    $pjk = ($tampil_jml * 10) / 100;
  } else {
    $pajak = number_format(($tampil_jml *  $master['nilai_pph']) / 100, 2, ",", ".");
    $pjk = ($tampil_jml *  $master['nilai_pph']) / 100;
  }
  $total_ppn = $dpp + $pjk;
} else {
  $pajak = 0;
  $total_ppn = $tampil_jml;
}
$html .= '<br>' . $pajak . '<br>' . number_format($total_ppn, 2, ",", ".");
$html .= '          </td>
	      </tr>
    
      </table>
    </td>
  </tr>          
</table>




<br>';
$pdf->writeHTML($html, true, false, true, false, '');
//$txt =  $master['keterangan'];
$txt2 =  $master['keterangan2'];
//$pdf->TextField('address', 60, 28, array('multiline' => true, 'lineWidth' => 0, 'borderStyle' => 'none'), array('v' => $txt));
$pdf->TextField('address', 140, 28, array('multiline' => true, 'lineWidth' => 0, 'borderStyle' => 'none'), array('v' => $txt2));
$pdf->SetFont('helvetica', '', 10, '', 'default', true);

$html2 = '

<table border="0" cellspacing="0" cellpadding="0">
   <tr height="20">
    <td width="20%">             
    
    </td>
    <td colspan="3" width="260"><br><br><br><br><br><br><br><u>Robbyanto Lukito</u><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Direktur</td>
  </tr>
  <tr height="20">
    <td height="30"></td>
   
    <td></td>
  </tr>
  <tr height="20">
    <td></td>
    <td colspan="3"></td>
  </tr>
</table>

';

$pdf->writeHTML($html2, true, false, true, false, '');



$pdf->Output('Print Konfirmasi.pdf', 'I');
