<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");
?>

<? $APPLICATION->IncludeComponent(
  "cabinet:cart",
  "",
  [
    "COMPOSITE_FRAME_MODE" => "A",
    "COMPOSITE_FRAME_TYPE" => "AUTO",
    "SEF_FOLDER" => "/cart/",
    "SEF_MODE" => "Y",
    "SEF_URL_TEMPLATES" => ['index' => 'index.php', 'action' => '#ACTION#/',]
  ]
); ?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
