<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Page\Asset;
IncludeTemplateLangFile(__FILE__);
global $USER;
global $APPLICATION;
$cur_page = $APPLICATION->GetCurPage(false);
?>
<!DOCTYPE html>
<html lang='ru'>

<head>
    <?
    Asset::getInstance()->addString("<meta charset='utf-8'/>");
    Asset::getInstance()->addString("<meta name='viewport' content='width=device-width, initial-scale=1'/>");
    Asset::getInstance()->addString("<meta name='theme-color' content='#000000'/>");

    Asset::getInstance()->addCss("/assets/fonts/fonts.css");
    Asset::getInstance()->addCss("/assets/main.css");
    Asset::getInstance()->addCss("/assets/style.css");
    Asset::getInstance()->addCss("/assets/new.css");
    ?>
    <title><?$APPLICATION->ShowTitle();?></title>
    <?$APPLICATION->ShowHead();?>
</head>

<body>
<?$APPLICATION->ShowPanel();?>
<div id="root" class="body-container">
    <div class="App">
        <div></div>
        <div style="opacity: 1; transform: none;">
            <header class="main-header fixed container'mobile">
                <div class="main-header__logo"><a class="active" href="/" aria-current="page"><img
                                src="/assets/img/icons/logo.svg" alt="logo"></a></div>
                <nav class="main-header__nav">
                    <ul class="main-header__list">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "top",
                        array(
                            "ROOT_MENU_TYPE" => "top",
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
                    </ul>
                </nav>
                <div class="main-header__buttons">
                    <ul class="main-header__buttons-list">
                        <li class="main-header__buttons-item">
                            <button class="main-header__button modal-button"
                                    data-src=".search-modal">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <g id="Icon">
                                        <g id="Group 35">
                                            <circle id="Ellipse 5" cx="8.57171" cy="8.57114" r="5.21429"
                                                    stroke="black"></circle>
                                            <line id="Line 41" x1="11.7823" y1="12.5033" x2="17.4965" y2="18.2176"
                                                  stroke="black"></line>
                                        </g>
                                    </g>
                                </svg>
                            </button>
                        </li>
                        <li class="main-header__buttons-item">
                            <?if($cur_page !='/checkout/'):?>
                            <button class="main-header__button<?/* modal-button" data-src=".basket-modal*/?>" onclick="return opencart()">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <g id="Icon">
                                        <path id="Ellipse 7"
                                              d="M12.8569 7.14279C12.8569 5.56483 11.5777 4.28564 9.99972 4.28564C8.42176 4.28564 7.14258 5.56483 7.14258 7.14279"
                                              stroke="black"></path>
                                        <rect id="Rectangle 153" x="3.35742" y="7.64282" width="13.2857" height="9"
                                              fill="white"
                                              stroke="black"></rect>
                                    </g>
                                </svg>
                            </button>
                            <?else:?>
                                <a class="main-header__button" href="/checkout/">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g id="Icon">
                                            <path id="Ellipse 7"
                                                  d="M12.8569 7.14279C12.8569 5.56483 11.5777 4.28564 9.99972 4.28564C8.42176 4.28564 7.14258 5.56483 7.14258 7.14279"
                                                  stroke="black">
                                            </path>
                                            <rect id="Rectangle 153" x="3.35742" y="7.64282" width="13.2857" height="9"
                                                  fill="white"
                                                  stroke="black">
                                            </rect>
                                        </g>
                                    </svg>
                                </a>
                            <?endif?>
                        </li>
                        <li class="main-header__buttons-item">
                            <? if ($USER->IsAuthorized()): ?>
                                <a class="main-header__button" href="/personal/">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g id="Icon" clip-path="url(#clip0_903_1614)">
                                            <circle id="Ellipse 6" cx="9.99958" cy="7.14289" r="3.78571"
                                                    stroke="black"></circle>
                                            <rect id="Rectangle 152" x="3.35742" y="13.3572" width="13.2857"
                                                  height="14.7143" rx="3.78571"
                                                  stroke="black"></rect>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_903_1614">
                                                <rect width="20" height="20" fill="white"></rect>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                            <? else: ?>
                                <button class="main-header__button modal-button"
                                        data-src=".profile-modal">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g id="Icon" clip-path="url(#clip0_903_1614)">
                                            <circle id="Ellipse 6" cx="9.99958" cy="7.14289" r="3.78571"
                                                    stroke="black"></circle>
                                            <rect id="Rectangle 152" x="3.35742" y="13.3572" width="13.2857"
                                                  height="14.7143" rx="3.78571"
                                                  stroke="black"></rect>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_903_1614">
                                                <rect width="20" height="20" fill="white"></rect>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </button>
                            <? endif ?>
                        </li>
                        <li class="main-header__buttons-item mobile-menu">
                            <button class="nav-mobile-btn modal-button" data-src=".mobile-header__nav">
                                <div class="mobile-line"></div>
                                <div class="mobile-line"></div>
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="modal-right subscribe-modal">
                    <div class="modal-top-content modal-right-content">
                        <div class="modal-right-heading">
                            <p>Подписка</p>
                            <button class="close-button"><img src="/assets/img/icons/close.svg" alt="close"></button>
                        </div>
                        <div class="search-container">
                            <p>Вы были подписаны на новостные рассылки!</p>
                            <p>В любой момент Вы можете отписаться в <a href="/personal/">личном кабинете</a></p>
                        </div>
                    </div>
                </div>
                <div class="modal-right subscribe-n-modal">
                    <div class="modal-top-content modal-right-content">
                        <div class="modal-right-heading">
                            <p>Подписка</p>
                            <button class="close-button"><img src="/assets/img/icons/close.svg" alt="close"></button>
                        </div>
                        <div class="search-container">
                            <p>Вы отписались от новостной рассылки!</p>
                            <p>В любой момент Вы можете подписаться в <a href="/personal/">личном кабинете</a></p>
                        </div>
                    </div>
                </div>

                <div class="modal-right search-modal">
                    <div class="modal-right-content">
                        <div class="modal-right-heading">
                            <p>Поиск</p>
                            <button class="close-button"><img src="/assets/img/icons/close.svg" alt="close"></button>
                        </div>
                        <form class="form" action="/search/index.php">
                            <div class="search-container">
                                <div class="search-container">
                                    <input type="text" placeholder="Поиск по каталогу" class="search-input" name="q">
                                </div>
                                <button class="search-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="21"
                                         viewBox="0 0 28 21" fill="none">
                                        <g clip-path="url(#clip0_1128_3180)">
                                            <line x1="1" y1="9.69238" x2="26" y2="9.69238" stroke="black"></line>
                                            <path d="M17.5435 18.1938L26.0293 9.70801L17.5435 1.22223"
                                                  stroke="black"></path>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1128_3180">
                                                <rect width="28" height="20" fill="white"
                                                      transform="matrix(-1 0 0 -1 28 20.1924)"></rect>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </button>
                            </div>
                        </form>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:news.list",
                            "rec",
                            Array(
                                "IBLOCK_ID" => 25,
                                "NEWS_COUNT" => 10,
                                "SET_TITLE" => "N",
                                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                                "CACHE_FILTER" => "N",
                                "DISPLAY_TOP_PAGER" => "N",
                                "DISPLAY_BOTTOM_PAGER" => "N",
                            ),
                            $component
                        );?>
                    </div>
                </div>
                <div class="modal-right basket-modal">
                    <?if($cur_page !='/checkout/'):?>
                    <div class="modal-right-content basket-container" id="basket-js__content">
                    </div>
                    <?endif?>
                </div>
                <div class="modal-right profile-modal">
                    <div class="modal-right-content profile-modal__step profile-modal__step--1">
                        <div class="modal-right-heading">
                            <p>Вход</p>
                            <button class="close-button"><img src="/assets/img/icons/close.svg" alt="close"></button>
                        </div>
                        <div class="auth-modal-title">
                            <h1 class="auth-modal-title__heading">Войдите в аккаунт или продолжите как гость</h1>
                            <p>Зарегистрируйтесь или войдите в свой аккаунт, чтобы воспользоваться программой
                                лояльности</p>
                        </div>
                        <div class="auth-modal-buttons">
                            <button class="primary-button-active">Войти /
                                Зарегистрироваться
                            </button>
                            <button class="primary-button">Продолжить как
                                гость
                            </button>
                        </div>
                    </div>

                    <div class="modal-right-content profile-modal__step profile-modal__step--2 hide">
                        <div class="modal-right-heading">
                            <p>Вход в аккаунт</p>
                            <button class="close-button"><img src="/assets/img/icons/close.svg"
                                                              alt="close"></button>
                        </div>
                        <div class="auth-modal-title">
                            <h1 class="auth-modal-title__heading">Войти или зарегистрироваться</h1>
                            <p>Мы отправим на номер SMS-сообщение с кодом подтверждения.</p>
                        </div>
                        <form class="form form--gap" id="form--send--sms">
                            <div class="input-container"><label class="input-label" for="phone">Ваш номер
                                    телефона</label><input class="input mobile-phone-input js_phone" id="phone"
                                                           placeholder="+7 (___) ___-__-__" name="phone"></div>
                            <button class="primary-button" type="submit"
                                    disabled="">Отправить
                            </button>
                        </form>
                    </div>

                    <div class="modal-right-content profile-modal__step profile-modal__step--3 hide">
                        <div class="modal-right-heading">
                            <button class="back-button"><img src="/assets/img/icons/arrow-left.svg"
                                                             alt="">
                                <p>Назад</p>
                            </button>
                            <button class="close-button"><img src="/assets/img/icons/close.svg" alt="close"></button>
                        </div>
                        <div class="auth-modal-title">
                            <h1 class="auth-modal-title__heading">Подтвердите номер</h1>
                            <p>Мы отправили код на номер </p>
                            <div id="check--error"></div>
                        </div>
                        <form class="form form--gap" id="form--verify--sms">
                            <div class="input-container"><label class="input-label" for="verificationCode">Код из
                                    SMS</label><input class="input " id="verificationCode" placeholder="----"
                                                      maxlength="4"
                                                      name="verificationCode"></div>
                            <div class="auth-modal-buttons"><button class="primary-button"
                                                               type="submit"
                                                               >Подтвердить телефон</button>
                                <button id="get--code--repeat" class="primary-button" type="button">Получить
                                    код повторно
                                </button>
                            </div>
                            <input type="hidden" name="phone" id="verifed--phone" />
                        </form>
                    </div>
                </div>
            </header>
            <nav class="mobile-header__nav" style="">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section.list",
                    "desk",
                    array(
                        "ADDITIONAL_COUNT_ELEMENTS_FILTER" => "additionalCountFilter",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "COUNT_ELEMENTS" => "Y",
                        "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
                        "FILTER_NAME" => "sectionsFilter",
                        "HIDE_SECTIONS_WITH_ZERO_COUNT_ELEMENTS" => "N",
                        "IBLOCK_ID" => "29",
                        "IBLOCK_TYPE" => "CRM_PRODUCT_CATALOG",
                        "SECTION_CODE" => "",
                        "SECTION_FIELDS" => array("", ""),
                        "SECTION_ID" => "",
                        "SECTION_URL" => "",
                        "SECTION_USER_FIELDS" => array("", ""),
                        "SHOW_PARENT_NAME" => "Y",
                        "TOP_DEPTH" => "2",
                        "VIEW_MODE" => "LINE",
                    )
                ); ?>
                <ul class="mobile-header__list">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "top",
                        array(
                            "ROOT_MENU_TYPE" => "top",
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
                </ul>
            </nav>
            <div style="opacity: 1; transform: none;">