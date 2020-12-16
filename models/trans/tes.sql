BEGIN
DECLARE vid_ppn_pph integer;
DECLARE vppnrp, vtotal,vnilai_pph,vgrandtotal decimal(16,4);

-- naikkan status pr --

update permintaan_barang_detail set is_po = 1 where id = new.id_reff;

-- AMBIL dari data PO--
select id_ppn_pph,nilai_pph into vid_ppn_pph,vnilai_pph from trans_po where id_transaksi = new.id_transaksi;


-- UPDATE BPB --
select sum(total) into vtotal from trans_po_d where id_transaksi = new.id_transaksi ;
if (new.id_ppn_pph=2) then
set vppnrp = ((vtotal * vnilai_pph) / 100);
set vgrandtotal = vtotal + vppnrp;

ELSEIF (new.id_ppn_pphh=1) then
set vgrandtotal = vtotal ;
set vtotal = ((100/(100+vnilai_pph)) * vtotal);
set vppnrp = vgrandtotal - vtotal;

ELSEIF (new.id_ppn_pphh=3) then
set vppnrp = 0;
set vgrandtotal = vtotal ;
end if;

UPDATE trans_po SET total = vtotal,ppnrp = vppnrp,grandtotal = vgrandtotal  where id_transaksi = new.id_transaksi ;


end