BEGIN
DECLARE vid INTEGER;
DECLARE vdate character(20);

b1:begin
DECLARE done INT DEFAULT FALSE;

DECLARE cur2 CURSOR FOR select id,date_time from permintaan_barangx;
DECLARE continue HANDLER FOR NOT FOUND SET done = TRUE;


OPEN cur2;

read_loop: LOOP
    FETCH cur2 INTO vid,vdate ;
    IF done THEN
      CLOSE cur2;
      LEAVE read_loop;
    END IF;
   update permintaan_barang set date_time = vdate where id  = vid;
	
END LOOP read_loop;
end b1;

end