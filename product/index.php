<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Товар");
?><?$APPLICATION->IncludeComponent(
	"dm:element",
	"",
	Array(
		"SEF_FOLDER" => "/product/",
		"SEF_MODE" => "Y",
		"SEF_URL_TEMPLATES" => array('element_code'=>'#ELEMENT_CODE#/',)
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>