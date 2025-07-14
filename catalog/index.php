<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Каталог");
?>

<div class="catalogpage">
  <div class="container">
    <? // Навигация по категориям ?>
    <? $APPLICATION->IncludeComponent(
      "bitrix:catalog.section.list",
      "categories-nav",
      [
        "IBLOCK_TYPE" => "CRM_PRODUCT_CATALOG",
        "IBLOCK_ID" => "29",
        "SECTION_ID" => $_REQUEST["SECTION_ID"],
//        "SECTION_CODE" => $_REQUEST["SECTION_CODE"],
        "SECTION_URL" => "/catalog/#SECTION_CODE#/",
        "COUNT_ELEMENTS" => "Y",
        "TOP_DEPTH" => "2",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_GROUPS" => "Y",
        "ADD_SECTIONS_CHAIN" => "N",
      ],
      false
    ); ?>
  </div>

  <? // Основной каталог ?>
  <? $APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    "catalog-page",
    [
      "IBLOCK_TYPE" => "CRM_PRODUCT_CATALOG",
      "IBLOCK_ID" => "29",
      "SECTION_ID" => $_REQUEST["SECTION_ID"],
      "SECTION_CODE" => $_REQUEST["SECTION_CODE"],
      "SECTION_CODE_PATH" => $_REQUEST["SECTION_CODE_PATH"],
      "ELEMENT_SORT_FIELD" => $_REQUEST["sort"] ?: "sort",
      "ELEMENT_SORT_ORDER" => $_REQUEST["order"] ?: "asc",
      "ELEMENT_SORT_FIELD2" => "id",
      "ELEMENT_SORT_ORDER2" => "desc",
      "PROPERTY_CODE" => ["PRICE", "OLD_PRICE", "MORE_PHOTO", "NEW", "PREORDER", "FAVORITE", "COLORS", "SIZES"],
      "PAGE_ELEMENT_COUNT" => "20",
      "LINE_ELEMENT_COUNT" => "3",
      "CACHE_TYPE" => "A",
      "CACHE_TIME" => "36000000",
      "CACHE_GROUPS" => "Y",
      "ADD_SECTIONS_CHAIN" => "N",
      "DISPLAY_BOTTOM_PAGER" => "Y",
      "DISPLAY_TOP_PAGER" => "N",
      "PAGER_TEMPLATE" => ".default",
      "SET_TITLE" => "Y",
      "SET_STATUS_404" => "Y",
      "SHOW_404" => "Y",
      "FILTER_NAME" => "arrFilter",
      "INCLUDE_SUBSECTIONS" => "Y",
      "SHOW_ALL_WO_SECTION" => "N",
      "HIDE_NOT_AVAILABLE" => "Y",
      "HIDE_NOT_AVAILABLE_OFFERS" => "Y",
    ],
    false
  ); ?>

</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
