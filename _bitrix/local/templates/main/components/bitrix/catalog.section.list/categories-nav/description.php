<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arComponentDescription = array(
	"NAME" => GetMessage("T_IBLOCK_DESC_CATEGORIES_NAV"),
	"DESCRIPTION" => GetMessage("T_IBLOCK_DESC_CATEGORIES_NAV_DESC"),
	"ICON" => "/images/catalog_sections.gif",
	"SORT" => 10,
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