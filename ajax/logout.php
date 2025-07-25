<?php
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

global $USER;
if ($USER->IsAuthorized()) {
    $USER->Logout();
    $result = ['result' => 'ok'];
} else {
    $result = ['result' => 'not_auth'];
}

header('Content-Type: application/json');
echo json_encode($result); 