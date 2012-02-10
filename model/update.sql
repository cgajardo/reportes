ALTER TABLE `mydb`.`instituciones` DROP COLUMN `id_plataforma;

CREATE  TABLE IF NOT EXISTS `mydb`.`instituciones_has_plataformas` (
  `id_institucion` INT(11) NOT NULL ,
  `id_plataforma` INT NOT NULL ,
  PRIMARY KEY (`id_institucion`, `id_plataforma`) ,
  INDEX `fk_instituciones_has_plataformas_instituciones1` (`id_institucion` ASC) ,
  INDEX `fk_instituciones_has_plataformas_plataformas1` (`id_plataforma` ASC) ,
  CONSTRAINT `fk_instituciones_has_plataformas_instituciones1`
    FOREIGN KEY (`id_institucion` )
    REFERENCES `mydb`.`instituciones` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_instituciones_has_plataformas_plataformas1`
    FOREIGN KEY (`id_plataforma` )
    REFERENCES `mydb`.`plataformas` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

ALTER TABLE `mydb`.`plataformas` 
DROP PRIMARY KEY, ADD PRIMARY KEY (`id`, `nombre`) ;


ALTER TABLE `mydb`.`instituciones_has_directores` CHANGE COLUMN `id_instituacion` `id_institucion` INT(11) NOT NULL, 
DROP PRIMARY KEY, ADD PRIMARY KEY (`id_institucion`, `id_persona`), 
DROP INDEX `fk_Instituciones_has_Personas_Instituciones1`, ADD INDEX `fk_Instituciones_has_Personas_Instituciones1` (`id_institucion` ASC);
