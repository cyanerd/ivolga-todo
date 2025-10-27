<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>

<div class="breadcrumbs">
  <div class="container">
    <div class="breadcrumbs__row desc">
      <a href="/">
        Главная
      </a>
      <a href="/collections/">
        Коллекции
      </a>
      <span>
        <?= htmlspecialcharsbx($arResult['NAME']) ?>
      </span>
    </div>
    <a href="/collections/" class="breadcrumbs__back mob">
      <i>
        <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
                d="M8.58333 3.3665C8.58333 5.53088 6.60759 7.4165 4 7.4165V8.9165C6.60759 8.9165 8.58333 10.8021 8.58333 12.9665V14.1665H10.0833V12.9665C10.0833 10.8809 8.84622 9.11574 7.0523 8.1665C8.84622 7.21727 10.0833 5.45208 10.0833 3.3665V2.1665H8.58333V3.3665Z"
                fill="#232229" fill-opacity="0.5"/>
        </svg>
      </i>
      Назад
    </a>
  </div>
</div>
<section class="collectionsinfo">
  <div class="container">
    <div class="collectionsinfo__content collectionsinfo__content_first">
      <h2>
        <?= htmlspecialcharsbx($arResult['NAME']) ?>
      </h2>
    </div>
  </div>
  <? if ($arResult['PROPERTIES']['PICTURE']['VALUE']): ?>
    <div class="collectionsinfo__fullimage">
      <img src="<?= CFile::GetPath($arResult['PROPERTIES']['PICTURE']['VALUE']) ?>"
           alt="<?= htmlspecialcharsbx($arResult['NAME']) ?>">
    </div>
  <? endif; ?>
  <div class="container">
    <div class="collectionsinfo__content">
      <? if ($arResult['PROPERTIES']['SUBTITLE']['VALUE']): ?>
        <h3><?= htmlspecialcharsbx($arResult['PROPERTIES']['SUBTITLE']['VALUE']) ?></h3><? endif; ?>
    </div>
  </div>
  <? if (is_array($arResult['PROPERTIES']['IMAGES']['VALUE']) && count($arResult['PROPERTIES']['IMAGES']['VALUE'])): ?>
    <div class="collectionsinfo__row">
      <? foreach ($arResult['PROPERTIES']['IMAGES']['VALUE'] as $itemImg): ?>
        <div class="collectionsinfo__col">
          <div class="collectionsinfo-image">
            <img src="<?= CFile::GetPath($itemImg) ?>" alt="<?= htmlspecialcharsbx($arResult['NAME']) ?>">
          </div>
        </div>
      <? endforeach; ?>
    </div>
  <? endif; ?>
  <? if ($arResult['PREVIEW_TEXT']) { ?>
    <div class="container">
      <div class="collectionsinfo__content">
        <?= $arResult['PREVIEW_TEXT'] ?>
      </div>
    </div>
  <? } ?>
  <? if (is_array($arResult['PROPERTIES']['GALLERY']['VALUE']) && count($arResult['PROPERTIES']['GALLERY']['VALUE'])): ?>
    <div class="collectionsinfo__gallery">
      <div class="collectionsinfo__gallery-slider swiper">
        <div class="swiper-wrapper">
          <? foreach ($arResult['PROPERTIES']['GALLERY']['VALUE'] as $galleryImg): ?>
            <div class="swiper-slide">
              <div class="collectionsinfo__gallery-item">
                <img src="<?= CFile::GetPath($galleryImg) ?>" alt="<?= htmlspecialcharsbx($arResult['NAME']) ?>">
              </div>
            </div>
          <? endforeach; ?>
        </div>
      </div>
      <div class="collectionsinfo__gallery-nav">
        <button class="collectionsinfo__gallery-prev">
          <svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="1.5" y="1" width="30" height="30" rx="15" stroke="white" stroke-width="2"/>
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M12.75 21L12.75 20C12.75 18.2051 11.2949 16.75 9.5 16.75L9.5 15.25C12.1234 15.25 14.25 17.3766 14.25 20L14.25 21L12.75 21Z"
                  fill="white"/>
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M9.5 15.25C11.2949 15.25 12.75 13.7949 12.75 12L12.75 11L14.25 11L14.25 12C14.25 14.6234 12.1234 16.75 9.5 16.75L9.5 15.25Z"
                  fill="white"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.5 15.25L27.5 15.25L27.5 16.75L9.5 16.75L9.5 15.25Z" fill="white"/>
          </svg>
        </button>
        <div class="collectionsinfo__gallery-counter">
          <span class="current">01</span> / <span
            class="total"><?= str_pad(count($arResult['PROPERTIES']['GALLERY']['VALUE']), 2, '0', STR_PAD_LEFT) ?></span>
        </div>
        <button class="collectionsinfo__gallery-next">
          <svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="1.5" y="1" width="30" height="30" rx="15" stroke="white" stroke-width="2"/>
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M21.4141 11.8335V12.6668C21.4141 14.0936 22.5707 15.2502 23.9974 15.2502V16.7502C21.7422 16.7502 19.9141 14.922 19.9141 12.6668V11.8335H21.4141Z"
                  fill="white"/>
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M23.9974 16.75C22.5707 16.75 21.4141 17.9066 21.4141 19.3333V20.1667H19.9141V19.3333C19.9141 17.0782 21.7422 15.25 23.9974 15.25V16.75Z"
                  fill="white"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M24 16.75H9V15.25H24V16.75Z" fill="white"/>
          </svg>
        </button>
      </div>
    </div>
  <? endif; ?>
  <? if ($arResult['DETAIL_TEXT']) { ?>
    <div class="container">
      <div class="collectionsinfo__content">
        <?= $arResult['DETAIL_TEXT'] ?>
      </div>
    </div>
  <? } ?>

  <? if (!empty($arResult['PROPERTIES']['ITEMS']['VALUE'])) { ?>
    <?
    $APPLICATION->IncludeComponent(
      "bitrix:catalog.section",
      "catalog-page",
      [
        "IBLOCK_TYPE" => "CRM_PRODUCT_CATALOG",
        "IBLOCK_ID" => CATALOG_ID,
        "SECTION_ID" => "",
        "SECTION_CODE" => "",
        "SECTION_USER_FIELDS" => [],
        "ELEMENT_SORT_FIELD" => "SORT",
        "ELEMENT_SORT_ORDER" => "ASC",
        "ELEMENT_SORT_FIELD2" => "ID",
        "ELEMENT_SORT_ORDER2" => "DESC",
        "FILTER_NAME" => "",
        "INCLUDE_SUBSECTIONS" => "Y",
        "SHOW_ALL_WO_SECTION" => "N",
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
        "ELEMENT_ID" => $arResult['PROPERTIES']['ITEMS']['VALUE'],
        "HIDE_CAPTION" => "Y"
      ],
      false
    );
    ?>
  <? } ?>
  <br><br>
  <div class="container">
    <h1 class="pagecollect__title">
      Другие коллекции
    </h1>
  </div>
  <?
  // Фильтр для исключения текущей коллекции
  global $otherCollectionsFilter;
  $otherCollectionsFilter = [
    "!ID" => $arResult['ID'],
    "ACTIVE" => "Y"
  ];
  ?>
  <? $APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "collections",
    [
      "IBLOCK_TYPE" => "content",
      "IBLOCK_ID" => "21",
      "NEWS_COUNT" => "4",
      "SORT_BY1" => "SORT",
      "SORT_ORDER1" => "ASC",
      "SORT_BY2" => "ID",
      "SORT_ORDER2" => "DESC",
      "FIELD_CODE" => ["ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PICTURE"],
      "PROPERTY_CODE" => ["SUBTITLE", "URL", "PICTURE", "ITEMS"],
      "DISPLAY_PANEL" => "N",
      "SET_TITLE" => "N",
      "SET_BROWSER_TITLE" => "N",
      "SET_META_KEYWORDS" => "N",
      "SET_META_DESCRIPTION" => "N",
      "SET_LAST_MODIFIED" => "N",
      "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
      "ADD_SECTIONS_CHAIN" => "N",
      "CACHE_TYPE" => "A",
      "CACHE_TIME" => "3600",
      "CACHE_FILTER" => "N",
      "CACHE_GROUPS" => "Y",
      "DISPLAY_TOP_PAGER" => "N",
      "DISPLAY_BOTTOM_PAGER" => "Y",
      "PAGER_SHOW_ALWAYS" => "N",
      "PAGER_TEMPLATE" => ".default",
      "PAGER_DESC_NUMBERING" => "N",
      "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
      "PAGER_SHOW_ALL" => "N",
      "PAGER_BASE_LINK_ENABLE" => "N",
      "SET_STATUS_404" => "N",
      "SHOW_404" => "N",
      "MESSAGE_404" => "",
      "FILTER_NAME" => "otherCollectionsFilter",
    ],
    false
  ); ?>
</section>
