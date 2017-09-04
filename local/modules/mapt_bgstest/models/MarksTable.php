<?php

namespace Mapt\BGSTest;

use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Application;

class MarksTable extends DataManager {
	public static function getTableName() {
		return "b_mbgstest_books_marks";
	}
	public static function getMap() {
		return array(
			"ID" => new IntegerField("ID", array(
				"primary" => true,
				"unique" => true,
				"autocomplete" => true
			)),
			"BOOK_ID" => new IntegerField("BOOK_ID",array(
				"title"=>"ID книги"
			)),
			"MARK" => new IntegerField("MARK",array(
				"title"=>"ќценка"
			))
		);
	}
	public static function migrateUp() {
		self::migrateDown();
		Application::getConnection()->query("
			CREATE TABLE ".self::getTableName()." (
				`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
				`BOOK_ID` INT UNSIGNED NULL DEFAULT NULL,
				`MARK` INT UNSIGNED NOT NULL,
				
				PRIMARY KEY (`ID`),
				KEY (`BOOK_ID`) USING HASH,
				FOREIGN KEY (`BOOK_ID`) REFERENCES `".BooksTable::getTableName()."`(`ID`) ON DELETE CASCADE ON UPDATE CASCADE
			) ENGINE = InnoDB
		");
	}
	public static function migrateDown() {
		$conn = Application::getConnection();
		if ($conn->isTableExists(self::getTableName()))
			$conn->dropTable(self::getTableName());
	}
}