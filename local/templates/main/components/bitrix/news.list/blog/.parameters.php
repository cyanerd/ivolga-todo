<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arComponentParameters = array(
    "GROUPS" => array(),
    "PARAMETERS" => array(
        "IBLOCK_TYPE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("IBLOCK_TYPE"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlockType,
            "REFRESH" => "Y",
        ),
        "IBLOCK_ID" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("IBLOCK_ID"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlock,
            "REFRESH" => "Y",
            "ADDITIONAL_VALUES" => "Y",
        ),
        "NEWS_COUNT" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("NEWS_COUNT"),
            "TYPE" => "STRING",
            "DEFAULT" => "3",
        ),
        "PROPERTY_CODE" => array(
            "PARENT" => "DETAIL_SETTINGS",
            "NAME" => GetMessage("PROPERTY_CODE"),
            "TYPE" => "LIST",
            "MULTIPLE" => "Y",
            "VALUES" => $arProperty,
            "ADDITIONAL_VALUES" => "Y",
        ),
        "SORT_BY1" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("SORT_BY1"),
            "TYPE" => "LIST",
            "DEFAULT" => "ACTIVE_FROM",
            "VALUES" => $arSort,
            "ADDITIONAL_VALUES" => "Y",
        ),
        "SORT_ORDER1" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("SORT_ORDER1"),
            "TYPE" => "LIST",
            "DEFAULT" => "DESC",
            "VALUES" => $arAscDesc,
        ),
        "CACHE_TYPE" => array(
            "PARENT" => "CACHE_SETTINGS",
            "NAME" => GetMessage("CACHE_TYPE"),
            "TYPE" => "LIST",
            "VALUES" => array(
                "A" => GetMessage("CACHE_TYPE_AUTO"),
                "Y" => GetMessage("CACHE_TYPE_YES"),
                "N" => GetMessage("CACHE_TYPE_NO"),
            ),
            "DEFAULT" => "A",
        ),
        "CACHE_TIME" => array(
            "PARENT" => "CACHE_SETTINGS",
            "NAME" => GetMessage("CACHE_TIME"),
            "TYPE" => "STRING",
            "DEFAULT" => "36000000",
        ),
    ),
);
?> 