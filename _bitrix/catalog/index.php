<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Каталог");
?>

<div class="catalogpage">
  <div class="container">
    <? // Навигация по категориям ?>
    <?
    // Фильтр для подсчета только товаров с остатками в навигации
    $GLOBALS['sectionsFilter'] = [
      'ACTIVE' => 'Y',
      '>CATALOG_QUANTITY' => 0
    ];
    ?>
    <? $APPLICATION->IncludeComponent(
      "bitrix:catalog.section.list",
      "categories-nav",
      [
        "IBLOCK_TYPE" => "CRM_PRODUCT_CATALOG",
        "IBLOCK_ID" => "29",
        "SECTION_ID" => $_REQUEST["SECTION_ID"],
        "SECTION_URL" => "/catalog/#SECTION_CODE#/",
        "COUNT_ELEMENTS" => "Y",
        "COUNT_ELEMENTS_FILTER" => "CNT_AVAILABLE",
        "HIDE_SECTIONS_WITH_ZERO_COUNT_ELEMENTS" => "N",
        "FILTER_NAME" => "sectionsFilter",
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

  // Фильтр по наличию товарных остатков
  $GLOBALS['arrFilter']['>CATALOG_QUANTITY'] = 0;
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
    $colorValues = explode(',', $_GET['color']);

    // Получаем ID цветов по их названиям
    $colorIds = [];
    foreach ($colorValues as $colorName) {
      // Ищем цвет в справочнике свойств
      $property_enums = CIBlockPropertyEnum::GetList(
        ["SORT" => "ASC"],
        ["IBLOCK_ID" => 29, "CODE" => "TSVET", "VALUE" => $colorName]
      );
      while ($enum_fields = $property_enums->GetNext()) {
        $colorIds[] = $enum_fields["ID"];
        error_log("Found color ID: " . $enum_fields["ID"] . " for name: " . $colorName);
      }
    }

    // Если нашли ID цветов, используем их для фильтрации
    if (!empty($colorIds)) {
      $GLOBALS['arrFilter']['PROPERTY_TSVET'] = $colorIds;
      error_log("Using color IDs for filtering: " . print_r($colorIds, true));
    } else {
      // Если не нашли ID, используем названия
      $GLOBALS['arrFilter']['PROPERTY_TSVET'] = $colorValues;
      error_log("Using color names for filtering: " . print_r($colorValues, true));
    }

    // Отладочная информация для фильтрации по цвету
    error_log("Full filter: " . print_r($GLOBALS['arrFilter'], true));

    // Проверяем, есть ли товары с таким цветом
    $testFilter = ['IBLOCK_ID' => 29, 'ACTIVE' => 'Y', 'PROPERTY_TSVET' => (!empty($colorIds) ? $colorIds : $colorValues)];

    // Если есть фильтр по разделу, добавляем его
    if (!empty($_REQUEST["SECTION_ID"])) {
      $testFilter['SECTION_ID'] = $_REQUEST["SECTION_ID"];
    } elseif (!empty($_REQUEST["SECTION_CODE"])) {
      $testFilter['SECTION_CODE'] = $_REQUEST["SECTION_CODE"];
    }

    error_log("Test filter: " . print_r($testFilter, true));

    $testRes = CIBlockElement::GetList([], $testFilter, false, false, ['ID', 'NAME', 'PROPERTY_TSVET']);
    $testCount = 0;
    while ($testEl = $testRes->GetNext()) {
      $testCount++;
      error_log("Found product with color: " . $testEl['NAME'] . " - " . $testEl['PROPERTY_TSVET_VALUE']);
    }
    error_log("Total products found with color filter: " . $testCount);
  }
  if (!empty($_GET['material'])) {
    $materialValues = explode(',', $_GET['material']);

    // Получаем ID материалов по их названиям
    $materialIds = [];
    foreach ($materialValues as $materialName) {
      // Ищем материал в справочнике свойств
      $property_enums = CIBlockPropertyEnum::GetList(
        ["SORT" => "ASC"],
        ["IBLOCK_ID" => 29, "CODE" => "MATERIAL", "VALUE" => $materialName]
      );
      while ($enum_fields = $property_enums->GetNext()) {
        $materialIds[] = $enum_fields["ID"];
        error_log("Found material ID: " . $enum_fields["ID"] . " for name: " . $materialName);
      }
    }

    // Если нашли ID материалов, используем их для фильтрации
    if (!empty($materialIds)) {
      $GLOBALS['arrFilter']['PROPERTY_MATERIAL'] = $materialIds;
      error_log("Using material IDs for filtering: " . print_r($materialIds, true));
    } else {
      // Если не нашли ID, используем названия
      $GLOBALS['arrFilter']['PROPERTY_MATERIAL'] = $materialValues;
      error_log("Using material names for filtering: " . print_r($materialValues, true));
    }

    // Отладочная информация для фильтрации по материалу
    error_log("Material filter applied: " . print_r($materialValues, true));
    error_log("Full filter: " . print_r($GLOBALS['arrFilter'], true));

    // Проверяем, есть ли товары с таким материалом
    $testFilter = ['IBLOCK_ID' => 29, 'ACTIVE' => 'Y', 'PROPERTY_MATERIAL' => (!empty($materialIds) ? $materialIds : $materialValues)];

    // Если есть фильтр по разделу, добавляем его
    if (!empty($_REQUEST["SECTION_ID"])) {
      $testFilter['SECTION_ID'] = $_REQUEST["SECTION_ID"];
    } elseif (!empty($_REQUEST["SECTION_CODE"])) {
      $testFilter['SECTION_CODE'] = $_REQUEST["SECTION_CODE"];
    }

    error_log("Test material filter: " . print_r($testFilter, true));

    $testRes = CIBlockElement::GetList([], $testFilter, false, false, ['ID', 'NAME', 'PROPERTY_MATERIAL']);
    $testCount = 0;
    while ($testEl = $testRes->GetNext()) {
      $testCount++;
      error_log("Found product with material: " . $testEl['NAME'] . " - " . $testEl['PROPERTY_MATERIAL_VALUE']);
    }
    error_log("Total products found with material filter: " . $testCount);
  }
  if (!empty($_GET['collection'])) {
    $collectionValues = explode(',', $_GET['collection']);

    // Получаем ID коллекций по их названиям
    $collectionIds = [];
    foreach ($collectionValues as $collectionName) {
      // Ищем коллекцию в справочнике свойств
      $property_enums = CIBlockPropertyEnum::GetList(
        ["SORT" => "ASC"],
        ["IBLOCK_ID" => 29, "CODE" => "KOLLEKTSIYA", "VALUE" => $collectionName]
      );
      while ($enum_fields = $property_enums->GetNext()) {
        $collectionIds[] = $enum_fields["ID"];
        error_log("Found collection ID: " . $enum_fields["ID"] . " for name: " . $collectionName);
      }
    }

    // Если нашли ID коллекций, используем их для фильтрации
    if (!empty($collectionIds)) {
      $GLOBALS['arrFilter']['PROPERTY_KOLLEKTSIYA'] = $collectionIds;
      error_log("Using collection IDs for filtering: " . print_r($collectionIds, true));
    } else {
      // Если не нашли ID, используем названия
      $GLOBALS['arrFilter']['PROPERTY_KOLLEKTSIYA'] = $collectionValues;
      error_log("Using collection names for filtering: " . print_r($collectionValues, true));
    }

    // Отладочная информация для фильтрации по коллекции
    error_log("Collection filter applied: " . print_r($collectionValues, true));
    error_log("Full filter: " . print_r($GLOBALS['arrFilter'], true));

    // Проверяем, есть ли товары с такой коллекцией
    $testFilter = ['IBLOCK_ID' => 29, 'ACTIVE' => 'Y', 'PROPERTY_KOLLEKTSIYA' => (!empty($collectionIds) ? $collectionIds : $collectionValues)];

    // Если есть фильтр по разделу, добавляем его
    if (!empty($_REQUEST["SECTION_ID"])) {
      $testFilter['SECTION_ID'] = $_REQUEST["SECTION_ID"];
    } elseif (!empty($_REQUEST["SECTION_CODE"])) {
      $testFilter['SECTION_CODE'] = $_REQUEST["SECTION_CODE"];
    }

    error_log("Test collection filter: " . print_r($testFilter, true));

    $testRes = CIBlockElement::GetList([], $testFilter, false, false, ['ID', 'NAME', 'PROPERTY_KOLLEKTSIYA']);
    $testCount = 0;
    while ($testEl = $testRes->GetNext()) {
      $testCount++;
      error_log("Found product with collection: " . $testEl['NAME'] . " - " . $testEl['PROPERTY_KOLLEKTSIYA_VALUE']);
    }
    error_log("Total products found with collection filter: " . $testCount);
  }
  ?>

  <?php
  if ($_GET['ajax'] === 'Y') {
    $APPLICATION->RestartBuffer();
  }

  // Отладочная информация для сортировки
  $sortField = $_REQUEST["sort"] === "price" ? "catalog_PRICE_7" : ($_REQUEST["sort"] === "sort" ? "id" : ($_REQUEST["sort"] ?: "id"));
  $sortOrder = $_REQUEST["order"] ?: "asc";
  error_log("Sort debug - REQUEST sort: " . ($_REQUEST["sort"] ?? 'not set'));
  error_log("Sort debug - REQUEST order: " . ($_REQUEST["order"] ?? 'not set'));
  error_log("Sort debug - Final sort field: " . $sortField);
  error_log("Sort debug - Final sort order: " . $sortOrder);

  // Отладочная информация для фильтрации
  error_log("=== FILTER DEBUG ===");
  error_log("GET params: " . print_r($_GET, true));
  error_log("REQUEST params: " . print_r($_REQUEST, true));
  error_log("Final filter: " . print_r($GLOBALS['arrFilter'], true));

  // Проверяем раздел
  if (!empty($_REQUEST["SECTION_CODE"])) {
    error_log("Section code: " . $_REQUEST["SECTION_CODE"]);
    $sectionRes = CIBlockSection::GetList([], ['IBLOCK_ID' => 29, 'CODE' => $_REQUEST["SECTION_CODE"]], false, false, ['ID', 'NAME', 'CODE']);
    $section = $sectionRes->GetNext();
    if ($section) {
      error_log("Section found: " . $section['NAME'] . " (ID: " . $section['ID'] . ")");
    } else {
      error_log("Section not found for code: " . $_REQUEST["SECTION_CODE"]);
    }
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
        "USE_PRICE_COUNT" => "Y",
        "SHOW_PRICE_COUNT" => "1",
        "CONVERT_CURRENCY" => "Y",
        "CURRENCY_ID" => "RUB",
        "PRICE_VAT_INCLUDE" => "Y",
        "ELEMENT_SORT_FIELD2" => "id",
        "ELEMENT_SORT_ORDER2" => "desc",
        "PROPERTY_CODE" => ["PRICE", "OLD_PRICE", "MORE_PHOTO", "NEW", "PREORDER", "FAVORITE", "COLORS", "SIZES", "NAIMENOVANIE_TOVARA_NA_SAYTE_ETIKETKE"],
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
        "QUANTITY_FILTER" => array(
          "PROPERTY_CODE" => array("QUANTITY"),
          "FILTER_VALUE" => ">0"
        ),
        "SECTION_ID" => $_REQUEST["SECTION_ID"],
        "SECTION_CODE" => $_REQUEST["SECTION_CODE"],
        "SECTION_CODE_PATH" => $_REQUEST["SECTION_CODE_PATH"],
        // Отладочная информация для раздела
        "SECTION_URL" => "",
        "ELEMENT_SORT_FIELD" => $sortField,
        "ELEMENT_SORT_ORDER" => $sortOrder,
      ],
      false
    ); ?>
  </div>
  <? if ($_GET['ajax'] === 'Y') {
    die();
  }
  ?>
</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
