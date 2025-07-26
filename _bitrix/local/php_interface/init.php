<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
CModule::IncludeModule("catalog");
CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");

require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/hb.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/axi.php';

define('LOG_FILENAME', $_SERVER['DOCUMENT_ROOT'] . '/log.txt');
const TP = '/local/templates/main/';

if (defined('ADMIN_SECTION')) {
  $APPLICATION->SetAdditionalCSS(TP . 'css/admin.css');
}

function d($s)
{
  echo '<pre>';
  var_dump($s);
  echo '</pre>';
}

function breadcrumbs($items)
{
  $out = [];
  $out[] = '';
  return implode($out);
}

function getIbItems($code, $filters = [], $options = ['ID_AS_KEY' => false])
{
  CModule::IncludeModule('iblock');

  $arFilter = array_merge([
    'IBLOCK_ID' => getIBlockIdByCode($code),
    'ACTIVE' => 'Y'
  ], $filters);

  $arSelect = [
    'ID',
    'NAME',
    'CODE',
    'PREVIEW_PICTURE',
    'PREVIEW_TEXT',
    'DETAIL_PICTURE',
    'DETAIL_TEXT',
    'DATE_CREATE',
    'PROPERTY_*'
  ];

  $elements = CIBlockElement::GetList(
    ['SORT' => 'ASC'],
    $arFilter,
    false,
    false,
    $arSelect
  );

  $items = [];
  while ($element = $elements->GetNextElement()) {
    $fields = $element->GetFields();
    $properties = $element->GetProperties();
    $fields['PROPS'] = $properties;

    if ($options['ID_AS_KEY']) $items[$fields['ID']] = $fields;
    else $items[] = $fields;
  }
  return $items;
}

function getSectionsWithItems($iblockCode)
{
  CModule::IncludeModule('iblock');

  $iblockId = getIBlockIdByCode($iblockCode);

  $sectionFilter = [
    'IBLOCK_ID' => $iblockId,
    'ACTIVE' => 'Y',
  ];

  $sectionSelect = [
    'ID',
    'NAME',
    'CODE',
    'SECTION_PAGE_URL',
  ];

  $sections = [];
  $dbSections = CIBlockSection::GetList(
    ['SORT' => 'ASC'],
    $sectionFilter,
    false,
    $sectionSelect
  );

  while ($section = $dbSections->GetNext()) {
    $sections[$section['ID']] = [
      'ID' => $section['ID'],
      'NAME' => $section['NAME'],
      'CODE' => $section['CODE'],
      'URL' => $section['SECTION_PAGE_URL'],
      'ITEMS' => [],
    ];
  }

  // Получаем элементы
  $elementFilter = [
    'IBLOCK_ID' => $iblockId,
    'ACTIVE' => 'Y',
  ];

  $elementSelect = [
    'ID',
    'NAME',
    'CODE',
    'PREVIEW_PICTURE',
    'PREVIEW_TEXT',
    'IBLOCK_SECTION_ID',
    'DATE_CREATE',
    'PROPERTY_*',
  ];

  $dbElements = CIBlockElement::GetList(
    ['SORT' => 'ASC'],
    $elementFilter,
    false,
    false,
    $elementSelect
  );

  while ($element = $dbElements->GetNextElement()) {
    $fields = $element->GetFields();
    $properties = $element->GetProperties();
    $fields['PROPS'] = $properties;

    if (!empty($fields['IBLOCK_SECTION_ID']) && isset($sections[$fields['IBLOCK_SECTION_ID']])) {
      $sections[$fields['IBLOCK_SECTION_ID']]['ITEMS'][] = $fields;
    }
  }

  return $sections;
}

function getCatalogItem($id)
{
  return getIbItems('catalog', ['ID' => $id])[0];
}


function getCatalogItems()
{
  return getIbItems('catalog');
}

function formatFilterItem($v, $key)
{
  if ($key === 'PRICE') {
    $v = $v / 1e6;
    if (fmod($v, 1) === 0.0) {
      $v = (int)$v;
    }
  }
  return is_int($v) ? $v . '' : sprintf('%.1f', $v);
}

function formatNumberWithSpaces($number)
{
  return number_format($number, 0, '.', ' ');
}

function pluralForm($number, $forms)
{
  $cases = [2, 0, 1, 1, 1, 2];
  return $forms[($number % 100 > 4 && $number % 100 < 20)
    ? 2
    : $cases[min($number % 10, 5)]];
}

function getIBlockIdByCode($iBlockCode)
{
  return (int)CIBlock::GetList([], ['CODE' => $iBlockCode])->Fetch()['ID'];
}

function clearPhoneString($phone): string
{
  return preg_replace('/[^0-9+]/', '', $phone);
}

function substrCountArray($haystack, $needle)
{
  $count = 0;
  foreach ($needle as $substring) {
    $count += substr_count($haystack, $substring);
  }
  return $count;
}

// =====================================================================================================================
// =====================================================================================================================
// =====================================================================================================================

use Bitrix\Sale;
use Bitrix\Highloadblock as HL;

\Bitrix\Main\Loader::includeModule('highloadblock');

function getDeliveryTypes()
{
  $arActiveDelivery = \Bitrix\Sale\Delivery\Services\Manager::getActiveList();
  $delivery_types = [];
  foreach ($arActiveDelivery as $delivery_type) {
    if ($delivery_type['CLASS_NAME'] != '\Bitrix\Sale\Delivery\Services\EmptyDeliveryService') {
      $delivery_types[] = [
        'ID' => $delivery_type['ID'],
        'NAME' => $delivery_type['NAME'],
        'PRICE' => $delivery_type['CONFIG']['MAIN']['PRICE'],
        'DESCRIPTION' => $delivery_type['DESCRIPTION'],
      ];
    }
  }
  return $delivery_types;
}

function getPayments()
{
  $db_ptype = CSalePaySystem::GetList($arOrder = ["SORT" => "ASC", "PSA_NAME" => "ASC"], ["LID" => SITE_ID, "CURRENCY" => "RUB", "ACTIVE" => "Y"]);
  while ($ptype = $db_ptype->Fetch()):
    if (!in_array($ptype['NAME'], ['Внутренний счет', 'Банковский перевод (Компании)', 'Банковский перевод (Контакты)', 'Предложение (Компании)', 'Предложение (Контакты)',]))
      $arPayments[$ptype['ID']] = $ptype;
  endwhile;
  return $arPayments;
}

function send_sms($host, $port, $login, $password, $phone, $text, $sender = false, $wapurl = false)
{
  $fp = fsockopen($host, $port, $errno, $errstr);
  if (!$fp) {
    return "errno: $errno \nerrstr: $errstr\n";
  }
  fwrite($fp, "GET /messages/v2/send/" .
    "?phone=" . rawurlencode($phone) .
    "&text=" . rawurlencode($text) .
    ($sender ? "&sender=" . rawurlencode($sender) : "") .
    ($wapurl ? "&wapurl=" . rawurlencode($wapurl) : "") .
    "  HTTP/1.0\n");
  fwrite($fp, "Host: " . $host . "\r\n");
  if ($login != "") {
    fwrite($fp, "Authorization: Basic " .
      base64_encode($login . ":" . $password) . "\n");
  }
  fwrite($fp, "\n");
  $response = "";
  while (!feof($fp)) {
    $response .= fread($fp, 1);
  }
  fclose($fp);
  [$other, $responseBody] = explode("\r\n\r\n", $response, 2);
  return $responseBody;
}

class MyTools
{
  static $arColors = [];

  static public function getVariantColors($art)
  {
    //ищем по части артикуля другие товары (цвета)
    $art_parts = explode('/', $art); //FWBS020005/98
    $filter = [
      'IBLOCK_ID' => 29,
      '%PROPERTY_CML2_ARTICLE' => $art_parts[0],
      'ACTIVE' => 'Y'
    ];
    $sort = [
      'DATE_ACTIVE_FROM' => 'DESC',
      'SORT' => 'DESC',
    ];
    $select = [
      'ID',
      'NAME',
      'IBLOCK_ID',
      'PROPERTY_TSVET',
      'DETAIL_PAGE_URL',
    ];
    $rsElement = \CIBlockElement::GetList($sort, $filter, false, [], $select);
    while ($arElement = $rsElement->GetNext()) {
      $arItems[$arElement['PROPERTY_TSVET_VALUE']] = $arElement['DETAIL_PAGE_URL'];
    }
    //$colors = array_unique($colors);
    return $arItems;
  }

  static public function getAddresses($user_id)
  {
    $filter = [
      'IBLOCK_ID' => 23,
      '=PROPERTY_USER_ID' => $user_id,
      'ACTIVE' => 'Y'
    ];
    $sort = [
      'DATE_ACTIVE_FROM' => 'DESC',
      'SORT' => 'DESC',
    ];
    $select = [
      'ID',
      'NAME',
      'IBLOCK_ID',
      'PROPERTY_USER_ID',
      'PROPERTY_CITY',
      'PROPERTY_ADDRESS',
      'PROPERTY_COMMENT',
      'PROPERTY_ENTRANCE',
      'PROPERTY_HOUSE',
      'PROPERTY_APARTMENT',
      'PROPERTY_FLOOR',
    ];
    $rsElement = \CIBlockElement::GetList($sort, $filter, false, [], $select);
    while ($arElement = $rsElement->GetNext()) {
      $items[] = [
        'ID' => $arElement['ID'],
        'NAME' => $arElement['NAME'],
        'USER_ID' => $arElement['PROPERTY_USER_ID_VALUE'],
        'CITY' => $arElement['PROPERTY_CITY_VALUE'],
        'ADDRESS' => $arElement['PROPERTY_ADDRESS_VALUE'],
        'COMMENT' => $arElement['PROPERTY_COMMENT_VALUE'],
        'ENTRANCE' => $arElement['PROPERTY_ENTRANCE_VALUE'],
        'APARTMENT' => $arElement['PROPERTY_APARTMENT_VALUE'],
        'FLOOR' => $arElement['PROPERTY_FLOOR_VALUE'],
        'HOUSE' => $arElement['PROPERTY_HOUSE_VALUE'],
      ];
    }
    return $items;
  }

  static public function getAddress($id)
  {
    $resElement = \CIBlockElement::GetList([], ['=ID' => $id], false, false, ['ID', 'IBLOCK_ID', 'NAME',])->GetNextElement();
    if ($resElement) {
      $addr = $resElement->getFields();
      $addr['PROPERTIES'] = $resElement->getProperties();
    }
    return $addr;
  }

  static public function getUserByFilter(array $arFilter, bool $only_published = false)
  {
    if ($only_published) $arFilter['ACTIVE'] = 'Y';
    $by = "ID";
    $order = "DESC";
    $rsUsers = CUser::GetList(($by), ($order), $arFilter, ["SELECT" => ["UF_*"]]);
    if (!$rsUsers->SelectedRowsCount()) return false;
    $arUser = $rsUsers->Fetch();
    return $arUser;
  }

  static public function RegisterUser(array $arInputFields)
  {
    $user = new CUser;
    $GeneratedPASS = '123456';
    $arFields = [
      "PERSONAL_PHONE" => $arInputFields['PERSONAL_PHONE'],
      "LOGIN" => 'user_' . md5(time())/*NormalizePhone($arInputFields['PERSONAL_PHONE'])*/,
      "ACTIVE" => $arInputFields['ACTIVE'] ? $arInputFields['ACTIVE'] : "N",
      "GROUP_ID" => $arInputFields['GROUP_ID'],
      "PASSWORD" => $GeneratedPASS,
      "CONFIRM_PASSWORD" => $GeneratedPASS,
    ];
    $User_ID = $user->Add($arFields);
    if (intval($User_ID) > 0)
      return $User_ID;
    else
      return ['ERROR' => $user->LAST_ERROR];
  }

  /**
   * Добавляем свойство к заказу
   */
  static public function addPropetyToOrder($ORDER_ID, $ORDER_PROPS_ID, $NAME, $VALUE)
  {
    $rsVals = CSaleOrderPropsValue::GetList(["SORT" => "ASC"], ["ORDER_ID" => $ORDER_ID, "ORDER_PROPS_ID" => $ORDER_PROPS_ID]);
    if ($arVals = $rsVals->Fetch()) {
      CSaleOrderPropsValue::Update($arVals['ID'], ["VALUE" => $VALUE]);
    } else {
      $arFields = [
        "ORDER_ID" => $ORDER_ID,
        "ORDER_PROPS_ID" => $ORDER_PROPS_ID,
        "NAME" => $NAME,
        "VALUE" => $VALUE];
      CSaleOrderPropsValue::Add($arFields);
    }
  }

  static public function addOrder($arOrderPayload)
  {
    global $USER;
    if ($USER->IsAuthorized()) {
      $user_id = IntVal($USER->GetID());
    } else {
      $user_id = self::RegisterUser([
        'ACTIVE' => 'Y',
        'GROUP_ID' => 16,
      ]);
    }

    $arFields = [
      "LID" => SITE_ID,
      "PERSON_TYPE_ID" => 3,
      "PAYED" => "N",
      "CANCELED" => "N",
      "STATUS_ID" => "N",
      "USER_ID" => $user_id,
      "PRICE" => $arOrderPayload['PRICE'],
      "CURRENCY" => "RUB",
      "PAY_SYSTEM_ID" => $arOrderPayload['PAY_SYSTEM_ID'],
      "PRICE_DELIVERY" => $arOrderPayload['PRICE_DELIVERY'],
      "DELIVERY_ID" => $arOrderPayload['DELIVERY_ID'],
    ];

    $ORDER_ID = CSaleOrder::Add($arFields);
    $ORDER_ID = IntVal($ORDER_ID);

    self::addPropetyToOrder($ORDER_ID, 20, "Ф.И.О.", $arOrderPayload['USER_DATA']['firstName']);
    self::addPropetyToOrder($ORDER_ID, 21, "E-Mail", $arOrderPayload['USER_DATA']['email']);
    self::addPropetyToOrder($ORDER_ID, 22, "Телефон", NormalizePhone($arOrderPayload['USER_DATA']['phone']));

    CSaleBasket::OrderBasket($ORDER_ID, $_SESSION["SALE_USER_ID"], SITE_ID);

    return $ORDER_ID;
  }

  static public function isFavourite($item_id)
  {
    $session_id = session_id();
    // есть ли уже этот товар
    $arFilter = ['IBLOCK_ID' => 24, 'ACTIVE' => 'Y', '=PROPERTY_SESSION_ID' => $session_id, '=PROPERTY_ITEM_ID' => $item_id];
    $db_list = CIBlockElement::GetList([], $arFilter, false, [], ['ID', 'IBLOCK_ID']);
    $arItem = $db_list->GetNext();
    return (bool)$arItem['ID'];
  }

  static public function getColor($color)
  {
    if (empty(self::$arColors)) {
      $hlblockId = 2;
      $hlblock = HL\HighloadBlockTable::getById($hlblockId)->fetch();
      $entity = HL\HighloadBlockTable::compileEntity($hlblock);
      $entity_data_class = $entity->getDataClass();

      $rsData = $entity_data_class::getList([
        'select' => ['UF_NAME', 'UF_COLOR_FILE'],
        'order' => ['ID' => 'ASC'],
      ]);
      while ($arData = $rsData->Fetch()) {
        self::$arColors[$arData['UF_NAME']] = CFile::GetPath($arData['UF_COLOR_FILE']);
      }
    }
    $color = mb_strtolower($color);
    if (isset(self::$arColors[$color])) {
      return self::$arColors[$color];
    }
    return 'none';
  }

  static public function getAllColors()
  {
    if (empty(self::$arColors)) {
      $hlblockId = 2;
      $hlblock = HL\HighloadBlockTable::getById($hlblockId)->fetch();
      $entity = HL\HighloadBlockTable::compileEntity($hlblock);
      $entity_data_class = $entity->getDataClass();

      $rsData = $entity_data_class::getList([
        'select' => ['UF_NAME', 'UF_COLOR_FILE'],
        'order' => ['ID' => 'ASC'],
      ]);
      while ($arData = $rsData->Fetch()) {
        self::$arColors[$arData['UF_NAME']] = CFile::GetPath($arData['UF_COLOR_FILE']);
      }
    }
    return array_keys(self::$arColors);
  }

  static public function getBasket()
  {
    $basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
    $basketItems = $basket->getBasketItems();

    return [
      'BASKET' => $basket,
      'BASKET_ITEMS' => $basketItems,
    ];
  }

  static public function getDeliveryTypes()
  {
    $arActiveDelivery = \Bitrix\Sale\Delivery\Services\Manager::getActiveList();
    $delivery_types = [];
    foreach ($arActiveDelivery as $delivery_type) {
      if ($delivery_type['CLASS_NAME'] != '\Bitrix\Sale\Delivery\Services\EmptyDeliveryService') {
        $delivery_types[] = [
          'ID' => $delivery_type['ID'],
          'NAME' => $delivery_type['NAME'],
          'PRICE' => $delivery_type['CONFIG']['MAIN']['PRICE'],
        ];
      }
    }
    return $delivery_types;
  }

  static public function getBasketBodyModal($basket, $format, $delivery_id = 0)
  {
    $amount = 0;
    foreach ($basket['BASKET_ITEMS'] as $arItem) {
      $amount_el = $arItem->getQuantity();
      $amount += $amount_el;
    }

    $delivery_summ = 0;
    if ($delivery_id > 0) {
      $delivery_types = getDeliveryTypes();
      foreach ($delivery_types as $delivery_type) {
        if ($delivery_type['ID'] == $delivery_id) {
          $delivery_summ = $delivery_type['PRICE'];
          break;
        }
      }
    }

    $amount_text = $amount . ' ' . spellcount_text($amount, 'товар', 'товара', 'товаров');
    $price = $basket['BASKET']->getPrice();

    //собираем товары
    ob_start();
    foreach ($basket['BASKET_ITEMS'] as $arItem):
      $product_id = $arItem->getProductId();
      $qty = $arItem->getQuantity();
      $cart_id = $arItem->getId();

      $rsElement = \CIBlockElement::GetList([], ['ACTIVE' => 'Y', '=ID' => $product_id], false, [], ['ID', 'NAME', 'CATALOG_PRICE_7',]);
      $arElement = $rsElement->GetNext();
      $parent_product = CCatalogSku::GetProductInfo($arElement['ID']);
      $rsParentProduct = \CIBlockElement::GetList([], ['ACTIVE' => 'Y', '=ID' => $parent_product['ID']], false, [], ['ID', 'NAME', 'DETAIL_PICTURE', 'DETAIL_PAGE_URL', 'PROPERTY_TSVET']);
      $arParentProduct = $rsParentProduct->GetNext();

      $DETAIL_PAGE_URL = $arParentProduct['DETAIL_PAGE_URL'];
      $img_src = isset($arParentProduct['~DETAIL_PICTURE']) ?
        \CFile::ResizeImageGet(
          $arParentProduct['~DETAIL_PICTURE'],
          ["width" => 326, "height" => 517],
          BX_RESIZE_IMAGE_EXACT
        )['src']
        : '/assets/img/no-photo.jpg';

      $color = $arParentProduct['PROPERTY_TSVET_VALUE'];
      $color_code = MyTools::getColor($color);
      ?>
      <li class="products-card--medium" id="basket_<?= $cart_id ?>">
        <a class="products-card__link" href="<?= $DETAIL_PAGE_URL ?>">
          <img src="<?= $img_src ?>" alt="product">
          <div class="products-card-title--medium">
            <p class="products-card-title__product"><?= $arElement['NAME'] ?></p>
            <p class="products-card-title__price"><?= number_format($arElement['CATALOG_PRICE_7'], 0, '', ' ') ?>&nbsp;₽</p>
          </div>
        </a>
        <div class="products-card__colors">
          <div class="products-card-color-small">
            <div style="background-image: url(<?= $color_code ?>)"></div>
          </div>
        </div>
        <div class='products-card__bottom-row'>
          <div class='products-card__counter'>
            <button class='products-card__counter-button products-card__counter-minus' onclick="minus_cart(<?= $cart_id ?>)">
              <svg width='9' height='1' viewBox='0 0 9 1' fill='none'
                   xmlns='http://www.w3.org/2000/svg'>
                <path d='M0.847656 0.0166016H8.87891V1.00879H0.847656V0.0166016Z'
                      fill='#8C8C8C'/>
              </svg>
            </button>
            <input type='number' class='products-card__counter-input' readonly
                   min="1"
                   value='<?= $qty ?>' id="basket-element-<?= $cart_id ?>"/>
            <button class='products-card__counter-button products-card__counter-plus' onclick="plus_cart(<?= $cart_id ?>)">
              <svg width='11' height='11' viewBox='0 0 11 11' fill='none'
                   xmlns='http://www.w3.org/2000/svg'>
                <path
                  d='M0.847656 5.0166H5.18359V0.680664H6.17578V5.0166H10.5117V6.00879H6.17578V10.3447H5.18359V6.00879H0.847656V5.0166Z'
                  fill='#8C8C8C'/>
              </svg>
            </button>
          </div>
          <button class='products-card__delete' onclick="del_cart(<?= $cart_id ?>)">Удалить</button>
        </div>
      </li>
    <?endforeach;
    $content_items = ob_get_contents();
    ob_end_clean();
    ob_start();
    if ($format == 'modal'):?>
      <div class="modal-right-heading">
        <p>Корзина</p>
        <button class="close-button" onclick="closecart()"><img src="/assets/img/icons/close.svg" alt="close">
        </button>
      </div>
      <? if ($amount == 0): ?>
        <div class="basket-modal-order">
          <h1 class="basket-modal-order__title">Ваш заказ</h1>

          <p class="basket-modal-order__description">Корзина пуста</p>
        </div>
      <? else: ?>
        <div class="basket-modal-order">
          <h1 class="basket-modal-order__title">Ваш заказ</h1>
          <ul class="basket-modal-order__list">
            <li class="basket-modal-order__item">
              <p><?= $amount_text ?></p>
              <p><?= number_format($price, 0, '', ' ') ?>&nbsp;₽</p>
            </li>
            <li class="basket-modal-order__item">
              <p>Итого</p>
              <p><?= number_format($price, 0, '', ' ') ?>&nbsp;₽</p>
            </li>
          </ul>
          <p class="basket-modal-order__description">Стоимость доставки будет рассчитана при
            оформлении заказа</p>
        </div>
        <a class="primary-button" href="/checkout/">Оформить заказ</a>
        <div class="container">
          <div class="products-card-head--centered container" style="display: none;">
            <h2 class="title" style="display: none;"></h2>
          </div>
          <div style="opacity: 1; transform: none;">
            <div class="products-card-container__content">
              <ul class="products-card-list products-card-list--2">
                <?= $content_items ?>
              </ul>
            </div>
          </div>
        </div>
      <? endif ?>
    <?endif;
    if ($format == 'checkout'):?>
      <div class="order-info">
        <h1 class="title-1 order-info__title">Ваш заказ</h1>
        <ul class="order-info__list">
          <li class="basket-modal-order__item">
            <p><?= $amount_text ?></p>
            <p><?= number_format($price, 0, '', ' ') ?>&nbsp;₽</p>
          </li>
          <? if ($delivery_id > 0): ?>
            <li class="order-info__item">
              <p>Доставка</p>
              <p><?= $delivery_summ == 0 ? 'бесплатно' : $delivery_summ . '&nbsp;₽' ?></p>
            </li>
          <? endif; ?>
          <li class="basket-modal-order__item">
            <p>Итого</p>
            <p><?= number_format($price + $delivery_summ, 0, '', ' ') ?>&nbsp;₽</p>
          </li>
        </ul>
      </div>
      <div class="orders">
      <div class="container">
        <div class="products-card-head--centered container" style="display: none;">
          <h2 class="title" style="display: none;"></h2>
        </div>
        <div style="opacity: 1; transform: none;">
          <div class="products-card-container__content">
            <ul class="products-card-list products-card-list--2">
              <?= $content_items ?>
            </ul>
          </div>
        </div>
      </div>
      </div><?
    endif;
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
  }
}

function spellcount_text($num, $one, $two, $many)
{
  if ($num % 10 == 1 && $num % 100 != 11) {
    return $one;
  } elseif ($num % 10 >= 2 && $num % 10 <= 4 && ($num % 100 < 10 || $num % 100 >= 20)) {
    return $two;
  } else {
    return $many;
  }
}
