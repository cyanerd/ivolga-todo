<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arComponentDescription = [
  "NAME" => GetMessage("T_IBLOCK_DESC_CATEGORIES_NAV"),
  "DESCRIPTION" => GetMessage("T_IBLOCK_DESC_CATEGORIES_NAV_DESC"),
  "ICON" => "/images/catalog_sections.gif",
  "SORT" => 10,
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
