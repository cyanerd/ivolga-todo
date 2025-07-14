<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arComponentDescription = array(
	"NAME" => GetMessage("T_IBLOCK_DESC_CATALOG_PAGE"),
	"DESCRIPTION" => GetMessage("T_IBLOCK_DESC_CATALOG_PAGE_DESC"),
	"ICON" => "/images/catalog_list.gif",
	"SORT" => 20,
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