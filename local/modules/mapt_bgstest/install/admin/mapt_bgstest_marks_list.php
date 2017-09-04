<?

if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/modules/mapt_bgstest/admin/marks_list.php")) {
	include($_SERVER["DOCUMENT_ROOT"]."/local/modules/mapt_bgstest/admin/marks_list.php");
} else {
	include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/mapt_bgstest/admin/marks_list.php");
}