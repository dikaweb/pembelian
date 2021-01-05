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
$html .= '
<table cellspacing="0" width="100%" cellpadding="0" border="0">
  <tr>
  
    <td><div align="center"><img src="/assets/img/logo/' . $master['kode_c'] . '.png"></div></td>
  </tr>
  <tr>
    <td><div align="center"><font size="14"><strong>' . $master['nm_company'] . '
    </strong></font><br><hr height="3" /></div></td>
  
  <td><br></td>
    </tr>
</table>

<table cellspacing="0" width="100%" cellpadding="0" border="0">
  <tr height="25">
    <td colspan="3" ><div align="center"><font size="12"><strong>BERITA ACARA<br></strong></font></div></td>
  </tr>

  <tr height="20" >
    <td width="15%">Tanggal</td>
    <td width="2%">:</td>
    <td width=""><font size="12" ><strong>' . tgl_indo($master['tanggal']) . '</strong></font></td>
  </tr>
  
  <tr height="20">
    <td>No. </td>
    <td>:</td>
    <td colspan="2"><font size="12"><strong>' . $master['no_bpb'] . '</strong></font></td>
  </tr>
  <tr height="20">
    <td>Supplier</td>
    <td>:</td>
    <td>' . $master['nm_supplier']  . '</td>
  </tr>
  <tr height="20">
    <td></td>
    <td>:</td>
    <td>' . $master['alamat_sp']  . '</td>
  </tr>
  <!--
  <tr height="20">
    <td>UP</td>
    <td>:</td>
    <td>' . $master['up_sp'] . '</td>
  </tr>
 
  <tr height="20">
    <td>Fax</td>
    <td>:</td>
    <td>' . $master['fax'] . '</td>
  </tr>
 
  <tr height="20">
    <td>Note</td>
    <td>:</td>
    <td>' . $master['note_po'] . '</td>
  </tr>
  -->
</table>

<br>
<br>
<table cellspacing="0" width="100%" cellpadding="0" border="0"> 
  <tr >
  <td  ><div ><font size="11">Bersama ini kami sampaikan Berita Acara sebagai kelengkapan surat jalan atas barang yang diterima <br></font></div></td>
</tr>
</table>
<br>
<br>

<table border="1" cell cellpadding="2" >
						<tr bgcolor="#ffffff" >
						
							<th width="5%" align="center">No</th>
							<th width="70%" align="center">Nama Barang</th>
							<th width="10%" align="center">Qty</th>
							<th width="15%" align="center">Satuan</th>
							
            </tr>';
$i = 1;

foreach ($detail as $row) {

  $html .= '<tr bgcolor="#ffffff">
							
							<td align="center">' . $i . '</td>
							<td>' . $row['nm_barang'] . '</td>
							<td align="center">' . rupiah($row['jumlah']) . '</td>
							<td align="center">' . $row['nm_satuan'] . '</td>
						
            </tr>';
  $i++;
}
$html .= '
<tr bgcolor="#ffffff" >
						
							<th align="center"></th>
							<th >' . $master['keterangan'] . '</th>
							<th align="center"></th>
							<th align="center"></th>
						
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
    <td colspan="3" width="260">Penerima<br><br><br><br><br><br><br><u>' . $master['nama_lengkap'] . '</u></td>
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
