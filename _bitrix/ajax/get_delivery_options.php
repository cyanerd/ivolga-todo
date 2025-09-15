<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

// Подключаем необходимые модули
if (!CModule::IncludeModule('iblock') || !CModule::IncludeModule('catalog') || !CModule::IncludeModule('sale')) {
    echo json_encode(['success' => false, 'error' => 'Required modules not loaded']);
    exit;
}

try {
    $request = \Bitrix\Main\Context::getCurrent()->getRequest();
    $city = $request->get('city');
    $basketTotal = (float)$request->get('basket_total', 0);

    if (empty($city) || $city === '0') {
        echo json_encode(['success' => false, 'error' => 'Город не выбран']);
        exit;
    }

    // Получаем корзину пользователя для расчета стоимости
    $basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), SITE_ID);
    $basketItems = $basket->getBasketItems();

    $totalWeight = 0;
    $totalVolume = 0;

    foreach ($basketItems as $item) {
        $totalWeight += $item->getWeight() * $item->getQuantity();
        // Примерный расчет объема (если нет точных данных)
        $totalVolume += 0.001 * $item->getQuantity(); // 1 литр на товар
    }

    // Базовые настройки доставки для разных городов
    $deliverySettings = [
        'Москва' => [
            'courier' => [
                'name' => 'Курьер по Москве',
                'description' => 'С примеркой 15 мин.',
                'price' => 500,
                'min_order' => 0,
                'max_weight' => 30,
                'delivery_time' => '1-2 дня'
            ],
            'pickup' => [
                'name' => 'Самовывоз из шоурума',
                'description' => 'ул. Яузская, 5. Бизнес-центр "Яузская, 5"',
                'price' => 0,
                'min_order' => 0,
                'delivery_time' => 'Сегодня'
            ],
            'cdek' => [
                'name' => 'СДЭК (Доставка курьером)',
                'description' => 'Доставка заказа курьером СДЭК',
                'price' => 400,
                'min_order' => 0,
                'delivery_time' => '2-3 дня'
            ]
        ],
        'Санкт-Петербург' => [
            'courier' => [
                'name' => 'Курьер по СПб',
                'description' => 'С примеркой 15 мин.',
                'price' => 800,
                'min_order' => 0,
                'max_weight' => 30,
                'delivery_time' => '2-3 дня'
            ],
            'pickup' => [
                'name' => 'Самовывоз из шоурума',
                'description' => 'Центр города',
                'price' => 0,
                'min_order' => 0,
                'delivery_time' => 'Сегодня'
            ],
            'cdek' => [
                'name' => 'СДЭК (Доставка курьером)',
                'description' => 'Доставка заказа курьером СДЭК',
                'price' => 600,
                'min_order' => 0,
                'delivery_time' => '3-4 дня'
            ]
        ],
        'Казань' => [
            'courier' => [
                'name' => 'Курьер по Казани',
                'description' => 'С примеркой 15 мин.',
                'price' => 600,
                'min_order' => 0,
                'max_weight' => 30,
                'delivery_time' => '2-3 дня'
            ],
            'pickup' => [
                'name' => 'Самовывоз из шоурума',
                'description' => 'Центр города',
                'price' => 0,
                'min_order' => 0,
                'delivery_time' => 'Сегодня'
            ],
            'cdek' => [
                'name' => 'СДЭК (Доставка курьером)',
                'description' => 'Доставка заказа курьером СДЭК',
                'price' => 500,
                'min_order' => 0,
                'delivery_time' => '3-4 дня'
            ]
        ],
        'Краснодар' => [
            'courier' => [
                'name' => 'Курьер по Краснодару',
                'description' => 'С примеркой 15 мин.',
                'price' => 700,
                'min_order' => 0,
                'max_weight' => 30,
                'delivery_time' => '2-3 дня'
            ],
            'pickup' => [
                'name' => 'Самовывоз из шоурума',
                'description' => 'Центр города',
                'price' => 0,
                'min_order' => 0,
                'delivery_time' => 'Сегодня'
            ],
            'cdek' => [
                'name' => 'СДЭК (Доставка курьером)',
                'description' => 'Доставка заказа курьером СДЭК',
                'price' => 600,
                'min_order' => 0,
                'delivery_time' => '3-4 дня'
            ]
        ]
    ];

    // Если город не найден в настройках, используем базовые настройки
    if (!isset($deliverySettings[$city])) {
        $deliverySettings[$city] = [
            'courier' => [
                'name' => 'Курьер',
                'description' => 'С примеркой 15 мин.',
                'price' => 800,
                'min_order' => 0,
                'max_weight' => 30,
                'delivery_time' => '3-5 дней'
            ],
            'pickup' => [
                'name' => 'Самовывоз из шоурума',
                'description' => 'Центр города',
                'price' => 0,
                'min_order' => 0,
                'delivery_time' => 'Сегодня'
            ],
            'cdek' => [
                'name' => 'СДЭК (Доставка курьером)',
                'description' => 'Доставка заказа курьером СДЭК',
                'price' => 700,
                'min_order' => 0,
                'delivery_time' => '4-6 дней'
            ]
        ];
    }

    // Применяем скидки и корректировки в зависимости от суммы заказа
    $citySettings = $deliverySettings[$city];

    // Скидка на доставку при заказе от определенной суммы
    foreach ($citySettings as $key => &$method) {
        if ($basketTotal >= 5000 && $method['price'] > 0) {
            $method['price'] = round($method['price'] * 0.8); // 20% скидка
            $method['description'] .= ' (скидка 20% от 5000₽)';
        }

        // Бесплатная доставка при заказе от 10000₽
        if ($basketTotal >= 10000 && $method['price'] > 0) {
            $method['price'] = 0;
            $method['description'] .= ' (бесплатно от 10000₽)';
        }

        // Проверяем ограничения по весу
        if (isset($method['max_weight']) && $totalWeight > $method['max_weight']) {
            $method['available'] = false;
            $method['description'] .= ' (превышен лимит веса)';
        } else {
            $method['available'] = true;
        }

        // Форматируем цену
        $method['price_formatted'] = $method['price'] > 0 ? number_format($method['price'], 0, '.', ' ') . ' ₽' : 'Бесплатно';
    }

    // Формируем HTML для вариантов доставки
    $deliveryHtml = '';

    // Курьер
    if ($citySettings['courier']['available']) {
        $deliveryHtml .= '<label class="order-methods__item' . ($citySettings['courier']['price'] === 0 ? ' order-methods__item--free' : '') . '">
            <h2>' . htmlspecialchars($citySettings['courier']['name']) . '</h2>
            <p>' . htmlspecialchars($citySettings['courier']['description']) . '</p>
            <h3>' . htmlspecialchars($citySettings['courier']['price_formatted']) . '</h3>
            <input type="radio" name="method-delivery" value="courier" data-price="' . $citySettings['courier']['price'] . '" data-delivery-time="' . htmlspecialchars($citySettings['courier']['delivery_time']) . '">
        </label>';
    }

    // СДЭК
    if ($citySettings['cdek']['available']) {
        $deliveryHtml .= '<label class="order-methods__item' . ($citySettings['cdek']['price'] === 0 ? ' order-methods__item--free' : '') . '">
            <h2>' . htmlspecialchars($citySettings['cdek']['name']) . '</h2>
            <p>' . htmlspecialchars($citySettings['cdek']['description']) . '</p>
            <h3>' . htmlspecialchars($citySettings['cdek']['price_formatted']) . '</h3>
            <input type="radio" name="method-delivery" value="cdek" data-price="' . $citySettings['cdek']['price'] . '" data-delivery-time="' . htmlspecialchars($citySettings['cdek']['delivery_time']) . '">
        </label>';
    }

    // Самовывоз
    $deliveryHtml .= '<label class="order-methods__item order-methods__item--free">
        <h2>' . htmlspecialchars($citySettings['pickup']['name']) . '</h2>
        <p>' . htmlspecialchars($citySettings['pickup']['description']) . '</p>
        <h3>Бесплатно</h3>
        <input type="radio" name="method-delivery" value="pickup" data-price="0" data-delivery-time="' . htmlspecialchars($citySettings['pickup']['delivery_time']) . '">
    </label>';

    // Дополнительная информация о доставке
    $deliveryInfo = [
        'city' => $city,
        'basket_total' => $basketTotal,
        'total_weight' => $totalWeight,
        'total_volume' => $totalVolume,
        'methods' => $citySettings
    ];

    echo json_encode([
        'success' => true,
        'delivery_html' => $deliveryHtml,
        'delivery_info' => $deliveryInfo
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
