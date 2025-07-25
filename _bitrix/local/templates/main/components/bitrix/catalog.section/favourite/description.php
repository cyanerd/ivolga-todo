<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arComponentDescription = array(
	"NAME" => GetMessage("T_IBLOCK_DESC_FAVOURITE"),
	"DESCRIPTION" => GetMessage("T_IBLOCK_DESC_FAVOURITE_DESC"),
	"ICON" => "/images/favourite.gif",
	"SORT" => 50,
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