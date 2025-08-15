<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("IVOLGA - Авторские украшения и одежда");
?>

<? $APPLICATION->IncludeComponent(
  "bitrix:news.list",
  "slider",
  [
    "ACTIVE_DATE_FORMAT" => "d.m.Y",
    "ADD_SECTIONS_CHAIN" => "N",
    "AJAX_MODE" => "N",
    "AJAX_OPTION_ADDITIONAL" => "",
    "AJAX_OPTION_HISTORY" => "N",
    "AJAX_OPTION_JUMP" => "N",
    "AJAX_OPTION_STYLE" => "Y",
    "CACHE_FILTER" => "N",
    "CACHE_GROUPS" => "Y",
    "CACHE_TIME" => "36000000",
    "CACHE_TYPE" => "A",
    "CHECK_DATES" => "Y",
    "DETAIL_URL" => "",
    "DISPLAY_BOTTOM_PAGER" => "N",
    "DISPLAY_DATE" => "N",
    "DISPLAY_NAME" => "Y",
    "DISPLAY_PICTURE" => "Y",
    "DISPLAY_PREVIEW_TEXT" => "N",
    "DISPLAY_TOP_PAGER" => "N",
    "FIELD_CODE" => ["", ""],
    "FILTER_NAME" => "",
    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
    "IBLOCK_ID" => "33",
    "IBLOCK_TYPE" => "content",
    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
    "INCLUDE_SUBSECTIONS" => "Y",
    "MESSAGE_404" => "",
    "NEWS_COUNT" => "20",
    "PAGER_BASE_LINK_ENABLE" => "N",
    "PAGER_DESC_NUMBERING" => "N",
    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
    "PAGER_SHOW_ALL" => "N",
    "PAGER_SHOW_ALWAYS" => "N",
    "PAGER_TEMPLATE" => ".default",
    "PAGER_TITLE" => "Новости",
    "PARENT_SECTION" => "",
    "PARENT_SECTION_CODE" => "",
    "PREVIEW_TRUNCATE_LEN" => "",
    "PROPERTY_CODE" => ["DESC", "LINK"],
    "SET_BROWSER_TITLE" => "N",
    "SET_LAST_MODIFIED" => "N",
    "SET_META_DESCRIPTION" => "N",
    "SET_META_KEYWORDS" => "N",
    "SET_STATUS_404" => "N",
    "SET_TITLE" => "N",
    "SHOW_404" => "N",
    "SORT_BY1" => "ACTIVE_FROM",
    "SORT_BY2" => "SORT",
    "SORT_ORDER1" => "DESC",
    "SORT_ORDER2" => "ASC",
    "STRICT_SECTION_CHECK" => "N"
  ]
); ?>

<?
global $indexSliderFilter;
$indexSliderFilter = ["!PROPERTY_SHOW_ON_MAIN_PAGE" => false];

$APPLICATION->IncludeComponent(
  "bitrix:catalog.section",
  "products",
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
    "FILTER_NAME" => "indexSliderFilter",
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

<? $APPLICATION->IncludeComponent(
  "bitrix:catalog.section.list",
  "categories",
  [
    "ADD_SECTIONS_CHAIN" => "N",
    "AJAX_MODE" => "N",
    "AJAX_OPTION_ADDITIONAL" => "",
    "AJAX_OPTION_HISTORY" => "N",
    "AJAX_OPTION_JUMP" => "N",
    "AJAX_OPTION_STYLE" => "Y",
    "BROWSER_TITLE" => "-",
    "CACHE_FILTER" => "N",
    "CACHE_GROUPS" => "Y",
    "CACHE_TIME" => "36000000",
    "CACHE_TYPE" => "A",
    "COUNT_ELEMENTS" => "N",
    "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
    "FILTER_NAME" => "sectionsFilter",
    "IBLOCK_ID" => "29",
    "IBLOCK_TYPE" => "CRM_PRODUCT_CATALOG",
    "SECTION_CODE" => "",
    "SECTION_FIELDS" => ["", ""],
    "SECTION_ID" => $_REQUEST["SECTION_ID"],
    "SECTION_URL" => "",
    "SECTION_USER_FIELDS" => ["", ""],
    "SHOW_PARENT_NAME" => "N",
    "TOP_DEPTH" => "2",
    "VIEW_MODE" => "LIST"
  ]
); ?>

<? $APPLICATION->IncludeComponent(
  "bitrix:news.list",
  "blog",
  [
    "ACTIVE_DATE_FORMAT" => "d.m.Y",
    "ADD_SECTIONS_CHAIN" => "N",
    "AJAX_MODE" => "N",
    "AJAX_OPTION_ADDITIONAL" => "",
    "AJAX_OPTION_HISTORY" => "N",
    "AJAX_OPTION_JUMP" => "N",
    "AJAX_OPTION_STYLE" => "Y",
    "CACHE_FILTER" => "N",
    "CACHE_GROUPS" => "Y",
    "CACHE_TIME" => "36000000",
    "CACHE_TYPE" => "A",
    "CHECK_DATES" => "Y",
    "DETAIL_URL" => "",
    "DISPLAY_BOTTOM_PAGER" => "N",
    "DISPLAY_DATE" => "N",
    "DISPLAY_NAME" => "Y",
    "DISPLAY_PICTURE" => "Y",
    "DISPLAY_PREVIEW_TEXT" => "N",
    "DISPLAY_TOP_PAGER" => "N",
    "FIELD_CODE" => ["", ""],
    "FILTER_NAME" => "",
    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
    "IBLOCK_ID" => "32",
    "IBLOCK_TYPE" => "content",
    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
    "INCLUDE_SUBSECTIONS" => "Y",
    "MESSAGE_404" => "",
    "NEWS_COUNT" => "3",
    "PAGER_BASE_LINK_ENABLE" => "N",
    "PAGER_DESC_NUMBERING" => "N",
    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
    "PAGER_SHOW_ALL" => "N",
    "PAGER_SHOW_ALWAYS" => "N",
    "PAGER_TEMPLATE" => ".default",
    "PAGER_TITLE" => "Новости",
    "PARENT_SECTION" => "",
    "PARENT_SECTION_CODE" => "",
    "PREVIEW_TRUNCATE_LEN" => "",
    "PROPERTY_CODE" => ["DATE", "LINK"],
    "SET_BROWSER_TITLE" => "N",
    "SET_LAST_MODIFIED" => "N",
    "SET_META_DESCRIPTION" => "N",
    "SET_META_KEYWORDS" => "N",
    "SET_STATUS_404" => "N",
    "SET_TITLE" => "N",
    "SHOW_404" => "N",
    "SORT_BY1" => "ACTIVE_FROM",
    "SORT_BY2" => "SORT",
    "SORT_ORDER1" => "DESC",
    "SORT_ORDER2" => "ASC",
    "STRICT_SECTION_CHECK" => "N",
    "SHOW_CAPTION" => "Y",
  ]
); ?>


<section class="about">
  <div class="about__inner">
    <div class="about__image">
      <? if ($siteSettings['UF_ABOUT_IMAGE']) { ?>
        <img src="<?= CFile::GetPath($siteSettings['UF_ABOUT_IMAGE']) ?>" alt="<?= $siteSettings['UF_FOUNDER_NAME'] ?>"
             class="about__img desc">
      <? } ?>
      <? if ($siteSettings['UF_ABOUT_IMAGE_MOB']) { ?>
        <img src="<?= CFile::GetPath($siteSettings['UF_ABOUT_IMAGE_MOB']) ?>" alt="<?= $siteSettings['UF_FOUNDER_NAME'] ?>"
             class="about__img mob">
      <? } ?>
    </div>
    <div class="about__content">
      <div class="about-top">
        <? if ($siteSettings['UF_TITLE']) { ?>
          <h2 class="about__title"><?= $siteSettings['UF_TITLE'] ?></h2>
        <? } ?>
        <? if ($siteSettings['UF_DESC']) { ?>
          <p class="about__text"><?= $siteSettings['UF_DESC'] ?></p>
        <? } ?>
      </div>
      <div class="about__footer">
        <? if ($siteSettings['UF_FOUNDER_NAME']) { ?>
          <h3 class="about__subtitle"><?= $siteSettings['UF_FOUNDER_NAME'] ?></h3>
        <? } ?>
        <? if ($siteSettings['UF_FOUNDER_DESC']) { ?>
          <p class="about__position"><?= $siteSettings['UF_FOUNDER_DESC'] ?></p>
        <? } ?>
      </div>
    </div>
  </div>
</section>


<section class="showrooms">
  <div class="container">

    <a href="/contacts/" class="showrooms__header">
      <h2 class="showrooms__title">Шоурумы</h2>
      <div class="showrooms__link">
        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
                d="M17.75 7.1665V8.1665C17.75 9.96143 19.2051 11.4165 21 11.4165V12.9165C18.3766 12.9165 16.25 10.7899 16.25 8.1665V7.1665H17.75Z"
                fill="#232229"/>
          <path fill-rule="evenodd" clip-rule="evenodd"
                d="M21 12.9165C19.2051 12.9165 17.75 14.3716 17.75 16.1665V17.1665H16.25V16.1665C16.25 13.5432 18.3766 11.4165 21 11.4165V12.9165Z"
                fill="#232229"/>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M21 12.9165H3V11.4165H21V12.9165Z" fill="#232229"/>
        </svg>

      </div>
    </a>
  </div>
  <div class="showrooms__content">
    <div class="showrooms__info">
      <div class="showrooms__info-header">
        <? if ($siteSettings['UF_ADDRESS_TITLE']) { ?>
          <h3 class="showrooms__info-title"><?= $siteSettings['UF_ADDRESS_TITLE'] ?></h3>
        <? } ?>
        <? if ($siteSettings['UF_ADDRESS_DESC']) { ?>
          <p class="showrooms__info-text"><?= $siteSettings['UF_ADDRESS_DESC'] ?></p>
        <? } ?>
      </div>
      <div class="showrooms__info-details">
        <? if ($siteSettings['UF_ADDRESS_TIME']) { ?>
          <p class="showrooms__info-hours"><?= $siteSettings['UF_ADDRESS_TIME'] ?></p>
        <? } ?>
        <? if ($siteSettings['UF_ADDRESS']) { ?>
          <p class="showrooms__info-address"><?= $siteSettings['UF_ADDRESS'] ?></p>
        <? } ?>
      </div>
    </div>

    <div class="showrooms__map" id="map-container">
      <div class="showrooms__map-img">
        <img src="/html/assets/img/showmap.0d926a06c426b37fcde4.jpg" alt="">
      </div>
      <i class="showrooms__map-icon">
        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
                d="M12 7.83301C10.7574 7.83301 9.75 8.84037 9.75 10.083C9.75 11.3256 10.7574 12.333 12 12.333C13.2426 12.333 14.25 11.3256 14.25 10.083C14.25 8.84037 13.2426 7.83301 12 7.83301ZM8.25 10.083C8.25 8.01194 9.92893 6.33301 12 6.33301C14.0711 6.33301 15.75 8.01194 15.75 10.083C15.75 12.1541 14.0711 13.833 12 13.833C9.92893 13.833 8.25 12.1541 8.25 10.083Z"
                fill="white"/>
          <path fill-rule="evenodd" clip-rule="evenodd"
                d="M12 3.33301C10.2098 3.33301 8.4929 4.04417 7.22703 5.31004C5.96116 6.57591 5.25 8.2928 5.25 10.083C5.25 13.188 6.98389 16.0152 8.81595 18.1221C9.72283 19.165 10.6316 20.0059 11.3139 20.5858C11.5837 20.8151 11.8172 21.0029 12 21.1455C12.1828 21.0029 12.4163 20.8151 12.6861 20.5858C13.3684 20.0059 14.2772 19.165 15.184 18.1221C17.0161 16.0152 18.75 13.188 18.75 10.083C18.75 8.2928 18.0388 6.57591 16.773 5.31004C15.5071 4.04417 13.7902 3.33301 12 3.33301ZM12 22.083C11.5699 22.6974 11.5697 22.6973 11.5695 22.6971L11.5671 22.6954L11.5615 22.6915L11.5425 22.678C11.5263 22.6664 11.5031 22.6498 11.4736 22.6282C11.4144 22.585 11.3294 22.522 11.2223 22.4401C11.0081 22.2764 10.7049 22.0368 10.3424 21.7287C9.61838 21.1133 8.65217 20.2197 7.68405 19.1064C5.76611 16.9008 3.75 13.728 3.75 10.083C3.75 7.89497 4.61919 5.79655 6.16637 4.24938C7.71354 2.7022 9.81196 1.83301 12 1.83301C14.188 1.83301 16.2865 2.7022 17.8336 4.24938C19.3808 5.79655 20.25 7.89497 20.25 10.083C20.25 13.728 18.2339 16.9008 16.316 19.1064C15.3478 20.2197 14.3816 21.1133 13.6576 21.7287C13.2951 22.0368 12.9919 22.2764 12.7777 22.4401C12.6706 22.522 12.5856 22.585 12.5264 22.6282C12.4969 22.6498 12.4737 22.6664 12.4575 22.678L12.4385 22.6915L12.4329 22.6954L12.4312 22.6967C12.4309 22.6968 12.4301 22.6974 12 22.083ZM12 22.083L12.4301 22.6974C12.1719 22.8782 11.8277 22.8779 11.5695 22.6971L12 22.083Z"
                fill="white"/>
        </svg>
      </i>
      <? if ($siteSettings['UF_MAP_LINK']) { ?>
        <a href="<?= $siteSettings['UF_MAP_LINK'] ?>" target="_blank" class="showrooms__map-btn">
          Открыть на карте
        </a>
      <? } ?>
    </div>
  </div>
</section>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
