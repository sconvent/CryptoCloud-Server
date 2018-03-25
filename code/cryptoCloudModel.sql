-- -----------------------------------------------------
-- Schema cryptoCloud
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `cryptoCloud` ;

-- -----------------------------------------------------
-- Schema cryptoCloud
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `cryptoCloud` ;
USE `cryptoCloud` ;

-- -----------------------------------------------------
-- Table `cryptoCloud`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cryptoCloud`.`user` ;

CREATE TABLE IF NOT EXISTS `cryptoCloud`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(128) NOT NULL,
  `auth_client_salt` VARCHAR(22) NOT NULL,
  `auth_server_salt` VARCHAR(22) NOT NULL,
  `enc_client_salt` VARCHAR(22) NOT NULL,
  `auth_password_hash` VARCHAR(31) NULL,
  `main_block_id` INT NULL DEFAULT NULL,
  `deleted` TINYINT(1) NOT NULL DEFAULT false,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  INDEX `fk_user_block1_idx` (`main_block_id` ASC),
  CONSTRAINT `fk_user_block1`
    FOREIGN KEY (`main_block_id`)
    REFERENCES `cryptoCloud`.`block` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cryptoCloud`.`block`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cryptoCloud`.`block` ;

CREATE TABLE IF NOT EXISTS `cryptoCloud`.`block` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `last_changed` INT NOT NULL,
  `deleted` TINYINT(1) NULL DEFAULT false,
  PRIMARY KEY (`id`),
  INDEX `fk_block_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_block_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `cryptoCloud`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cryptoCloud`.`access_token`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cryptoCloud`.`access_token` ;

CREATE TABLE IF NOT EXISTS `cryptoCloud`.`access_token` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `token` VARCHAR(128) NOT NULL,
  `valid_until` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_AccessToken_user1_idx` (`user_id` ASC),
  UNIQUE INDEX `token_UNIQUE` (`token` ASC),
  CONSTRAINT `fk_AccessToken_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `cryptoCloud`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cryptoCloud`.`salt`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cryptoCloud`.`salt` ;

CREATE TABLE IF NOT EXISTS `cryptoCloud`.`salt` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `auth_client_salt` VARCHAR(22) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;
