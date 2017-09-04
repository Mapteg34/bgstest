<?php

namespace Mapt\BGSTest;

use Bitrix\Main\Entity;
use Bitrix\Main\Application;

class BooksTable extends Entity\DataManager {
	public static function getTableName() {
		return "b_mbgstest_books";
	}
	public static function getMap() {
		return array(
			"ID" => new Entity\IntegerField("ID", array(
				"primary" => true,
				"unique" => true,
				"autocomplete" => true
			)),
			"NAME" => new Entity\StringField("NAME", array(
				"title"=>"Название"
			)),
			"AUTHOR" => new Entity\StringField("AUTHOR", array(
				"title"=>"Автор"
			)),
			"RATING_AVG" => new Entity\ExpressionField('RATING_AVG',
				"IFNULL((SELECT AVG(MARK) FROM ".MarksTable::getTableName()." WHERE BOOK_ID=%s),0)",
				array('ID'),
				array(
					"title"=>"Рейтинг"
				)
			)
		);
	}
	public static function migrateUp() {
		self::migrateDown();
		Application::getConnection()->query("
			CREATE TABLE ".self::getTableName()." (
				`ID` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
				`NAME` VARCHAR(255) NOT NULL,
				`AUTHOR` VARCHAR(255) NOT NULL,
				
				PRIMARY KEY (`ID`),
				UNIQUE (`NAME`,`AUTHOR`)
			) ENGINE = InnoDB
		");
	}
	public static function migrateDown() {
		$conn = Application::getConnection();
		if ($conn->isTableExists(self::getTableName()))
			$conn->dropTable(self::getTableName());
	}
}
