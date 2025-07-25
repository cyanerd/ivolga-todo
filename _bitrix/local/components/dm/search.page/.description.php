<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => "Своя страничка поиска",
	"DESCRIPTION" => GetMessage("Своя страничка поиска"),
	"ICON" => "/images/icon.gif",
	"PATH" => array(
		"ID" => "dm",
		"CHILD" => array(
			"ID" => "dm_search_page",
		)
	),
);
?>