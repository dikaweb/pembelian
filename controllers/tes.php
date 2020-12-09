   from to
   1 container = 10 dos
   1 dos = 20 pack
   1 pack = 12 pcs

   select * from m_satuan_konversi where id_brg = 10
   loop
   select * from m_satuan_konversi where id_brg = 10 and from = vloop_to





   BEGIN
   DECLARE vis_ada_stock,vid_sat_m_barang,vid_sat_terakhir integer;
   DECLARE vkonversi_satuan integer;
   DECLARE vqty integer;
   DECLARE vjml_stock,vid_sat_konv_terakhir integer;
   DECLARE vid_gudang_sup,vid_sat_po,vid_sat_terkecil integer;
   DECLARE vjml_po, vjml_dt_konv_terkecil decimal;

   select id_satuan into vid_sat_terkecil from m_barang where id_barang = old.id_barang;
   select konversi_satuan(old.ID_BARANG,old.ID_SATUAN) into vkonversi_satuan;

   -- AMBIL id_gudang supplier di po--
   select id_gudang,id_satuan,jumlah,jml_dt_konv_terkecil,id_sat_konv_terakhir into vid_gudang_sup,vid_sat_po,vjml_po,vjml_dt_konv_terkecil,vid_sat_konv_terakhir from trans_po_d where id_detail = old.id_po_d;

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

   set vjml_stock = (vkonversi_satuan*old.jumlah) - vqty;

   UPDATE trans_stock SET qty =vjml_stock,id_sat_terakhir = vid_sat_terkecil WHERE ID_GUDANG = old.ID_GUDANG AND ID_BARANG = old.ID_BARANG;