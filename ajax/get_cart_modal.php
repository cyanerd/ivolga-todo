<?php
include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
include($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/log_helper.php");

CModule::IncludeModule("catalog");
CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");

use Bitrix\Sale;
global $USER;

$request = \Bitrix\Main\Context::getCurrent()->getRequest();

$basket = MyTools::getBasket();
$amount = 0;

// Добавляем отладочную информацию
projectDebugLog('Cart debug: Basket items count: ' . count($basket['BASKET_ITEMS']), 'cart_modal');

foreach ($basket['BASKET_ITEMS'] as $arItem) {
  $amount_el = $arItem->getQuantity();
  $amount += $amount_el;
  projectDebugLog('Cart debug: Item ID: ' . $arItem->getProductId() . ', Quantity: ' . $amount_el, 'cart_modal');
}

$price = $basket['BASKET']->getPrice();
projectDebugLog('Cart debug: Total amount: ' . $amount . ', Total price: ' . $price, 'cart_modal');

// Формируем HTML для модального окна корзины
ob_start();

if ($amount == 0): ?>
  <div class="cart-empty">
    <p>Корзина пуста</p>
    <p>Добавьте товары для оформления заказа</p>
  </div>
<? else: ?>
  <div class="cart-items">
    <? foreach ($basket['BASKET_ITEMS'] as $arItem): 
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
      <div class="modalcart-item" data-cart-id="<?= $cart_id ?>">
        <div class="modalcart-item__group">
          <a href="<?= $DETAIL_PAGE_URL ?>" class="modalcart-item__img">
            <img src="<?= $img_src ?>" alt="<?= $arElement['NAME'] ?>">
          </a>
          <div class="modalcart-item__content">
            <a href="<?= $DETAIL_PAGE_URL ?>" class="modalcart-item__title">
              <?= $arElement['NAME'] ?>
            </a>
            <p class="modalcart-item__meta">
              <? if ($color): ?>
                Цвет: <?= $color ?><br>
              <? endif; ?>
              Размер: М
            </p>
            <div class="counter js--count">
              <button class="counter__prev">
                <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M2 9.25V7.75H14V9.25H2Z" fill="#232229"/>
                </svg>
              </button>
              <input type="number" value="<?= $qty ?>" class="counter__number" readonly>
              <button class="counter__next">
                <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M8.75 7.75V4.5H7.25V7.75H2V9.25H7.25V12.5H8.75V9.25H14V7.75H8.75Z" fill="#232229"/>
                </svg>
              </button>
            </div>
          </div>
        </div>

        <div class="modalcart-item__price">
          <p class="modalcart-item__price-current">
            <?= number_format($arElement['CATALOG_PRICE_7'], 0, '', ' ') ?>₽
          </p>
        </div>
        <button class="modalcart-item__cart">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.75 4.5H20.25V6H3.75V4.5Z" fill="#4A4855"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.75 3H8.25V1.5H15.75V3Z" fill="#4A4855"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M6 5.25V19.5H18V5.25H19.5V21H4.5V5.25H6Z" fill="#4A4855"/>
          </svg>
        </button>
      </div>
    <? endforeach; ?>
  </div>
  
  <div class="modalcart__footer">
    <p class="modalcart__price">
      ИТОГО: <?= number_format($price, 0, '', ' ') ?>₽
    </p>
    <button class="modalcart__order">
      Оформить заказ
    </button>
  </div>
<? endif;

$content = ob_get_contents();
ob_end_clean();

echo \Bitrix\Main\Web\Json::encode([
  'success' => true,
  'html' => $content,
  'count' => $amount,
  'total' => $price
]);
?> 