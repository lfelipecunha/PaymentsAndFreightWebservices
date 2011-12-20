CREATE TABLE IF NOT EXISTS `users` (
  `id_user` BIGINT UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `username` VARCHAR(255)  NOT NULL  ,
  `password` CHAR(32)  NOT NULL    ,
PRIMARY KEY(`id_user`))
ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS `template_groups` (
  `id_template_group` BIGINT UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `modified_by` BIGINT UNSIGNED  NOT NULL  ,
  `create_by` BIGINT UNSIGNED  NOT NULL  ,
  `name` VARCHAR(255)  NOT NULL  ,
  `status` BOOL  NOT NULL DEFAULT TRUE ,
  date_created DATETIME  NOT NULL  ,
  date_modified DATETIME  NULL    ,
PRIMARY KEY(`id_template_group`)  ,
INDEX template_groups_FKIndex1(`create_by`)  ,
INDEX template_groups_FKIndex2(`modified_by`),
  FOREIGN KEY(`create_by`)
    REFERENCES users(`id_user`)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(`modified_by`)
    REFERENCES users(`id_user`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS `used_template_groups` (
  `id_used_template_group` BIGINT UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_template_group` BIGINT UNSIGNED  NOT NULL  ,
  `modified_by`  BIGINT UNSIGNED  NOT NULL  ,
  `created_by` BIGINT UNSIGNED  NOT NULL  ,
  `name` VARCHAR(255)  NOT NULL  ,
  `status` BOOL  NOT NULL  ,
  `date_created` DATETIME  NOT NULL  ,
  `date_modified` DATETIME  NULL  ,
  `smtp_user` VARCHAR(255)  NOT NULL  ,
  `smtp_password` VARCHAR(255)  NOT NULL  ,
  `smtp_server` VARCHAR(255)  NOT NULL  ,
  `smtp_port` INTEGER UNSIGNED  NOT NULL    ,
PRIMARY KEY(`id_used_template_group`) ,
INDEX `used_template_groups_FKIndex1`(`created_by`)  ,
INDEX `used_template_groups_FKIndex2`(`modified_by` )  ,
INDEX `used_template_groups_FKIndex3`(`id_template_group`),
  FOREIGN KEY(`created_by`)
    REFERENCES users(`id_user`)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(`modified_by` )
    REFERENCES users(`id_user`)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(`id_template_group`)
    REFERENCES template_groups(`id_template_group`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS `templates` (
  `id_template` BIGINT UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_template_group` BIGINT UNSIGNED  NOT NULL  ,
  `modified_by` BIGINT UNSIGNED  NOT NULL  ,
  `created_by` BIGINT UNSIGNED  NOT NULL  ,
  `name` INTEGER UNSIGNED  NOT NULL  ,
  `status` BOOL  NOT NULL DEFAULT TRUE ,
  `text` TEXT  NOT NULL  ,
  `date_created` DATETIME  NOT NULL  ,
  `date_modified` DATETIME  NULL    ,
PRIMARY KEY(`id_template`)  ,
INDEX `templates_FKIndex1`(`modified_by`)  ,
INDEX `templates_FKIndex2`(`created_by`)  ,
INDEX `templates_FKIndex3`(`id_template_group`),
  FOREIGN KEY(`modified_by`)
    REFERENCES users(`id_user`)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(`created_by`)
    REFERENCES users(`id_user`)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(`id_template_group`)
    REFERENCES template_groups(`id_template_group`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS `layouts` (
  `id_layout` BIGINT UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_used_template_group` BIGINT UNSIGNED  NOT NULL  ,
  `modified_by` BIGINT UNSIGNED  NOT NULL  ,
  `created_by` BIGINT UNSIGNED  NOT NULL  ,
  `name` VARCHAR(255)  NOT NULL  ,
  `text` TEXT  NOT NULL  ,
  `date_created` DATETIME  NOT NULL  ,
  `date_modified` DATETIME  NULL  ,
  `status` BOOL  NOT NULL DEFAULT TRUE   ,
PRIMARY KEY(`id_layout`)  ,
INDEX `layouts_FKIndex1`(`created_by`)  ,
INDEX `layouts_FKIndex2`(`modified_by`)  ,
INDEX `layouts_FKIndex3`(`id_used_template_group`),
  FOREIGN KEY(`created_by`)
    REFERENCES users(`id_user`)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(`modified_by`)
    REFERENCES users(`id_user`)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(`id_used_template_group`)
    REFERENCES `used_template_groups`(`id_used_template_group`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS `modified_templates` (
  `id_modified_template` BIGINT UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_layout` BIGINT UNSIGNED  NOT NULL  ,
  `id_used_template_group` BIGINT UNSIGNED  NOT NULL  ,
  `id_template_group` BIGINT UNSIGNED  NOT NULL  ,
  `modified_by` BIGINT UNSIGNED  NOT NULL  ,
  `created_by` BIGINT UNSIGNED  NOT NULL  ,
  `text` TEXT  NOT NULL  ,
  `date_modified` DATETIME  NULL  ,
  `date_created` DATETIME  NOT NULL  ,
  `status` BOOL  NOT NULL DEFAULT TRUE ,
  `sender` VARCHAR(255)  NULL  ,
  `cc` VARCHAR(255)  NULL  ,
  `bcc` VARCHAR(255)  NULL  ,
  `mail_return` VARCHAR(255)  NULL    ,
PRIMARY KEY(`id_modified_template`)  ,
INDEX `modified_templates_FKIndex1`(`created_by`)  ,
INDEX `modified_templates_FKIndex2`(`modified_by`)  ,
INDEX `modified_templates_FKIndex3`(`id_template_group`)  ,
INDEX `modified_templates_FKIndex4`(`id_used_template_group`)  ,
INDEX `modified_templates_FKIndex5`(`id_layout`),
  FOREIGN KEY(`created_by`)
    REFERENCES users(`id_user`)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(`modified_by`)
    REFERENCES users(`id_user`)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(`id_template_group`)
    REFERENCES template_groups(`id_template_group`)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(`id_used_template_group`)
    REFERENCES `used_template_groups`(`id_used_template_group`)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(`id_layout`)
    REFERENCES `layouts`(`id_layout`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS `variables` (
  `id_variables` BIGINT UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_template` BIGINT UNSIGNED  NOT NULL  ,
  `modified_by` BIGINT UNSIGNED  NOT NULL  ,
  `created_by` BIGINT UNSIGNED  NOT NULL  ,
  `name` VARCHAR(255)  NOT NULL  ,
  `description` VARCHAR(255)  NOT NULL  ,
  `date_created` DATETIME  NOT NULL  ,
  `date_modified` DATETIME  NULL    ,
PRIMARY KEY(`id_variables`)  ,
INDEX `variables_FKIndex1`(`modified_by`)  ,
INDEX `variables_FKIndex2`(`created_by`)  ,
INDEX `variables_FKIndex3`(`id_template`),
  FOREIGN KEY(`modified_by`)
    REFERENCES users(`id_user`)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(`created_by`)
    REFERENCES users(`id_user`)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(`id_template`)
    REFERENCES templates(`id_template`)
      ON DELETE CASCADE
      ON UPDATE CASCADE) ENGINE=INNODB;




