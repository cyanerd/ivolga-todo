<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arComponentDescription = [
  "NAME" => "Своя страничка поиска",
  "DESCRIPTION" => GetMessage("Своя страничка поиска"),
  "ICON" => "/images/icon.gif",
  "PATH" => [
    "ID" => "dm",
    "CHILD" => [
      "ID" => "dm_search_page",
    ]
  ],
];
?>
