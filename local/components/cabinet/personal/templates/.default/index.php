<?php
    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<main class="profile">
    <?require "left-menu.php";?>
    <div style="opacity: 1; transform: none;">
        <div class="right-container">
            <div class="profile-container">
                <div class="profile-info">
                    <h1 class="common-profile-title"><?=$arResult['USER']['NAME'] ? $arResult['USER']['NAME'] : '<Имя: не указано>' ?></h1>
                    <?/*
                    <div class="profile-info__loyalty">
                        <p>Программа лояльности</p>
                        <p>№32542552</p>
                    </div>
                    */?>
                    <div class="profile-info__discount">
                        <p>
                            <strong>Скидка по программе:</strong><br/><br/>
                            Каждая покупка в ívolga приносит вам 2 бонусных балла за каждые 100 рублей, которые вы потратили. Расходы на доставку при этом не учитываются.<br/><br/>
                            1 бонусный балл = 1 российский рубль. Оплатить баллами можно не больше 50% стоимости покупки, а оставшуюся часть — любым удобным способом.<br/><br/>
                            Баллы за покупку моделей со скидкой не начисляются и не списываются. Если в одном заказе есть позиции со скидкой и без, для расчета баллов будут учитываться только изделия по полной стоимости.<br/><br/>
                            Если вы оформляете возврат покупки, использованные баллы будут восстановлены на вашем бонусном счете после обработки возврата.<br/><br/>
                            Срок действия бонусных баллов — 365 дней с момента начисления.

                        </p>
                        <p>&nbsp;</p>
                    </div>
                </div>
                <div class="profile-news">
                    <h1 class="profile-news__title">Новостная рассылка</h1>
                    <p class="profile-news__description">Получайте новости об актуальных акциях и специальных коллекциях
                        бренда ívolga</p>
                    <p>Вы: <?=$arResult['USER']['UF_NOT_SUBSCRIBED'] ? 'не подписаны на новости':'подписаны на новости'?></p>
                </div>
                <?if($arResult['USER']['UF_NOT_SUBSCRIBED']):?>
                <form class="form form--gap" action="/personal/" method="post">
                    <div class="input-container"><input type="checkbox" id="personal-agreement" name="agreement"><label
                                for="personal-agreement" class="checkbox-input-label"><span>Я хочу получать новостную рассылку от
                        магазина ívolga</span></label></div><button class="primary-button" type="submit"
                                                                    disabled="">Подписаться</button>
                    <input type="hidden" name="action" value="subscribe">
                </form>
                <?else:?>
                <form class="form form--gap" action="/personal/" method="post">
                    <div class="input-container"><input type="checkbox" id="personal-agreement" name="agreement"><label
                                for="personal-agreement" class="checkbox-input-label"><span>Я не хочу получать новостную рассылку от
                        магазина ívolga</span></label></div><button class="primary-button" type="submit"
                                                                    disabled="">Отписаться</button>
                    <input type="hidden" name="action" value="subscribe">
                </form>
                <?endif;?>

                <a class="primary-button logout-confirm" href="/?logout=yes&<?=bitrix_sessid_get()?>">Выйти из профиля</a>

            </div>
        </div>
    </div>
</main>