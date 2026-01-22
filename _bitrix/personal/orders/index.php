<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle('История заказов');
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
        <?php include __DIR__ . '/../menu.php'; ?>
        <div class="infopage__main">
          <h1 class="lk__title">
            История заказов
          </h1>

          <? $APPLICATION->IncludeComponent(
            'bitrix:sale.personal.order.list',
            'personal_orders',
            [
              'ACTIVE_DATE_FORMAT' => 'd.m.Y',
              'ALLOW_INNER' => 'N',
              'CACHE_GROUPS' => 'Y',
              'CACHE_TIME' => '3600',
              'CACHE_TYPE' => 'A',
              'DEFAULT_SORT' => 'STATUS',
              'DISALLOW_CANCEL' => 'N',
              'HISTORIC_STATUSES' => [],
              'NAV_TEMPLATE' => '',
              'ONLY_INNER_FULL' => 'N',
              'ORDERS_PER_PAGE' => '20',
              'PATH_TO_BASKET' => '/cart/',
              'PATH_TO_CANCEL' => '/personal/order/cancel/',
              'PATH_TO_COPY' => '/personal/order/copy/',
              'PATH_TO_DETAIL' => '/personal/order/detail/',
              'PATH_TO_PAYMENT' => '/payment/',
              'REFRESH_PRICES' => 'N',
              'RESTRICT_CHANGE_PAYSYSTEM' => [
                '0'
              ],
              'SAVE_IN_SESSION' => 'Y',
              'SET_TITLE' => 'N',
              'STATUS_COLOR_F' => 'gray',
              'STATUS_COLOR_N' => 'green',
              'STATUS_COLOR_P' => 'yellow',
              'STATUS_COLOR_PSEUDO_CANCELED' => 'red'
            ]
          ); ?>

        </div>
      </div>
    </div>
  </div>
</section>

<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); ?>
