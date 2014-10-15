/* TODO: manually: ALTER DATABASE intranet CHARACTER SET utf8 COLLATE utf8_unicode_ci; */

/* rename tables */
RENAME TABLE `Banner_Images` TO `Banner_Image`;
RENAME TABLE `Door_Closures` TO `Door_Closure`;
RENAME TABLE `Groups` TO `Group`;
RENAME TABLE `My_Links` TO `My_Link`;
RENAME TABLE `Pages` TO `Page`;
RENAME TABLE `Pages_Xrf` TO `Page_Item`;
RENAME TABLE `Personal_Links` TO `Personal_Link`;
RENAME TABLE `Section_Groups` TO `Section_Group`;
RENAME TABLE `Section_Groups_Item_Xrf` TO `Section_Group_Item`;
RENAME TABLE `Settings` TO `Setting`;
RENAME TABLE `Users` TO `User`;

/* update table storage engine and charsets */
ALTER TABLE `Announcement`       ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `Banner_Image`       ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `Door_Closure`       ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `Group`              ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `Intranet_Group`     ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `Intranet_Hierarchy` ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `Item`               ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `Link_Of_The_Week`   ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `My_Link`            ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `News`               ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `Page`               ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `Page_Item`          ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `Personal_Link`      ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `Section`            ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `Section_Group`      ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `Section_Group_Item` ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `Setting`            ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `Subsection`         ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `User`               ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

/* delete existing foreign keys */
ALTER TABLE `My_Link` DROP FOREIGN KEY `My_LinksPersonal_LinksFK`;
DROP INDEX `My_LinksFK` ON `MyLink`;
ALTER TABLE `Page_Item` DROP FOREIGN KEY `FK_Pages_Xrf`;
ALTER TABLE `Page_Item` DROP FOREIGN KEY `FK_Pages_Xrf2`;
DROP INDEX `FK_Pages_Xrf2` ON `PageItem`;

/* update table schema */
ALTER TABLE  `Announcement` CHANGE  `ID`  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE  `Title`  `title` VARCHAR( 200 ) NOT NULL ,
CHANGE  `Description`  `description` TEXT NOT NULL ,
CHANGE  `Last_Updated_DateTime`  `lastUpdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE  `DateTime`  `announcedTime` TIMESTAMP NOT NULL DEFAULT  '0000-00-00 00:00:00',
CHANGE  `Excerpt`  `excerpt` VARCHAR( 2000 ) NOT NULL ,
CHANGE  `Displayed`  `displayed` CHAR( 1 ) NOT NULL DEFAULT  'N';

ALTER TABLE  `Banner_Image` CHANGE  `Id`  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE  `Image_Name`  `name` VARCHAR( 200 ) NOT NULL ,
CHANGE  `Alt_Text`  `altText` VARCHAR( 500 ) NOT NULL ,
CHANGE  `Artist`  `artist` VARCHAR( 1000 ) NOT NULL ,
CHANGE  `Title`  `title` VARCHAR( 1000 ) NOT NULL ,
CHANGE  `Link`  `link` VARCHAR( 2000 ) NOT NULL ,
CHANGE  `Link_Text`  `linkText` VARCHAR( 2000 ) NOT NULL ;

ALTER TABLE  `Door_Closure` CHANGE  `ID`  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE  `Title`  `title` VARCHAR( 45 ) NOT NULL ,
CHANGE  `Description`  `description` TEXT NOT NULL ,
CHANGE  `Submission_DateTime`  `submittedTime` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE  `Group` CHANGE  `title`  `title` VARCHAR( 2000 ) NOT NULL ;

ALTER TABLE  `Intranet_Group` CHANGE  `Item_Id`  `itemId` INT( 11 ) UNSIGNED NOT NULL ,
CHANGE  `Ordinal`  `ordinal` INT( 4 ) UNSIGNED NOT NULL ;
ALTER TABLE  `Intranet_Group` ADD  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ;

ALTER TABLE  `Intranet_Hierarchy` CHANGE  `Item_Id`  `itemId` INT( 11 ) UNSIGNED NOT NULL ,
CHANGE  `One`  `one` SMALLINT( 1 ) UNSIGNED NOT NULL ,
CHANGE  `Two`  `two` SMALLINT( 1 ) UNSIGNED NOT NULL ,
CHANGE  `Three`  `three` SMALLINT( 1 ) UNSIGNED NOT NULL ;
--TODO: drop primary index on item_id
ALTER TABLE  `Intranet_Hierarchy` ADD  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ;

ALTER TABLE  `Item` CHANGE  `Id`  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE  `Title`  `title` VARCHAR( 200 ) NOT NULL ,
CHANGE  `Short_Title`  `shortTitle` CHAR( 30 ) NOT NULL ,
CHANGE  `Description`  `description` VARCHAR( 6000 ) NOT NULL ,
CHANGE  `Url`  `url` VARCHAR( 500 ) NOT NULL ,
CHANGE  `Phone_Number`  `phoneNumber` BIGINT( 10 ) NOT NULL ,
CHANGE  `Display_Homepage`  `displayOnHomePage` CHAR( 1 ) NOT NULL ,
CHANGE  `External_Link`  `externalLink` CHAR( 1 ) NOT NULL DEFAULT  'N',
CHANGE  `Display_Disclaimer`  `disclaimer` CHAR( 1 ) NOT NULL DEFAULT  'N',
CHANGE  `Multiple_Line`  `multipleLine` CHAR( 1 ) NOT NULL DEFAULT  'N',
CHANGE  `Is_PDF`  `isPdf` CHAR( 1 ) NOT NULL DEFAULT  'N',
CHANGE  `PDF_Size`  `pdfSize` VARCHAR( 20 ) NOT NULL ;

ALTER TABLE  `Link_Of_The_Week` CHANGE  `ID`  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE  `Title`  `title` VARCHAR( 200 ) NOT NULL ,
CHANGE  `Url`  `url` VARCHAR( 500 ) NOT NULL ,
CHANGE  `Description`  `description` TEXT NOT NULL ,
CHANGE  `Status_Level`  `status_level` CHAR( 1 ) NOT NULL DEFAULT  '',
CHANGE  `Submitter`  `submitter` VARCHAR( 100 ) NOT NULL ,
CHANGE  `Submission_DateTime`  `submitted` TIMESTAMP NOT NULL ,
CHANGE  `LOW_Start_DateTime`  `start_date` DATE NOT NULL ,
CHANGE  `LOW_End_DateTime`  `end_date` DATE NOT NULL ,
CHANGE  `Displayed`  `displayed` CHAR( 1 ) NOT NULL DEFAULT  'N';

ALTER TABLE  `My_Link` CHANGE  `Id`  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE  `Username`  `username` VARCHAR( 10 ) NOT NULL ,
CHANGE  `Item_Id`  `item_id` INT( 11 ) UNSIGNED NOT NULL  ;

ALTER TABLE  `News` CHANGE  `ID`  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE  `Title`  `title` VARCHAR( 200 ) NOT NULL ,
CHANGE  `Description`  `description` TEXT NOT NULL ,
CHANGE  `Last_Updated_DateTime`  `lastUpdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE  `Excerpt`  `excerpt` VARCHAR( 500 ) NOT NULL ,
CHANGE  `Displayed`  `displayed` CHAR( 1 ) NOT NULL DEFAULT  'N',
CHANGE  `DateTime`  `newsTime` TIMESTAMP NOT NULL DEFAULT  '0000-00-00 00:00:00';

ALTER TABLE  `Page` CHANGE  `Id`  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE  `Name`  `name` VARCHAR( 500 ) NOT NULL ,
CHANGE  `Description`  `description` VARCHAR( 2000 ) NOT NULL ,
CHANGE  `Short_Name`  `shortName` VARCHAR( 100 ) NOT NULL ,
CHANGE  `Banner_Number`  `bannerNumber` CHAR( 2 ) NOT NULL ;

ALTER TABLE  `Page_Item` CHANGE  `page_id`  `page_id` INT( 11 ) UNSIGNED NOT NULL ,
CHANGE  `item_id`  `item_id` INT( 11 ) UNSIGNED NOT NULL ;
--TODO: drop primary key
ALTER TABLE  `Page_Item` ADD  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ;

ALTER TABLE  `Personal_Link` CHANGE  `Id`  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE  `Username`  `username` CHAR( 10 ) NOT NULL DEFAULT  '',
CHANGE  `Title`  `title` VARCHAR( 100 ) NOT NULL ,
CHANGE  `Url`  `url` VARCHAR( 500 ) NOT NULL ;

ALTER TABLE  `Section` CHANGE  `Id`  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE  `Title`  `title` VARCHAR( 200 ) NOT NULL COMMENT  'Title of the Section';

ALTER TABLE  `Section_Group` CHANGE  `Id`  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE  `Section_Id`  `sectionId` INT( 11 ) UNSIGNED NOT NULL ,
CHANGE  `Subsection_Id`  `subsectionId` INT( 11 ) UNSIGNED NOT NULL ,
CHANGE  `Group_Id`  `groupId` INT( 11 ) UNSIGNED NOT NULL ,
CHANGE  `Subsection_Ordinal`  `subsectionOrdinal` INT( 4 ) UNSIGNED NOT NULL ,
CHANGE  `Group_Ordinal`  `groupOrdinal` INT( 4 ) UNSIGNED NOT NULL ;

ALTER TABLE  `Section_Group_Item` CHANGE  `Section_Group_Id`  `sectionGroupId` INT( 11 ) UNSIGNED NOT NULL ,
CHANGE  `Item_Id`  `itemId` INT( 11 ) UNSIGNED NOT NULL ,
CHANGE  `Item_Ordinal`  `itemOrdinal` INT( 11 ) UNSIGNED NOT NULL ;
ALTER TABLE  `Section_Group_Item` ADD  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST

ALTER TABLE  `Setting` ADD  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ;
ALTER TABLE  `Setting` CHANGE  `id`  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE  `Setting`  `name` VARCHAR( 2000 ) NOT NULL ,
CHANGE  `Value`  `value` VARCHAR( 5000 ) NOT NULL ,
CHANGE  `Last_Updated_DateTime`  `lastUpdate` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE  `Subsection` CHANGE  `Id`  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE  `Title`  `title` VARCHAR( 200 ) NOT NULL COMMENT  'Title of the subsection';

ALTER TABLE User DROP PRIMARY KEY;
ALTER TABLE  `User` ADD  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ;
ALTER TABLE  `User` CHANGE  `id`  `id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE  `User_Id`  `username` VARCHAR( 255 ) NOT NULL ,
CHANGE  `Password`  `hash` VARCHAR( 255 ) NOT NULL ,
CHANGE  `First_Name`  `firstName` VARCHAR( 100 ) NOT NULL ,
CHANGE  `Last_Name`  `lastName` VARCHAR( 100 ) NOT NULL ,
CHANGE  `Email_Address`  `email` VARCHAR( 100 ) NOT NULL ,
CHANGE  `Phone_Number`  `phone` BIGINT( 10 ) UNSIGNED NOT NULL ;

ALTER TABLE  `User` ADD  `address` VARCHAR( 255 ) NOT NULL ,
ADD  `city` VARCHAR( 255 ) NOT NULL ,
ADD  `state` VARCHAR( 255 ) NOT NULL ,
ADD  `zip` VARCHAR( 255 ) NOT NULL ,
ADD  `active` TINYINT( 1 ) UNSIGNED NOT NULL ;

--clean up data (html entities shouldn't be in the database)
UPDATE Item set title = REPLACE(title, '&amp;', '&'),
short_title = REPLACE(short_title, '&amp;', '&'),
description = REPLACE(description, '&amp;', '&');



/* TODO: add foreign key constraints and indexes */

