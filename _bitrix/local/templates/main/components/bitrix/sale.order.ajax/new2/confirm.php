<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

if ($arParams["SET_TITLE"] == "Y") {
  $APPLICATION->SetTitle(Loc::getMessage("SOA_ORDER_COMPLETE"));
}
?>

<? if (!empty($arResult["ORDER"])): ?>


  <section class="orderproceed">
    <div class="orderproceed__wrap1">
      <div class="container">
        <div class="orderproceed__content">
          <p class="orderproceed__title">
            Заказ №<?= htmlspecialcharsbx($arResult["ORDER"]["ACCOUNT_NUMBER"]) ?> успешно создан
          </p>
          <?
          if ($arResult["ORDER"]["IS_ALLOW_PAY"] === 'Y') {
            ?>
            <div class="orderproceed__txt">
              <?
              if (!empty($arResult["PAYMENT"])) {
                foreach ($arResult["PAYMENT"] as $payment) {
                  if ($payment["PAID"] != 'Y') {
                    if (!empty($arResult['PAY_SYSTEM_LIST']) && array_key_exists($payment["PAY_SYSTEM_ID"], $arResult['PAY_SYSTEM_LIST'])) {
                      $arPaySystem = $arResult['PAY_SYSTEM_LIST_BY_PAYMENT_ID'][$payment["ID"]];
                    if (empty($arPaySystem["ERROR"])) { ?>
                      <p class="pay_name"><?= Loc::getMessage("SOA_PAY") ?></p>
                    <?= CFile::ShowImage($arPaySystem["LOGOTIP"], 100, 100, "border=0\" style=\"width:100px; margin: 16px 0;\"", "", false) ?>
                      <div class="paysystem_name"><?= $arPaySystem["NAME"] ?></div>

                    <? if ($arPaySystem["ACTION_FILE"] <> '' && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
                    <?
                    $orderAccountNumber = urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]));
                    $paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
                    ?>
                      <script>
                        window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>');
                      </script>
                    <?= Loc::getMessage("SOA_PAY_LINK", ["#LINK#" => $arParams["PATH_TO_PAYMENT"] . "?ORDER_ID=" . $orderAccountNumber . "&PAYMENT_ID=" . $paymentAccountNumber]) ?>
                    <? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
                    <br/>
                    <?= Loc::getMessage("SOA_PAY_PDF", ["#LINK#" => $arParams["PATH_TO_PAYMENT"] . "?ORDER_ID=" . $orderAccountNumber . "&pdf=1&DOWNLOAD=Y"]) ?>
                    <? endif ?>
                    <? else: ?>
                      <div class="_buffered-output">
                        <?= $arPaySystem["BUFFERED_OUTPUT"] ?>
                      </div>
                    <? endif ?>
                    <?
                    } else {
                    ?>
                      <span style="color:red;"><?= Loc::getMessage("SOA_ORDER_PS_ERROR") ?></span>
                    <?
                    }
                    } else {
                    ?>
                      <span style="color:red;"><?= Loc::getMessage("SOA_ORDER_PS_ERROR") ?></span>
                      <?
                    }
                  }
                }
              }
              ?>

              <div class="orderproceed__buttons" style="margin-top: 30px;">
              <a href="/catalog" class="orderproceed__buttons-tocat">
                Перейти в каталог
              </a>
              </div>

            </div> <?
          } else { ?>
            <div class="orderproceed__txt">
              Благодарим вас за покупку в интернет-магазине Ivolga!
              Номер вашей
              оплаты: <?= htmlspecialcharsbx($arResult['PAYMENT'][$arResult['ORDER']["PAYMENT_ID"]]['ACCOUNT_NUMBER']) ?>.
              Вы можете следить за выполнением своего заказа в <a href="/personal">Персональном разделе сайта.</a>
            </div>
            <div class="orderproceed__buttons">
              <a href="/personal" class="orderproceed__buttons-check">
                отслеживать заказ
              </a>
              <a href="/catalog" class="orderproceed__buttons-tocat">
                Перейти в каталог
              </a>
            </div>
          <? } ?>
        </div>
      </div>
    </div>
  </section>

  <? /*
  <table class="sale_order_full_table">
    <tr>
      <td>
        111
        <?= Loc::getMessage("SOA_ORDER_SUC", [
          "#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"]->toUserTime()->format('d.m.Y H:i'),
          "#ORDER_ID#" => htmlspecialcharsbx($arResult["ORDER"]["ACCOUNT_NUMBER"])
        ]) ?>
        /111
        222
        <? if (!empty($arResult['ORDER']["PAYMENT_ID"])): ?>
          <?= Loc::getMessage("SOA_PAYMENT_SUC", [
            "#PAYMENT_ID#" => htmlspecialcharsbx($arResult['PAYMENT'][$arResult['ORDER']["PAYMENT_ID"]]['ACCOUNT_NUMBER'])
          ]) ?>
        <? endif ?>
        /222
        333
        <? if ($arParams['NO_PERSONAL'] !== 'Y'): ?>
          <br/><br/>
          <?= Loc::getMessage('SOA_ORDER_SUC1', ['#LINK#' => $arParams['PATH_TO_PERSONAL']]) ?>
        <? endif; ?>
        /333
      </td>
    </tr>
  </table>
 */ ?>

  <?
  /*
    if ($arResult["ORDER"]["IS_ALLOW_PAY"] === 'Y') {
      if (!empty($arResult["PAYMENT"])) {
        foreach ($arResult["PAYMENT"] as $payment) {
          if ($payment["PAID"] != 'Y') {
            if (!empty($arResult['PAY_SYSTEM_LIST'])
              && array_key_exists($payment["PAY_SYSTEM_ID"], $arResult['PAY_SYSTEM_LIST'])
            ) {
              $arPaySystem = $arResult['PAY_SYSTEM_LIST_BY_PAYMENT_ID'][$payment["ID"]];

              if (empty($arPaySystem["ERROR"])) {
                ?>
                <br/><br/>

                <table class="sale_order_full_table">
                  <tr>
                    <td class="ps_logo">
                      <div class="pay_name"><?= Loc::getMessage("SOA_PAY") ?></div>
                      <?= CFile::ShowImage($arPaySystem["LOGOTIP"], 100, 100, "border=0\" style=\"width:100px\"", "", false) ?>
                      <div class="paysystem_name"><?= $arPaySystem["NAME"] ?></div>
                      <br/>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <? if ($arPaySystem["ACTION_FILE"] <> '' && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
                        <?
                        $orderAccountNumber = urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]));
                        $paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
                        ?>
                        <script>
                          window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>');
                        </script>
                      <?= Loc::getMessage("SOA_PAY_LINK", ["#LINK#" => $arParams["PATH_TO_PAYMENT"] . "?ORDER_ID=" . $orderAccountNumber . "&PAYMENT_ID=" . $paymentAccountNumber]) ?>
                      <? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
                      <br/>
                        <?= Loc::getMessage("SOA_PAY_PDF", ["#LINK#" => $arParams["PATH_TO_PAYMENT"] . "?ORDER_ID=" . $orderAccountNumber . "&pdf=1&DOWNLOAD=Y"]) ?>
                      <? endif ?>
                      <? else: ?>
                        <?= $arPaySystem["BUFFERED_OUTPUT"] ?>
                      <? endif ?>
                    </td>
                  </tr>
                </table>

                <?
              } else {
                ?>
                <span style="color:red;"><?= Loc::getMessage("SOA_ORDER_PS_ERROR") ?></span>
                <?
              }
            } else {
              ?>
              <span style="color:red;"><?= Loc::getMessage("SOA_ORDER_PS_ERROR") ?></span>
              <?
            }
          }
        }
      }
    } else {
      ?>
      <br/><strong><?= $arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR'] ?></strong>
      <?
    } */
  ?>

<? else: ?>

  <b><?= Loc::getMessage("SOA_ERROR_ORDER") ?></b>
  <br/><br/>

  <table class="sale_order_full_table">
    <tr>
      <td>
        <?= Loc::getMessage("SOA_ERROR_ORDER_LOST", ["#ORDER_ID#" => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"])]) ?>
        <?= Loc::getMessage("SOA_ERROR_ORDER_LOST1") ?>
      </td>
    </tr>
  </table>

<? endif ?>
