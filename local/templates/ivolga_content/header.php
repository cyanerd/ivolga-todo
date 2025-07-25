<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/local/templates/ivolga/header.php'
?>
<main class="faq container">
    <div class="faq-menu">
        <h1 class="faq-menu__title">Помощь покупателю</h1>
        <?$APPLICATION->IncludeComponent(
            "bitrix:menu",
            "left",
            array(
                "ROOT_MENU_TYPE" => "left_content",
                "MENU_CACHE_TYPE" => "A",
                "MENU_CACHE_TIME" => "36",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "MENU_THEME" => "site",
                "CACHE_SELECTED_ITEMS" => "N",
                "MENU_CACHE_GET_VARS" => array(
                ),
                "MAX_LEVEL" => "1",
                "USE_EXT" => "N",
                "DELAY" => "N",
                "ALLOW_MULTI_SELECT" => "N",
                "CHILD_MENU_TYPE" => ""
            ),
            false
        );?>
    </div>
    <div style="opacity: 1; transform: none;">
        <div class="faq-info">
            <h1 class="faq-info__title"><?$APPLICATION->ShowTitle();?></h1>
