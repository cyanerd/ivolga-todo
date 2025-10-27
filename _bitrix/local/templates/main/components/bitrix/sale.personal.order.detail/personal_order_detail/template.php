<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
$order = $arResult;
?>
<div class="infopage__main">
  <div class="singleorder">
    <div class="singleorder__header">
      <p class="singleorder__title">
        Заказ №<?= htmlspecialcharsbx($order["ACCOUNT_NUMBER"] ?? $order["ID"]) ?></p>
      <p class="singleorder__status singleorder__status_delivered">
        <?= htmlspecialcharsbx($order["STATUS"]["NAME"] ?? "-") ?>
      </p>
    </div>
    <p class="singleorder__date">
      <? if ($order["DELIVERY_DATE"]): ?>
        Заказ будет доставлен <?= $order["DELIVERY_DATE"] ?>
      <? elseif ($order["DATE_INSERT_FORMATTED"]): ?>
        Заказ от <?= $order["DATE_INSERT_FORMATTED"] ?>
      <? else: ?>
        Дата не указана
      <? endif; ?>
    </p>

    <div class="singleorder__products">
      <? if (!empty($order["BASKET"])): ?>
        <? foreach ($order["BASKET"] as $item): ?>
          <?php
          $detailUrl = '#';
          $skuId = $item['PRODUCT_ID'];
          $parent = CCatalogSku::GetProductInfo($skuId);
          if ($parent && $parent['ID']) {
            $rs = CIBlockElement::GetList(
              [],
              ['ID' => $parent['ID']],
              false,
              false,
              ['ID', 'CODE']
            );
            if ($ar = $rs->GetNext()) {
              $detailUrl = '/product/' . $ar['CODE'] . '/';
            }
          }
          ?>
          <a href="<?= $detailUrl ?>" class="singleorder-prod">
            <div class="singleorder-prod__left">
              <div class="singleorder-prod__image">
                <img src="<?= $item["PICTURE"]["SRC"] ?? '/assets/img/no-photo.jpg' ?>"
                     alt="<?= htmlspecialcharsbx($item["NAME"] ?? '') ?>">
              </div>
              <div class="singleorder-prod__content">
                <p class="singleorder-prod__title">
                  <?= htmlspecialcharsbx($item["NAME"] ?? '') ?>
                </p>
                <p class="singleorder-prod__count">
                  <?= floatval($item["QUANTITY"]) ?> шт.
                </p>
              </div>
            </div>
            <div class="singleorder-prod__right">
              <p class="singleorder-prod__price">
                <?= $item["PRICE_FORMATED"] ?? $item["FORMATED_SUM"] ?? '' ?>
              </p>
            </div>
          </a>
        <? endforeach; ?>
      <? else: ?>
        <p>Нет товаров в заказе</p>
      <? endif; ?>
    </div>

    <div class="singleorder-info">
      <div class="singleorder-info__persona">
        <p class="singleorder-info__persona-title">
          Данные получателя
        </p>
        <p class="singleorder-info__persona-txt">
          <?= htmlspecialcharsbx($order["USER_NAME"] ?? '-') ?><br><br>
          <?= htmlspecialcharsbx($order["USER_ADDRESS"] ?? '-') ?><br><br>
          <a href="#"><?= htmlspecialcharsbx($order["USER_PHONE"] ?? '-') ?></a>
        </p>
        <p class="singleorder-info__persona-title">
          Комментарий
        </p>
        <p class="singleorder-info__persona-txt">
          <?= htmlspecialcharsbx($order["USER_COMMENT"] ?? '-') ?>
        </p>
      </div>
      <div class="singleorder-info__info">
        <div class="singleorder-info__info-item">
          <p>
            <?= count($order["BASKET"] ?? []) ?> <?= pluralForm(count($order["BASKET"] ?? []), ["товар", "товара", "товаров"]) ?>
            на сумму
          </p>
          <p>
            <?= $order["PRICE_FORMATED"] ?? '-'; ?>
          </p>
        </div>
        <div class="singleorder-info__info-item">
          <p>
            Скидка
          </p>
          <p>
            <?= $order["DISCOUNT_VALUE_FORMATED"] ?? '0 ₽'; ?>
          </p>
        </div>
        <div class="singleorder-info__info-item">
          <p>
            Промокод
          </p>
          <p>
            0 ₽
          </p>
        </div>
        <div class="singleorder-info__info-item">
          <p>
            Способ доставки
          </p>
          <p>
            <?= $order['SHIPMENT'][0]["DELIVERY_NAME"] ?? '-'; ?>
          </p>
        </div>
        <div class="singleorder-info__info-item">
          <p>
            Доставка
          </p>
          <p>
            <?= $order["PRICE_DELIVERY_FORMATED"] ?? 'Бесплатно'; ?>
          </p>
        </div>
        <div class="singleorder-info__info-item singleorder-info__info-item_finish">
          <p class="finallabel">
            Итого
          </p>
          <p class="finalprice">
            <?= $order["SUM_PAID_FORMATED"] ?? $order["PRICE_FORMATED"] ?? '-'; ?>
          </p>
        </div>
      </div>
    </div>

    <div class="singleorder-footer">
      <a href="#" class="singleorder-footer__support" id="support-link">
        Связаться с поддержкой
      </a>
      <? if ($order["CAN_CANCEL"] == "Y"): ?>
        <a href="<?= $order["URL_TO_CANCEL"] ?>" class="singleorder-footer__cancel">
          Отменить заказ
        </a>
      <? endif; ?>
    </div>
  </div>
</div>

<!-- Support Modal -->
<div class="support-modal" id="support-modal"
     style="display:none;position:fixed;top:0;right:0;width:400px;max-width:100vw;height:100vh;background:#fff;z-index:9999;box-shadow:-2px 0 16px rgba(0,0,0,0.15);transition:transform 0.3s;transform:translateX(100%);">
  <div style="padding:24px 24px 16px 24px;display:flex;justify-content:space-between;align-items:center;">
    <span style="font-size:20px;font-weight:bold;">Связаться с поддержкой</span>
    <button id="support-modal-close" style="background:none;border:none;font-size:24px;cursor:pointer;">&times;</button>
  </div>
  <form id="support-form" style="padding:0 24px 24px 24px;display:flex;flex-direction:column;gap:16px;">
    <textarea name="message" id="support-message" rows="6" placeholder="Опишите вашу проблему..."
              style="width:100%;padding:12px;font-size:16px;resize:vertical;"></textarea>
    <input type="hidden" name="order_id" value="<?= htmlspecialcharsbx($order['ID']) ?>">
    <button type="submit"
            style="background:#232229;color:#fff;padding:12px 0;font-size:16px;border:none;border-radius:4px;cursor:pointer;">
      Отправить
    </button>
    <div id="support-form-success" style="display:none;color:green;font-size:15px;">Сообщение отправлено!</div>
    <div id="support-form-error" style="display:none;color:red;font-size:15px;"></div>
  </form>
</div>

<style>
    .support-modal {
        box-sizing: border-box;
    }

    @media (max-width: 500px) {
        .support-modal {
            width: 100vw;
        }
    }
</style>
