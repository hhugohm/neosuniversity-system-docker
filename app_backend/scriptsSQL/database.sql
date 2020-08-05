/*script database neosuniversity
*/

create user 'neossoftware'@'localhost' identified by 'discom';


/*CREATE DATABASE neosuniversity CHARACTER SET utf8 COLLATE utf8_spanish_ci;
*/

GRANT ALL PRIVILEGES ON neosuniversity.* TO 'neossoftware'@'localhost' WITH GRANT OPTION;

flush privileges;


/*tables catalogs
*/

CREATE DATABASE IF NOT EXISTS `neosuniversity` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;

USE `neosuniversity`;

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
    `imgThumb` VARCHAR(500) NOT NULL,
    `shortdesc` varchar(500) NOT NULL,
    `imgcourse` varchar(250) NOT NULL,
    `creationDate` DATE NOT NULL COMMENT 'Fecha de creacion del curso\n',
    PRIMARY KEY (`id`));

  ALTER TABLE `neosuniversity`.`tc_course` ADD COLUMN isOnline INT NOT NULL DEFAULT 0;

  ALTER TABLE `neosuniversity`.`tc_course` ADD COLUMN urlCourseOnline varchar(1000)  NULL;



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
  `hash_reset` VARCHAR(500) NULL,
  `rol_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`email`));


CREATE TABLE `neosuniversity`.`tw_control_panel` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `course_id` INT NOT NULL,
  `email_id` VARCHAR(200) NOT NULL,
  `enrollment_date` DATE NOT NULL COMMENT 'Fecha de inscripcion\n',
  `no_classess_completed` INT NOT NULL,
  `isComplete` INT NOT NULL,
  PRIMARY KEY (`id`));

  ALTER TABLE `neosuniversity`.`tw_control_panel` ADD COLUMN payIsComplete INT  NULL DEFAULT 0;
  ALTER TABLE `neosuniversity`.`tw_control_panel` ADD COLUMN paypalOrderId VARCHAR(100)  NULL;
  ALTER TABLE `neosuniversity`.`tw_control_panel` ADD COLUMN paypalPaymentId VARCHAR(100)  NULL ;



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

/** new feature file attach*/
CREATE TABLE `neosuniversity`.`tr_class_files` (
  `id` INT NOT NULL AUTO_INCREMENT,
 `section_id` INT NOT NULL,
  `class_id` INT NOT NULL,
  `fileName` VARCHAR (100) NOT NULL,
  `filePath` VARCHAR (200) NOT NULL,
  `description` VARCHAR (500) NULL,
   PRIMARY KEY (`id`)
);


CREATE TABLE `neosuniversity`.`tw_section` (
  `control_panel_id` BIGINT NOT NULL,
  `section_id` INT NOT NULL,
  `classesCompleted` INT NOT NULL,
  PRIMARY KEY (`control_panel_id`, `section_id`));

CREATE TABLE `neosuniversity`.`tw_class` (
  `control_panel_id` BIGINT NOT NULL,
  `section_id` INT NOT NULL,
  `class_id` INT NOT NULL,
  `isCompleted` INT NOT NULL,
  PRIMARY KEY (`control_panel_id`, `section_id`, `class_id`));

  CREATE TABLE `neosuniversity`.`tw_preinscripcion` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `course_id` INT NOT NULL,
  `email` VARCHAR(200) NOT NULL,
  `nombre` VARCHAR(1000) NOT NULL,
  `telefono` VARCHAR(100) NULL,
  `pais` VARCHAR(100) NOT NULL,
  `tipo_pago` INT NOT NULL,
  `fecha_pago` DATE NOT NULL,
  `fecha_preinscripcion` DATE NOT NULL,
  PRIMARY KEY (`id`));



/*
FOREIGN keys
*/
ALTER TABLE neosuniversity.tc_course
ADD  FOREIGN KEY (author_id)
REFERENCES neosuniversity.tc_author (id);

ALTER TABLE `neosuniversity`.`tw_preinscripcion`
ADD  FOREIGN KEY (course_id)
REFERENCES `neosuniversity`.`tc_course` (`id`);

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
REFERENCES neosuniversity.tw_control_panel (id)
ON DELETE CASCADE;

ALTER TABLE neosuniversity.tw_class
ADD  FOREIGN KEY (section_id)
REFERENCES neosuniversity.tr_course_section (id);

ALTER TABLE neosuniversity.tw_section
ADD  FOREIGN KEY (control_panel_id)
REFERENCES neosuniversity.tw_control_panel (id)
ON DELETE CASCADE;

ALTER TABLE neosuniversity.tw_section
ADD  FOREIGN KEY (section_id)
REFERENCES neosuniversity.tr_course_section (id);

ALTER TABLE neosuniversity.tr_class
ADD  FOREIGN KEY (section_id)
REFERENCES neosuniversity.tr_course_section (id);

ALTER TABLE neosuniversity.tr_class_files
ADD  FOREIGN KEY (section_id,class_id)
REFERENCES neosuniversity.tr_class (section_id,class_id);


ALTER TABLE neosuniversity.tr_course_section
ADD  FOREIGN KEY (course_id)
REFERENCES neosuniversity.tc_course (id);


ALTER TABLE neosuniversity.tw_control_panel
ADD  FOREIGN KEY (course_id)
REFERENCES neosuniversity.tc_course (id);

ALTER TABLE neosuniversity.tw_control_panel
ADD  FOREIGN KEY (email_id)
REFERENCES neosuniversity.tw_user (email)
ON DELETE CASCADE; /* TODO quitar esto es para fines de desarrollo*/

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


INSERT INTO `neosuniversity`.`tc_author`
(
 `name`,
 `lastName`,
 `title`,
 `resume`)
VALUES
  (
   'Hugo',
   'Hidalgo',
   'Ing.',
   'Desarrollador Full Stack, certificado en Java 8 ');




INSERT INTO `neosuniversity`.`tc_course` (`id`, `courseName`,
`author_id`, `numbClasses`, `numHrsVideo`, `courseDesc`, `isFree`, `cost`, `imgThumb`, `shortdesc`, `imgcourse`, `creationDate`)
VALUES
	(1,'Git de principiante a experto',1,20,4.0,'<strong>Descripción general Curso Git y Github.</strong>\n<p>\nEn el curso de Git y Github aprenderán qué es el software de un sistema de control de versiones, en la unidad 1 se inicia con el concepto de sistema de control de versiones hasta su instalación,  en la unidad 2 se aborda propiamente el sistema de control de versiones, en la unidad 3 se trabaja con las ramas en Git y por último se hace referencia al manejo de Github.\n</p>\n<strong>\nObjetivo General:\n</strong>\n<p>\nEl estudiante aprenderá a manejar una de las herramientas más populares en el desarrollo colaborativo y que se ha convertido en un estandar en el control de versiones del código en los proyectos empresariales\n</p>',1,0.0,'img/neosuniv/git-logo.png','Con este curso entenderas las bases del sistema de control de versiones más usado en la industria del software','img/neosuniv/git3.png','2018-07-30');


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
    3);


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
   'Usando Git en el control de versiones',
   1,
   '//player.vimeo.com/video/248399799?portrait=0&autoplay=1',
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
   'Como descargar Git',
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
   'Como instalar Git en Windows',
   1,
   'http://youtube.com/neosuniversity/fdfdf?32434',
   NULL,
   NULL);


INSERT INTO `neosuniversity`.`tr_course_section`
(
  `course_id`,
  `sectionNumber`,
  `description`,
  `numberClasses`)
VALUES
  (
    1,
    2,
    'Conceptos y comandos básicos en Git',
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
  (2,
   1,
   'Configuración básica en Git',
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
  (2,
   2,
   'Inicializando un repositorio (teoría)',
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
  (2,
   3,
   'Inicializando un repositorio (práctica)',
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
  (2,
   4,
   'Ciclo de vida básico de un archivo en Git',
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
  (2,
   5,
   'Comandos básicos en un repositorio Git ',
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
  (2,
   6,
   'Comandos básicos en un repositorio - Práctica 1 ',
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
  (2,
   7,
   'Comandos básicos en un repositorio - Práctica 2 ',
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
  (2,
   8,
   'Comandos básicos en un repositorio - Práctica 3 ',
   1,
   'http://youtube.com/neosuniversity/fdfdf?32434',
   NULL,
   NULL);



INSERT INTO `neosuniversity`.`tw_user`
(`username`,
 `completeName`,
 `email`,
 `pwd`,
 `country_id`,
 `rol_id`
 )
VALUES
  ('neossoftware',
   'Mario Hidalgo Martínez',
   'mario.hidalgom@yahoo.com.mx',
   '$2y$12$/2WvvYz7vb1C3SuwgGEugebmKW6sCUq9MKo16OAPSurLeMMP2KfzG',
   NULL,2);

/*
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
   0);*/

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


/*
 INSERT INTO `neosuniversity`.`tc_course` (`courseName`, `author_id`, `numbClasses`, `numHrsVideo`, `courseDesc`, `isFree`, `cost`) VALUES ('Java', '1', '50', '6.5', 'Curso diseñado para aprender Java desde cero', '1', '0.0');

INSERT INTO `neosuniversity`.`tr_course_section` (`id`, `course_id`, `sectionNumber`, `description`, `numberClasses`) VALUES ('2', '2', '1', 'Introduccion a Java', '10');

INSERT INTO `neosuniversity`.`tr_class` (`section_id`, `class_id`, `classDescription`, `activityType`, `videoURL`) VALUES ('2', '1', 'Instalacion de Java', '1', 'http://youtube.com/neosuniversity/fdfdf?22365');

INSERT INTO `neosuniversity`.`tr_course_section` (`course_id`, `sectionNumber`, `description`, `numberClasses`) VALUES ('1', '2', 'Comandos Basicos Git', '3');

INSERT INTO `neosuniversity`.`tr_class` (`section_id`, `class_id`, `classDescription`, `activityType`, `videoURL`) VALUES ('3', '1', 'Comando clone git', '1', 'http://youtube.com/neosuniversity/fdfdf?15261');

commit;


select * from tw_user;

delete from tw_user
where email = 'kris_gasca@hotmail.com';

select * from tw_control_panel;

delete from tw_control_panel where id=1;

commit;

select * from tw_class;

select * from tw_section;


select * from tr_course_section;

select * from tr_class;

*/