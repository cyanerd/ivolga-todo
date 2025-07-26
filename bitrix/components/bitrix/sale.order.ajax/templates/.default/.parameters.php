<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var array $arCurrentValues */

use Bitrix\Main\Loader;
use Bitrix\Catalog;
use Bitrix\Iblock;

if (!Loader::includeModule('sale'))
  return;

$arThemes = [];
if ($eshop = \Bitrix\Main\ModuleManager::isModuleInstalled('bitrix.eshop')) {
  $arThemes['site'] = GetMessage('THEME_SITE');
}
$arThemesList = [
  'blue' => GetMessage('THEME_BLUE'),
  'green' => GetMessage('THEME_GREEN'),
  'red' => GetMessage('THEME_RED'),
  'yellow' => GetMessage('THEME_YELLOW')
];
$dir = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/css/main/themes/";
if (is_dir($dir)) {
  foreach ($arThemesList as $themeID => $themeName) {
    if (!is_file($dir . $themeID . '/style.css'))
      continue;
    $arThemes[$themeID] = $themeName;
  }
}

$arTemplateParameters = [
  "TEMPLATE_THEME" => [
    "NAME" => GetMessage("TEMPLATE_THEME"),
    "TYPE" => "LIST",
    'VALUES' => $arThemes,
    'DEFAULT' => $eshop ? 'site' : 'blue',
    "PARENT" => "VISUAL"
  ],
  "SHOW_ORDER_BUTTON" => [
    "NAME" => GetMessage("SHOW_ORDER_BUTTON"),
    "TYPE" => "LIST",
    "VALUES" => [
      'final_step' => GetMessage("SHOW_FINAL_STEP"),
      'always' => GetMessage("SHOW_ALWAYS")
    ],
    "PARENT" => "VISUAL",
  ],
  "SHOW_TOTAL_ORDER_BUTTON" => [
    "NAME" => GetMessage("SHOW_TOTAL_ORDER_BUTTON"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "N",
    "PARENT" => "VISUAL",
  ],
  "SHOW_PAY_SYSTEM_LIST_NAMES" => [
    "NAME" => GetMessage("SHOW_PAY_SYSTEM_LIST_NAMES"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "Y",
    "PARENT" => "VISUAL",
  ],
  "SHOW_PAY_SYSTEM_INFO_NAME" => [
    "NAME" => GetMessage("SHOW_PAY_SYSTEM_INFO_NAME"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "Y",
    "PARENT" => "VISUAL",
  ],
  "SHOW_DELIVERY_LIST_NAMES" => [
    "NAME" => GetMessage("SHOW_DELIVERY_LIST_NAMES"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "Y",
    "PARENT" => "VISUAL",
  ],
  "SHOW_DELIVERY_INFO_NAME" => [
    "NAME" => GetMessage("SHOW_DELIVERY_INFO_NAME"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "Y",
    "PARENT" => "VISUAL",
  ],
  "SHOW_DELIVERY_PARENT_NAMES" => [
    "NAME" => GetMessage("DELIVERY_PARENT_NAMES"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "Y",
    "PARENT" => "VISUAL",
  ],
  "SHOW_STORES_IMAGES" => [
    "NAME" => GetMessage("SHOW_STORES_IMAGES"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "Y",
    "PARENT" => "VISUAL",
  ],
  "SKIP_USELESS_BLOCK" => [
    "NAME" => GetMessage("SKIP_USELESS_BLOCK"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "Y",
    "PARENT" => "VISUAL",
  ],
  "BASKET_POSITION" => [
    "NAME" => GetMessage("BASKET_POSITION"),
    "TYPE" => "LIST",
    "MULTIPLE" => "N",
    "VALUES" => [
      "after" => GetMessage("BASKET_POSITION_AFTER"),
      "before" => GetMessage("BASKET_POSITION_BEFORE")
    ],
    "DEFAULT" => "after",
    "PARENT" => "VISUAL"
  ],
  "SHOW_BASKET_HEADERS" => [
    "NAME" => GetMessage("SHOW_BASKET_HEADERS"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "N",
    "PARENT" => "VISUAL",
  ],
  "DELIVERY_FADE_EXTRA_SERVICES" => [
    "NAME" => GetMessage("DELIVERY_FADE_EXTRA_SERVICES"),
    "TYPE" => "CHECKBOX",
    "MULTIPLE" => "N",
    "DEFAULT" => "N",
    "PARENT" => "VISUAL",
  ],
  "SHOW_NEAREST_PICKUP" => [
    "NAME" => GetMessage("SHOW_NEAREST_PICKUP"),
    "TYPE" => "CHECKBOX",
    "MULTIPLE" => "N",
    "DEFAULT" => "N",
    "PARENT" => "VISUAL",
  ],
  "DELIVERIES_PER_PAGE" => [
    "NAME" => GetMessage("DELIVERIES_PER_PAGE"),
    "TYPE" => "STRING",
    "MULTIPLE" => "N",
    "DEFAULT" => "9",
    "PARENT" => "VISUAL",
  ],
  "PAY_SYSTEMS_PER_PAGE" => [
    "NAME" => GetMessage("PAY_SYSTEMS_PER_PAGE"),
    "TYPE" => "STRING",
    "MULTIPLE" => "N",
    "DEFAULT" => "9",
    "PARENT" => "VISUAL",
  ],
  "PICKUPS_PER_PAGE" => [
    "NAME" => GetMessage("PICKUPS_PER_PAGE"),
    "TYPE" => "STRING",
    "MULTIPLE" => "N",
    "DEFAULT" => "5",
    "PARENT" => "VISUAL",
  ],
  "SHOW_PICKUP_MAP" => [
    "NAME" => GetMessage("SHOW_PICKUP_MAP"),
    "TYPE" => "CHECKBOX",
    "MULTIPLE" => "N",
    "DEFAULT" => "Y",
    "PARENT" => "VISUAL",
  ],
  "SHOW_MAP_IN_PROPS" => [
    "NAME" => GetMessage("SHOW_MAP_IN_PROPS"),
    "TYPE" => "CHECKBOX",
    "MULTIPLE" => "N",
    "DEFAULT" => "N",
    "REFRESH" => "Y",
    "PARENT" => "VISUAL",
  ],
  "PICKUP_MAP_TYPE" => [
    "NAME" => GetMessage("PICKUP_MAP_TYPE"),
    "TYPE" => "LIST",
    "MULTIPLE" => "N",
    "VALUES" => [
      "yandex" => GetMessage("PICKUP_MAP_TYPE_YANDEX"),
      "google" => GetMessage("PICKUP_MAP_TYPE_GOOGLE")
    ],
    "DEFAULT" => "yandex",
    "PARENT" => "VISUAL"
  ],
  "SERVICES_IMAGES_SCALING" => [
    "NAME" => GetMessage("SERVICES_IMAGES_SCALING"),
    "TYPE" => "LIST",
    "VALUES" => [
      'standard' => GetMessage("SOA_STANDARD"),
      'adaptive' => GetMessage("SOA_ADAPTIVE"),
      'no_scale' => GetMessage("SOA_NO_SCALE")
    ],
    "DEFAULT" => "adaptive",
    "PARENT" => "ADDITIONAL_SETTINGS"
  ],
  "PRODUCT_COLUMNS_HIDDEN" => [
    "NAME" => GetMessage("PRODUCT_COLUMNS_HIDDEN"),
    "TYPE" => "LIST",
    "MULTIPLE" => "Y",
    "COLS" => 25,
    "SIZE" => 7,
    "VALUES" => [],
    "DEFAULT" => [],
    "ADDITIONAL_VALUES" => "N",
    "PARENT" => "ADDITIONAL_SETTINGS"
  ],
  "HIDE_ORDER_DESCRIPTION" => [
    "NAME" => GetMessage("HIDE_ORDER_DESCRIPTION"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "N",
    "PARENT" => "ADDITIONAL_SETTINGS"
  ],
  "ALLOW_USER_PROFILES" => [
    "NAME" => GetMessage("ALLOW_USER_PROFILES"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "N",
    "REFRESH" => "Y",
    "PARENT" => "BASE"
  ],
  "ALLOW_NEW_PROFILE" => [
    "NAME" => GetMessage("ALLOW_NEW_PROFILE"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "N",
    "HIDDEN" =>
      (isset($arCurrentValues['ALLOW_USER_PROFILES']) && $arCurrentValues['ALLOW_USER_PROFILES'] === 'Y')
        ? 'N'
        : 'Y'
    ,
    "PARENT" => "BASE"
  ],
  "SHOW_COUPONS" => [
    "NAME" => GetMessage("SHOW_COUPONS"),
    "TYPE" => "CHECKBOX",
    "MULTIPLE" => "N",
    "DEFAULT" => "Y",
    "REFRESH" => "Y",
    "PARENT" => "VISUAL",
  ],
  "USE_YM_GOALS" => [
    "NAME" => GetMessage("USE_YM_GOALS1"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "N",
    "REFRESH" => "Y",
    "PARENT" => "ANALYTICS_SETTINGS"
  ]
];

if (!isset($arCurrentValues['SHOW_COUPONS']) || $arCurrentValues['SHOW_COUPONS'] === 'Y') {
  $arTemplateParameters["SHOW_COUPONS_BASKET"] = [
    "NAME" => GetMessage("SHOW_COUPONS_BASKET"),
    "TYPE" => "CHECKBOX",
    "MULTIPLE" => "N",
    "DEFAULT" => "Y",
    "PARENT" => "VISUAL",
  ];
  $arTemplateParameters["SHOW_COUPONS_DELIVERY"] = [
    "NAME" => GetMessage("SHOW_COUPONS_DELIVERY"),
    "TYPE" => "CHECKBOX",
    "MULTIPLE" => "N",
    "DEFAULT" => "Y",
    "PARENT" => "VISUAL",
  ];
  $arTemplateParameters["SHOW_COUPONS_PAY_SYSTEM"] = [
    "NAME" => GetMessage("SHOW_COUPONS_PAY_SYSTEM"),
    "TYPE" => "CHECKBOX",
    "MULTIPLE" => "N",
    "DEFAULT" => "Y",
    "PARENT" => "VISUAL",
  ];
}

if (isset($arCurrentValues['USE_YM_GOALS']) && $arCurrentValues['USE_YM_GOALS'] === 'Y') {
  $arTemplateParameters["YM_GOALS_COUNTER"] = [
    "NAME" => GetMessage("YM_GOALS_COUNTER"),
    "TYPE" => "STRING",
    "DEFAULT" => "",
    "PARENT" => "ANALYTICS_SETTINGS"
  ];
  $arTemplateParameters["YM_GOALS_INITIALIZE"] = [
    "NAME" => GetMessage("YM_GOALS_INITIALIZE"),
    "TYPE" => "STRING",
    "DEFAULT" => "BX-order-init",
    "PARENT" => "ANALYTICS_SETTINGS"
  ];
  $arTemplateParameters["YM_GOALS_EDIT_REGION"] = [
    "NAME" => GetMessage("YM_GOALS_EDIT_REGION"),
    "TYPE" => "STRING",
    "DEFAULT" => "BX-region-edit",
    "PARENT" => "ANALYTICS_SETTINGS"
  ];
  $arTemplateParameters["YM_GOALS_EDIT_DELIVERY"] = [
    "NAME" => GetMessage("YM_GOALS_EDIT_DELIVERY"),
    "TYPE" => "STRING",
    "DEFAULT" => "BX-delivery-edit",
    "PARENT" => "ANALYTICS_SETTINGS"
  ];
  $arTemplateParameters["YM_GOALS_EDIT_PICKUP"] = [
    "NAME" => GetMessage("YM_GOALS_EDIT_PICKUP"),
    "TYPE" => "STRING",
    "DEFAULT" => "BX-pickUp-edit",
    "PARENT" => "ANALYTICS_SETTINGS"
  ];
  $arTemplateParameters["YM_GOALS_EDIT_PAY_SYSTEM"] = [
    "NAME" => GetMessage("YM_GOALS_EDIT_PAY_SYSTEM"),
    "TYPE" => "STRING",
    "DEFAULT" => "BX-paySystem-edit",
    "PARENT" => "ANALYTICS_SETTINGS"
  ];
  $arTemplateParameters["YM_GOALS_EDIT_PROPERTIES"] = [
    "NAME" => GetMessage("YM_GOALS_EDIT_PROPERTIES"),
    "TYPE" => "STRING",
    "DEFAULT" => "BX-properties-edit",
    "PARENT" => "ANALYTICS_SETTINGS"
  ];
  $arTemplateParameters["YM_GOALS_EDIT_BASKET"] = [
    "NAME" => GetMessage("YM_GOALS_EDIT_BASKET"),
    "TYPE" => "STRING",
    "DEFAULT" => "BX-basket-edit",
    "PARENT" => "ANALYTICS_SETTINGS"
  ];
  $arTemplateParameters["YM_GOALS_NEXT_REGION"] = [
    "NAME" => GetMessage("YM_GOALS_NEXT_REGION"),
    "TYPE" => "STRING",
    "DEFAULT" => "BX-region-next",
    "PARENT" => "ANALYTICS_SETTINGS"
  ];
  $arTemplateParameters["YM_GOALS_NEXT_DELIVERY"] = [
    "NAME" => GetMessage("YM_GOALS_NEXT_DELIVERY"),
    "TYPE" => "STRING",
    "DEFAULT" => "BX-delivery-next",
    "PARENT" => "ANALYTICS_SETTINGS"
  ];
  $arTemplateParameters["YM_GOALS_NEXT_PICKUP"] = [
    "NAME" => GetMessage("YM_GOALS_NEXT_PICKUP"),
    "TYPE" => "STRING",
    "DEFAULT" => "BX-pickUp-next",
    "PARENT" => "ANALYTICS_SETTINGS"
  ];
  $arTemplateParameters["YM_GOALS_NEXT_PAY_SYSTEM"] = [
    "NAME" => GetMessage("YM_GOALS_NEXT_PAY_SYSTEM"),
    "TYPE" => "STRING",
    "DEFAULT" => "BX-paySystem-next",
    "PARENT" => "ANALYTICS_SETTINGS"
  ];
  $arTemplateParameters["YM_GOALS_NEXT_PROPERTIES"] = [
    "NAME" => GetMessage("YM_GOALS_NEXT_PROPERTIES"),
    "TYPE" => "STRING",
    "DEFAULT" => "BX-properties-next",
    "PARENT" => "ANALYTICS_SETTINGS"
  ];
  $arTemplateParameters["YM_GOALS_NEXT_BASKET"] = [
    "NAME" => GetMessage("YM_GOALS_NEXT_BASKET"),
    "TYPE" => "STRING",
    "DEFAULT" => "BX-basket-next",
    "PARENT" => "ANALYTICS_SETTINGS"
  ];
  $arTemplateParameters["YM_GOALS_SAVE_ORDER"] = [
    "NAME" => GetMessage("YM_GOALS_SAVE_ORDER"),
    "TYPE" => "STRING",
    "DEFAULT" => "BX-order-save",
    "PARENT" => "ANALYTICS_SETTINGS"
  ];
}

$arTemplateParameters['USE_ENHANCED_ECOMMERCE'] = [
  'PARENT' => 'ANALYTICS_SETTINGS',
  'NAME' => GetMessage('USE_ENHANCED_ECOMMERCE'),
  'TYPE' => 'CHECKBOX',
  'REFRESH' => 'Y',
  'DEFAULT' => 'N'
];

if (isset($arCurrentValues['USE_ENHANCED_ECOMMERCE']) && $arCurrentValues['USE_ENHANCED_ECOMMERCE'] === 'Y') {
  if (Loader::includeModule('catalog')) {
    $arIblockIDs = [];
    $arIblockNames = [];
    $catalogIterator = Catalog\CatalogIblockTable::getList([
      'select' => ['IBLOCK_ID', 'NAME' => 'IBLOCK.NAME'],
      'order' => ['IBLOCK_ID' => 'ASC']
    ]);
    while ($catalog = $catalogIterator->fetch()) {
      $catalog['IBLOCK_ID'] = (int)$catalog['IBLOCK_ID'];
      $arIblockIDs[] = $catalog['IBLOCK_ID'];
      $arIblockNames[$catalog['IBLOCK_ID']] = $catalog['NAME'];
    }
    unset($catalog, $catalogIterator);

    if (!empty($arIblockIDs)) {
      $arProps = [];
      $propertyIterator = Iblock\PropertyTable::getList([
        'select' => ['ID', 'CODE', 'NAME', 'IBLOCK_ID'],
        'filter' => ['@IBLOCK_ID' => $arIblockIDs, '=ACTIVE' => 'Y', '!=XML_ID' => CIBlockPropertyTools::XML_SKU_LINK],
        'order' => ['IBLOCK_ID' => 'ASC', 'SORT' => 'ASC', 'ID' => 'ASC']
      ]);
      while ($property = $propertyIterator->fetch()) {
        $property['ID'] = (int)$property['ID'];
        $property['IBLOCK_ID'] = (int)$property['IBLOCK_ID'];
        $property['CODE'] = (string)$property['CODE'];

        if ($property['CODE'] == '') {
          $property['CODE'] = $property['ID'];
        }

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

          if ($arProps[$property['CODE']]['COUNT'] < 2) {
            $arProps[$property['CODE']]['IBLOCK_TITLE'][$property['IBLOCK_ID']] = $arIblockNames[$property['IBLOCK_ID']];
          }

          $arProps[$property['CODE']]['COUNT']++;
        }
      }
      unset($property, $propertyIterator, $arIblockNames, $arIblockIDs);

      $propList = [];
      foreach ($arProps as $property) {
        $iblockList = '';

        if ($property['COUNT'] > 1) {
          $iblockList = ($property['COUNT'] > 2 ? ' ( ... )' : ' (' . implode(', ', $property['IBLOCK_TITLE']) . ')');
        }

        $propList['PROPERTY_' . $property['CODE']] = $property['TITLE'] . $iblockList;
      }
      unset($property, $arProps);
    }
  }

  $arTemplateParameters['DATA_LAYER_NAME'] = [
    'PARENT' => 'ANALYTICS_SETTINGS',
    'NAME' => GetMessage('DATA_LAYER_NAME'),
    'TYPE' => 'STRING',
    'DEFAULT' => 'dataLayer'
  ];

  if (!empty($propList)) {
    $arTemplateParameters['BRAND_PROPERTY'] = [
      'PARENT' => 'ANALYTICS_SETTINGS',
      'NAME' => GetMessage('BRAND_PROPERTY'),
      'TYPE' => 'LIST',
      'MULTIPLE' => 'N',
      'DEFAULT' => '',
      'VALUES' => ['' => ''] + $propList
    ];
  }
}

if (isset($arCurrentValues['SHOW_MAP_IN_PROPS']) && $arCurrentValues['SHOW_MAP_IN_PROPS'] === 'Y') {
  $arDelivery = [];
  $services = Bitrix\Sale\Delivery\Services\Manager::getActiveList();
  foreach ($services as $service) {
    $arDelivery[$service['ID']] = $service['NAME'];
  }

  $arTemplateParameters["SHOW_MAP_FOR_DELIVERIES"] = [
    "NAME" => GetMessage("SHOW_MAP_FOR_DELIVERIES"),
    "TYPE" => "LIST",
    "MULTIPLE" => "Y",
    "VALUES" => $arDelivery,
    "DEFAULT" => "",
    "COLS" => 25,
    "ADDITIONAL_VALUES" => "N",
    "PARENT" => "VISUAL"
  ];
}

$dbPerson = CSalePersonType::GetList(["SORT" => "ASC", "NAME" => "ASC"], ['ACTIVE' => 'Y']);
while ($arPerson = $dbPerson->GetNext()) {
  $arPers2Prop = [];

  $dbProp = CSaleOrderProps::GetList(
    ["SORT" => "ASC", "NAME" => "ASC"],
    ["PERSON_TYPE_ID" => $arPerson["ID"], 'UTIL' => 'N']
  );
  while ($arProp = $dbProp->Fetch()) {
    if ($arProp["IS_LOCATION"] == 'Y') {
      if (intval($arProp["INPUT_FIELD_LOCATION"]) > 0)
        $altPropId = $arProp["INPUT_FIELD_LOCATION"];

      continue;
    }

    $arPers2Prop[$arProp["ID"]] = $arProp["NAME"];
  }

  if (isset($altPropId))
    unset($arPers2Prop[$altPropId]);

  if (!empty($arPers2Prop)) {
    $arTemplateParameters["PROPS_FADE_LIST_" . $arPerson["ID"]] = [
      "NAME" => GetMessage("PROPS_FADE_LIST") . ' (' . $arPerson["NAME"] . ')' . '[' . $arPerson["LID"] . ']',
      "TYPE" => "LIST",
      "MULTIPLE" => "Y",
      "VALUES" => $arPers2Prop,
      "DEFAULT" => "",
      "COLS" => 25,
      "ADDITIONAL_VALUES" => "N",
      "PARENT" => "VISUAL"
    ];
  }
}
unset($arPerson, $dbPerson);

$arTemplateParameters["USE_CUSTOM_MAIN_MESSAGES"] = [
  "NAME" => GetMessage("USE_CUSTOM_MESSAGES"),
  "TYPE" => "CHECKBOX",
  "REFRESH" => 'Y',
  "DEFAULT" => 'N',
  "PARENT" => "MAIN_MESSAGE_SETTINGS"
];

if (isset($arCurrentValues['USE_CUSTOM_MAIN_MESSAGES']) && $arCurrentValues['USE_CUSTOM_MAIN_MESSAGES'] === 'Y') {
  $arTemplateParameters["MESS_AUTH_BLOCK_NAME"] = [
    "NAME" => GetMessage("AUTH_BLOCK_NAME"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("AUTH_BLOCK_NAME_DEFAULT"),
    "PARENT" => "MAIN_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_REG_BLOCK_NAME"] = [
    "NAME" => GetMessage("REG_BLOCK_NAME"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("REG_BLOCK_NAME_DEFAULT"),
    "PARENT" => "MAIN_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_BASKET_BLOCK_NAME"] = [
    "NAME" => GetMessage("BASKET_BLOCK_NAME"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("BASKET_BLOCK_NAME_DEFAULT"),
    "PARENT" => "MAIN_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_REGION_BLOCK_NAME"] = [
    "NAME" => GetMessage("REGION_BLOCK_NAME"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("REGION_BLOCK_NAME_DEFAULT"),
    "PARENT" => "MAIN_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_PAYMENT_BLOCK_NAME"] = [
    "NAME" => GetMessage("PAYMENT_BLOCK_NAME"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("PAYMENT_BLOCK_NAME_DEFAULT"),
    "PARENT" => "MAIN_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_DELIVERY_BLOCK_NAME"] = [
    "NAME" => GetMessage("DELIVERY_BLOCK_NAME"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("DELIVERY_BLOCK_NAME_DEFAULT"),
    "PARENT" => "MAIN_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_BUYER_BLOCK_NAME"] = [
    "NAME" => GetMessage("BUYER_BLOCK_NAME"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("BUYER_BLOCK_NAME_DEFAULT"),
    "PARENT" => "MAIN_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_BACK"] = [
    "NAME" => GetMessage("BACK"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("BACK_DEFAULT"),
    "PARENT" => "MAIN_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_FURTHER"] = [
    "NAME" => GetMessage("FURTHER"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("FURTHER_DEFAULT"),
    "PARENT" => "MAIN_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_EDIT"] = [
    "NAME" => GetMessage("EDIT"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("EDIT_DEFAULT"),
    "PARENT" => "MAIN_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_ORDER"] = [
    "NAME" => GetMessage("ORDER"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("ORDER_DEFAULT"),
    "PARENT" => "MAIN_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_PRICE"] = [
    "NAME" => GetMessage("PRICE"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("PRICE_DEFAULT"),
    "PARENT" => "MAIN_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_PERIOD"] = [
    "NAME" => GetMessage("PERIOD"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("PERIOD_DEFAULT"),
    "PARENT" => "MAIN_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_NAV_BACK"] = [
    "NAME" => GetMessage("NAV_BACK"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("NAV_BACK_DEFAULT"),
    "PARENT" => "MAIN_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_NAV_FORWARD"] = [
    "NAME" => GetMessage("NAV_FORWARD"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("NAV_FORWARD_DEFAULT"),
    "PARENT" => "MAIN_MESSAGE_SETTINGS"
  ];
}

$arTemplateParameters["USE_CUSTOM_ADDITIONAL_MESSAGES"] = [
  "NAME" => GetMessage("USE_CUSTOM_MESSAGES"),
  "TYPE" => "CHECKBOX",
  "REFRESH" => 'Y',
  "DEFAULT" => 'N',
  "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
];

if (isset($arCurrentValues['USE_CUSTOM_ADDITIONAL_MESSAGES']) && $arCurrentValues['USE_CUSTOM_ADDITIONAL_MESSAGES'] === 'Y') {
  $arTemplateParameters["MESS_PRICE_FREE"] = [
    "NAME" => GetMessage("PRICE_FREE"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("PRICE_FREE_DEFAULT"),
    "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_ECONOMY"] = [
    "NAME" => GetMessage("ECONOMY"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("ECONOMY_DEFAULT"),
    "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_REGISTRATION_REFERENCE"] = [
    "NAME" => GetMessage("REGISTRATION_REFERENCE"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("REGISTRATION_REFERENCE_DEFAULT"),
    "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_AUTH_REFERENCE_1"] = [
    "NAME" => GetMessage("AUTH_REFERENCE_1"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("AUTH_REFERENCE_1_DEFAULT"),
    "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_AUTH_REFERENCE_2"] = [
    "NAME" => GetMessage("AUTH_REFERENCE_2"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("AUTH_REFERENCE_2_DEFAULT"),
    "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_AUTH_REFERENCE_3"] = [
    "NAME" => GetMessage("AUTH_REFERENCE_3"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("AUTH_REFERENCE_3_DEFAULT"),
    "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_ADDITIONAL_PROPS"] = [
    "NAME" => GetMessage("ADDITIONAL_PROPS"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("ADDITIONAL_PROPS_DEFAULT"),
    "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_USE_COUPON"] = [
    "NAME" => GetMessage("USE_COUPON"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("USE_COUPON_DEFAULT"),
    "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_COUPON"] = [
    "NAME" => GetMessage("COUPON"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("COUPON_DEFAULT"),
    "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_PERSON_TYPE"] = [
    "NAME" => GetMessage("PERSON_TYPE"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("PERSON_TYPE_DEFAULT"),
    "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_SELECT_PROFILE"] = [
    "NAME" => GetMessage("SELECT_PROFILE"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("SELECT_PROFILE_DEFAULT"),
    "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_REGION_REFERENCE"] = [
    "NAME" => GetMessage("REGION_REFERENCE"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("REGION_REFERENCE_DEFAULT"),
    "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_PICKUP_LIST"] = [
    "NAME" => GetMessage("PICKUP_LIST"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("PICKUP_LIST_DEFAULT"),
    "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_NEAREST_PICKUP_LIST"] = [
    "NAME" => GetMessage("NEAREST_PICKUP_LIST"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("NEAREST_PICKUP_LIST_DEFAULT"),
    "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_SELECT_PICKUP"] = [
    "NAME" => GetMessage("SELECT_PICKUP"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("SELECT_PICKUP_DEFAULT"),
    "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_INNER_PS_BALANCE"] = [
    "NAME" => GetMessage("INNER_PS_BALANCE"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("INNER_PS_BALANCE_DEFAULT"),
    "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_INNER_PS_BALANCE"] = [
    "NAME" => GetMessage("INNER_PS_BALANCE"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("INNER_PS_BALANCE_DEFAULT"),
    "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_ORDER_DESC"] = [
    "NAME" => GetMessage("ORDER_DESC"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("ORDER_DESC_DEFAULT"),
    "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
  ];
}

$arTemplateParameters["USE_CUSTOM_ERROR_MESSAGES"] = [
  "NAME" => GetMessage("USE_CUSTOM_MESSAGES"),
  "TYPE" => "CHECKBOX",
  "REFRESH" => 'Y',
  "DEFAULT" => 'N',
  "PARENT" => "ERROR_MESSAGE_SETTINGS"
];

if (isset($arCurrentValues['USE_CUSTOM_ERROR_MESSAGES']) && $arCurrentValues['USE_CUSTOM_ERROR_MESSAGES'] === 'Y') {
  $arTemplateParameters["MESS_SUCCESS_PRELOAD_TEXT"] = [
    "NAME" => GetMessage("SUCCESS_PRELOAD_TEXT"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("SUCCESS_PRELOAD_TEXT_DEFAULT"),
    "PARENT" => "ERROR_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_FAIL_PRELOAD_TEXT"] = [
    "NAME" => GetMessage("FAIL_PRELOAD_TEXT"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("FAIL_PRELOAD_TEXT_DEFAULT"),
    "PARENT" => "ERROR_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_DELIVERY_CALC_ERROR_TITLE"] = [
    "NAME" => GetMessage("DELIVERY_CALC_ERROR_TITLE"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("DELIVERY_CALC_ERROR_TITLE_DEFAULT"),
    "PARENT" => "ERROR_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_DELIVERY_CALC_ERROR_TEXT"] = [
    "NAME" => GetMessage("DELIVERY_CALC_ERROR_TEXT"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("DELIVERY_CALC_ERROR_TEXT_DEFAULT"),
    "PARENT" => "ERROR_MESSAGE_SETTINGS"
  ];
  $arTemplateParameters["MESS_PAY_SYSTEM_PAYABLE_ERROR"] = [
    "NAME" => GetMessage("PAY_SYSTEM_PAYABLE_ERROR_TEXT"),
    "TYPE" => "STRING",
    "DEFAULT" => GetMessage("PAY_SYSTEM_PAYABLE_ERROR_DEFAULT"),
    "PARENT" => "ERROR_MESSAGE_SETTINGS"
  ];
}
