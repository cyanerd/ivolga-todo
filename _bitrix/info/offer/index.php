<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Публичная оферта");
?>

<section class="infopage">
  <div class="infopage__wrap">
    <div class="container">
      <div class="infopage__row">
        <div class="infopage__aside">
          <?php
          $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "info-aside",
            [
              "ROOT_MENU_TYPE" => "customers",
              "MAX_LEVEL" => "1",
              "CHILD_MENU_TYPE" => "",
              "MENU_CACHE_TYPE" => "A",
              "MENU_CACHE_TIME" => "3600",
              "MENU_CACHE_USE_GROUPS" => "Y",
              "MENU_CACHE_GET_VARS" => [],
              "COMPONENT_TEMPLATE" => "info-aside"
            ]
          );
          ?>
        </div>
        <div class="infopage__main">
          <h1 class="infopage__title">
            <?$APPLICATION->ShowTitle(); ?>
          </h1>
          <div class="infopage__content">
            <? $axi->GT('offer') ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
