<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
IncludeModuleLangFile(__FILE__);

$aMenu = array(
	"parent_menu" => "global_menu_services",
	"section" => "mapt_subscribe",
	"text" => "Books",
	"title" => "Books",
	"icon" => "-",
	"page_icon" => "-",
	"items_id" => "menu_mapt_bgstest",
	"items" => array(
		array(
			"text" => "Books",
			"url" => "mapt_bgstest_books_list.php?lang=".LANGUAGE_ID,
			"title" => "",
			"more_url" => Array()
		),
		array(
			"text" => "Marks",
			"url" => "mapt_bgstest_marks_list.php?lang=".LANGUAGE_ID,
			"title" => "",
			"more_url" => Array()
		)
	)
);

return !empty($aMenu) ? $aMenu : false;