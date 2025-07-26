<?php
include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("catalog");
CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");
CModule::IncludeModule("search");

use Bitrix\Sale;

global $USER;
$request = \Bitrix\Main\Context::getCurrent()->getRequest();

$command = $request['command'];

switch ($command) {
  case "like":
    $res = 'none';
    $char_id = $request['id'];
    $session_id = session_id();

    // есть ли уже этот товар
    $arFilter = ['IBLOCK_ID' => 24, 'ACTIVE' => 'Y', '=PROPERTY_SESSION_ID' => $session_id, '=PROPERTY_ITEM_ID' => $char_id];
    $db_list = CIBlockElement::GetList([], $arFilter, false, [], ['ID', 'IBLOCK_ID']);
    $arItem = $db_list->GetNext();

    if (!$arItem['ID']):
      $res = 'on';
      $el = new CIBlockElement;
      $PROP = [];
      $PROP['SESSION_ID'] = $session_id;
      $PROP['ITEM_ID'] = $char_id;

      $arLoadProductArray = [
        "IBLOCK_SECTION_ID" => false,
        "IBLOCK_ID" => 24,
        "PROPERTY_VALUES" => $PROP,
        "NAME" => '#' . $char_id . '#',
        "ACTIVE" => "Y",
      ];
      $el->Add($arLoadProductArray);
    else:
      $res = 'off';
      CIBlockElement::Delete($arItem['ID']);
    endif;
    $data = json_encode([
      'result' => $res,
    ]);
    echo $data;
    break;
}

// === Подписка на новости (footer newsletter) ===
if ($command == 'newsletter_subscribe') {
  $email = trim($request['email']);
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
      'status' => 'error',
      'message' => 'Некорректный email',
    ]);
    exit;
  }
  CModule::IncludeModule("form");
  $formId = 1;
  $arValues = [
    "form_text_1" => $email,
  ];
  $RESULT_ID = CFormResult::Add($formId, $arValues);
  if ($RESULT_ID) {
    echo json_encode([
      'status' => 'success',
      'message' => 'Спасибо! Вы успешно подписались на новости.'
    ]);
  } else {
    echo json_encode([
      'status' => 'error',
      'message' => 'Ошибка при сохранении. Попробуйте позже.'
    ]);
  }
  exit;
}
