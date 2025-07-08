<?php
    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<main class="profile">
    <?require "left-menu.php";?>
    <div style="opacity: 1; transform: none;">
        <div class="right-container">
            <div class="addresses-container">
                <h1 class="common-profile-title">Адресная книга</h1>
                <?if(empty($arResult['ADDRESS'])):?>
                    <p>Пока здесь пусто</p>
                <?else:?>
                    <ul class="addresses-list">
                        <? foreach ($arResult['ADDRESS'] as $arItem): ?>
                            <li class="addresses-item" id="addr<?=$arItem['ID']?>">
                                <p><?=$arItem['NAME']?></p>
                                <p><?=$arItem['ADDRESS']?></p>
                                <div style="display: flex; gap: 10px;">
                                    <a class="primary-button" href="/personal/change_addresses/?id=<?=$arItem['ID']?>">Изменить</a>
                                    <a class="primary-button" href="javascript: del_addr(<?=$arItem['ID']?>)">Удалить</a>
                                </div>
                            </li>
                        <? endforeach ?>
                    </ul>
                <?endif;?>
                <a class="primary-button" href="/personal/new-address/">Добавить новый адрес</a>
            </div>
        </div>
    </div>
</main>