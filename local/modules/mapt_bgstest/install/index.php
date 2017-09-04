<?php
use Bitrix\Main\ModuleManager;
require_once(__DIR__."/../models/BooksTable.php");
require_once(__DIR__."/../models/MarksTable.php");
use Mapt\BGSTest\BooksTable;
use Mapt\BGSTest\MarksTable;

class mapt_bgstest extends CModule
{
	var $MODULE_ID = "mapt_bgstest";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;

	var $errors;

	function __construct()
	{
		$arModuleVersion = array();
		include(dirname(__FILE__)."/version.php");
		
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		
		$this->MODULE_NAME = "Mapt BGS test module";
		$this->MODULE_DESCRIPTION = "Mapt BGS test module";
		$this->PARTNER_NAME = "Mapt aka Malahov Artem";
		$this->PARTNER_URI = "http://ibs1c.ru";
	}

	function InstallDB() {
		BooksTable::migrateUp();
		MarksTable::migrateUp();
		return true;
	}
	function UnInstallDB($arParams = array()) {
		MarksTable::migrateDown();
		BooksTable::migrateDown();
		return true;
	}

	function InstallEvents() {
		return true;
	}
	function UnInstallEvents() {
		return true;
	}

	function InstallFiles() {
		CopyDirFiles(__DIR__."/js", $_SERVER["DOCUMENT_ROOT"]."/bitrix/js/".$this->MODULE_ID."/", true, true);
		CopyDirFiles(__DIR__."/components", $_SERVER["DOCUMENT_ROOT"]."/local/components/".$this->MODULE_ID."/", true, true);
		CopyDirFiles(__DIR__."/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin/", true, true);
		return true;
	}
	function UnInstallFiles() {
		DeleteDirFilesEx("/bitrix/js/".$this->MODULE_ID);
		DeleteDirFilesEx("/local/components/".$this->MODULE_ID);
		DeleteDirFiles(__DIR__."/admin/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin/");
		return true;
	}


	function DoInstall() {
		$RIGHT = $GLOBALS["APPLICATION"]->GetGroupRight($this->MODULE_ID);
		if($RIGHT == "W") {
			$this->InstallDB();
			ModuleManager::registerModule($this->MODULE_ID);
			$this->InstallEvents();
			$this->InstallFiles();
		}
	}

	function DoUninstall() {
		$RIGHT = $GLOBALS["APPLICATION"]->GetGroupRight($this->MODULE_ID);
		if($RIGHT == "W") {
			ModuleManager::unRegisterModule($this->MODULE_ID);
			$this->UnInstallDB();
			$this->UnInstallEvents();
			$this->UnInstallFiles();
		}
	}
}