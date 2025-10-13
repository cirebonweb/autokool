DELIMITER $$

CREATE TRIGGER trg_update_data_total
AFTER INSERT ON sp_invoice_isi
FOR EACH ROW
BEGIN
  UPDATE sp_invoice_data
  SET total = (
    SELECT IFNULL(SUM(total), 0)
    FROM sp_invoice_isi
    WHERE invoice_data_id = NEW.invoice_data_id
  )
  WHERE id = NEW.invoice_data_id;
END$$

CREATE TRIGGER trg_update_data_total_on_update
AFTER UPDATE ON sp_invoice_isi
FOR EACH ROW
BEGIN
  IF OLD.invoice_data_id != NEW.invoice_data_id THEN
    UPDATE sp_invoice_data
    SET total = (
      SELECT IFNULL(SUM(total), 0)
      FROM sp_invoice_isi
      WHERE invoice_data_id = OLD.invoice_data_id
    )
    WHERE id = OLD.invoice_data_id;
  END IF;

  UPDATE sp_invoice_data
  SET total = (
    SELECT IFNULL(SUM(total), 0)
    FROM sp_invoice_isi
    WHERE invoice_data_id = NEW.invoice_data_id
  )
  WHERE id = NEW.invoice_data_id;
END$$

CREATE TRIGGER trg_update_data_total_on_delete
AFTER DELETE ON sp_invoice_isi
FOR EACH ROW
BEGIN
  UPDATE sp_invoice_data
  SET total = (
    SELECT IFNULL(SUM(total), 0)
    FROM sp_invoice_isi
    WHERE invoice_data_id = OLD.invoice_data_id
  )
  WHERE id = OLD.invoice_data_id;
END$$

DELIMITER ;