<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
global $USER;
if (!$USER->IsAuthorized()) {
  LocalRedirect('/');
  die();
}
?>

<section class="infopage lk">
  <div class="infopage__wrap">
    <div class="container">
      <div class="infopage__row">
        <?php include __DIR__ . '/menu.php'; ?>
        <div class="infopage__main">
          <h1 class="lk__title">
            Персональная информация
          </h1>

          <? $APPLICATION->IncludeComponent(
            "bitrix:main.profile",
            "personal_profile",
            [
              "SET_TITLE" => "N",
              "USER_PROPERTY" => [
                "UF_SUBSCRIBE_EMAIL"
              ],
              "SEND_INFO" => "N",
              "CHECK_RIGHTS" => "N",
              "USER_PROPERTY_NAME" => "",
              "AJAX_MODE" => "N",
              "AJAX_OPTION_JUMP" => "N",
              "AJAX_OPTION_STYLE" => "Y",
              "AJAX_OPTION_HISTORY" => "N",
              "USE_CAPTCHA" => "N",
              "USER_CONSENT" => "Y",
              "USER_CONSENT_ID" => "1",
              "USER_CONSENT_IS_CHECKED" => "Y",
              "USER_CONSENT_IS_LOADED" => "N"
            ]
          ); ?>

        </div>
      </div>
    </div>
  </div>
</section>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
