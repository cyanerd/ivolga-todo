<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Избранное");
?>

<div class="__favourite">
  <? $APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    "favourite",
    [
      "IBLOCK_TYPE" => "CRM_PRODUCT_CATALOG",
      "IBLOCK_ID" => CATALOG_ID,
      "SECTION_SORT_FIELD" => "sort",
      "SECTION_SORT_ORDER" => "asc",
      "ELEMENT_SORT_FIELD" => "sort",
      "ELEMENT_SORT_ORDER" => "asc",
      "ELEMENT_SORT_FIELD2" => "id",
      "ELEMENT_SORT_ORDER2" => "desc",
      "PROPERTY_CODE" => [
        0 => "CML2_ARTICLE",
        1 => "TSVET",
        2 => "MORE_PHOTO",
        3 => "UKHOD",
        4 => "NAIMENOVANIE_TOVARA_NA_SAYTE_ETIKETKE",
        5 => "NEW",
        6 => "PREORDER",
      ],
      "OFFERS_FIELD_CODE" => [
        0 => "ID",
        1 => "NAME",
      ],
      "OFFERS_PROPERTY_CODE" => [
        0 => "COLOR",
        1 => "SIZE",
      ],
      "OFFERS_LIMIT" => "5",
      "PRICE_CODE" => [
        0 => "BASE",
      ],
      "USE_PRICE_COUNT" => "N",
      "SHOW_PRICE_COUNT" => "1",
      "PRICE_VAT_INCLUDE" => "Y",
      "CONVERT_CURRENCY" => "N",
      "CURRENCY_ID" => "RUB",
      "USE_ELEMENT_COUNTER" => "Y",
      "SHOW_DEACTIVATED" => "N",
      "DISPLAY_COMPARE" => "N",
      "COMPARE_PATH" => "/catalog/compare.php",
      "USE_REGION" => "N",
      "SHOW_GALLERY" => "Y",
      "GALLERY_THUMB_SIZE" => "100",
      "GALLERY_MAIN_SIZE" => "600",
      "CACHE_TYPE" => "A",
      "CACHE_TIME" => "36000000",
      "CACHE_GROUPS" => "Y",
    ],
    false
  ); ?>
</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
