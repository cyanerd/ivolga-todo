<?php
    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<main class="profile">
    <?require "left-menu.php";?>
    <div style="opacity: 1; transform: none;">
        <div class="right-container">
            <div class="orders-container">
                <h1 class="common-profile-title">История заказов</h1>
                <?if(empty($arResult['ORDERS'])):?>
                    <p>Пока здесь пусто</p>
                <?else:?>
                    <ul class="orders-list">
                        <?foreach ($arResult['ORDERS'] as $arOrder):?>
                            <li class="orders-item">
                                <p>#<?=$arOrder['ID']?></p>
                                <p><?=number_format($arOrder['PRICE_DELIVERY'] + $arOrder['PRICE'], 0, '' ,' ')?>₽</p>
                                <p><?=$arOrder['DATE_INSERT']->format("d.m.Y")?></p>
                                <a class="primary-button" href="/personal/order_detail/<?=$arOrder['ID']?>/">Детали</a>
                            </li>
                        <?endforeach?>
                    </ul>
                <?endif?>
            </div>
        </div>
    </div>
</main>