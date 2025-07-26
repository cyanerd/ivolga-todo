<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arComponentDescription = [
  "NAME" => GetMessage("T_IBLOCK_DESC_FAVOURITE"),
  "DESCRIPTION" => GetMessage("T_IBLOCK_DESC_FAVOURITE_DESC"),
  "ICON" => "/images/favourite.gif",
  "SORT" => 50,
  "PATH" => [
    "ID" => "content",
    "CHILD" => [
      "ID" => "catalog",
      "NAME" => GetMessage("T_IBLOCK_DESC_CATALOG"),
      "SORT" => 30,
    ],
  ],
];
?>
