<?php
function plugin_version_winupdate()
{
return array('name' => 'winupdate',
'version' => '1.1',
'author'=> 'Guillaume PRIOU, Gilles DUBOIS',
'license' => 'GPLv2',
'verMinOcs' => '2.2');
}

function plugin_init_winupdate()
{
$object = new plugins;
$object -> add_cd_entry("winupdate","other");

// Officepack table creation

$object -> sql_query("CREATE TABLE IF NOT EXISTS `winupdatestate` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `HARDWARE_ID` INT(11) NOT NULL,
  `AUOPTIONS` VARCHAR(255) DEFAULT NULL,
  `SCHEDULEDINSTALLDATE` VARCHAR(255) DEFAULT NULL,
  `LASTSUCCESSTIME` VARCHAR(255) DEFAULT NULL,
  `DETECTSUCCESSTIME` VARCHAR(255) DEFAULT NULL,
  `DOWNLOADSUCCESSTIME` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY  (`ID`,`HARDWARE_ID`)
) ENGINE=INNODB ;");

}

function plugin_delete_winupdate()
{
$object = new plugins;
$object -> del_cd_entry("winupdate");

$object -> sql_query("DROP TABLE `winupdatestate`;");

}

?>
