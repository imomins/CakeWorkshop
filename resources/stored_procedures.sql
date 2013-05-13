-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.24-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-04-06 04:57:24
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping database structure for cake_workshop
CREATE DATABASE IF NOT EXISTS `cake_workshop` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `cake_workshop`;


-- Dumping structure for procedure cake_workshop.sp_delete_all_data_VORSICHT
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_all_data_VORSICHT`()
BEGIN
	DELETE FROM days;
	DELETE FROM bookings;
	DELETE FROM courses_terms;
	DELETE FROM courses;
	DELETE FROM terms;
	DELETE FROM categories;
	DELETE FROM invoices;
	DELETE FROM users;
	DELETE FROM occupations;
	DELETE FROM departments;
END//
DELIMITER ;


-- Dumping structure for procedure cake_workshop.sp_get_duplicate_emails_benutzer_tabelle
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_duplicate_emails_benutzer_tabelle`()
    READS SQL DATA
BEGIN
	SELECT b1.*
	FROM `benutzer-tabelle` b1
		INNER JOIN (
			SELECT mail
			FROM `benutzer-tabelle`
				GROUP BY mail
				HAVING COUNT(id) > 1
		) q_inner ON b1.mail = q_inner.mail
	ORDER BY b1.mail;
END//
DELIMITER ;


-- Dumping structure for procedure cake_workshop.sp_import_all_data
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_import_all_data`()
BEGIN
	call sp_import_terms();
	call sp_import_genders();
	#call sp_import_occupations();
	call sp_import_departments();
	call sp_import_courses();
	call sp_import_not_imported_workshops_with_separate_group();
	call sp_import_users_and_create_invoice();
END//
DELIMITER ;


-- Dumping structure for procedure cake_workshop.sp_import_courses
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_import_courses`()
BEGIN
	DECLARE fetch_kurs_titel VARCHAR(100);
   DECLARE loop_1_done INT DEFAULT FALSE;
   
	DECLARE cur CURSOR FOR SELECT DISTINCT TRIM(`workshop-tabelle`.Titel) FROM `workshop-tabelle`;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET loop_1_done = TRUE;

	OPEN cur;
	
	loop_1: LOOP
		FETCH cur INTO fetch_kurs_titel;
				
		IF loop_1_done THEN
			LEAVE loop_1;
		END IF;
		
		IF NOT EXISTS (SELECT name FROM courses WHERE name = fetch_kurs_titel) THEN
			INSERT INTO courses (name) VALUES (fetch_kurs_titel);
		END IF;	
		
	END LOOP loop_1;
	
	CLOSE cur;
END//
DELIMITER ;


-- Dumping structure for procedure cake_workshop.sp_import_departments
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_import_departments`()
BEGIN
	DECLARE fetch_fachbereiche VARCHAR(100);
   DECLARE loop_1_done INT DEFAULT FALSE;
   
	DECLARE cur CURSOR FOR SELECT DISTINCT TRIM(`benutzer-tabelle`.Fachbereich) FROM `benutzer-tabelle`;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET loop_1_done = TRUE;

	OPEN cur;
	
	loop_1: LOOP
		FETCH cur INTO fetch_fachbereiche;
				
		IF loop_1_done THEN
			LEAVE loop_1;
		END IF;
		
		IF NOT EXISTS (SELECT name FROM departments WHERE name = fetch_fachbereiche) THEN
			INSERT INTO departments (name) VALUES (fetch_fachbereiche);
		END IF;	
		
	END LOOP loop_1;
	
	CLOSE cur;
END//
DELIMITER ;


-- Dumping structure for procedure cake_workshop.sp_import_genders
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_import_genders`()
BEGIN
	DECLARE fetch_anrede VARCHAR(100);
   DECLARE loop_1_done INT DEFAULT FALSE;
   
	DECLARE cur CURSOR FOR SELECT DISTINCT TRIM(Anrede) FROM `benutzer-tabelle`;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET loop_1_done = TRUE;

	OPEN cur;
	
	loop_1: LOOP
		FETCH cur INTO fetch_anrede;
				
		IF loop_1_done THEN
			LEAVE loop_1;
		END IF;
		
		IF NOT EXISTS (SELECT name FROM genders WHERE name = fetch_anrede) THEN
			INSERT INTO genders (name) VALUES (fetch_anrede);
		END IF;	
		
	END LOOP loop_1;
	
	CLOSE cur;
END//
DELIMITER ;


-- Dumping structure for procedure cake_workshop.sp_import_not_imported_workshops_with_separate_group
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_import_not_imported_workshops_with_separate_group`()
BEGIN
	DECLARE fetch_name VARCHAR(100);
   DECLARE fetch_code VARCHAR(100);
   DECLARE fetch_term VARCHAR(100);
   
   DECLARE loop_done INT DEFAULT FALSE;
   
   DECLARE cur CURSOR FOR SELECT TRIM(w.Titel),TRIM(w.Kategorie),TRIM(w.Zeitraum)
	FROM `workshop-tabelle` w
		INNER JOIN
			`benutzer-tabelle` b ON (w.id = b.id)
	WHERE TRIM(w.Kategorie) NOT IN (SELECT DISTINCT TRIM(fetch_name) FROM courses)
		GROUP BY
			w.Kategorie;			
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET loop_done = TRUE;
			
	#IF NOT EXISTS (SELECT name FROM categories WHERE name = 'Nicht zugeordnet') THEN
	#	INSERT INTO categories (name) VALUES ('Nicht zugeordnet');
	#END IF;
						
	OPEN cur;
	
	loop_done: LOOP
		FETCH cur INTO fetch_name, fetch_code, fetch_term;
				
		IF loop_done THEN
			LEAVE loop_done;
		END IF;
		
		INSERT IGNORE INTO terms (name,`start`,`end`) VALUES (fetch_term, '0000-00-00', '0000-00-00');				
		INSERT IGNORE INTO courses (name/*,code,category_id*/) VALUES (fetch_name/*, fetch_code, (SELECT id FROM categories WHERE name = 'Nicht zugeordnet')*/);
		INSERT IGNORE INTO courses_terms (term_id, course_id, `max`, schedule_name) VALUES ((SELECT id FROM terms WHERE name = fetch_term), (SELECT id FROM courses WHERE name = fetch_name /*fetch_code*/), 0, 'unknown');
		
	END LOOP loop_done;
	
	CLOSE cur;
END//
DELIMITER ;


-- Dumping structure for procedure cake_workshop.sp_import_occupations
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_import_occupations`()
BEGIN
	DECLARE fetch_beschaeftigt_als VARCHAR(100);
   DECLARE loop_1_done INT DEFAULT FALSE;
   
	DECLARE cur CURSOR FOR SELECT DISTINCT TRIM(Beschaeftigt_Als) FROM `benutzer-tabelle`;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET loop_1_done = TRUE;

	OPEN cur;
	
	loop_1: LOOP
		FETCH cur INTO fetch_beschaeftigt_als;
				
		IF loop_1_done THEN
			LEAVE loop_1;
		END IF;
		
		IF NOT EXISTS (SELECT name FROM occupations WHERE name = fetch_beschaeftigt_als) THEN
			INSERT INTO occupations (name) VALUES (fetch_beschaeftigt_als);
		END IF;	
		
	END LOOP loop_1;
	
	CLOSE cur;
END//
DELIMITER ;


-- Dumping structure for procedure cake_workshop.sp_import_terms
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_import_terms`()
BEGIN
	DECLARE fetch_zeitraum VARCHAR(100);
   DECLARE loop_1_done INT DEFAULT FALSE;
   
	DECLARE cur CURSOR FOR SELECT DISTINCT TRIM(Zeitraum) FROM `workshop-tabelle`;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET loop_1_done = TRUE;

	OPEN cur;
	
	loop_1: LOOP
		FETCH cur INTO fetch_zeitraum;
				
		IF loop_1_done THEN
			LEAVE loop_1;
		END IF;
		
		IF NOT EXISTS (SELECT name FROM terms WHERE name = fetch_zeitraum) THEN
			INSERT INTO terms (name) VALUES (fetch_zeitraum);
		END IF;	
		
	END LOOP loop_1;
	
	CLOSE cur;
END//
DELIMITER ;


-- Dumping structure for procedure cake_workshop.sp_import_users_and_create_invoice
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_import_users_and_create_invoice`()
    MODIFIES SQL DATA
BEGIN
	# Daten von der alten benutzer-tabelle
	DECLARE fetch_benutzer_id INT;
	DECLARE insert_benutzer_id BIGINT;
	DECLARE insert_group_id BIGINT;
	
	DECLARE fetch_anrede VARCHAR(10);
	DECLARE insert_gender_id BIGINT;
	
	DECLARE fetch_title VARCHAR(50);
	DECLARE fetch_vorname VARCHAR(250);
	DECLARE fetch_nachname VARCHAR(250);
	
	DECLARE fetch_fachbereich VARCHAR(250);
	DECLARE insert_department_id BIGINT;
	
	DECLARE fetch_beschaeftigt_als VARCHAR(250);
	DECLARE insert_occupation VARCHAR(1000);
	
	DECLARE fetch_mail VARCHAR(250);
	DECLARE fetch_tel VARCHAR(100);
	DECLARE fetch_webct VARCHAR(128);
	
	DECLARE fetch_rechnung_an VARCHAR(8);
	DECLARE insert_invoice_count BIGINT;
	DECLARE insert_type_id BIGINT;
	DECLARE insert_type_name VARCHAR(45);
	DECLARE insert_address_id BIGINT;
	
	DECLARE fetch_institution VARCHAR(250);
	DECLARE fetch_abteilung VARCHAR(128);
	DECLARE fetch_zu_haenden VARCHAR(128);
	DECLARE fetch_strasse VARCHAR(250);
	DECLARE fetch_postfach VARCHAR(15);
	DECLARE fetch_plz VARCHAR(11);
	DECLARE fetch_ort VARCHAR(250);	
	
	DECLARE fetch_wissenschaftler TINYINT(1);
	DECLARE fetch_sonstige TINYINT(1);
	DECLARE fetch_student TINYINT(1);
	DECLARE fetch_lehrer TINYINT(1);
		
	DECLARE fetch_datum DATETIME;

   DECLARE loop_1_done INT DEFAULT FALSE;
   DECLARE row_exists TINYINT DEFAULT FALSE;
   
	DECLARE benutzer_cursor CURSOR FOR
		SELECT
			id,
			STR_TO_DATE(TRIM(Datum), '%Y.%m.%d-%H:%i:%s'),
			TRIM(Anrede),
			TRIM(Titel),
			TRIM(Vorname),
			TRIM(Nachname),
			TRIM(Fachbereich),
			TRIM(Beschaeftigt_Als),			
			TRIM(Mail),
			TRIM(Telefonnummer),			
			TRIM(`WebCT-ID`),
			TRIM(rechnungAn),			
			TRIM(Institution),
			TRIM(Abteilung),			
			TRIM(zuHaenden),
			TRIM(Strasse),			
			TRIM(Hauspostfach),
			TRIM(PLZ),			
			TRIM(Ort),
			TRIM(Beschaeftigt_Als) LIKE '%wiss%',
			TRIM(Beschaeftigt_Als) LIKE '%sonstige%',
			TRIM(Beschaeftigt_Als) LIKE '%student%',
			TRIM(Beschaeftigt_Als) LIKE '%lehr%'
		FROM `benutzer-tabelle`
		ORDER BY id ASC;
		
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET loop_1_done = TRUE;

	OPEN benutzer_cursor;
	
	loop_1: LOOP
		FETCH benutzer_cursor
			INTO
				fetch_benutzer_id,
				fetch_datum,
				fetch_anrede,
				fetch_title,
				fetch_vorname,
				fetch_nachname,
				fetch_fachbereich,
				fetch_beschaeftigt_als,
				fetch_mail,
				fetch_tel,
				fetch_webct,
				fetch_rechnung_an,
				fetch_institution,
				fetch_abteilung,
				fetch_zu_haenden,
				fetch_strasse,
				fetch_postfach,
				fetch_plz,
				fetch_ort,
				fetch_wissenschaftler,
				fetch_sonstige,
				fetch_student,
				fetch_lehrer;
				
		IF loop_1_done THEN
			LEAVE loop_1;
		END IF;

		# =============================		
		# BENTUZER ANLEGEN
		# =============================
				
		# Benutzer nur anlegen sofern er nicht existiert
		IF NOT EXISTS (SELECT * FROM users WHERE users.email = fetch_mail) THEN
			# UNIQUE index auf name, daher INSERT fehler ignorieren
			INSERT IGNORE INTO genders (`name`) VALUES (fetch_anrede);
			SELECT genders.id INTO insert_gender_id FROM genders WHERE genders.name = fetch_anrede LIMIT 1;
			
			INSERT IGNORE INTO departments (`name`) VALUES (fetch_fachbereich);
			SELECT departments.id INTO insert_department_id FROM departments WHERE departments.name = fetch_fachbereich LIMIT 1;
			
			#INSERT IGNORE INTO occupations (`name`) VALUES (fetch_beschaeftigt_als);
			#SELECT occupations.id INTO insert_occupation_id FROM occupations WHERE occupations.name = fetch_beschaeftigt_als LIMIT 1;
			
			#SELECT groups.id INTO insert_group_id FROM groups WHERE groups.name = 'attendee' LIMIT 1;
			
			INSERT INTO users
				(
					`group_name`,
					`email`,
					`password`,
					`title`,
					`firstname`,
					`lastname`,
					`gender_id`,
					`department_id`,
					/*`occupation`,*/
					`notes`,
					`hrz`,
					`phone`,
					`email_confirmed`,
					`active`,
					`created`
				)
				VALUES
				(
					'attendee',
					fetch_mail,
					SHA1('random'),
					fetch_title,
					fetch_vorname,
					fetch_nachname,
					insert_gender_id,
					insert_department_id,
					CONCAT('Beschäftigung (import): ', fetch_beschaeftigt_als),
					fetch_webct,
					fetch_tel,
					0,
					0,
					fetch_datum												
				);
				
				SET insert_benutzer_id = last_insert_id();
		# Der Benutzer existiert
		ELSE
			SELECT users.id INTO insert_benutzer_id FROM users WHERE users.email = fetch_mail;
		END IF;
		
		# =============================
		# RECHNUNG ANLEGEN
		# =============================
		
		# Jetzt mÃ¼ssen wir raten, ob der Benutzer nicht schon mal diese Rechnung benutzt hat.		
		IF NOT EXISTS (SELECT * FROM invoices WHERE invoices.user_id = insert_benutzer_id AND (STRCMP(LCASE(fetch_strasse), LCASE(TRIM(invoices.street))) != 0) LIMIT 1) THEN
			#INSERT IGNORE INTO types (name) VALUES (fetch_rechnung_an);
			#SELECT types.id INTO insert_type_id FROM types WHERE types.name = fetch_rechnung_an LIMIT 1;

			# Leere rechnungAn Felder behandeln + Checken ob private oder geschäftlich
			SET @is_business = (TRIM(fetch_rechnung_an)='' AND TRIM(fetch_institution)!='') OR (TRIM(fetch_rechnung_an) = 'arbeitg');
			SET @is_private = (TRIM(fetch_rechnung_an)='' AND TRIM(fetch_institution)='') OR (TRIM(fetch_rechnung_an) = 'privat');
			
			IF @is_business = 1 THEN
				SET insert_type_name = 'business';
			ELSE
				SET insert_type_name = 'private';
			END IF;
			
			SELECT COUNT(*) INTO insert_invoice_count FROM invoices WHERE invoices.user_id = insert_benutzer_id;
			SET insert_invoice_count = insert_invoice_count + 1;
			
			# Die Rechnunsvorlagen werden durch nummeriert, um sie zu separieren "Standard-Rechnung-<anzahl bisheriger Rechnungen + 1>"
			INSERT INTO invoices
				(`type_name`,`user_id`,`name`,`institution`,`department`,`postbox`,`to_person`,`street`,`zip`,`location`)
			VALUES
				(insert_type_name,insert_benutzer_id,CONCAT('Standard-Rechnung-',insert_invoice_count),fetch_institution,fetch_abteilung,fetch_postfach,fetch_zu_haenden,fetch_strasse,fetch_plz,fetch_ort);
			
			SET insert_address_id = LAST_INSERT_ID();
		ELSE
			# Rechnung existiert
			SELECT invoices.id INTO insert_address_id FROM invoices WHERE invoices.user_id = insert_benutzer_id AND (STRCMP(LCASE(fetch_strasse), LCASE(invoices.street))) LIMIT 1;
		END IF;
		
		# =============================
		# WORKSHOP BUCHUNGEN
		# =============================
		
		# Jetzts durch alle gebuchten Workshops iterieren und anlegen
		# Dran denken die "fetch_benutzer_id" aus der Tabelle verweist auf die Buchung zu dieser Person
		# obwohl wir jetzt einzigartige Benutzer haben mit der echten id "insert_benutzer_id".
		
		BLOCK2: BEGIN
			DECLARE loop_2_done TINYINT DEFAULT FALSE;

			DECLARE fetch_courses_term_id BIGINT;

			DECLARE fetch_zeitraum VARCHAR(50);
			DECLARE fetch_kategorie VARCHAR(20);
			DECLARE fetch_datum DATETIME;
			DECLARE fetch_zusage TINYINT;
			DECLARE fetch_teilnahme TINYINT;
			DECLARE fetch_zertifikat TINYINT;
			DECLARE fetch_neu TINYINT;
			DECLARE fetch_titel VARCHAR(200);
			
			DECLARE fetch_courses_term_count BIGINT DEFAULT 0;
			
			DECLARE booking_state_name VARCHAR(45);
			DECLARE attendance_state_name VARCHAR(45);

			# Cursor fÃ¼r die gebuchten Workshops
			# Darauf achten, dass der "fetch_benutzer_id"  die ID
			# aus der alten "benutzer-tabelle" ist die verwendet werden
			# muss, um die Buchungen nachzuschlagen in der workshop-tabelle.
			DECLARE workshop_cursor CURSOR FOR
				SELECT
					STR_TO_DATE(TRIM(`Anmeldedatum`), '%Y.%m.%d-%H:%i:%s'),
					TRIM(`Kategorie`),
					TRIM(Titel),
					TRIM(`Zeitraum`),
					TRIM(`Zusage`),
					TRIM(`Erfolgreiche Teilnahme`),
					TRIM(`Zertifikat`),
					TRIM(`Neu`)	
				FROM `workshop-tabelle`
				WHERE `workshop-tabelle`.ID = fetch_benutzer_id;
								
			DECLARE CONTINUE HANDLER FOR NOT FOUND SET loop_2_done = TRUE;
			
			OPEN workshop_cursor;
			loop_2: LOOP
				FETCH workshop_cursor INTO
					fetch_datum,
					fetch_kategorie,
					fetch_titel,
					fetch_zeitraum,
					fetch_zusage,
					fetch_teilnahme,
					fetch_zertifikat,
					fetch_neu;
					
					# Jetzt den Kurs zu diesem bestimmten Semester nachschlagen
					SELECT COUNT(*), courses_terms.id INTO fetch_courses_term_count, fetch_courses_term_id
					FROM courses_terms
					WHERE
						courses_terms.term_id = (SELECT terms.id FROM terms WHERE terms.name = fetch_zeitraum)
					AND
						courses_terms.course_id = (SELECT courses.id FROM courses WHERE courses.name = fetch_titel);
						
					IF fetch_zusage = 1 THEN
						SET booking_state_name = 'confirmed';
					ELSE 
						SET booking_state_name = 'unconfirmed';						
					END IF;
					
					IF fetch_teilnahme = 1 THEN
						SET attendance_state_name = 'present';
					ELSE
						SET attendance_state_name = 'not_present';
					END IF;
					
					# Beschäftigung erraten
					IF fetch_wissenschaftler = 1 THEN
						SET @occupation_id = 1;
					ELSEIF fetch_student = 1 THEN
						SET @occupation_id = 4;
					ELSEIF fetch_lehrer = 1 THEN
						SET @occupation_id = 3;
					ELSE
						SET @occupation_id = 5;
					END IF;
					
					# Falls es den Kurs gibt einfÃ¼gen
					IF (fetch_courses_term_count > 0) THEN		
						INSERT IGNORE INTO bookings
							(
								user_id,courses_term_id,
								address_id,
								booking_state_name,
								attendance_state_name,
								certificate,
								created,
								updated,
								occupation_id,
								notes
							)
						VALUES
							(
								insert_benutzer_id,
								fetch_courses_term_id,
								insert_address_id,
								booking_state_name,
								attendance_state_name,
								fetch_zertifikat,
								fetch_datum,
								CURRENT_TIMESTAMP(),
								@occupation_id,
								CONCAT('Beschäftigung (import): ',fetch_beschaeftigt_als)
							);
					END IF;
			
				IF loop_2_done THEN
					CLOSE workshop_cursor;
					LEAVE loop_2;
				END IF;									
			END LOOP loop_2;	
		END BLOCK2;
		
	END LOOP loop_1;
	
	CLOSE benutzer_cursor;
END//
DELIMITER ;


-- Dumping structure for procedure cake_workshop.sp_query_not_imported_courses
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_query_not_imported_courses`()
BEGIN
	SELECT DISTINCT Kategorie
		FROM `workshop-tabelle`
		WHERE TRIM(Kategorie) NOT IN (
			SELECT DISTINCT TRIM(code)
			FROM courses
		);
END//
DELIMITER ;


-- Dumping structure for procedure cake_workshop.sp_query_workshop_tabelle_bookings
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_query_workshop_tabelle_bookings`()
BEGIN
	SELECT b.ID,b.Vorname,b.Nachname,w.Titel,w.Kategorie
	FROM `workshop-tabelle` w
		INNER JOIN
			`benutzer-tabelle` b ON (w.id = b.id)
		GROUP BY
			w.Kategorie,w.ID;
END//
DELIMITER ;


-- Dumping structure for procedure cake_workshop.sp_query_workshop_tabelle_not_imported_bookings_refed_coureses
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_query_workshop_tabelle_not_imported_bookings_refed_coureses`()
BEGIN
	SELECT b.ID,b.Vorname,b.Nachname,w.Titel,w.Kategorie
	FROM `workshop-tabelle` w
		INNER JOIN
			`benutzer-tabelle` b ON (w.id = b.id)
	WHERE TRIM(w.Kategorie) NOT IN (SELECT DISTINCT TRIM(code) FROM courses)
		GROUP BY
			w.Kategorie,w.ID;
END//
DELIMITER ;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
