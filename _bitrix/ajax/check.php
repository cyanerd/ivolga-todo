<?php
include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

global $USER;

$request = \Bitrix\Main\Context::getCurrent()->getRequest()->toArray();
$phone = $request['phone'];
$verificationCode = $request['verificationCode'];
if (!$phone) {
  echo \Bitrix\Main\Web\Json::encode([
    'status' => 'error',
    'message' => 'укажите номер телефона',
  ]);
  die;
}
if (!$verificationCode) {
  echo \Bitrix\Main\Web\Json::encode([
    'status' => 'error',
    'message' => 'не указан код верификации',
  ]);
  die;
}
$phone = NormalizePhone($phone);

// есть ли уже такой пользователь
$filter = ["PERSONAL_PHONE" => $phone, "UF_CODE" => $verificationCode];
$rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), $filter);
$arUser = $rsUsers->Fetch();

if (!$arUser) {
  echo \Bitrix\Main\Web\Json::encode([
    'status' => 'error',
    'message' => 'код указан неверно',
  ]);
  die;
}

$USER->Authorize($arUser['ID']);

echo \Bitrix\Main\Web\Json::encode([
  'status' => 'success',
  'title' => 'Спасибо',
  'message' => 'Вы успешно авторизовались!',
  'phone' => $phone,
]);
