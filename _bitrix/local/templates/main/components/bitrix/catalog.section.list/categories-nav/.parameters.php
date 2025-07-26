<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arComponentParameters = [
  "GROUPS" => [
    "SETTINGS" => [
      "NAME" => GetMessage("T_IBLOCK_DESC_SETTINGS"),
      "SORT" => 100,
    ],
  ],
  "PARAMETERS" => [
    "IBLOCK_TYPE" => [
      "PARENT" => "BASE",
      "NAME" => GetMessage("T_IBLOCK_DESC_TYPE"),
      "TYPE" => "LIST",
      "VALUES" => $arIBLockType,
      "REFRESH" => "Y",
    ],
    "IBLOCK_ID" => [
      "PARENT" => "BASE",
      "NAME" => GetMessage("T_IBLOCK_DESC_ID"),
      "TYPE" => "LIST",
      "VALUES" => $arIBlock,
      "REFRESH" => "Y",
      "ADDITIONAL_VALUES" => "Y",
    ],
    "SECTION_ID" => [
      "PARENT" => "BASE",
      "NAME" => GetMessage("T_IBLOCK_DESC_SECTION_ID"),
      "TYPE" => "STRING",
      "DEFAULT" => '={$_REQUEST["SECTION_ID"]}',
    ],
    "SECTION_CODE" => [
      "PARENT" => "BASE",
      "NAME" => GetMessage("T_IBLOCK_DESC_SECTION_CODE"),
      "TYPE" => "STRING",
      "DEFAULT" => '',
    ],
    "SECTION_CODE_PATH" => [
      "PARENT" => "BASE",
      "NAME" => GetMessage("T_IBLOCK_DESC_SECTION_CODE_PATH"),
      "TYPE" => "STRING",
      "DEFAULT" => '',
    ],
    "SECTION_SORT_FIELD" => [
      "PARENT" => "SETTINGS",
      "NAME" => GetMessage("T_IBLOCK_DESC_SECTION_SORT_FIELD"),
      "TYPE" => "LIST",
      "VALUES" => [
        "sort" => GetMessage("T_IBLOCK_DESC_SECTION_SORT_FIELD_SORT"),
        "name" => GetMessage("T_IBLOCK_DESC_SECTION_SORT_FIELD_NAME"),
        "id" => GetMessage("T_IBLOCK_DESC_SECTION_SORT_FIELD_ID"),
        "date" => GetMessage("T_IBLOCK_DESC_SECTION_SORT_FIELD_DATE"),
      ],
      "DEFAULT" => "sort",
      "ADDITIONAL_VALUES" => "Y",
    ],
    "SECTION_SORT_ORDER" => [
      "PARENT" => "SETTINGS",
      "NAME" => GetMessage("T_IBLOCK_DESC_SECTION_SORT_ORDER"),
      "TYPE" => "LIST",
      "VALUES" => [
        "asc" => GetMessage("T_IBLOCK_DESC_SECTION_SORT_ORDER_ASC"),
        "desc" => GetMessage("T_IBLOCK_DESC_SECTION_SORT_ORDER_DESC"),
      ],
      "DEFAULT" => "asc",
    ],
    "SECTION_SORT_FIELD2" => [
      "PARENT" => "SETTINGS",
      "NAME" => GetMessage("T_IBLOCK_DESC_SECTION_SORT_FIELD2"),
      "TYPE" => "LIST",
      "VALUES" => [
        "id" => GetMessage("T_IBLOCK_DESC_SECTION_SORT_FIELD_ID"),
        "name" => GetMessage("T_IBLOCK_DESC_SECTION_SORT_FIELD_NAME"),
        "sort" => GetMessage("T_IBLOCK_DESC_SECTION_SORT_FIELD_SORT"),
        "date" => GetMessage("T_IBLOCK_DESC_SECTION_SORT_FIELD_DATE"),
      ],
      "DEFAULT" => "id",
      "ADDITIONAL_VALUES" => "Y",
    ],
    "SECTION_SORT_ORDER2" => [
      "PARENT" => "SETTINGS",
      "NAME" => GetMessage("T_IBLOCK_DESC_SECTION_SORT_ORDER2"),
      "TYPE" => "LIST",
      "VALUES" => [
        "asc" => GetMessage("T_IBLOCK_DESC_SECTION_SORT_ORDER_ASC"),
        "desc" => GetMessage("T_IBLOCK_DESC_SECTION_SORT_ORDER_DESC"),
      ],
      "DEFAULT" => "desc",
    ],
    "SECTION_COUNT" => [
      "PARENT" => "SETTINGS",
      "NAME" => GetMessage("T_IBLOCK_DESC_SECTION_COUNT"),
      "TYPE" => "STRING",
      "DEFAULT" => "20",
    ],
    "LINE_ELEMENT_COUNT" => [
      "PARENT" => "SETTINGS",
      "NAME" => GetMessage("T_IBLOCK_DESC_LINE_ELEMENT_COUNT"),
      "TYPE" => "STRING",
      "DEFAULT" => "3",
    ],
    "SECTION_URL" => [
      "PARENT" => "URL_TEMPLATES",
      "NAME" => GetMessage("T_IBLOCK_DESC_SECTION_URL"),
      "TYPE" => "STRING",
      "DEFAULT" => "",
    ],
    "CACHE_TYPE" => [
      "PARENT" => "CACHE_SETTINGS",
      "NAME" => GetMessage("T_IBLOCK_DESC_CACHE_TYPE"),
      "TYPE" => "LIST",
      "VALUES" => [
        "A" => GetMessage("T_IBLOCK_DESC_CACHE_TYPE_AUTO"),
        "Y" => GetMessage("T_IBLOCK_DESC_CACHE_TYPE_YES"),
        "N" => GetMessage("T_IBLOCK_DESC_CACHE_TYPE_NO"),
      ],
      "DEFAULT" => "A",
    ],
    "CACHE_TIME" => [
      "PARENT" => "CACHE_SETTINGS",
      "NAME" => GetMessage("T_IBLOCK_DESC_CACHE_TIME"),
      "TYPE" => "STRING",
      "DEFAULT" => "36000000",
    ],
    "CACHE_GROUPS" => [
      "PARENT" => "CACHE_SETTINGS",
      "NAME" => GetMessage("T_IBLOCK_DESC_CACHE_GROUPS"),
      "TYPE" => "CHECKBOX",
      "DEFAULT" => "Y",
    ],
  ],
];
?>
