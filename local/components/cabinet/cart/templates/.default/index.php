<?php
    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<?if(empty($arResult['BASKET']['BASKET_ITEMS'])):?>
    <main class="checkout-content" style="justify-content: center;">
        <p>Корзина пуста</p>
    </main>
    <? return false; ?>
<?endif;?>
<script id="ISDEKscript" type="text/javascript" src="https://widget.cdek.ru/widget/widjet.js" charset="utf-8"></script>
<script type="text/javascript">
    var widjet = new ISDEKWidjet({
        defaultCity: 'Москва', //какой город отображается по умолчанию
        cityFrom: 'Москва', // из какого города будет идти доставка
        country: 'Россия', // можно выбрать страну, для которой отображать список ПВЗ
        path: '/widget/scripts/', //директория с библиотеками
        servicepath: '/widget/scripts/service.php', //ссылка на файл service.php на вашем сайте
        apikey: '32d3c924-b5e2-4e9b-9094-93dde8e2e9d0',
        link: false,
        popup: true,
        choose: true,
        hidedelt: true,
        hidedress: true,
        hidecash: true,
        onReady: function () { // на загрузку виджета отобразим информацию о доставке до ПВЗ
            $('.pickup-shipping__title-address').html('');
        },
        onChoose: function (info) { // при выборе ПВЗ: запишем информацию в текстовые поля
            $('.pickup-shipping__title-address').html('г.' + info.cityName + ', ' + info.PVZ.Address);
        }
    });
</script>
<main class="checkout-content">
    <div class="checkout-config-container">
        <?if(!$arResult['USER']):?>
        <div class="checkout-config">
            <p><a href="#" class="modal-button" data-src=".profile-modal">Авторизуйтесь</a>, чтобы не вводить данные каждый раз!</p>
        </div>
        <?endif?>
        <div class="checkout-config active">
            <button class="configuration">
                <div class="configuration-head">
                    <h1 class="title-1">Адрес и доставка</h1>
                    <div class="configuration-head__icon"></div>
                </div>
            </button>
            <div style="opacity: 1; transform: none;">
                <div class="form checkout-form">
                    <div class="configuration-content">
                        <div class="configuration-buttons">
                            <?foreach ($arResult['DELIVERY_TYPES'] as $key=>$delivery):?>
                            <div class="configuration-buttons__wrapper">
                                <button data-type="delivery" class="delivery-button<?=($key == 0) ? ' active' : ''?>" data-id="<?=$delivery['ID']?>">
                                    <div class="delivery-header__title">
                                        <p><?=$delivery['NAME']?></p>
                                        <p><span><?=$delivery['DESCRIPTION']?></span></p>
                                    </div>
                                    <div class="delivery-header__price">
                                        <p>
                                            <?=in_array($delivery['ID'], [193, 195]) ? 'от ' : ''?>
                                            <?=$delivery['PRICE'] == 0 ? 'бесплатно' : $delivery['PRICE'].'&nbsp;₽'?>
                                        </p>
                                    </div>
                                </button>
                            </div>
                            <?endforeach;?>
                        </div>
                        <div style="opacity: 1; transform: none;">
                            <form id="address_delivery_form">
                                <div class="shipping-content cart-block" id="address_delivery">
                                    <?if(!empty($arResult['ADDRESSES'])):?>
                                        <div class="input-container city-container">
                                            <label class="input-label" for="addr">Указать адрес <small>(можете задать в личном кабинете)</small></label>
                                            <select name="addr" id="addr" class="select-input ">
                                                <option>Выбрать</option>
                                                <?foreach ($arResult['ADDRESSES'] as $address):?>
                                                    <option value="<?=$address['ID']?>"><?=$address['NAME']?></option>
                                                <?endforeach;?>
                                            </select>
                                        </div>
                                    <?endif?>
                                    <div class="input-container"><label class="input-label" for="address">Адрес доставки</label><input
                                                class="input " placeholder="Улица Большая Никитская, 2, кв. 21" id="address"
                                                name="address">
                                    </div>
                                    <div class="input-container"><label class="input-label" for="comment">Комментарий к
                                            заказу</label><textarea class="textarea-input " id="comment"
                                                                    placeholder="Позвоните за 2 часа, этаж 2, домофон 54667457" name="comment"></textarea>
                                    </div>

                                </div>
                            </form>
                            <div class="pickup-shipping cart-block" id="pickup">
                                <div class="pickup-shipping__title">
                                    <p>СДЭК</p>
                                    <p class="pickup-shipping__title-address" id="cdek"></p>
                                </div>
                                <button class="primary-button modal-button" onclick="widjet.open()" type="button">Изменить адрес</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="checkout-config">
            <button class="configuration">
                <div class="configuration-head">
                    <h1 class="title-1">Получатель</h1>
                    <div class="configuration-head__icon"></div>
                </div>
            </button>
            <div style="opacity: 1; transform: none;">
                <form class="checkout-form" id="checkout-form">
                    <div class="form__container">
                        <div class="input-container"><label class="input-label" for="firstName">Имя</label><input
                                    class="input " id="firstName" placeholder="Имя" name="firstName" value="<?=$arResult['USER']['NAME']?>"></div>
                        <div class="input-container"><label class="input-label" for="lastName">Фамилия</label><input
                                    class="input " id="lastName" placeholder="Фамилия" name="lastName" value="<?=$arResult['USER']['LAST_NAME']?>"></div>
                        <div class="input-container"><label class="input-label" for="email">Эл. почта</label><input
                                    class="input " placeholder="olga@ivolga.com" id="email" name="email" value="<?=$arResult['USER']['EMAIL']?>"></div>
                        <div class="input-container"><label class="input-label" for="phone">Ваш номер
                                телефона</label>
                            <input class="input js_phone" id="phone" placeholder="+7 (___) ___-__-__"
                                                       name="phone" value="<?=$arResult['USER']['PERSONAL_PHONE'] ? '+'.$arResult['USER']['PERSONAL_PHONE'] : ''?>"></div>
                        <div class="input-container">
                            <input type="checkbox" id="agreementp" name="personal-agreementp" value="Y">
                            <label for="agreementp" class="checkbox-input-label">
                                <span>Я даю согласие на <a href="/privacy/" target="_blank">обработку персональных данных</a></span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="checkout-config">
            <button class="configuration">
                <div class="configuration-head">
                    <h1 class="title-1">Оплата</h1>
                    <div class="configuration-head__icon"></div>
                </div>
            </button>
            <div style="opacity: 1; transform: none;">
                <form class="checkout-form form payment-checkout">
                    <div class="form__container">
                        <?foreach ($arResult['PAYMENTS'] as $payment):?>
                        <div class="input-container">
                            <input type="radio" id="option<?=$payment['ID']?>" name="radio-name" value="<?=$payment['ID']?>">
                            <label for="option<?=$payment['ID']?>" class="radio-input-label"><span><?=$payment['NAME']?></span></label>
                        </div>
                        <?endforeach;?>
                    </div>
                </form>
            </div>
        </div>
        <div class="form__bottom-container">
            <div class="form-checkbox">
                <div class="input-container">
                    <input type="checkbox" id="personal-agreement" name="agreement"><label for="personal-agreement"
                                                                                           class="checkbox-input-label">
                      <span>Я согласен с <a href="/privacy/"> условиями
                          интернет-магазина</a>
                          ívolga
                      </span>
                    </label>
                </div>
            </div>
            <div id="error-container"></div>
            <button id="order_create" class="primary-button" type="button">Подтвердить заказ</button>
        </div>
    </div>
    <div class="checkout-order-container" id="checkout-order-container">
        <?$basket = MyTools::getBasket();$basket_body = MyTools::getBasketBodyModal($basket, 'checkout', $arResult['DELIVERY_TYPES'][0]['ID']);echo $basket_body;?>
    </div>
</main>