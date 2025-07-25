<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Метод не поддерживается']);
    exit;
}

$orderId = intval($_POST['order_id'] ?? 0);
if (!$orderId) {
    echo json_encode(['status' => 'error', 'message' => 'Не передан номер заказа']);
    exit;
}

if (!CModule::IncludeModule('sale')) {
    echo json_encode(['status' => 'error', 'message' => 'Модуль sale не установлен']);
    exit;
}

$order = Bitrix\Sale\Order::load($orderId);
if (!$order) {
    echo json_encode(['status' => 'error', 'message' => 'Заказ не найден']);
    exit;
}

if ($order->isCanceled()) {
    echo json_encode(['status' => 'success', 'message' => 'Заказ уже отменён']);
    exit;
}

$result = $order->setField('CANCELED', 'Y');
$order->setField('REASON_CANCELED', 'Отмена пользователем через личный кабинет');
$saveResult = $order->save();

if ($saveResult->isSuccess()) {
    echo json_encode(['status' => 'success', 'message' => 'Заказ успешно отменён']);
} else {
    echo json_encode(['status' => 'error', 'message' => implode('; ', $saveResult->getErrorMessages())]);
} 