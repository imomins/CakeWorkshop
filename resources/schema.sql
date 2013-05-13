SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `cake_workshop` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `cake_workshop` ;

-- -----------------------------------------------------
-- Table `cake_workshop`.`categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cake_workshop`.`categories` ;

CREATE  TABLE IF NOT EXISTS `cake_workshop`.`categories` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cake_workshop`.`courses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cake_workshop`.`courses` ;

CREATE  TABLE IF NOT EXISTS `cake_workshop`.`courses` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `category_id` BIGINT UNSIGNED NOT NULL ,
  `code` VARCHAR(100) NULL ,
  `name` VARCHAR(200) NOT NULL ,
  `description` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_courses_categories1_idx` (`category_id` ASC) ,
  UNIQUE INDEX `code_UNIQUE` (`code` ASC) ,
  CONSTRAINT `fk_courses_categories1`
    FOREIGN KEY (`category_id` )
    REFERENCES `cake_workshop`.`categories` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cake_workshop`.`terms`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cake_workshop`.`terms` ;

CREATE  TABLE IF NOT EXISTS `cake_workshop`.`terms` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `start` DATE NOT NULL ,
  `end` DATE NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `idx_unique_term` (`name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cake_workshop`.`genders`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cake_workshop`.`genders` ;

CREATE  TABLE IF NOT EXISTS `cake_workshop`.`genders` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `idx_unique_name` (`name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cake_workshop`.`departments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cake_workshop`.`departments` ;

CREATE  TABLE IF NOT EXISTS `cake_workshop`.`departments` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `number` TINYINT NULL ,
  `name` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `idx_unique_name` (`name` ASC) ,
  UNIQUE INDEX `number_UNIQUE` (`number` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cake_workshop`.`groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cake_workshop`.`groups` ;

CREATE  TABLE IF NOT EXISTS `cake_workshop`.`groups` (
  `name` VARCHAR(45) NOT NULL ,
  `display` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`name`) ,
  UNIQUE INDEX `display_UNIQUE` (`display` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cake_workshop`.`occupations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cake_workshop`.`occupations` ;

CREATE  TABLE IF NOT EXISTS `cake_workshop`.`occupations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(200) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cake_workshop`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cake_workshop`.`users` ;

CREATE  TABLE IF NOT EXISTS `cake_workshop`.`users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `group_name` VARCHAR(45) NOT NULL ,
  `gender_id` BIGINT UNSIGNED NOT NULL ,
  `occupation_id` BIGINT UNSIGNED NOT NULL ,
  `email` VARCHAR(100) NOT NULL ,
  `password` VARCHAR(45) NOT NULL ,
  `title` VARCHAR(45) NULL ,
  `firstname` VARCHAR(45) NOT NULL ,
  `lastname` VARCHAR(45) NOT NULL ,
  `department_id` BIGINT UNSIGNED NULL ,
  `hrz` VARCHAR(45) NULL ,
  `phone` VARCHAR(45) NOT NULL ,
  `hash` VARCHAR(100) NULL ,
  `email_confirmed` TINYINT(1) NOT NULL DEFAULT 0 ,
  `email_update` VARCHAR(100) NULL ,
  `active` VARCHAR(45) NOT NULL ,
  `notes` TEXT NULL ,
  `created` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_users_genders_idx` (`gender_id` ASC) ,
  INDEX `fk_attendees_departments_idx` (`department_id` ASC) ,
  UNIQUE INDEX `idx_unique_email` (`email` ASC) ,
  INDEX `idx_hash` (`hash` ASC) ,
  INDEX `fk_users_groups_idx` (`group_name` ASC) ,
  INDEX `fk_users_occupations_idx` (`occupation_id` ASC) ,
  CONSTRAINT `fk_users_genders1`
    FOREIGN KEY (`gender_id` )
    REFERENCES `cake_workshop`.`genders` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_attendees_departments1`
    FOREIGN KEY (`department_id` )
    REFERENCES `cake_workshop`.`departments` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups1`
    FOREIGN KEY (`group_name` )
    REFERENCES `cake_workshop`.`groups` (`name` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_occupations1`
    FOREIGN KEY (`occupation_id` )
    REFERENCES `cake_workshop`.`occupations` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cake_workshop`.`schedules`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cake_workshop`.`schedules` ;

CREATE  TABLE IF NOT EXISTS `cake_workshop`.`schedules` (
  `name` VARCHAR(45) NOT NULL ,
  `display` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`name`) ,
  UNIQUE INDEX `display_UNIQUE` (`display` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cake_workshop`.`courses_terms`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cake_workshop`.`courses_terms` ;

CREATE  TABLE IF NOT EXISTS `cake_workshop`.`courses_terms` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `term_id` BIGINT UNSIGNED NOT NULL ,
  `course_id` BIGINT UNSIGNED NOT NULL ,
  `schedule_name` VARCHAR(45) NOT NULL ,
  `attendees` INT UNSIGNED NOT NULL ,
  `max` INT UNSIGNED NOT NULL ,
  `location` VARCHAR(1000) NULL ,
  `locked` TINYINT(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_courses_terms_terms1_idx` (`term_id` ASC) ,
  INDEX `fk_courses_terms_courses1_idx` (`course_id` ASC) ,
  INDEX `fk_courses_terms_schedules1_idx` (`schedule_name` ASC) ,
  UNIQUE INDEX `course_UNIQUE` (`term_id` ASC, `course_id` ASC, `schedule_name` ASC) ,
  CONSTRAINT `fk_courses_terms_terms1`
    FOREIGN KEY (`term_id` )
    REFERENCES `cake_workshop`.`terms` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_courses_terms_courses1`
    FOREIGN KEY (`course_id` )
    REFERENCES `cake_workshop`.`courses` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_courses_terms_schedules1`
    FOREIGN KEY (`schedule_name` )
    REFERENCES `cake_workshop`.`schedules` (`name` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cake_workshop`.`booking_states`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cake_workshop`.`booking_states` ;

CREATE  TABLE IF NOT EXISTS `cake_workshop`.`booking_states` (
  `name` VARCHAR(45) NOT NULL ,
  `display` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`name`) ,
  UNIQUE INDEX `display_UNIQUE` (`display` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cake_workshop`.`attendance_states`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cake_workshop`.`attendance_states` ;

CREATE  TABLE IF NOT EXISTS `cake_workshop`.`attendance_states` (
  `name` VARCHAR(45) NOT NULL ,
  `display` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`name`) ,
  UNIQUE INDEX `display_UNIQUE` (`display` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cake_workshop`.`types`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cake_workshop`.`types` ;

CREATE  TABLE IF NOT EXISTS `cake_workshop`.`types` (
  `name` VARCHAR(45) NOT NULL ,
  `display` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`name`) ,
  UNIQUE INDEX `display_UNIQUE` (`display` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cake_workshop`.`addresses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cake_workshop`.`addresses` ;

CREATE  TABLE IF NOT EXISTS `cake_workshop`.`addresses` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `user_id` BIGINT UNSIGNED NOT NULL ,
  `type_name` VARCHAR(45) NOT NULL ,
  `institution` VARCHAR(100) NULL ,
  `department` VARCHAR(100) NULL ,
  `postbox` VARCHAR(100) NULL ,
  `to_person` VARCHAR(100) NULL ,
  `street` VARCHAR(100) NOT NULL ,
  `zip` VARCHAR(10) NOT NULL ,
  `location` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_addresses_types_idx` (`type_name` ASC) ,
  INDEX `fk_addresses_users_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_addresses_types`
    FOREIGN KEY (`type_name` )
    REFERENCES `cake_workshop`.`types` (`name` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_addresses_users`
    FOREIGN KEY (`user_id` )
    REFERENCES `cake_workshop`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cake_workshop`.`bookings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cake_workshop`.`bookings` ;

CREATE  TABLE IF NOT EXISTS `cake_workshop`.`bookings` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `user_id` BIGINT UNSIGNED NOT NULL ,
  `address_id` BIGINT UNSIGNED NOT NULL ,
  `courses_term_id` BIGINT UNSIGNED NOT NULL ,
  `booking_state_name` VARCHAR(45) NOT NULL ,
  `attendance_state_name` VARCHAR(45) NULL ,
  `notes` TEXT NULL ,
  `certificate` TINYINT(1) NOT NULL DEFAULT 0 ,
  `unsubscribed_at` DATETIME NULL ,
  `created` DATETIME NOT NULL ,
  `updated` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_bookings_users_idx` (`user_id` ASC) ,
  UNIQUE INDEX `idx_unique_booking` (`user_id` ASC, `courses_term_id` ASC) ,
  INDEX `fk_bookings_courses_term_idx` (`courses_term_id` ASC) ,
  INDEX `fk_bookings_statuses1_idx` (`booking_state_name` ASC) ,
  INDEX `fk_bookings_attendance_states1_idx` (`attendance_state_name` ASC) ,
  INDEX `fk_bookings_addresses1_idx` (`address_id` ASC) ,
  CONSTRAINT `fk_bookings_users`
    FOREIGN KEY (`user_id` )
    REFERENCES `cake_workshop`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bookings_courses_terms1`
    FOREIGN KEY (`courses_term_id` )
    REFERENCES `cake_workshop`.`courses_terms` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bookings_statuses1`
    FOREIGN KEY (`booking_state_name` )
    REFERENCES `cake_workshop`.`booking_states` (`name` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bookings_attendance_states1`
    FOREIGN KEY (`attendance_state_name` )
    REFERENCES `cake_workshop`.`attendance_states` (`name` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bookings_addresses1`
    FOREIGN KEY (`address_id` )
    REFERENCES `cake_workshop`.`addresses` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cake_workshop`.`days`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cake_workshop`.`days` ;

CREATE  TABLE IF NOT EXISTS `cake_workshop`.`days` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `courses_term_id` BIGINT UNSIGNED NOT NULL ,
  `start_date` DATE NOT NULL ,
  `start_time` TIME NOT NULL ,
  `end_time` TIME NOT NULL ,
  INDEX `fk_courses_days_courses_terms1_idx` (`courses_term_id` ASC) ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `unique_day` (`start_time` ASC, `end_time` ASC, `courses_term_id` ASC, `start_date` ASC) ,
  CONSTRAINT `fk_courses_days_courses_terms1`
    FOREIGN KEY (`courses_term_id` )
    REFERENCES `cake_workshop`.`courses_terms` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cake_workshop`.`messages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cake_workshop`.`messages` ;

CREATE  TABLE IF NOT EXISTS `cake_workshop`.`messages` (
  `name` VARCHAR(100) NOT NULL ,
  `title` VARCHAR(100) NOT NULL ,
  `message` TEXT NOT NULL ,
  PRIMARY KEY (`name`) )
ENGINE = InnoDB;

USE `cake_workshop` ;
USE `cake_workshop`;

DELIMITER $$

USE `cake_workshop`$$
DROP TRIGGER IF EXISTS `cake_workshop`.`trigger_increment_booking_count` $$
USE `cake_workshop`$$




CREATE TRIGGER trigger_increment_booking_count AFTER INSERT ON bookings
  FOR EACH ROW BEGIN
	UPDATE courses_terms SET courses_terms.attendees = courses_terms.attendees + 1 WHERE courses_terms.id = NEW.courses_term_id;
END;

$$


USE `cake_workshop`$$
DROP TRIGGER IF EXISTS `cake_workshop`.`trigger_decrement_booking_count` $$
USE `cake_workshop`$$




CREATE TRIGGER trigger_decrement_booking_count AFTER DELETE ON bookings
  FOR EACH ROW BEGIN
	UPDATE courses_terms SET attendees = attendees - 1 WHERE courses_terms.id = OLD.courses_term_id;
END;

$$


DELIMITER ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `cake_workshop`.`genders`
-- -----------------------------------------------------
START TRANSACTION;
USE `cake_workshop`;
INSERT INTO `cake_workshop`.`genders` (`id`, `name`) VALUES (1, 'Herr');
INSERT INTO `cake_workshop`.`genders` (`id`, `name`) VALUES (2, 'Frau');
INSERT INTO `cake_workshop`.`genders` (`id`, `name`) VALUES (3, 'Sonstiges');

COMMIT;

-- -----------------------------------------------------
-- Data for table `cake_workshop`.`groups`
-- -----------------------------------------------------
START TRANSACTION;
USE `cake_workshop`;
INSERT INTO `cake_workshop`.`groups` (`name`, `display`) VALUES ('admin', 'Administrator');
INSERT INTO `cake_workshop`.`groups` (`name`, `display`) VALUES ('assistant', 'Assistent');
INSERT INTO `cake_workshop`.`groups` (`name`, `display`) VALUES ('attendee', 'Teilnehmer');
INSERT INTO `cake_workshop`.`groups` (`name`, `display`) VALUES ('manager', 'Schulungsleiter');

COMMIT;

-- -----------------------------------------------------
-- Data for table `cake_workshop`.`occupations`
-- -----------------------------------------------------
START TRANSACTION;
USE `cake_workshop`;
INSERT INTO `cake_workshop`.`occupations` (`id`, `name`) VALUES (1, 'Lehrende/r / Wiss. Mitarb. der Goethe-Universität');
INSERT INTO `cake_workshop`.`occupations` (`id`, `name`) VALUES (2, 'Stud. Mitarb. der Goethe-Universität');
INSERT INTO `cake_workshop`.`occupations` (`id`, `name`) VALUES (3, 'Lehrer/in');
INSERT INTO `cake_workshop`.`occupations` (`id`, `name`) VALUES (4, 'Hess. Hochschulangehörige/r');
INSERT INTO `cake_workshop`.`occupations` (`id`, `name`) VALUES (5, 'Sonstige');

COMMIT;

-- -----------------------------------------------------
-- Data for table `cake_workshop`.`schedules`
-- -----------------------------------------------------
START TRANSACTION;
USE `cake_workshop`;
INSERT INTO `cake_workshop`.`schedules` (`name`, `display`) VALUES ('as_planned', 'Planmäßig');
INSERT INTO `cake_workshop`.`schedules` (`name`, `display`) VALUES ('cancelled', 'Abgesagt');
INSERT INTO `cake_workshop`.`schedules` (`name`, `display`) VALUES ('rescheduled', 'Abgesagt und neu angesetzt');
INSERT INTO `cake_workshop`.`schedules` (`name`, `display`) VALUES ('unknown', 'Noch offen');

COMMIT;

-- -----------------------------------------------------
-- Data for table `cake_workshop`.`booking_states`
-- -----------------------------------------------------
START TRANSACTION;
USE `cake_workshop`;
INSERT INTO `cake_workshop`.`booking_states` (`name`, `display`) VALUES ('confirmed', 'Bestätigt');
INSERT INTO `cake_workshop`.`booking_states` (`name`, `display`) VALUES ('self_unsubscribed', 'Selbst abgemeldet');
INSERT INTO `cake_workshop`.`booking_states` (`name`, `display`) VALUES ('admin_unsubscribed', 'Wurde abgemeldet');
INSERT INTO `cake_workshop`.`booking_states` (`name`, `display`) VALUES ('unconfirmed', 'Unbestätigt');
INSERT INTO `cake_workshop`.`booking_states` (`name`, `display`) VALUES ('cleared', 'Abgerechnet');

COMMIT;

-- -----------------------------------------------------
-- Data for table `cake_workshop`.`attendance_states`
-- -----------------------------------------------------
START TRANSACTION;
USE `cake_workshop`;
INSERT INTO `cake_workshop`.`attendance_states` (`name`, `display`) VALUES ('present', 'Anwesend und Abgeschlossen');
INSERT INTO `cake_workshop`.`attendance_states` (`name`, `display`) VALUES ('ill', 'Abgesagt wegen Krankheit');
INSERT INTO `cake_workshop`.`attendance_states` (`name`, `display`) VALUES ('self_cancelled', 'Selbst abgesagt');
INSERT INTO `cake_workshop`.`attendance_states` (`name`, `display`) VALUES ('goodwill_self_cancelled', 'Selbst abgesagt (Kulanz)');
INSERT INTO `cake_workshop`.`attendance_states` (`name`, `display`) VALUES ('not_present', 'Nicht Teilgenommen');

COMMIT;

-- -----------------------------------------------------
-- Data for table `cake_workshop`.`types`
-- -----------------------------------------------------
START TRANSACTION;
USE `cake_workshop`;
INSERT INTO `cake_workshop`.`types` (`name`, `display`) VALUES ('private', 'Privat');
INSERT INTO `cake_workshop`.`types` (`name`, `display`) VALUES ('business', 'Geschäftlich');

COMMIT;
