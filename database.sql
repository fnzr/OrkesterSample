-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema blog_db
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema blog_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `blog_db` ;
USE `blog_db` ;

-- -----------------------------------------------------
-- Table `blog_db`.`Tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blog_db`.`Tag` (
                                               `idTag` INT NOT NULL AUTO_INCREMENT,
                                               `value` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`idTag`));


-- -----------------------------------------------------
-- Table `blog_db`.`Author`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blog_db`.`Author` (
                                                  `idAuthor` INT NOT NULL AUTO_INCREMENT,
                                                  `name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`idAuthor`));


-- -----------------------------------------------------
-- Table `blog_db`.`Article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blog_db`.`Article` (
                                                   `idArticle` INT NOT NULL AUTO_INCREMENT,
                                                   `title` VARCHAR(255) NOT NULL,
    `content` VARCHAR(45) NULL,
    `postedAt` VARCHAR(45) NULL,
    `idAuthor` INT NULL,
    PRIMARY KEY (`idArticle`),
    INDEX `fk_Article_Author1_idx` (`idAuthor` ASC) ,
    CONSTRAINT `fk_Article_Author1`
    FOREIGN KEY (`idAuthor`)
    REFERENCES `blog_db`.`Author` (`idAuthor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `blog_db`.`Comment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blog_db`.`Comment` (
                                                   `idComment` INT NOT NULL AUTO_INCREMENT,
                                                   `message` VARCHAR(255) NOT NULL,
    `idArticle` INT NOT NULL,
    PRIMARY KEY (`idComment`),
    INDEX `fk_Comment_Article1_idx` (`idArticle` ASC) ,
    CONSTRAINT `fk_Comment_Article1`
    FOREIGN KEY (`idArticle`)
    REFERENCES `blog_db`.`Article` (`idArticle`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `blog_db`.`Article_Tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blog_db`.`Article_Tag` (
                                                       `idTag` INT NOT NULL,
                                                       `idArticle` INT NOT NULL,
                                                       PRIMARY KEY (`idTag`, `idArticle`),
    INDEX `fk_Tag_Article_Article1_idx` (`idArticle` ASC) ,
    INDEX `fk_Tag_Article_Tag1_idx` (`idTag` ASC) ,
    CONSTRAINT `fk_Tag_Article_Tag1`
    FOREIGN KEY (`idTag`)
    REFERENCES `blog_db`.`Tag` (`idTag`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_Tag_Article_Article1`
    FOREIGN KEY (`idArticle`)
    REFERENCES `blog_db`.`Article` (`idArticle`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
