<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

// Подключаем необходимые модули
if (!CModule::IncludeModule('iblock') || !CModule::IncludeModule('catalog') || !CModule::IncludeModule('sale')) {
    echo json_encode(['success' => false, 'error' => 'Required modules not loaded']);
    exit;
}

try {
    // Получаем корзину пользователя
    $basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), SITE_ID);
    $basketItems = $basket->getBasketItems();

    // Подсчитываем итоги
    $totalPrice = 0;
    $totalDiscount = 0;
    $totalQuantity = 0;

        // Формируем HTML для списка товаров
    $cartItemsHtml = '';
    
    if (empty($basketItems)) {
      // Если корзина пуста, показываем сообщение
      $cartItemsHtml = '<li class="cart-empty-message">Корзина пуста</li>';
      $totalQuantity = 0;
    } else {
      foreach ($basketItems as $item) {
        $productId = $item->getProductId();
        $quantity = $item->getQuantity();
        $price = $item->getFinalPrice();
        $discountPrice = $item->getDiscountPrice();
        
        $totalPrice += $price;
        $totalDiscount += $discountPrice;
        $totalQuantity += $quantity;

        // Получаем информацию о товаре
        $rsElement = \CIBlockElement::GetList([], ['ACTIVE' => 'Y', '=ID' => $productId], false, [], ['ID', 'NAME', 'DETAIL_PICTURE', 'PREVIEW_PICTURE']);
        $arElement = $rsElement->GetNext();
        
        // Получаем родительский товар (если это SKU)
        $parent_product = CCatalogSku::GetProductInfo($arElement['ID']);
        if ($parent_product) {
          $rsParentProduct = \CIBlockElement::GetList([], ['ACTIVE' => 'Y', '=ID' => $parent_product['ID']], false, [], ['ID', 'NAME', 'DETAIL_PICTURE', 'PREVIEW_PICTURE']);
          $arParentProduct = $rsParentProduct->GetNext();
          $image = $arParentProduct['DETAIL_PICTURE'] ?: $arParentProduct['PREVIEW_PICTURE'];
          $productName = $arParentProduct['NAME'];
        } else {
          $image = $arElement['DETAIL_PICTURE'] ?: $arElement['PREVIEW_PICTURE'];
          $productName = $arElement['NAME'];
        }
        
        if ($image) {
          $imageUrl = CFile::GetPath($image);
        } else {
          $imageUrl = '/assets/img/no-photo.jpg';
        }

        $cartItemsHtml .= '<li>
            <picture>
                <img src="' . $imageUrl . '" alt="' . htmlspecialchars($productName) . '">
            </picture>
        </li>';
      }
    }

    // Формируем итоговую информацию
    $totalInfo = [
        'totalQuantity' => $totalQuantity,
        'totalQuantityText' => $totalQuantity . ' ' . pluralForm($totalQuantity, ["товар", "товара", "товаров"]),
        'priceWithoutDiscount' => $totalQuantity > 0 ? number_format($totalPrice + $totalDiscount, 0, '.', ' ') : '0',
        'discount' => $totalQuantity > 0 ? number_format($totalDiscount, 0, '.', ' ') : '0',
        'finalPrice' => $totalQuantity > 0 ? number_format($totalPrice + 500, 0, '.', ' ') : '500', // +500 за доставку
        'cashback' => $totalQuantity > 0 ? number_format(($totalPrice + 500) * 0.07, 0, '.', ' ') : '35' // 7% кэшбэк
    ];

    echo json_encode([
        'success' => true,
        'cartItems' => $cartItemsHtml,
        'totalInfo' => $totalInfo
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'error' => $e->getMessage()
    ]);
}
?>
