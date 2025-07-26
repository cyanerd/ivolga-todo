<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
  die();
}

/** @var array $arCurrentValues */

use Bitrix\Main\Loader;
use Bitrix\Catalog;
use Bitrix\Iblock;

if (!Loader::includeModule('sale'))
  return;

$siteId = isset($_REQUEST['src_site']) && is_string($_REQUEST['src_site']) ? $_REQUEST['src_site'] : '';
$siteId = mb_substr(preg_replace('/[^a-z0-9_]/i', '', $siteId), 0, 2);

$arColumns = [
  "PREVIEW_PICTURE" => GetMessage("SOA_PREVIEW_PICTURE"),
  "DETAIL_PICTURE" => GetMessage("SOA_DETAIL_PICTURE"),
  "PREVIEW_TEXT" => GetMessage("SOA_PREVIEW_TEXT"),
  "PROPS" => GetMessage("SOA_PROPS"),
  "NOTES" => GetMessage("SOA_PRICE_TYPE"),
  "DISCOUNT_PRICE_PERCENT_FORMATED" => GetMessage("SOA_DISCOUNT"),
  "PRICE_FORMATED" => GetMessage("SOA_PRICE_FORMATED"),
  "WEIGHT_FORMATED" => GetMessage("SOA_WEIGHT")
];

$arIblockIDs = [];
$arIblockNames = [];
if (Loader::includeModule('catalog')) {
  $parameters = [
    'select' => [
      'IBLOCK_ID',
      'NAME' => 'IBLOCK.NAME',
    ],
    'order' => [
      'IBLOCK_ID' => 'ASC',
    ],
  ];

  if ($siteId !== '') {
    $parameters['select']['SITE_ID'] = 'IBLOCK_SITE.SITE_ID';
    $parameters['filter'] = [
      '=SITE_ID' => $siteId,
    ];
    $parameters['runtime'] = [
      'IBLOCK_SITE' => [
        'data_type' => 'Bitrix\Iblock\IblockSiteTable',
        'reference' => [
          'ref.IBLOCK_ID' => 'this.IBLOCK_ID',
        ],
        'join_type' => 'inner',
      ],
    ];
  }

  $catalogIterator = Catalog\CatalogIblockTable::getList($parameters);
  while ($catalog = $catalogIterator->fetch()) {
    $catalog['IBLOCK_ID'] = (int)$catalog['IBLOCK_ID'];
    $arIblockIDs[] = $catalog['IBLOCK_ID'];
    $arIblockNames[$catalog['IBLOCK_ID']] = $catalog['NAME'];
  }
  unset($catalog, $catalogIterator);

  if (!empty($arIblockIDs)) {
    $arProps = [];
    $propertyIterator = Iblock\PropertyTable::getList([
      'select' => [
        'ID',
        'CODE',
        'NAME',
        'IBLOCK_ID',
      ],
      'filter' => [
        '@IBLOCK_ID' => $arIblockIDs,
        '=ACTIVE' => 'Y',
        '!=XML_ID' => CIBlockPropertyTools::XML_SKU_LINK,
      ],
      'order' => [
        'IBLOCK_ID' => 'ASC',
        'SORT' => 'ASC',
        'ID' => 'ASC',
      ]
    ]);
    while ($property = $propertyIterator->fetch()) {
      $property['ID'] = (int)$property['ID'];
      $property['IBLOCK_ID'] = (int)$property['IBLOCK_ID'];
      $property['CODE'] = (string)$property['CODE'];
      if ($property['CODE'] == '')
        $property['CODE'] = $property['ID'];
      if (!isset($arProps[$property['CODE']])) {
        $arProps[$property['CODE']] = [
          'CODE' => $property['CODE'],
          'TITLE' => $property['NAME'] . ' [' . $property['CODE'] . ']',
          'ID' => [$property['ID']],
          'IBLOCK_ID' => [$property['IBLOCK_ID'] => $property['IBLOCK_ID']],
          'IBLOCK_TITLE' => [$property['IBLOCK_ID'] => $arIblockNames[$property['IBLOCK_ID']]],
          'COUNT' => 1
        ];
      } else {
        $arProps[$property['CODE']]['ID'][] = $property['ID'];
        $arProps[$property['CODE']]['IBLOCK_ID'][$property['IBLOCK_ID']] = $property['IBLOCK_ID'];
        if ($arProps[$property['CODE']]['COUNT'] < 2)
          $arProps[$property['CODE']]['IBLOCK_TITLE'][$property['IBLOCK_ID']] = $arIblockNames[$property['IBLOCK_ID']];
        $arProps[$property['CODE']]['COUNT']++;
      }
    }
    unset($property, $propertyIterator);

    $propList = [];
    foreach ($arProps as &$property) {
      $iblockList = '';
      if ($property['COUNT'] > 1) {
        $iblockList = ($property['COUNT'] > 2 ? ' ( ... )' : ' (' . implode(', ', $property['IBLOCK_TITLE']) . ')');
      }
      $propList['PROPERTY_' . $property['CODE']] = $property['TITLE'] . $iblockList;
    }
    unset($property, $arProps);

    if (!empty($propList))
      $arColumns = array_merge($arColumns, $propList);
    unset($propList);
  }
}

$arComponentParameters = [
  "GROUPS" => [
    "ANALYTICS_SETTINGS" => [
      "NAME" => GetMessage("SOA_ANALYTICS_SETTINGS")
    ],
    "MAIN_MESSAGE_SETTINGS" => [
      "NAME" => GetMessage("SOA_MAIN_MESSAGE_SETTINGS")
    ],
    "ADDITIONAL_MESSAGE_SETTINGS" => [
      "NAME" => GetMessage("SOA_ADDITIONAL_MESSAGE_SETTINGS")
    ],
    "ERROR_MESSAGE_SETTINGS" => [
      "NAME" => GetMessage("SOA_ERROR_MESSAGE_SETTINGS1")
    ]
  ],
  "PARAMETERS" => [
    "USER_CONSENT" => [],
    "ACTION_VARIABLE" => [
      "NAME" => GetMessage('SOA_ACTION_VARIABLE'),
      "TYPE" => "STRING",
      "MULTIPLE" => "N",
      "DEFAULT" => "soa-action",
      "PARENT" => "ADDITIONAL_SETTINGS",
    ],
    "PATH_TO_BASKET" => [
      "NAME" => GetMessage("SOA_PATH_TO_BASKET1"),
      "TYPE" => "STRING",
      "MULTIPLE" => "N",
      "DEFAULT" => "/personal/cart/",
      "COLS" => 25,
      "PARENT" => "ADDITIONAL_SETTINGS",
    ],
    "PATH_TO_PERSONAL" => [
      "NAME" => GetMessage("SOA_PATH_TO_PERSONAL1"),
      "TYPE" => "STRING",
      "MULTIPLE" => "N",
      "DEFAULT" => "index.php",
      "COLS" => 25,
      "PARENT" => "ADDITIONAL_SETTINGS",
    ],
    "PATH_TO_PAYMENT" => [
      "NAME" => GetMessage("SOA_PATH_TO_PAYMENT"),
      "TYPE" => "STRING",
      "MULTIPLE" => "N",
      "DEFAULT" => "payment.php",
      "COLS" => 25,
      "PARENT" => "ADDITIONAL_SETTINGS",
    ],
    "PATH_TO_AUTH" => [
      "NAME" => GetMessage("SOA_PATH_TO_AUTH1"),
      "TYPE" => "STRING",
      "MULTIPLE" => "N",
      "DEFAULT" => "/auth/",
      "COLS" => 25,
      "PARENT" => "ADDITIONAL_SETTINGS",
    ],
    "PAY_FROM_ACCOUNT" => [
      "NAME" => GetMessage("SOA_ALLOW_PAY_FROM_ACCOUNT1"),
      "TYPE" => "CHECKBOX",
      "DEFAULT" => "N",
      "PARENT" => "BASE",
    ],
    "ONLY_FULL_PAY_FROM_ACCOUNT" => [
      "NAME" => GetMessage("SOA_ONLY_FULL_PAY_FROM_ACCOUNT1"),
      "TYPE" => "CHECKBOX",
      "DEFAULT" => "N",
      "PARENT" => "BASE",
    ],
    "ALLOW_AUTO_REGISTER" => [
      "NAME" => GetMessage("SOA_ALLOW_AUTO_REGISTER"),
      "TYPE" => "CHECKBOX",
      "DEFAULT" => "N",
      "PARENT" => "BASE",
    ],
    "ALLOW_APPEND_ORDER" => [
      "NAME" => GetMessage("SOA_ALLOW_APPEND_ORDER"),
      "TYPE" => "CHECKBOX",
      "DEFAULT" => "Y",
      "PARENT" => "BASE",
    ],
    "SEND_NEW_USER_NOTIFY" => [
      "NAME" => GetMessage("SOA_SEND_NEW_USER_NOTIFY"),
      "TYPE" => "CHECKBOX",
      "DEFAULT" => "Y",
      "PARENT" => "BASE",
    ],
    "DELIVERY_NO_AJAX" => [
      "NAME" => GetMessage("SOA_DELIVERY_NO_AJAX3"),
      "TYPE" => "LIST",
      "MULTIPLE" => "N",
      "VALUES" => [
        'N' => GetMessage("SOA_DELIVERY_NO_AJAX_NO"),
        'H' => GetMessage("SOA_DELIVERY_NO_AJAX_HANDLER"),
        'Y' => GetMessage("SOA_DELIVERY_NO_AJAX_YES"),
      ],
      "DEFAULT" => "N",
      "REFRESH" => "Y",
      "PARENT" => "BASE",
    ],
    "SHOW_NOT_CALCULATED_DELIVERIES" => [
      "NAME" => GetMessage("SOA_SHOW_NOT_CALCULATED_DELIVERIES"),
      "TYPE" => "LIST",
      "MULTIPLE" => "N",
      "DEFAULT" => "L",
      "VALUES" => [
        'N' => GetMessage("SOA_SHOW_NOT_CALCULATED_DELIVERIES_N"),
        'L' => GetMessage("SOA_SHOW_NOT_CALCULATED_DELIVERIES_L"),
        'Y' => GetMessage("SOA_SHOW_NOT_CALCULATED_DELIVERIES_Y"),
      ],
      "HIDDEN" => isset($arCurrentValues['DELIVERY_NO_AJAX']) && $arCurrentValues['DELIVERY_NO_AJAX'] === 'Y' ? 'N' : 'Y',
      "PARENT" => "BASE",
    ],
    "DELIVERY_NO_SESSION" => [
      "NAME" => GetMessage("SOA_DELIVERY_NO_SESSION"),
      "TYPE" => "CHECKBOX",
      "MULTIPLE" => "N",
      "DEFAULT" => "Y",
      "PARENT" => "BASE",
    ],
    "TEMPLATE_LOCATION" => [
      "NAME" => GetMessage("SBB_TEMPLATE_LOCATION1"),
      "TYPE" => "LIST",
      "MULTIPLE" => "N",
      "VALUES" => [
        "popup" => GetMessage("SBB_TMP_POPUP"),
        ".default" => GetMessage("SBB_TMP_DEFAULT1")
      ],
      "DEFAULT" => "popup",
      "COLS" => 25,
      "ADDITIONAL_VALUES" => "N",
      "PARENT" => "BASE",
    ],
    "SPOT_LOCATION_BY_GEOIP" => [
      "NAME" => GetMessage("SBB_SPOT_LOCATION_BY_GEOIP"),
      "TYPE" => "CHECKBOX",
      "DEFAULT" => "Y",
      "PARENT" => "BASE",
    ],
    "DELIVERY_TO_PAYSYSTEM" => [
      "NAME" => GetMessage("SBB_DELIVERY_PAYSYSTEM"),
      "TYPE" => "LIST",
      "MULTIPLE" => "N",
      "VALUES" => [
        "d2p" => GetMessage("SBB_TITLE_PD"),
        "p2d" => GetMessage("SBB_TITLE_DP")
      ],
      "PARENT" => "BASE",
    ],
    "SHOW_VAT_PRICE" => [
      "NAME" => GetMessage('SOA_SHOW_VAT_PRICE'),
      "TYPE" => "CHECKBOX",
      "DEFAULT" => "Y",
      "PARENT" => "BASE",
    ],
    "SET_TITLE" => [],
    "USE_PREPAYMENT" => [
      "NAME" => GetMessage('SBB_USE_PREPAYMENT'),
      "TYPE" => "CHECKBOX",
      "DEFAULT" => "N",
      "PARENT" => "BASE",
    ],
    "DISABLE_BASKET_REDIRECT" => [
      "NAME" => GetMessage('SOA_DISABLE_BASKET_REDIRECT2'),
      "TYPE" => "CHECKBOX",
      "DEFAULT" => "N"
    ],
    "EMPTY_BASKET_HINT_PATH" => [
      "NAME" => GetMessage('SOA_EMPTY_BASKET_HINT_PATH'),
      "TYPE" => "STRING",
      "DEFAULT" => "/"
    ],
    "USE_PHONE_NORMALIZATION" => [
      "NAME" => GetMessage("SOA_USE_PHONE_NORMALIZATION"),
      "TYPE" => "CHECKBOX",
      "DEFAULT" => "Y",
      "PARENT" => "ADDITIONAL_SETTINGS"
    ]
  ]
];

//compatibility to old default columns in basket
$defaultColumns = [];
if (!isset($arCurrentValues['PRODUCT_COLUMNS']) && !isset($arCurrentValues['PRODUCT_COLUMNS_VISIBLE']))
  $defaultColumns = ['PREVIEW_PICTURE', 'PROPS'];
else if (!isset($arCurrentValues['PRODUCT_COLUMNS_VISIBLE'])) {
  if (isset($arCurrentValues['PRODUCT_COLUMNS'])) {
    if (!is_array($arCurrentValues['PRODUCT_COLUMNS'])) {
      $arCurrentValues['PRODUCT_COLUMNS'] = [];
    }
    $defaultColumns = array_merge($arCurrentValues['PRODUCT_COLUMNS'], ['PRICE_FORMATED']);
  } else {
    $defaultColumns = ['PROPS', 'DISCOUNT_PRICE_PERCENT_FORMATED', 'PRICE_FORMATED'];
  }
}

$arComponentParameters["PARAMETERS"]["PRODUCT_COLUMNS_VISIBLE"] = [
  "NAME" => GetMessage("SOA_PRODUCT_COLUMNS"),
  "TYPE" => "LIST",
  "MULTIPLE" => "Y",
  "COLS" => 25,
  "SIZE" => 7,
  "VALUES" => $arColumns,
  "DEFAULT" => $defaultColumns,
  "ADDITIONAL_VALUES" => "N",
  "PARENT" => "ADDITIONAL_SETTINGS",
];

if (
  !empty($templateProperties['PRODUCT_COLUMNS_HIDDEN'])
  && is_array($templateProperties['PRODUCT_COLUMNS_HIDDEN'])
) {
  $templateProperties['PRODUCT_COLUMNS_HIDDEN']['VALUES'] = $arColumns;
}

// deprecated parameter
if (($arCurrentValues['COUNT_DELIVERY_TAX'] ?? 'N') === 'Y') {
  $arComponentParameters["PARAMETERS"]["COUNT_DELIVERY_TAX"] = [
    "NAME" => GetMessage("SOA_COUNT_DELIVERY_TAX"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "N",
    "PARENT" => "BASE",
  ];
}

$arComponentParameters["PARAMETERS"]['COMPATIBLE_MODE'] = [
  "NAME" => GetMessage("SOA_COMPATIBLE_MODE1"),
  "TYPE" => "CHECKBOX",
  "DEFAULT" => "Y",
  "PARENT" => "BASE"
];

$arComponentParameters["PARAMETERS"]['USE_PRELOAD'] = [
  "NAME" => GetMessage("SOA_USE_PRELOAD"),
  "TYPE" => "CHECKBOX",
  "DEFAULT" => "Y",
  "PARENT" => "BASE"
];

foreach ($arIblockIDs as $iblockId) {
  $fileProperties = ['-' => GetMessage("SOA_DEFAULT")];
  $propertyIterator = CIBlockProperty::getList(
    ["SORT" => "ASC", "NAME" => "ASC"],
    ["IBLOCK_ID" => $iblockId, "ACTIVE" => "Y"]
  );
  while ($property = $propertyIterator->fetch()) {
    if ($property['PROPERTY_TYPE'] == 'F') {
      $property['ID'] = (int)$property['ID'];
      $propertyName = '[' . $property['ID'] . ']' . ($property['CODE'] != '' ? '[' . $property['CODE'] . ']' : '') . ' ' . $property['NAME'];
      if ($property['CODE'] == '')
        $property['CODE'] = $property['ID'];

      $fileProperties[$property['CODE']] = $propertyName;
    }
  }

  $arComponentParameters["PARAMETERS"]['ADDITIONAL_PICT_PROP_' . $iblockId] = [
    "NAME" => GetMessage("SOA_ADDITIONAL_IMAGE") . ' [' . $arIblockNames[$iblockId] . ']',
    "TYPE" => "LIST",
    "MULTIPLE" => "N",
    "VALUES" => $fileProperties,
    "ADDITIONAL_VALUES" => "N",
    "PARENT" => 'ADDITIONAL_SETTINGS'
  ];
}

$arComponentParameters["PARAMETERS"]['BASKET_IMAGES_SCALING'] = [
  "NAME" => GetMessage("SOA_BASKET_IMAGES_SCALING"),
  "TYPE" => "LIST",
  "VALUES" => [
    'standard' => GetMessage("SOA_STANDARD"),
    'adaptive' => GetMessage("SOA_ADAPTIVE"),
    'no_scale' => GetMessage("SOA_NO_SCALE")
  ],
  "DEFAULT" => "adaptive",
  "PARENT" => "ADDITIONAL_SETTINGS"
];
