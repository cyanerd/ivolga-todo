<?php
include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

global $USER;

$request = \Bitrix\Main\Context::getCurrent()->getRequest()->toArray();
$phone = $request['phone'];
if(!$phone) {
    echo \Bitrix\Main\Web\Json::encode([
        'status' => 'error',
    ]);
    die;
}
$phone = NormalizePhone($phone);

// есть ли уже такой пользователь
$filter = Array("PERSONAL_PHONE" => $phone);
$rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), $filter);
$arUser = $rsUsers->Fetch();

$sms_code = round(rand(1000, 9999));

if(!$arUser) {
    // регистрируем нового
    $user = new CUser;
    $prfx = 'user_'.md5(time());
    $email = $prfx.'@hostland.pro';
    $arFields = Array(
        "NAME"              => '',
        "PERSONAL_PHONE"    => $phone,
        "LOGIN"             => $email,
        "EMAIL" => '',
        "ACTIVE"            => "Y",
        "PASSWORD"          => '123456',
        "CONFIRM_PASSWORD"  => '123456',
        "UF_CODE" => $sms_code,
    );
    $USER_ID = $user->Add($arFields);
} else {
    //обновляем код у старого
    $user = new CUser;
    $arFields = Array(
        "UF_CODE" => $sms_code,
    );
    $user->Update($arUser['ID'], $arFields);
}
send_sms("api.smsfeedback.ru", 80, "ivolgafashion", "HiCS5yttz",  preg_replace('~\D+~', '', $phone), 'Код для подтверждения: '.$sms_code);
echo \Bitrix\Main\Web\Json::encode([
    'status' => 'success',
    'title' => 'Спасибо',
    'message' => 'Ваше обращение успешно отправлено!',
    'phone' => $phone,
]);