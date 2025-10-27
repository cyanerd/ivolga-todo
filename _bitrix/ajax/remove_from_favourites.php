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
    // Используем класс Favourites для удаления товара
    $result = \Ivolga\Classes\Favourites::removeFromFavourites($userId, $productId);

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Товар удален из избранного'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Ошибка при удалении товара из избранного'
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
