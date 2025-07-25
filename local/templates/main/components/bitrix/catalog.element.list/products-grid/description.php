<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arComponentDescription = array(
	"NAME" => GetMessage("T_IBLOCK_DESC_PRODUCTS_GRID"),
	"DESCRIPTION" => GetMessage("T_IBLOCK_DESC_PRODUCTS_GRID_DESC"),
	"ICON" => "/images/catalog_list.gif",
	"SORT" => 30,
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