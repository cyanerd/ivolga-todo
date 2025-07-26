<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arComponentDescription = [
  "NAME" => GetMessage("T_IBLOCK_DESC_PRODUCT_DETAIL"),
  "DESCRIPTION" => GetMessage("T_IBLOCK_DESC_PRODUCT_DETAIL_DESC"),
  "ICON" => "/images/catalog_detail.gif",
  "SORT" => 40,
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
