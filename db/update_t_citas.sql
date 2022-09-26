--Agregar campo de nota a la cita
ALTER TABLE `db_turnero`.`t_citas` ADD COLUMN `nota` LONGTEXT NULL  AFTER `editmode` ;
