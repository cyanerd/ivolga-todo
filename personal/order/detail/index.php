<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Детали заказа");
?>

<section class="infopage lk">
  <div class="infopage__wrap">
    <div class="container">
      <div class="infopage__row">
        <?php include __DIR__ . '/../../menu.php'; ?>
        <div class="infopage__main">
          <h1 class="lk__title">
            Детали заказа
          </h1>

          <? $APPLICATION->IncludeComponent(
            "bitrix:sale.personal.order.detail",
            "personal_order_detail",
            [
              "ACTIVE_DATE_FORMAT" => "d.m.Y H:i:s",
              "ALLOW_INNER" => "N",
              "CACHE_GROUPS" => "Y",
              "CACHE_TIME" => "3600",
              "CACHE_TYPE" => "A",
              "CUSTOM_SELECT_PROPS" => [
                ""
              ],
              "DISALLOW_CANCEL" => "N",
              "ID" => (int)$_REQUEST["ID"],
              "ONLY_INNER_FULL" => "N",
              "PATH_TO_BASKET" => "/cart/",
              "PATH_TO_CANCEL" => "/personal/order/cancel/",
              "PATH_TO_COPY" => "/personal/order/copy/",
              "PATH_TO_PAYMENT" => "/payment/",
              "REFRESH_PRICES" => "N",
              "RESTRICT_CHANGE_PAYSYSTEM" => [
                "0"
              ],
              "SAVE_IN_SESSION" => "Y",
              "SET_TITLE" => "N",
              "STATUS_COLOR_F" => "gray",
              "STATUS_COLOR_N" => "green",
              "STATUS_COLOR_P" => "yellow",
              "STATUS_COLOR_PSEUDO_CANCELED" => "red"
            ]
          ); ?>

        </div>
      </div>
    </div>
  </div>
</section>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
