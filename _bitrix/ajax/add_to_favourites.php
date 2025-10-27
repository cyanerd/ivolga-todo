<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

// Включаем обработку ошибок
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Получаем данные из POST запроса
$input = json_decode(file_get_contents('php://input'), true);
$productId = intval($input['product_id'] ?? 0);

// Проверяем авторизацию пользователя
if (!$USER->IsAuthorized()) {
  echo json_encode([
    'success' => false,
    'error' => 'Пользователь не авторизован'
  ]);
  exit;
}

$userId = $USER->GetID();

if (!$productId) {
  echo json_encode([
    'success' => false,
    'error' => 'Не указан ID товара'
  ]);
  exit;
}

try {
  // Используем класс Favourites для добавления товара
  $result = \Ivolga\Classes\Favourites::addToFavourites($userId, $productId);

  if ($result) {
    echo json_encode([
      'success' => true,
      'message' => 'Товар добавлен в избранное'
    ]);
  } else {
    echo json_encode([
      'success' => false,
      'error' => 'Ошибка при добавлении товара в избранное'
    ]);
  }

} catch (Exception $e) {
  echo json_encode([
    'success' => false,
    'error' => $e->getMessage()
  ]);
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>
