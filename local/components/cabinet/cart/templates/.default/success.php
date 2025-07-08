<div class="checkout-status">
    <h1>Заказ #<?=$arResult['ORDER_ID']?> оформлен</h1>
    <p>Благодарим вас за покупку в интернет-магазине ívolga! Ваш заказ успешно оформлен. Отследить
        статус заказа можно в личном кабинете. Номер вашего заказа #<?=$arResult['ORDER_ID']?></p>
    <a href="/catalog/" class="primary-button" type="button">Перейти в каталог</a>

    <?if($arResult['PAY_CONTENT']):?>
    <div id="payment_block">
        <?=$arResult['PAY_CONTENT']?>
    </div>
    <?endif?>
</div>