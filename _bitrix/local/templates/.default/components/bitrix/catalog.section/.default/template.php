<? use local\php_interface\MyTools;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<main class="content">
    <div class="catalog-collection">
        <div class="catalog__banner">
            <div class="main-content__banner-img"></div>
        </div>
        <div class="container">
            <div class="products-card-container__content">
                <div class="container">
                    <div class="products-card-head--space-between container">
                        <h2 class="title"><?= $arResult['NAME'] ?? 'Каталог' ?></h2>
                        <?/*
                        <button class="filter-button modal-button" data-src=".modal-top">
                            <h1 class="title">Фильтры +</h1>
                        </button>
                        <div class="modal-top modal-right">
                            <div class="modal-top-content modal-right-content">
                                <div class="buttonchik">
                                    <button class="close-button">
                                        <img src="/assets/img/icons/close.svg" alt="close">
                                    </button>
                                </div>
                                <? $APPLICATION->IncludeComponent(
                                    "bitrix:catalog.section.list",
                                    "",
                                    array(
                                        "ADDITIONAL_COUNT_ELEMENTS_FILTER" => "additionalCountFilter",
                                        "ADD_SECTIONS_CHAIN" => "N",
                                        "CACHE_FILTER" => "N",
                                        "CACHE_GROUPS" => "Y",
                                        "CACHE_TIME" => "36000000",
                                        "CACHE_TYPE" => "A",
                                        "COUNT_ELEMENTS" => "Y",
                                        "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
                                        "FILTER_NAME" => "sectionsFilter",
                                        "HIDE_SECTIONS_WITH_ZERO_COUNT_ELEMENTS" => "N",
                                        "IBLOCK_ID" => "26",
                                        "IBLOCK_TYPE" => "CRM_PRODUCT_CATALOG",
                                        "SECTION_CODE" => "",
                                        "SECTION_FIELDS" => array("", ""),
                                        "SECTION_ID" => "",
                                        "SECTION_URL" => "",
                                        "SECTION_USER_FIELDS" => array("", ""),
                                        "SHOW_PARENT_NAME" => "Y",
                                        "TOP_DEPTH" => "2",
                                        "VIEW_MODE" => "LINE",
                                    )
                                ); ?>
                            </div>
                        </div>
                        */?>
                    </div>
                    <div style="opacity: 1; transform: none;">
                        <div class="products-card-container__content">
                            <ul class="products-card-list products-card-list--4">
                                <? foreach ($arResult['ITEMS'] as $arItem):
                                    $arPrice = CCatalogProduct::GetOptimalPrice($arItem['ID'], 1);

                                    $img_src = isset($arItem['~DETAIL_PICTURE']) ?
                                        \CFile::ResizeImageGet(
                                            $arItem['~DETAIL_PICTURE'],
                                            array("width" => 326, "height" => 517),
                                            BX_RESIZE_IMAGE_EXACT
                                        )['src']
                                        : '/assets/img/no-photo.jpg';

                                    $is_like = MyTools::isFavourite($arItem['ID']);
                                    ?>
                                    <li class="products-card--big">
                                        <button data-id="<?= $arItem['ID'] ?>"
                                                class="products-card__wish-list-button favorite<?= $is_like ? ' checked' : '' ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" id="Bold" viewBox="0 0 24 24"
                                                 width="512" height="512">
                                                <g id="_01_align_center" data-name="01 align center">
                                                    <path fill="#374753"
                                                          d="M17.5.917a6.4,6.4,0,0,0-5.5,3.3A6.4,6.4,0,0,0,6.5.917,6.8,6.8,0,0,0,0,7.967c0,6.775,10.956,14.6,11.422,14.932l.578.409.578-.409C13.044,22.569,24,14.742,24,7.967A6.8,6.8,0,0,0,17.5.917ZM12,20.846c-3.253-2.43-10-8.4-10-12.879a4.8,4.8,0,0,1,4.5-5.05A4.8,4.8,0,0,1,11,7.967h2a4.8,4.8,0,0,1,4.5-5.05A4.8,4.8,0,0,1,22,7.967C22,12.448,15.253,18.416,12,20.846Z"/>
                                                </g>
                                                <path class="checked" fill="#374753"
                                                      d="M17.5.917a6.4,6.4,0,0,0-5.5,3.3A6.4,6.4,0,0,0,6.5.917,6.8,6.8,0,0,0,0,7.967c0,6.775,10.956,14.6,11.422,14.932l.578.409.578-.409C13.044,22.569,24,14.742,24,7.967A6.8,6.8,0,0,0,17.5.917Z"/>
                                            </svg>
                                        </button>
                                        <a class="products-card__link" href="/product/<?= $arItem['CODE'] ?>/"><img
                                                    src="<?= $img_src ?>" alt="<?= $arItem['NAME'] ?>">
                                            <div class="products-card-title--big">
                                                <p class="products-card-title__product"><?= $arItem['PROPERTIES']['NAIMENOVANIE_TOVARA_NA_SAYTE_ETIKETKE']['VALUE'] ?? $arItem['NAME'] ?></p>
                                                <p class="products-card-title__price"><?= number_format($arPrice['PRICE']['PRICE'], 0, '' ,' ')?> ₽</p></p>
                                            </div>
                                        </a>
                                        <?
                                        $colors = MyTools::getVariantColors($arItem['PROPERTIES']['CML2_ARTICLE']['VALUE']);
                                        ?>
                                        <div class="products-card__colors">
                                            <? foreach ($colors as $color => $detail_page_url):?>
                                                <div class="products-card-color-small<? if ($arItem['PROPERTIES']['TSVET']['VALUE'] == $color) echo ' __active' ?>">
                                                    <div style="background-image: url(<?= MyTools::getColor($color) ?>)"></div>
                                                </div>
                                            <? endforeach; ?>
                                        </div>
                                    </li>
                                <? endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
