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

  <?php
  // Фильтрация каталога по GET-параметрам
  $GLOBALS['arrFilter'] = [];
  if (!empty($_GET['size'])) {
    $sizeValues = explode(',', $_GET['size']);
    $enumIds = [];
    $property_enums = CIBlockPropertyEnum::GetList(
      ["SORT" => "ASC"],
      ["IBLOCK_ID" => 30, "CODE" => "RAZMER"]
    );
    $valueToId = [];
    while ($enum_fields = $property_enums->GetNext()) {
      $valueToId[$enum_fields["VALUE"]] = $enum_fields["ID"];
      $valueToId[$enum_fields["ID"]] = $enum_fields["ID"];
    }
    foreach ($sizeValues as $val) {
      if (isset($valueToId[$val])) {
        $enumIds[] = $valueToId[$val];
      }
    }
    if (!empty($enumIds)) {
      $sizeFilter = [
        'IBLOCK_ID' => 30,
        'ACTIVE' => 'Y',
        'PROPERTY_RAZMER' => $enumIds
      ];
      $skuRes = CIBlockElement::GetList([], $sizeFilter, false, false, ['ID', 'PROPERTY_CML2_LINK']);
      $productIds = [];
      while ($sku = $skuRes->Fetch()) {
        if (!empty($sku['PROPERTY_CML2_LINK_VALUE'])) {
          $productIds[] = $sku['PROPERTY_CML2_LINK_VALUE'];
        }
      }
      if (!empty($productIds)) {
        $GLOBALS['arrFilter']['ID'] = $productIds;
      } else {
        $GLOBALS['arrFilter']['ID'] = [0];
      }
    }
  }
  if (!empty($_GET['color'])) {
    $GLOBALS['arrFilter']['PROPERTY_TSVET'] = explode(',', $_GET['color']);
  }
  if (!empty($_GET['material'])) {
    $GLOBALS['arrFilter']['PROPERTY_MATERIAL'] = explode(',', $_GET['material']);
  }
  if (!empty($_GET['collection'])) {
    $GLOBALS['arrFilter']['PROPERTY_KOLLEKTSIYA'] = explode(',', $_GET['collection']);
  }
  ?>

  <?php
  if ($_GET['ajax'] === 'Y') {
    $APPLICATION->RestartBuffer();
  }
  ?>
  <div id="catalog-ajax-container">
    <? $APPLICATION->IncludeComponent(
      "bitrix:catalog.section",
      "catalog-page",
      [
        "IBLOCK_TYPE" => "CRM_PRODUCT_CATALOG",
        "IBLOCK_ID" => "29",
        "PRICE_CODE" => ["Розничная цена"],
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
        "SET_TITLE" => "N",
        "SET_STATUS_404" => "N",
        "SHOW_404" => "N",
        "FILTER_NAME" => "arrFilter",
        "INCLUDE_SUBSECTIONS" => "Y",
        "SHOW_ALL_WO_SECTION" => "N",
        "HIDE_NOT_AVAILABLE" => "Y",
        "HIDE_NOT_AVAILABLE_OFFERS" => "Y",
        "SECTION_ID" => $_REQUEST["SECTION_ID"],
        "SECTION_CODE" => $_REQUEST["SECTION_CODE"],
        "SECTION_CODE_PATH" => $_REQUEST["SECTION_CODE_PATH"],
        "ELEMENT_SORT_FIELD" => $_REQUEST["sort"] ?: "sort",
        "ELEMENT_SORT_ORDER" => $_REQUEST["order"] ?: "asc",
      ],
      false
    ); ?>

    <button class="catalogpage__more">
      Показать ещё
    </button>

  </div>
  <? if ($_GET['ajax'] === 'Y') {
    die();
  }
  ?>
</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
