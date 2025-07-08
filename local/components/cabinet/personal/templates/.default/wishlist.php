<?php
    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $arFilter;
// находим все товары из избранного
$session_id = session_id();
$arItems = [];
$arFilter = array('IBLOCK_ID' => 24, 'ACTIVE' => 'Y', '=PROPERTY_SESSION_ID' => $session_id, );
$db_list = CIBlockElement::GetList(array(), $arFilter, false, array(), array('ID', 'IBLOCK_ID', 'PROPERTY_ITEM_ID',));
while ($arElement = $db_list->GetNext()):
    if($arElement['PROPERTY_ITEM_ID_VALUE']) $arItems[] = $arElement['PROPERTY_ITEM_ID_VALUE'];
endwhile;
$arFilter['=ID'] = !empty($arItems) ? $arItems : false;
?>
<main class="profile">
    <?require "left-menu.php";?>
    <div style="opacity: 1; transform: none;">
        <div class="right-container">
            <div class="wishlist-container">
                <div class="container">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:catalog.section",
                        "list",
                        array(
                            "IBLOCK_TYPE" => 'catalog',
                            "IBLOCK_ID" => 29,
                            "ELEMENT_SORT_FIELD" => "sort",
                            "ELEMENT_SORT_FIELD2" => "id",
                            "ELEMENT_SORT_ORDER" => "asc",
                            "ELEMENT_SORT_ORDER2" => "desc",
                            "INCLUDE_SUBSECTIONS" => 'Y',
                            "FILTER_NAME" => 'arFilter',
                            "PAGE_ELEMENT_COUNT" => 100,
                            "PRICE_CODE" => array("Розничная цена"),
                            "USE_PRICE_COUNT" => 'N',
                            "SHOW_PRICE_COUNT" => '1',
                            "PRICE_VAT_INCLUDE" => 'Y',
                            "USE_PRODUCT_QUANTITY" => 'N',
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "A",
                        )
                    );?>
                </div>
            </div>
        </div>
    </div>
</main>