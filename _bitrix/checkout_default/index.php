<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Оформление заказа");
?>

<section class="pagecollect">
  <div>
    <div class="_container _cart">
      <h1 class="pagecollect__title">
        <? $APPLICATION->ShowTitle(); ?>
      </h1>
      <? $APPLICATION->IncludeComponent(
        "bitrix:sale.order.ajax",
        ".default",
        [
          "ALLOW_AUTO_REGISTER" => "Y",
          "ALLOW_NEW_PROFILE" => "Y",
          "ALLOW_USER_PROFILES" => "N",
          "COMPATIBLE_MODE" => "Y",
          "DELIVERY_NO_AJAX" => "N",
          "DELIVERY_NO_SESSION" => "N",
          "DELIVERY_TO_PAYSYSTEM" => "d2p",
          "DISABLE_BASKET_REDIRECT" => "N",
          "ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
          "PATH_TO_AUTH" => "/auth/",
          "PATH_TO_BASKET" => "/cart/",
          "PATH_TO_PAYMENT" => "/payment/",
          "PATH_TO_PERSONAL" => "/personal/",
          "PAY_FROM_ACCOUNT" => "N",
          "PROP_1" => [],
          "PROP_2" => [],
          "REGISTER_AJAX" => "Y",
          "SEND_NEW_USER_NOTIFY" => "Y",
          "SET_TITLE" => "N",
          "SHOW_AJAX_HEADERS" => "N",
          "SHOW_NOT_CALCULATED_DELIVERIES" => "L",
          "SHOW_VAT_PRICE" => "N",
          "TEMPLATE_LOCATION" => "popup",
          "USE_PREPAYMENT" => "N",
          "SHOW_AUTH_BLOCK" => "Y",
          "SHOW_REGISTER_BLOCK" => "Y",

          "ADDITIONAL_PICT_PROP_8" => "-",
          "BASKET_IMAGES_SCALING" => "standard",
          "BASKET_POSITION" => "after",
          "DELIVERIES_PER_PAGE" => "8",
          "DELIVERY_FADE_EXTRA_SERVICES" => "Y",
          "MESS_DELIVERY_CALC_ERROR_TEXT" => "Вы можете продолжить оформление заказа, а чуть позже менеджер магазина 
 свяжется с вами и уточнит информацию по доставке.",
          "MESS_DELIVERY_CALC_ERROR_TITLE" => "Не удалось рассчитать стоимость доставки.",
          "MESS_FAIL_PRELOAD_TEXT" => "Вы заказывали в нашем интернет-магазине, поэтому мы заполнили все данные автоматически. 
Обратите внимание на развернутый блок с информацией о заказе. Здесь вы можете внести необходимые изменения или оставить 
как есть и нажать кнопку \"#ORDER_BUTTON#\".",
          "MESS_SUCCESS_PRELOAD_TEXT" => "Вы заказывали в нашем интернет-магазине, поэтому мы заполнили все данные 
автоматически. Если все заполнено верно, нажмите кнопку \"#ORDER_BUTTON#\".",
          "PAY_SYSTEMS_PER_PAGE" => "8",
          "PICKUPS_PER_PAGE" => "5",
          "PRODUCT_COLUMNS_HIDDEN" => ["PROPERTY_MATERIAL"],
          "PRODUCT_COLUMNS_VISIBLE" => ["PREVIEW_PICTURE", "PROPS"],
          "PROPS_FADE_LIST_1" => ["17", "19"],
          "SERVICES_IMAGES_SCALING" => "standard",
          "SHOW_BASKET_HEADERS" => "N",
          "SHOW_COUPONS" => "Y",
          "SHOW_COUPONS_BASKET" => "Y",
          "SHOW_COUPONS_DELIVERY" => "Y",
          "SHOW_COUPONS_PAY_SYSTEM" => "Y",
          "SHOW_DELIVERY_INFO_NAME" => "Y",
          "SHOW_DELIVERY_LIST_NAMES" => "Y",
          "SHOW_DELIVERY_PARENT_NAMES" => "Y",
          "SHOW_MAP_IN_PROPS" => "N",
          "SHOW_NEAREST_PICKUP" => "N",
          "SHOW_ORDER_BUTTON" => "final_step",
          "SHOW_PAY_SYSTEM_INFO_NAME" => "Y",
          "SHOW_PAY_SYSTEM_LIST_NAMES" => "Y",
          "SHOW_STORES_IMAGES" => "Y",
          "SHOW_TOTAL_ORDER_BUTTON" => "Y",
          "SKIP_USELESS_BLOCK" => "Y",
          "TEMPLATE_THEME" => "site",
          "USE_CUSTOM_ADDITIONAL_MESSAGES" => "N",
          "USE_CUSTOM_ERROR_MESSAGES" => "Y",
          "USE_CUSTOM_MAIN_MESSAGES" => "N",
          "USE_YM_GOALS" => "N",
          "USER_CONSENT" => "Y",
          "USER_CONSENT_ID" => "1",
          "USER_CONSENT_IS_CHECKED" => "Y",
          "USER_CONSENT_IS_LOADED" => "N",
        ]
      ); ?>
    </div>
  </div>

  <div id="hehe1">hehe1</div>
  <div id="hehe2">hehe2</div>
</section>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
