/*script database neosuniversity
*/


create user 'neossoftware'@'localhost' identified by 'discom';



CREATE DATABASE neosuniversity CHARACTER SET utf8 COLLATE utf8_spanish_ci;
GRANT ALL PRIVILEGES ON neosuniversity.* TO 'neossoftware'@'localhost' WITH GRANT OPTION;

flush privileges;


/*tables catalogs
*/

CREATE TABLE `neosuniversity`.`tc_category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `categoryName` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `neosuniversity`.`tc_author` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `lastName` VARCHAR(200) NOT NULL,
  `title` VARCHAR(200) NULL,
  `resume` VARCHAR(10000) NULL,
  PRIMARY KEY (`id`));


  CREATE TABLE `neosuniversity`.`tc_course` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `courseName` VARCHAR(200) NOT NULL,
    `author_id` INT NOT NULL,
    `numbClasses` INT NULL,
    `numHrsVideo` DECIMAL(4,1) NULL,
    `courseDesc` MEDIUMTEXT NOT NULL,
    `isFree` INT NOT NULL,
    `cost` DECIMAL(5,1) NOT NULL,
    PRIMARY KEY (`id`));


CREATE TABLE `neosuniversity`.`tc_country` (
  `id` VARCHAR(3) NOT NULL,
  `countryName` VARCHAR(400) NOT NULL,
  PRIMARY KEY (`id`));

/*table to have a relationship between course and category*/
CREATE TABLE `neosuniversity`.`tr_categ_course` (
  `category_id` INT NOT NULL,
  `course_id` INT NOT NULL,
  PRIMARY KEY (`category_id`, `course_id`));

  /*table for requirement p.e basic computer skills*/
CREATE TABLE `neosuniversity`.`tc_requirement` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `requirement` VARCHAR(1000) NOT NULL,
  PRIMARY KEY (`id`));

/*table for course objectives*/
CREATE TABLE `neosuniversity`.`tc_objective` (
  `id` INT NOT NULL AUTO_INCREMENT,
 `objectiveName` VARCHAR(1000) NOT NULL,
PRIMARY KEY (`id`));

/*table to have a relationship between requirement and courses*/
CREATE TABLE `neosuniversity`.`tr_requirement_course` (
  `requirement_id` INT NOT NULL,
  `course_id` INT NOT NULL,
  PRIMARY KEY (`requirement_id`, `course_id`));

  /*table to have a relationship between objective and courses*/
CREATE TABLE `neosuniversity`.`tr_objective_course` (
  `objective_id` INT NOT NULL,
  `course_id` INT NOT NULL,
PRIMARY KEY (`objective_id`, `course_id`));

/**user table */
CREATE TABLE `neosuniversity`.`tw_user` (
  `username` VARCHAR(50) NOT NULL,
  `completeName` VARCHAR(1000) NOT NULL,
  `email` VARCHAR(200) NOT NULL,
  `pwd` VARCHAR(1000) NOT NULL,
  `country_id` VARCHAR(3) NULL,
  PRIMARY KEY (`email`));


CREATE TABLE `neosuniversity`.`tw_control_panel` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `course_id` INT NOT NULL,
  `email_id` VARCHAR(200) NOT NULL,
  `enrollment_date` DATE NOT NULL COMMENT 'Fecha de inscripcion\n',
  `no_classess_completed` INT NOT NULL,
  `isComplete` INT NOT NULL,
  PRIMARY KEY (`id`));


CREATE TABLE `neosuniversity`.`tr_course_section` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `course_id` INT NOT NULL,
  `sectionNumber` INT NOT NULL,
  `description` VARCHAR(300) NOT NULL,
  `numberClasses` INT NOT NULL,
  PRIMARY KEY (`id`));


CREATE TABLE `neosuniversity`.`tr_class` (
  `section_id` INT NOT NULL,
  `class_id` INT NOT NULL,
  `classDescription` VARCHAR(1000) NOT NULL,
  `activityType` INT NOT NULL COMMENT '1 is Video, 2 is PDF, 3 is Lecture, 4 is an exam',
  `videoURL` VARCHAR(1000) NULL,
  `pdfURL` VARCHAR(1000) NULL,
  `examID` INT NULL,
  PRIMARY KEY (`section_id`, `class_id`));

CREATE TABLE `neosuniversity`.`tw_section` (
  `control_panel_id` BIGINT NOT NULL,
  `section_id` INT NOT NULL,
  `classesCompleted` INT NOT NULL,
  PRIMARY KEY (`control_panel_id`, `section_id`));

CREATE TABLE `neosuniversity`.`tw_class` (
  `control_panel_id` BIGINT NOT NULL,
  `section_id` INT NOT NULL,
  `class_id` INT NOT NULL,
  `isCompleted` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`control_panel_id`, `section_id`, `class_id`));


/*
FOREIGN keys
*/
ALTER TABLE neosuniversity.tc_course
ADD  FOREIGN KEY (author_id)
REFERENCES neosuniversity.tc_author (id);

ALTER TABLE neosuniversity.tr_requirement_course
ADD  FOREIGN KEY (course_id)
REFERENCES neosuniversity.tc_course (id);

ALTER TABLE neosuniversity.tr_requirement_course
ADD  FOREIGN KEY (requirement_id)
REFERENCES neosuniversity.tc_requirement (id);

ALTER TABLE neosuniversity.tr_categ_course
ADD  FOREIGN KEY (category_id)
REFERENCES neosuniversity.tc_category (id);

ALTER TABLE neosuniversity.tr_categ_course
ADD  FOREIGN KEY (course_id)
REFERENCES neosuniversity.tc_course (id);

ALTER TABLE neosuniversity.tr_objective_course
ADD  FOREIGN KEY (course_id)
REFERENCES neosuniversity.tc_course (id);

ALTER TABLE neosuniversity.tr_objective_course
ADD  FOREIGN KEY (objective_id)
REFERENCES neosuniversity.tc_objective (id);

ALTER TABLE neosuniversity.tw_class
ADD  FOREIGN KEY (control_panel_id)
REFERENCES neosuniversity.tw_control_panel (id);

ALTER TABLE neosuniversity.tw_class
ADD  FOREIGN KEY (section_id)
REFERENCES neosuniversity.tr_course_section (id);

ALTER TABLE neosuniversity.tw_section
ADD  FOREIGN KEY (control_panel_id)
REFERENCES neosuniversity.tw_control_panel (id);

ALTER TABLE neosuniversity.tw_section
ADD  FOREIGN KEY (section_id)
REFERENCES neosuniversity.tr_course_section (id);

ALTER TABLE neosuniversity.tr_class
ADD  FOREIGN KEY (section_id)
REFERENCES neosuniversity.tr_course_section (id);

ALTER TABLE neosuniversity.tr_course_section
ADD  FOREIGN KEY (course_id)
REFERENCES neosuniversity.tc_course (id);


ALTER TABLE neosuniversity.tw_control_panel
ADD  FOREIGN KEY (course_id)
REFERENCES neosuniversity.tc_course (id);

ALTER TABLE neosuniversity.tw_control_panel
ADD  FOREIGN KEY (email_id)
REFERENCES neosuniversity.tw_user (email);

ALTER TABLE neosuniversity.tw_user
ADD  FOREIGN KEY (country_id)
REFERENCES neosuniversity.tc_country (id);

/*is pending tw_control_panel*/


/*inserts*/

INSERT INTO `neosuniversity`.`tc_category`
(
`categoryName`)
VALUES
(
'Herramientas de desarrollo');

INSERT INTO `neosuniversity`.`tc_category`
(
`categoryName`)
VALUES
(
'Programación Web');


INSERT INTO `neosuniversity`.`tc_author`
(
 `name`,
 `lastName`,
 `title`,
 `resume`)
VALUES
  (
   'Mario',
   'Hidalgo',
   'Ing.',
   'Desarrollador Full Stack, certificado en Java 8 ');


INSERT INTO `neosuniversity`.`tc_course`
(
  `courseName`,
  `author_id`,
  `numbClasses`,
  `numHrsVideo`,
  `courseDesc`,
  `isFree`,
  `cost`)
VALUES
  (
    'Git de principiante a experto',
    1,
    20,
    4,
    'This course is designed to be a comprehensive approach to Git, which means no prior knowledge or experience is required but students will emerge at the end with a very solid understanding and hands-on experience with Git and related source control concepts.',
    1,
    0.0);

INSERT INTO `neosuniversity`.`tr_course_section`
(
  `course_id`,
  `sectionNumber`,
  `description`,
  `numberClasses`)
VALUES
  (
    1,
    1,
    'Introducción a Git',
    8);


INSERT INTO `neosuniversity`.`tr_class`
(`section_id`,
 `class_id`,
 `classDescription`,
 `activityType`,
 `videoURL`,
 `pdfURL`,
 `examID`)
VALUES
  (1,
   1,
   'Historia de Git',
   1,
   'http://youtube.com/neosuniversity/fdfdf?32434',
   NULL,
   NULL);

INSERT INTO `neosuniversity`.`tr_class`
(`section_id`,
 `class_id`,
 `classDescription`,
 `activityType`,
 `videoURL`,
 `pdfURL`,
 `examID`)
VALUES
  (1,
   2,
   'Porque usar Git y Github',
   1,
   'http://youtube.com/neosuniversity/fdfdf?32434',
   NULL,
   NULL);


INSERT INTO `neosuniversity`.`tr_class`
(`section_id`,
 `class_id`,
 `classDescription`,
 `activityType`,
 `videoURL`,
 `pdfURL`,
 `examID`)
VALUES
  (1,
   3,
   'Descargar Git client en Windows / Linux',
   1,
   'http://youtube.com/neosuniversity/fdfdf?32434',
   NULL,
   NULL);



INSERT INTO `neosuniversity`.`tr_class`
(`section_id`,`class_id`,`classDescription`,
 `activityType`,
 `videoURL`,
 `pdfURL`,
 `examID`)
VALUES
  (1,
   4,
   'Instalación de Git Client',
   1,
   'http://youtube.com/neosuniversity/fdfdf?32434',
   NULL,
   NULL);


INSERT INTO `neosuniversity`.`tw_user`
(`username`,
 `completeName`,
 `email`,
 `pwd`,
 `country_id`)
VALUES
  ('neossoftware',
   'Mario Hidalgo Martínez',
   'mario.hidalgom@yahoo.com.mx',
   '$2y$12$/2WvvYz7vb1C3SuwgGEugebmKW6sCUq9MKo16OAPSurLeMMP2KfzG',
   NULL);

INSERT INTO `neosuniversity`.`tw_control_panel`
(
  `course_id`,
  `email_id`,
  `enrollment_date`,
  `no_classess_completed`,
  `isComplete`)
VALUES
  (1,
   'mario.hidalgom@yahoo.com.mx',
   '2017-05-14',
   0,
   0);

INSERT INTO `neosuniversity`.`tr_categ_course`(`category_id`,`course_id`)
 VALUES (1,1);

INSERT INTO `neosuniversity`.`tr_categ_course`(`category_id`,`course_id`)
 VALUES (2,1);

INSERT INTO `neosuniversity`.`tc_objective`(`id`,`objectiveName`)
 VALUES (1,'Conocerá los principios basicos del control de versiones');

INSERT INTO `neosuniversity`.`tr_objective_course`(`objective_id`,`course_id`)
VALUES (1,1);

INSERT INTO `neosuniversity`.`tc_requirement`(`id`,`requirement`)
 VALUES (1,'Conocimientos basicos en computacion');

INSERT INTO `neosuniversity`.`tc_requirement`(`id`,`requirement`)
VALUES (2,'Conocimientos basicos para instalar software');

INSERT INTO `neosuniversity`.`tc_requirement`(`id`,`requirement`)
 VALUES (3,'Permisos de administrador para instalar software');

 INSERT INTO `neosuniversity`.`tr_requirement_course`(`requirement_id`,`course_id`)
 VALUES (1,1);

INSERT INTO `neosuniversity`.`tr_requirement_course`(`requirement_id`,`course_id`)
VALUES (2,1);

INSERT INTO `neosuniversity`.`tr_requirement_course`(`requirement_id`,`course_id`)
 VALUES (3,1);

commit;
