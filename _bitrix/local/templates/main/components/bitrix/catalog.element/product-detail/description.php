<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arComponentDescription = array(
	"NAME" => GetMessage("T_IBLOCK_DESC_PRODUCT_DETAIL"),
	"DESCRIPTION" => GetMessage("T_IBLOCK_DESC_PRODUCT_DETAIL_DESC"),
	"ICON" => "/images/catalog_detail.gif",
	"SORT" => 40,
	"PATH" => array(
		"ID" => "content",
		"CHILD" => array(
			"ID" => "catalog",
			"NAME" => GetMessage("T_IBLOCK_DESC_CATALOG"),
			"SORT" => 30,
		),
	),
);
?> 