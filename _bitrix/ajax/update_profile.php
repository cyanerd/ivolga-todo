<?php
// AJAX-обновление профиля пользователя Bitrix

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

header('Content-Type: application/json; charset=UTF-8');

global $USER;
if (!$USER->IsAuthorized()) {
  echo json_encode(['success' => false, 'error' => 'Пользователь не авторизован']);
  exit;
}

$data = $_POST;
$user = new CUser;
$fields = [];

if (isset($data['NAME'])) $fields['NAME'] = $data['NAME'];
if (isset($data['LAST_NAME'])) $fields['LAST_NAME'] = $data['LAST_NAME'];
if (isset($data['PERSONAL_BIRTHDAY'])) $fields['PERSONAL_BIRTHDAY'] = $data['PERSONAL_BIRTHDAY'];
if (isset($data['PERSONAL_PHONE'])) $fields['PERSONAL_PHONE'] = $data['PERSONAL_PHONE'];
if (isset($data['EMAIL'])) $fields['EMAIL'] = $data['EMAIL'];
$fields['UF_NOT_SUBSCRIBED'] = isset($data['UF_NOT_SUBSCRIBED']) && $data['UF_NOT_SUBSCRIBED'] === 'Y' ? false : true;

if ($user->Update($USER->GetID(), $fields)) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'error' => $user->LAST_ERROR]);
}
exit;
