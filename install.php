<?php

/**
 * This function is called on installation and is used to create database schema for the plugin
 */
function extension_install_winupdate()
{
    $commonObject = new ExtensionCommon;

    $commonObject -> sqlQuery("DROP TABLE `winupdatestate`");

    $commonObject -> sqlQuery("CREATE TABLE `winupdatestate` (
                              `ID` INT(11) NOT NULL AUTO_INCREMENT,
                              `HARDWARE_ID` INT(11) NOT NULL,
                              `KB` VARCHAR(255) DEFAULT NULL,
                              `TITLE` VARCHAR(255) DEFAULT NULL,
                              `DATE` VARCHAR(255) DEFAULT NULL,
                              `OPERATION` VARCHAR(255) DEFAULT NULL,
                              `STATUS` VARCHAR(255) DEFAULT NULL,
                              `SUPPORTLINK` VARCHAR(255) DEFAULT NULL,
                              `DESCRIPTION` VARCHAR(255) DEFAULT NULL,
                              PRIMARY KEY  (`ID`,`HARDWARE_ID`)
                            ) ENGINE=INNODB ;");
}

/**
 * This function is called on removal and is used to destroy database schema for the plugin
 */
function extension_delete_winupdate()
{
    $commonObject = new ExtensionCommon;
    $commonObject -> sqlQuery("DROP TABLE `winupdatestate`");
}

/**
 * This function is called on plugin upgrade
 */
function extension_upgrade_winupdate()
{

}
