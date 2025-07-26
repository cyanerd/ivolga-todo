<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$q = $arResult['q'];
?>
<main class="content">
  <div class="catalog-collection">
    <div>
      <div class="products-card-container__content">
        <div class="container">
          <form class="form" action="/search/index.php" style="margin-bottom: 2em">
            <div class="search-container">
              <div class="search-container">
                <input type="text" placeholder="Поиск по каталогу" class="search-input" name="q" value="<?= $q ?>">
              </div>
              <button class="search-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="21" viewBox="0 0 28 21" fill="none">
                  <g clip-path="url(#clip0_1128_3180)">
                    <line x1="1" y1="9.69238" x2="26" y2="9.69238" stroke="black"></line>
                    <path d="M17.5435 18.1938L26.0293 9.70801L17.5435 1.22223" stroke="black"></path>
                  </g>
                  <defs>
                    <clipPath id="clip0_1128_3180">
                      <rect width="28" height="20" fill="white" transform="matrix(-1 0 0 -1 28 20.1924)"></rect>
                    </clipPath>
                  </defs>
                </svg>
              </button>
            </div>
          </form>
          <div style="opacity: 1; transform: none;">
            <div class="products-card-container__content">
              <? if (!$arResult['ITEMS']): ?>
                <p>Ничего не найдено</p>
              <? else: ?>
                <ul class="products-card-list products-card-list--4">
                  <?
                  $arProductIDs = [];
                  foreach ($arResult['ITEMS'] as $arSearchItem) {
                    $arProductIDs[] = $arSearchItem['ITEM_ID'];
                  }
                  $GLOBALS['searchFilter'] = ['ID' => $arProductIDs];

                  $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section",
                    "catalog-page",
                    [
                      "IBLOCK_TYPE" => "CRM_PRODUCT_CATALOG",
                      "IBLOCK_ID" => "29",
                      "SECTION_ID" => "",
                      "SECTION_CODE" => "",
                      "SECTION_USER_FIELDS" => [],
                      "ELEMENT_SORT_FIELD" => "SORT",
                      "ELEMENT_SORT_ORDER" => "ASC",
                      "ELEMENT_SORT_FIELD2" => "ID",
                      "ELEMENT_SORT_ORDER2" => "DESC",
                      "FILTER_NAME" => "searchFilter",
                      "INCLUDE_SUBSECTIONS" => "Y",
                      "SHOW_ALL_WO_SECTION" => "Y",
                      "PAGE_ELEMENT_COUNT" => "20",
                      "LINE_ELEMENT_COUNT" => "4",
                      "PROPERTY_CODE" => ["MORE_PHOTO"],
                      "OFFERS_LIMIT" => "0",
                      "TEMPLATE_THEME" => "",
                      "PRICE_CODE" => ["Розничная цена"],
                      "ADD_PICT_PROP" => "",
                      "LABEL_PROP" => [],
                      "PRODUCT_DISPLAY_MODE" => "Y",
                      "PRODUCT_BLOCKS_ORDER" => "",
                      "SECTION_URL" => "",
                      "DETAIL_URL" => "",
                      "BASKET_URL" => "/personal/basket.php",
                      "ACTION_VARIABLE" => "action",
                      "PRODUCT_ID_VARIABLE" => "id",
                      "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                      "PRODUCT_PROPS_VARIABLE" => "prop",
                      "SECTION_ID_VARIABLE" => "SECTION_ID",
                      "SET_TITLE" => "N",
                      "SET_BROWSER_TITLE" => "N",
                      "SET_META_KEYWORDS" => "N",
                      "SET_META_DESCRIPTION" => "N",
                      "SET_LAST_MODIFIED" => "N",
                      "USE_MAIN_ELEMENT_SECTION" => "N",
                      "CACHE_TYPE" => "A",
                      "CACHE_TIME" => "0",
                      "CACHE_GROUPS" => "Y",
                      "DISPLAY_TOP_PAGER" => "N",
                      "DISPLAY_BOTTOM_PAGER" => "N",
                      "PAGER_TITLE" => "Товары",
                      "PAGER_SHOW_ALWAYS" => "N",
                      "PAGER_TEMPLATE" => ".default",
                      "PAGER_DESC_NUMBERING" => "N",
                      "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                      "PAGER_SHOW_ALL" => "N",
                      "PAGER_BASE_LINK_ENABLE" => "N",
                      "SET_STATUS_404" => "N",
                      "SHOW_404" => "N",
                      "MESSAGE_404" => "",
                      "COMPATIBLE_MODE" => "Y",
                    ],
                    false
                  );
                  ?>
                </ul>
              <? endif ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>



