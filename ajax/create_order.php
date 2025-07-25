<?php
include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
include($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/log_helper.php");

CModule::IncludeModule("catalog");
CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");

use Bitrix\Sale;
global $USER;

$request = \Bitrix\Main\Context::getCurrent()->getRequest();

// Получаем данные из запроса
$firstName = $request->getPost('firstName');
$lastName = $request->getPost('lastName');
$email = $request->getPost('email');
$phone = $request->getPost('phone');
$address = $request->getPost('address');
$comment = $request->getPost('comment');
$deliveryType = $request->getPost('deliveryType');
$paymentType = $request->getPost('paymentType');
$agreement = $request->getPost('agreement');

// Проверяем обязательные поля
if (!$firstName || !$lastName || !$email || !$phone || !$address || !$deliveryType || !$paymentType || !$agreement) {
    echo \Bitrix\Main\Web\Json::encode([
        'success' => false,
        'message' => 'Пожалуйста, заполните все обязательные поля'
    ]);
    return;
}

try {
    // Получаем корзину
    $basket = MyTools::getBasket();
    
    if (empty($basket['BASKET_ITEMS'])) {
        echo \Bitrix\Main\Web\Json::encode([
            'success' => false,
            'message' => 'Корзина пуста'
        ]);
        return;
    }

    // Создаем заказ
    $order = Sale\Order::create(SITE_ID);
    
    // Добавляем товары в заказ
    foreach ($basket['BASKET_ITEMS'] as $basketItem) {
        $order->getBasket()->addItem($basketItem);
    }

    // Устанавливаем свойства заказа
    $propertyCollection = $order->getPropertyCollection();
    
    // Имя
    $nameProperty = $propertyCollection->getItemByOrderPropertyCode('FIO');
    if ($nameProperty) {
        $nameProperty->setValue($firstName . ' ' . $lastName);
    }
    
    // Email
    $emailProperty = $propertyCollection->getItemByOrderPropertyCode('EMAIL');
    if ($emailProperty) {
        $emailProperty->setValue($email);
    }
    
    // Телефон
    $phoneProperty = $propertyCollection->getItemByOrderPropertyCode('PHONE');
    if ($phoneProperty) {
        $phoneProperty->setValue($phone);
    }
    
    // Адрес
    $addressProperty = $propertyCollection->getItemByOrderPropertyCode('ADDRESS');
    if ($addressProperty) {
        $addressProperty->setValue($address);
    }
    
    // Комментарий
    if ($comment) {
        $commentProperty = $propertyCollection->getItemByOrderPropertyCode('COMMENT');
        if ($commentProperty) {
            $commentProperty->setValue($comment);
        }
    }

    // Устанавливаем способ доставки
    $shipmentCollection = $order->getShipmentCollection();
    $shipment = $shipmentCollection->createItem();
    $shipment->setFields([
        'DELIVERY_ID' => $deliveryType,
        'DELIVERY_NAME' => 'Доставка'
    ]);

    // Устанавливаем способ оплаты
    $paymentCollection = $order->getPaymentCollection();
    $payment = $paymentCollection->createItem();
    $payment->setFields([
        'PAY_SYSTEM_ID' => $paymentType,
        'PAY_SYSTEM_NAME' => 'Оплата'
    ]);

    // Сохраняем заказ
    $result = $order->save();
    
    if ($result->isSuccess()) {
        $orderId = $order->getId();
        
        // Очищаем корзину
        $basket->clearAll();
        $basket->save();
        
        // Логируем создание заказа
        projectDebugLog('Order created: ID=' . $orderId . ', User=' . $USER->GetID(), 'order_creation');
        
        echo \Bitrix\Main\Web\Json::encode([
            'success' => true,
            'orderId' => $orderId,
            'message' => 'Заказ успешно создан'
        ]);
    } else {
        $errors = $result->getErrorMessages();
        projectDebugLog('Order creation failed: ' . implode(', ', $errors), 'order_creation');
        
        echo \Bitrix\Main\Web\Json::encode([
            'success' => false,
            'message' => 'Ошибка при создании заказа: ' . implode(', ', $errors)
        ]);
    }
    
} catch (Exception $e) {
    projectDebugLog('Order creation exception: ' . $e->getMessage(), 'order_creation');
    
    echo \Bitrix\Main\Web\Json::encode([
        'success' => false,
        'message' => 'Ошибка при создании заказа: ' . $e->getMessage()
    ]);
}
?> 