<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
header('Content-Type: application/json');

if (!CModule::IncludeModule("main")) {
  echo json_encode(["success" => false, "error" => "Bitrix core not loaded"]);
  exit;
}

global $USER;
if (!$USER->IsAuthorized()) {
  echo json_encode(["success" => false, "error" => "Пользователь не авторизован"]);
  exit;
}

$current = $_POST['current'] ?? '';
$new = $_POST['new'] ?? '';
$repeat = $_POST['repeat'] ?? '';

if (!$current || !$new || !$repeat) {
  echo json_encode(["success" => false, "error" => "Заполните все поля"]);
  exit;
}

if ($new !== $repeat) {
  echo json_encode(["success" => false, "error" => "Пароли не совпадают"]);
  exit;
}

$userId = $USER->GetID();
$rsUser = CUser::GetByID($userId);
$arUser = $rsUser->Fetch();

// Проверяем текущий пароль через Login
$authRes = $USER->Login($arUser["LOGIN"], $current, "N");
if (is_array($authRes) && isset($authRes["TYPE"]) && $authRes["TYPE"] == "ERROR") {
  echo json_encode(["success" => false, "error" => "Текущий пароль неверный"]);
  // Восстанавливаем авторизацию
  $USER->Authorize($userId);
  exit;
}
// Восстанавливаем авторизацию
$USER->Authorize($userId);

$user = new CUser;
$fields = ["PASSWORD" => $new, "CONFIRM_PASSWORD" => $repeat];
if ($user->Update($userId, $fields)) {
  echo json_encode(["success" => true]);
} else {
  echo json_encode(["success" => false, "error" => $user->LAST_ERROR]);
}
