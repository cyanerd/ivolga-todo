<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Поиск");
?>

<section class="pagecollect">
  <div class="pagecollect__wrap">
    <div class="container">
      <h1 class="pagecollect__title">
        <? $APPLICATION->ShowTitle(); ?>
      </h1>
    </div>

    <? $APPLICATION->IncludeComponent(
      "dm:search.page",
      "",
      [
      ]
    ); ?>

  </div>
</section>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
