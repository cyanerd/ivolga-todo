<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<main class="profile">
    <? require "left-menu.php"; ?>
    <div style="opacity: 1; transform: none;">
        <div class="right-container">
            <div class="settings-container">
                <h1 class="common-profile-title">Настройки профиля</h1>
                <?if($arResult['updated']):?>
                    <p style="color: green">Данные обновлены!</p>
                <?endif?>
                <form class="form" action="/personal/" method="post">
                    <div class="form__container">
                        <div class="input-container"><label class="input-label" for="firstName">Имя</label>
                            <input class="input " id="firstName" placeholder="Имя" name="firstName" required value="<?=$arResult['USER']['NAME']?>">
                        </div>
                        <div class="input-container"><label class="input-label" for="lastName">Фамилия</label>
                            <input class="input " id="lastName" placeholder="Фамилия" name="lastName" value="<?=$arResult['USER']['LAST_NAME']?>">
                        </div>
                        <div class="input-container"><label class="input-label" for="dateOfBirth">Дата
                                рождения</label>
                            <input min="1800-01-01" max="2999-12-31" class="input " type="date" id="dateOfBirth" name="dateOfBirth" value="<?=$arResult['USER']['PERSONAL_BIRTHDATE']?>">
                        </div>
                        <div class="input-container"><label class="input-label" for="email">Эл. почта</label>
                            <input type="email" class="input " placeholder="olga@ivolga.com" id="email" name="email" value="<?=$arResult['USER']['EMAIL']?>">
                        </div>
                        <div class="input-container"><label class="input-label">Телефон</label>
                            <input class="input-readonly"
                                    placeholder="<?=$arResult['USER']['PERSONAL_PHONE']?>" readonly="">
                        </div>
                    </div>
                    <div class="form__bottom-container">
                        <div class="form-checkbox">
                            <div class="input-container"><input type="checkbox" id="personal-agreement"
                                                                name="personal-agreement"><label
                                        for="personal-agreement" class="checkbox-input-label"><span>Я
                                        даю согласие на <a href="/privacy/" target="_blank">обработку персональных данных</a></span></label></div>
                        </div>
                        <button class="primary-button" type="submit" disabled="">Сохранить</button>
                    </div>
                    <input type="hidden" name="action" value="update_user" />
                </form>
            </div>
        </div>
    </div>
</main>