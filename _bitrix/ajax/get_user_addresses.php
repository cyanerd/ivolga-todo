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

    // Получаем адреса пользователя
    $addresses = MyTools::getAddresses($userId);

    if (!empty($addresses)) {
        // Формируем HTML для списка адресов
        $addressesHtml = '';
        foreach ($addresses as $address) {
            $addressesHtml .= '
            <div class="address-item" data-address=\'' . json_encode($address) . '\'>
                <div class="address-item__content">
                    <h3 class="address-item__title">' . htmlspecialchars($address['NAME']) . '</h3>
                    <p class="address-item__address">
                        ' . htmlspecialchars($address['CITY']) . ', ' .
                        htmlspecialchars($address['ADDRESS']) . ', д. ' .
                        htmlspecialchars($address['HOUSE']);

            if ($address['ENTRANCE']) {
                $addressesHtml .= ', подъезд ' . htmlspecialchars($address['ENTRANCE']);
            }
            if ($address['APARTMENT']) {
                $addressesHtml .= ', кв. ' . htmlspecialchars($address['APARTMENT']);
            }
            if ($address['FLOOR']) {
                $addressesHtml .= ', этаж ' . htmlspecialchars($address['FLOOR']);
            }

            $addressesHtml .= '
                    </p>';

            if ($address['COMMENT']) {
                $addressesHtml .= '<p class="address-item__comment">' . htmlspecialchars($address['COMMENT']) . '</p>';
            }

            $addressesHtml .= '
                </div>
                <button class="address-item__select" type="button">Выбрать</button>
            </div>';
        }

        echo json_encode([
            'success' => true,
            'addresses' => $addresses,
            'addressesHtml' => $addressesHtml
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'addresses' => [],
            'addressesHtml' => '<div class="address-empty">У вас пока нет сохраненных адресов</div>'
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
