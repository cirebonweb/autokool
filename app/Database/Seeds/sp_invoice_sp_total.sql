DELIMITER $$

CREATE TRIGGER trg_update_sp_total
AFTER INSERT ON sp_invoice_isi
FOR EACH ROW
BEGIN
  UPDATE sp_invoice_sp
  SET total = (
    SELECT IFNULL(SUM(total), 0)
    FROM sp_invoice_isi
    WHERE invoice_sp_id = NEW.invoice_sp_id
  )
  WHERE id = NEW.invoice_sp_id;
END$$

CREATE TRIGGER trg_update_sp_total_on_update
AFTER UPDATE ON sp_invoice_isi
FOR EACH ROW
BEGIN
  -- Update old sp if invoice_sp_id changed
  IF OLD.invoice_sp_id != NEW.invoice_sp_id THEN
    UPDATE sp_invoice_sp
    SET total = (
      SELECT IFNULL(SUM(total), 0)
      FROM sp_invoice_isi
      WHERE invoice_sp_id = OLD.invoice_sp_id
    )
    WHERE id = OLD.invoice_sp_id;
  END IF;

  -- Always update new sp
  UPDATE sp_invoice_sp
  SET total = (
    SELECT IFNULL(SUM(total), 0)
    FROM sp_invoice_isi
    WHERE invoice_sp_id = NEW.invoice_sp_id
  )
  WHERE id = NEW.invoice_sp_id;
END$$

CREATE TRIGGER trg_update_sp_total_on_delete
AFTER DELETE ON sp_invoice_isi
FOR EACH ROW
BEGIN
  UPDATE sp_invoice_sp
  SET total = (
    SELECT IFNULL(SUM(total), 0)
    FROM sp_invoice_isi
    WHERE invoice_sp_id = OLD.invoice_sp_id
  )
  WHERE id = OLD.invoice_sp_id;
END$$

DELIMITER ;