BEGIN
DECLARE vis_ada_stock,vid_sat_m_barang,vid_sat_terakhir,vid_po integer;
DECLARE vkonversi_satuan,vqty,vtotal,vgrandtotal,vppnrp,vnilai_pph decimal(16,4);
DECLARE vjml_stock,vid_sat_konv_terakhir,vid_ppn_pph integer;
DECLARE vid_gudang_sup,vid_sat_po,vid_sat_terkecil integer;
DECLARE vjml_po, vjml_dt_konv_terkecil decimal(16,4);
DECLARE vtotal_qty,vtotal_qty_terambil decimal(16,4);

select id_satuan into vid_sat_terkecil from m_barang where id_barang = old.id_barang; 
select konversi_satuan(old.ID_BARANG,old.ID_SATUAN) into vkonversi_satuan;

-- AMBIL id_gudang supplier di po--
select id_transaksi,id_gudang,id_satuan,jumlah,jml_dt_konv_terkecil,id_sat_konv_terakhir into vid_po,vid_gudang_sup,vid_sat_po,vjml_po,vjml_dt_konv_terkecil,vid_sat_konv_terakhir from trans_po_d where id_detail = old.id_po_d;


if (old.jenis='PO') then

-- AMBIL QTY STOCK LAMA DIGUDANG SUPPLIER--
select konversi_satuan(old.id_barang,id_sat_terakhir) * qty into vqty from trans_stock where id_gudang = vid_gudang_sup and ID_BARANG = old.ID_BARANG;

-- tambahkan stock di DIGUDANG SUPPLIER--
set vjml_stock = vqty + (vkonversi_satuan*old.jumlah);
UPDATE trans_stock SET qty =vjml_stock,id_sat_terakhir = vid_sat_terkecil WHERE ID_GUDANG = vid_gudang_sup AND ID_BARANG = old.ID_BARANG;
-- telah selesai urusan gudang supplier --

-- cek apakah ada di table stock -- 
select count(id_gudang) into vis_ada_stock from trans_stock WHERE ID_GUDANG = old.ID_GUDANG AND ID_BARANG = old.ID_BARANG;

-- INSERT ROW BARU JIKA MASIH BELUM ADA --
if (vis_ada_stock =0) then
insert into trans_stock (id_barang,id_gudang,id_sat_terakhir)values(old.ID_BARANG,old.ID_GUDANG,vid_sat_terkecil);
end if;

-- AMBIL QTY STOCK LAMA dan kurangkan--
select konversi_satuan(old.id_barang,id_sat_terakhir) * qty into vqty from trans_stock WHERE ID_GUDANG = old.ID_GUDANG AND ID_BARANG = old.ID_BARANG;

set vjml_stock = vqty - (vkonversi_satuan*old.jumlah);

UPDATE trans_stock SET qty =vjml_stock,id_sat_terakhir = vid_sat_terkecil WHERE ID_GUDANG = old.ID_GUDANG AND ID_BARANG = old.ID_BARANG;
end if;
-- UPDATE PO --

UPDATE trans_po_d set id_sat_konv_terakhir = vid_sat_terkecil, jml_konv_terkecil = konversi_satuan(old.id_barang,vid_sat_po) * vjml_po,jml_dt_konv_terkecil =  (konversi_satuan(old.ID_BARANG,vid_sat_konv_terakhir) * vjml_dt_konv_terkecil)  - (konversi_satuan(old.ID_BARANG,old.ID_SATUAN)*old.jumlah) where id_detail = old.id_po_d;

select sum(jml_konv_terkecil),sum(jml_dt_konv_terkecil) 
               into vtotal_qty,vtotal_qty_terambil
               from trans_po_d
              where id_transaksi = vid_po;
if (vtotal_qty_terambil = 0.00) then 
             update trans_po 
                set status=3
              where id_transaksi=vid_po;
end if;
if (vtotal_qty_terambil >= vtotal_qty) then 
             update trans_po 
                set status=5
              where id_transaksi=vid_po;
end if;
if (vtotal_qty_terambil > 0) and (vtotal_qty_terambil < vtotal_qty) then 
             update trans_po
                set status=4
              where id_transaksi=vid_po;
end if;


-- AMBIL dari data bpb--
select id_ppn_pph,nilai_pph into vid_ppn_pph,vnilai_pph from trans_bpb where id_bpb = old.id_bpb;


-- UPDATE BPB --
select sum(total) into vtotal from trans_bpb_d where id_bpb = old.id_bpb ;
if (vid_ppn_pph=2) then
set vppnrp = ((vtotal * vnilai_pph) / 100);
set vgrandtotal = vtotal + vppnrp;

ELSEIF (vid_ppn_pph=1) then
set vppnrp = ((100/(100+vnilai_pph)) * vtotal);
set vgrandtotal = vtotal ;
set vtotal = vtotal - vppnrp;

ELSEIF (vid_ppn_pph=3) then
set vppnrp = 0;
set vgrandtotal = vtotal ;
end if;


UPDATE trans_bpb SET total = vtotal,ppnrp = vppnrp,grandtotal = vgrandtotal  where id_bpb = old.id_bpb ;
END