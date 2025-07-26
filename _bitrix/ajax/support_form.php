<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['status' => 'error', 'message' => 'Метод не поддерживается']);
  exit;
}

$message = trim($_POST['message'] ?? '');
$orderId = trim($_POST['order_id'] ?? '');

if (!$message) {
  echo json_encode(['status' => 'error', 'message' => 'Пустое сообщение']);
  exit;
}
if (!$orderId) {
  echo json_encode(['status' => 'error', 'message' => 'Не указан номер заказа']);
  exit;
}

CModule::IncludeModule("form");
$formId = 2;
$arValues = [
  "form_text_2" => $message,
  "form_text_3" => $orderId,
];
$RESULT_ID = CFormResult::Add($formId, $arValues);
if ($RESULT_ID) {
  echo json_encode([
    'status' => 'success',
    'message' => 'Спасибо! Ваше обращение отправлено.'
  ]);
} else {
  echo json_encode([
    'status' => 'error',
    'message' => 'Ошибка при сохранении. Попробуйте позже.'
  ]);
}
