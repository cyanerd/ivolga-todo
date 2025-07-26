<?php
include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("catalog");
CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");

use Bitrix\Sale;
use local\php_interface\MyTools;

global $USER;

$request = \Bitrix\Main\Context::getCurrent()->getRequest();

$error = false;
$error_text = '';
$error_code = 0;

$basket = MyTools::getBasket();
if (empty($basket['BASKET_ITEMS'])) {
  $error = true;
  $error_text = 'Корзина пуста';
  $error_code = 1;
}

parse_str($request['data']['form'], $res_data);
$res_data = array_map('trim', $res_data);
if (empty($res_data['firstName'])) {
  $error = true;
  $error_text = 'Не указано имя';
  $error_code = 2;
}
if (empty($res_data['lastName'])) {
  $error = true;
  $error_text = 'Не указана фамилия';
  $error_code = 2;
}
if (empty($res_data['personal-agreementp']) || $res_data['personal-agreementp'] != 'Y') {
  $error = true;
  $error_text = 'Требуется дать согласие на обработку персональных данных';
  $error_code = 2;
}
$phone_number = NormalizePhone($res_data['phone']);
if (empty($phone_number)) {
  $error = true;
  $error_text = 'Не указан номер телефона';
  $error_code = 2;
}

parse_str($request['data']['address'], $res_address);
$res_address = array_map('trim', $res_address);

$delivery_id = $request['data']['delivery_id'];
$cdek = $request['data']['cdek'];
if ($delivery_id == 193 && !$cdek) {
  $error = true;
  $error_text = 'Вы не указали адрес СДЭК';
  $error_code = 3;
}

if (!($request['data']['agreement'] == 'true')) {
  $error = true;
  $error_text = 'Требуется подтверждение о согласии';
  $error_code = 10;
}

$payment_id = (int)$request['data']['payment_id'];
if (!$payment_id) {
  $error = true;
  $error_text = 'Не выбран тип оплаты';
  $error_code = 15;
}

if (($delivery_id == 2 || $delivery_id == 194 || $delivery_id == 195) && !$res_address['address']) {
  $error = true;
  $error_text = 'Не указан адрес доставки';
  $error_code = 15;
}

if ($error) {
  echo \Bitrix\Main\Web\Json::encode([
    'error' => true,
    'error_text' => $error_text,
    'error_code' => $error_code,
  ]);
  return false;
}

$price = $basket['BASKET']->getPrice();

$delivery_types = getDeliveryTypes();
$delivery_summ = 0;
foreach ($delivery_types as $delivery_type) {
  if ($delivery_type['ID'] == $delivery_id) {
    $delivery_summ = $delivery_type['PRICE'];
    break;
  }
}

$arOrderPayload = [
  'PRICE' => $price,
  'PAY_SYSTEM_ID' => $payment_id,
  'PRICE_DELIVERY' => $delivery_summ,
  'DELIVERY_ID' => $delivery_id,
  'USER_DATA' => $res_data,
  'ADDRESS' => $res_address['address'],
  'COMMENT' => $res_address['comment'],
  'CDEK' => $cdek,
];

$ORDER_ID = MyTools::addOrder($arOrderPayload);

echo \Bitrix\Main\Web\Json::encode([
  'ret_url' => '/checkout/success/?order_id=' . $ORDER_ID,
]);
return false;
