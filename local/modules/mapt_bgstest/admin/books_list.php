<?
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;
use Mapt\BGSTest\BooksTable;
use Mapt\Tools\AdminModelList;

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

Loc::loadMessages(__FILE__);

if (!$GLOBALS["USER"]->IsAdmin())
	$GLOBALS["APPLICATION"]->AuthForm(Loc::getMessage("ACCESS_DENIED"));

if (!Loader::includeModule("mapt_tools"))
	$GLOBALS["APPLICATION"]->AuthForm(Loc::getMessage("ACCESS_DENIED"));

if (!Loader::includeModule("mapt_bgstest"))
	$GLOBALS["APPLICATION"]->AuthForm(Loc::getMessage("ACCESS_DENIED"));

$w = new AdminModelList(BooksTable::getEntity());
$w->setFilterEnabled(true);
$w->setViewEnabled(true);
$w->setDeleteEnabled(true);
$w->setAddEnabled(true);
$w->setEditEnabled(true);
$w->prolog();

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

$w->epilog();

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");