<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
global $USER;
if (!$USER->IsAuthorized()) {
  LocalRedirect('/');
  die();
}

\Bitrix\Main\Loader::includeModule('mindbox.loyalty');
global $USER;
$customer = new \Mindbox\Loyalty\Models\Customer($USER->IsAuthorized() ? (int)$USER->GetID() : null);
$customerInfo = \Mindbox\Loyalty\Operations\GetCustomerInfo::make()->execute($customer->getDto());

$balanceFields = $customerInfo->getResult()->getBalances()?->getFieldsAsArray();
$settings = \Mindbox\Loyalty\Support\SettingsFactory::create();
$balanceSystemName = $settings->getBalanceSystemName();

if (!empty($balanceSystemName)) {
    foreach ($balanceFields as $balanceField) {
        if ($balanceField['systemName'] === $balanceSystemName) {
            $arBalance = $balanceField;
        }
    }
}

if (empty($arBalance)) {
    $arBalance = is_array($balanceFields) ? reset($balanceFields) : [];
}

$bonuses = [
    'available' => $arBalance['available'],
    'available_format' => \CCurrencyLang::CurrencyFormat((int)$arBalance['available'], 'RUB'),
    'blocked' => $arBalance['blocked'],
    'blocked_format' => \CCurrencyLang::CurrencyFormat((int)$arBalance['blocked'], 'RUB'),
];
?>

<section class="infopage lk">
    <div class="infopage__wrap">
        <div class="container">
            <div class="infopage__row">
                <?php include __DIR__ . '/../menu.php'; ?>
                <div class="infopage__main">
                    <h1 class="lk__title">
                        Бонусный баланс
                    </h1>

                    <p style="font-size: 14px;">На вашем бонусном счету <?=$bonuses['available_format']?></p>
                    <?
                    // в случае чего использовать компонент
                    /*$APPLICATION->IncludeComponent(
                        "mindbox:loyalty.program",
                        "",
                        Array(
                            "CURRENCY_ID" => "RUB",
                            "HISTORY_DATE_FORMAT" => "d.m.Y",
                            "HISTORY_ENABLE" => "Y",
                            "HISTORY_PAGE_SIZE" => "20",
                            "LEVEL_NAMES_LOYALTY" => array("Серебряный", "Золотой", "Платиновый"),
                            "LEVEL_PRICES_LOYALTY" => array("10000", "50000", "100000"),
                            "LOYALTY_ENABLE" => "Y",
                            "SEGMETS_LOYALTY" => array("e8aba66d-0a35-47ca-b68d-b9ce399d5134", "481b935d-f547-4be5-bc3d-39c63deb00dc", "f929cc91-641b-4476-8710-c5a390467c1c")
                        )
                    );*/?>

                </div>
            </div>
        </div>
    </div>
</section>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
