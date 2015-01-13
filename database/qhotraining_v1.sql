/*
SQLyog Community v9.63 
MySQL - 5.0.45-community-nt : Database - qhotraining
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `qhotraining`;

/*Table structure for table `qhotraining_tbl_masterupload` */

DROP TABLE IF EXISTS `qhotraining_tbl_masterupload`;

CREATE TABLE `qhotraining_tbl_masterupload` (
  `MasterUploadId` int(10) unsigned NOT NULL auto_increment,
  `MasterUploadTableName` varchar(100) default NULL,
  `MasterUploadTableId` int(11) default NULL,
  `MaxFileUpload` int(11) default NULL COMMENT 'Tong so file duoc upload toi da',
  `TotalFileUpload` int(11) default NULL COMMENT 'Tong so file da duoc upload',
  `MaxFileSize` int(11) default NULL COMMENT 'KB',
  `MasterUploadType` varchar(20) default NULL,
  `MasterUploadStatus` varchar(20) default NULL,
  `MasterUploadCreateId` int(11) default NULL,
  `MasterUploadCreateName` varchar(50) default NULL,
  `MasterUploadUpdateId` int(11) default NULL,
  `MasterUploadUpdateName` varchar(50) default NULL,
  `MasterUploadCreateDate` datetime default NULL,
  `MasterUploadUpdateDate` datetime default NULL,
  PRIMARY KEY  (`MasterUploadId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `qhotraining_tbl_masterupload` */

/*Table structure for table `qhotraining_tbl_maxupload` */

DROP TABLE IF EXISTS `qhotraining_tbl_maxupload`;

CREATE TABLE `qhotraining_tbl_maxupload` (
  `MaxUploadId` int(10) unsigned NOT NULL auto_increment,
  `MaxUploadTableName` varchar(100) default NULL,
  `MaxUploadTableId` int(11) default NULL,
  `MaxUpload` int(11) default NULL COMMENT 'tong so file dc upload toi da',
  `TotalUploaded` int(11) default NULL COMMENT 'tong so file da upload',
  `MaxUploadCreateId` int(11) default NULL,
  `MaxUploadCreateName` varchar(50) default NULL,
  `MaxUploadUpdateId` int(11) default NULL,
  `MaxUploadUpdateName` varchar(50) default NULL,
  `MaxUploadCreateDate` datetime default NULL,
  `MaxUploadUpdateDate` datetime default NULL,
  PRIMARY KEY  (`MaxUploadId`),
  KEY `MaxUpload_Idx_TableName` (`MaxUploadTableName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `qhotraining_tbl_maxupload` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
