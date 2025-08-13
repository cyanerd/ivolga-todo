<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

// Проверяем авторизацию пользователя
if (!$USER->IsAuthorized()) {
    echo json_encode([
        'success' => false,
        'error' => 'Пользователь не авторизован'
    ]);
    exit;
}

try {
    // Получаем ID пользователя
    $userId = $USER->GetID();
    
    // Получаем данные пользователя
    $userData = $USER->GetByID($userId)->Fetch();
    
    if ($userData) {
        // Получаем дополнительные поля пользователя
        $rsUser = CUser::GetByID($userId);
        $arUser = $rsUser->Fetch();
        
        // Формируем ответ с данными пользователя
        $response = [
            'success' => true,
            'userData' => [
                'firstName' => $arUser['NAME'] ?: '',
                'lastName' => $arUser['LAST_NAME'] ?: '',
                'email' => $arUser['EMAIL'] ?: '',
                'phone' => $arUser['PERSONAL_PHONE'] ?: $arUser['LOGIN'] ?: '', // Используем LOGIN если нет телефона
                'login' => $arUser['LOGIN'] ?: ''
            ]
        ];
        
        echo json_encode($response);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Данные пользователя не найдены'
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
