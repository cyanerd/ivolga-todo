<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if (!CModule::IncludeModule("catalog") || !CModule::IncludeModule("iblock")) {
    echo json_encode(['error' => 'Modules not found']);
    exit;
}

$offerId = intval($_POST['offer_id']);

if (!$offerId) {
    echo json_encode(['error' => 'Invalid offer ID']);
    exit;
}

// Получаем цены торгового предложения
$price = 0;
$oldPrice = 0;
$discountPercent = 0;

// Используем GetOptimalPrice для автоматического определения цены
$optimalPrice = CCatalogProduct::GetOptimalPrice($offerId, 1, array(), 'N', array(), SITE_ID);
if ($optimalPrice && isset($optimalPrice['PRICE'])) {
    $price = $optimalPrice['PRICE']['PRICE'];
}

// Если GetOptimalPrice не вернул цену, пробуем получить напрямую
if ($price == 0) {
    $dbPrice = CPrice::GetList(
        array(),
        array(
            "PRODUCT_ID" => $offerId,
            "CATALOG_GROUP_ID" => 7 // ID типа цены "Розничная цена"
        )
    );
    if ($arPrice = $dbPrice->Fetch()) {
        $price = $arPrice["PRICE"];
    }
}

// Получаем старую цену (Первоначальная розничная цена, ID=8)
$dbOldPrice = CPrice::GetList(
    array(),
    array(
        "PRODUCT_ID" => $offerId,
        "CATALOG_GROUP_ID" => 8 // ID типа цены "Первоначальная розничная цена"
    )
);
if ($arOldPrice = $dbOldPrice->Fetch()) {
    $oldPrice = $arOldPrice["PRICE"];
}

// Рассчитываем процент скидки, если есть старая цена и она больше текущей
if ($oldPrice > 0 && $oldPrice > $price) {
    $discountPercent = round((($oldPrice - $price) / $oldPrice) * 100);
}

echo json_encode([
    'success' => true,
    'price' => $price,
    'old_price' => $oldPrice,
    'discount_percent' => $discountPercent,
    'formatted_price' => number_format($price, 0, '.', ' ') . '₽',
    'formatted_old_price' => $oldPrice > $price ? number_format($oldPrice, 0, '.', ' ') . '₽' : '',
    'formatted_discount' => $discountPercent > 0 ? '-' . $discountPercent . '%' : ''
]);
?>