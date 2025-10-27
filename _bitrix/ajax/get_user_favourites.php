<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

// Включаем обработку ошибок
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Проверяем авторизацию пользователя
if (!$USER->IsAuthorized()) {
    echo json_encode([
        'success' => false,
        'error' => 'Пользователь не авторизован'
    ]);
    exit;
}

$userId = $USER->GetID();

try {
    // Получаем список избранных товаров пользователя
    $favourites = \Ivolga\Classes\Favourites::getUserFavourites($userId);

    echo json_encode([
        'success' => true,
        'favourites' => $favourites
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>
