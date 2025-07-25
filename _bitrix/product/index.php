<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Товар");
?>

<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.element",
	"product-detail",
	array(
		"IBLOCK_TYPE" => "CRM_PRODUCT_CATALOG",
		"IBLOCK_ID" => "29",
			"ELEMENT_ID" => $_REQUEST["ELEMENT_ID"],
	"ELEMENT_CODE" => $_REQUEST["ELEMENT_CODE"] ?: $_REQUEST["CODE"],
		"PROPERTY_CODE" => array(
			0 => "CML2_ARTICLE",
			1 => "TSVET",
			2 => "MORE_PHOTO",
			3 => "UKHOD",
			4 => "NAIMENOVANIE_TOVARA_NA_SAYTE_ETIKETKE",
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "COLOR",
			1 => "SIZE",
		),
		"OFFERS_LIMIT" => "5",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"CURRENCY_ID" => "RUB",
		"USE_ELEMENT_COUNTER" => "Y",
		"SHOW_DEACTIVATED" => "N",
		"SHOW_404" => "Y",
		"MESSAGE_404" => "Товар не найден",
		"DISPLAY_COMPARE" => "N",
		"COMPARE_PATH" => "/catalog/compare.php",
		"USE_REGION" => "N",
		"SHOW_GALLERY" => "Y",
		"GALLERY_THUMB_SIZE" => "100",
		"GALLERY_MAIN_SIZE" => "600",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>