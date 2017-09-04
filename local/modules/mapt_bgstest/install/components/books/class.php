<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Mapt\BGSTest\BooksTable;
use Mapt\BGSTest\MarksTable;
use Bitrix\Main\Web\Json;

class MaptSubscribe extends CBitrixComponent {
	private function ajax_result($arResult) {
		$GLOBALS["APPLICATION"]->RestartBuffer();
		echo Json::encode($arResult);
		die();
	}
	private function ajax_error($errorText) {
		return $this->ajax_result(array("state"=>"error","errorText" =>$errorText));
	}
	private function ajax_success($result=false) {
		$arResult = array("state"=>"success");
		
		if ($result!==false)
			$arResult["result"]=$result;
		
		return $this->ajax_result($arResult);
	}
	private function action_list() {
		if ($this->StartResultCache()) {
			$this->arResult["BOOKS"] = array();

			$rsBooks = BooksTable::GetList(array(
				"select"=>array_keys(BooksTable::getMap())
			));

			while ($arBook = $rsBooks->fetch())
				$this->arResult["BOOKS"][] = $arBook;

			$this->includeComponentTemplate();
		}
		
		return true;
	}
	private function action_mark($book_id,$mark) {
		if (!in_array($mark,array(1,2,3,4,5)))
			return $this->ajax_error("Invalid mark");
		
		$res = MarksTable::add(array(
			"BOOK_ID"=>$book_id,
			"MARK"=>$mark
		));
		
		if (!$res->isSuccess())
			return $this->ajax_error(implode(";",$res->getErrorMessages()));
		
		$book_avg = BooksTable::getByPrimary($book_id,array("select"=>array("RATING_AVG")))->fetch()["RATING_AVG"];
		
		return $this->ajax_success($book_avg);
	}
	public function executeComponent() {
		if (!CModule::IncludeModule("mapt_bgstest")) {
			ShowError("Failed include mapt_bgstest module");
			return;
		}
		
		if ($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["FORM_ID"]) && $_POST["FORM_ID"]=="BOOKS_RATING" && check_bitrix_sessid())
			return $this->action_mark($_POST["BOOK_ID"],$_POST["MARK"]);
		
		return $this->action_list();
	}
}