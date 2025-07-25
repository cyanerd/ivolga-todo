<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die('die');
IncludeTemplateLangFile(__FILE__);
?>
<?

use Bitrix\Main\Page\Asset;

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8"/>
  <meta lang="RU"/>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="theme-color" content="#ffffff">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="format-detection" content="telephone=no">
  <meta name="format-detection" content="address=no">
  <link rel="icon" href="/favicon.ico">
  <link href="<?= TP ?>fonts/Pragmatica-Book.842677ed598abca93979.woff2" rel="preload" as="font" crossorigin="">
  <link href="<?= TP ?>fonts/Pragmatica-Book.bce5690e59930466c670.woff" rel="preload" as="font" crossorigin="">
  <link href="<?= TP ?>fonts/Steinbeck-Regular.083be5b679d999fdbcf1.woff2" rel="preload" as="font" crossorigin="">
  <link href="<?= TP ?>fonts/Steinbeck-Regular.5a451630a016d4e2df07.woff" rel="preload" as="font" crossorigin="">
  <script defer="defer" src="/local/templates/main/js/app.js?v=<?= time() ?>"></script>
  <script defer="defer" src="/local/templates/main/js/productCard.js"></script>

  <?
  global $APPLICATION;
  $APPLICATION->ShowHead();
  $APPLICATION->SetPageProperty('keywords', '');
  $APPLICATION->SetPageProperty('description', '');

  # Scripts
  $APPLICATION->AddHeadScript('https://code.jquery.com/jquery-3.5.1.min.js');
  $APPLICATION->AddHeadScript('https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js');
  $APPLICATION->AddHeadScript(TP . 'js/custom.js?v=' . time());
  CJSCore::Init(['fx']);

  # Stylesheets
  $APPLICATION->SetAdditionalCSS('https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css');
  $APPLICATION->SetAdditionalCSS(TP . 'css/app.css');
  $APPLICATION->SetAdditionalCSS(TP . 'css/custom.css?v=2');
  $APPLICATION->SetAdditionalCSS('/assets/css/favourite.css?v=1');
  ?>
  <title><? $APPLICATION->ShowTitle(); ?></title>
</head>

<?
$siteSettings = [];
CModule::IncludeModule('iblock');
$_MAIN = new CMain;
$axi = Axi::get();
global $USER;

$siteSettings = [
  'alert' => \COption::GetOptionString("askaron.settings", "UF_ALERT"),
  'copyright' => \COption::GetOptionString("askaron.settings", "UF_COPYRIGHT"),
  'madeby' => \COption::GetOptionString("askaron.settings", "UF_MADEBY"),
  'madebylink' => \COption::GetOptionString("askaron.settings", "UF_MADEBYLINK"),
  'phone' => \COption::GetOptionString("askaron.settings", "UF_PHONE"),
  'email' => \COption::GetOptionString("askaron.settings", "UF_EMAIL"),
  'vk' => \COption::GetOptionString("askaron.settings", "UF_VK"),
  'tg' => \COption::GetOptionString("askaron.settings", "UF_TG"),
  'ogrn' => \COption::GetOptionString("askaron.settings", "UF_OGRN"),
  'inn' => \COption::GetOptionString("askaron.settings", "UF_INN"),

  'UF_ABOUT_IMAGE' => \COption::GetOptionString("askaron.settings", "UF_ABOUT_IMAGE"),
  'UF_ABOUT_IMAGE_MOB' => \COption::GetOptionString("askaron.settings", "UF_ABOUT_IMAGE_MOB"),
  'UF_DESC' => \COption::GetOptionString("askaron.settings", "UF_DESC"),
  'UF_TITLE' => \COption::GetOptionString("askaron.settings", "UF_TITLE"),
  'UF_FOUNDER_NAME' => \COption::GetOptionString("askaron.settings", "UF_FOUNDER_NAME"),
  'UF_FOUNDER_DESC' => \COption::GetOptionString("askaron.settings", "UF_FOUNDER_DESC"),

  'UF_ADDRESS_DESC' => \COption::GetOptionString("askaron.settings", "UF_ADDRESS_DESC"),
  'UF_ADDRESS_TITLE' => \COption::GetOptionString("askaron.settings", "UF_ADDRESS_TITLE"),
  'UF_ADDRESS_TIME' => \COption::GetOptionString("askaron.settings", "UF_ADDRESS_TIME"),
  'UF_ADDRESS' => \COption::GetOptionString("askaron.settings", "UF_ADDRESS"),
  'UF_MAP_LINK' => \COption::GetOptionString("askaron.settings", "UF_MAP_LINK"),

  'UF_ABOUT' => \COption::GetOptionString("askaron.settings", "UF_ABOUT"),

  'UF_SIZE_TABLE' => \COption::GetOptionString("askaron.settings", "UF_SIZE_TABLE"),
  'UF_SIZE_TABS' => \COption::GetOptionString("askaron.settings", "UF_SIZE_TABS"),
  'UF_SIZE_TABS_CONTENT' => \COption::GetOptionString("askaron.settings", "UF_SIZE_TABS_CONTENT"),
];

$bodyClasses = [];
$headerClass = '';
if ($APPLICATION->GetCurPage() === '/') {
  $bodyClasses[] = 'index-page';
  $headerClass = 'transparent';
}

if ($APPLICATION->GetCurPage() === '/policy/') {
}

?>
<? $APPLICATION->ShowPanel() ?>
<body class="<?= implode(' ', $bodyClasses) ?>">

<div class="topblock">
  <? if ($siteSettings['alert']) { ?>
    <div class="alert-main" id="alert-main" style="display: none;">
      <span class="alert-main__text"><?= $siteSettings['alert'] ?></span>
      <button class="alert-main__close" id="alert-close">
        <svg width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M13 17.1665L7 9.1665M1 1.1665L7 9.1665M7 9.1665L13 1.1665M7 9.1665L1 17.1665" stroke="#232229"
                stroke-width="1.5"/>
        </svg>
      </button>
    </div>
  <? } ?>

  <header class="header">
    <div class="header__container _container">
      <div class="header__menu">
        <div class="header__menu-mob mobheader">
          <button class="header__menu-burger">
            <span></span><span></span>
          </button>
          <a href="/search/" class="header__button header__button--search">
            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M13.0001 6.4165C10.1006 6.4165 7.75006 8.76701 7.75006 11.6665C7.75006 13.1165 8.33686 14.4279 9.28775 15.3788C10.2386 16.3297 11.5501 16.9165 13.0001 16.9165C15.8996 16.9165 18.2501 14.566 18.2501 11.6665C18.2501 8.76701 15.8996 6.4165 13.0001 6.4165ZM6.25006 11.6665C6.25006 7.93858 9.27213 4.9165 13.0001 4.9165C16.728 4.9165 19.7501 7.93858 19.7501 11.6665C19.7501 15.3944 16.728 18.4165 13.0001 18.4165C11.4066 18.4165 9.94124 17.8636 8.78683 16.9404L5.53039 20.1968L4.46973 19.1362L7.72617 15.8797C6.80292 14.7253 6.25006 13.26 6.25006 11.6665Z"
                    fill="#232229"/>
            </svg>

          </a>
        </div>
        <?
        $APPLICATION->IncludeComponent(
          "bitrix:menu",
          "main-menu-left",
          [
            "ROOT_MENU_TYPE" => "top1",
            "MAX_LEVEL" => "3",
            "CHILD_MENU_TYPE" => "left",
            "USE_EXT" => "Y",
            "DELAY" => "N",
            "ALLOW_MULTI_SELECT" => "Y",
            "MENU_CACHE_TYPE" => "N",
            "MENU_CACHE_TIME" => "3600",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "MENU_CACHE_GET_VARS" => [],
            "COMPONENT_TEMPLATE" => "main-menu-left"
          ],
          false
        );
        ?>
        <a href="/" class="header__logo">
          <img
            src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTY4IiBoZWlnaHQ9IjY1IiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXRoIGQ9Ik0yMy4yNTUgMjMuMDYzaDMuNzIydjIxLjU4NGgtMy43MjJWMjMuMDYzWm0zLjktOS4yODFoNC42NjNsLTUuMTU1IDUuNjQ4aC0zLjIyOGwzLjcyLTUuNjQ4Wk0zMi42MTggMjMuMDYzaDMuODU2TDQzLjM4IDQxLjFsNi43MjUtMTguMDM3aDMuNjMyTDQ1LjQ0IDQ0LjY0N2gtNC4zOTRsLTguNDI5LTIxLjU4NFpNNTYuNjUgMzMuODMzYzAtNi43ODYgNC45MzItMTEuNDI2IDExLjU2Ny0xMS40MjYgNi42MzYgMCAxMS41MjMgNC42NCAxMS41MjMgMTEuNDI2IDAgNi43ODYtNC44ODcgMTEuNDctMTEuNTIzIDExLjQ3LTYuNjM1IDAtMTEuNTY3LTQuNjg0LTExLjU2Ny0xMS40N1ptMTEuNTY4IDguNDVjNC42MTggMCA3LjcxMi0zLjU0NyA3LjcxMi04LjQ5NCAwLTQuOTQ3LTMuMDUtOC4zNjItNy43MTItOC4zNjItNC43MDggMC03Ljc1NiAzLjMyOC03Ljc1NiA4LjM2MiAwIDUuMDM1IDMuMDkzIDguNDkzIDcuNzU2IDguNDkzWk04NC45MzggNDAuMzU3VjEzLjc4MmgzLjcyMXYyNi4zNTVjMCAxLjYyLjgwOCAyLjE0NSAyLjEwOCAyLjE0NWgxLjAyMnYzLjAyMWgtMS43NGMtMy40MDggMC01LjExLTEuNzk0LTUuMTEtNC45NDZaTTEyMi4xMDMgMzMuODMzYzAtNi42OTggNC4zNDktMTEuNDI2IDEwLjgwNS0xMS40MjYgNC40MzkgMCA3LjEyOSAyLjE4OSA4LjIwNSAzLjk0di0zLjI4NGgzLjYzMnYyMS41ODRoLTMuNjMyVjQxLjFjLS41ODMgMS4xMzktMy4yMjggNC4yMDMtOC4xNiA0LjIwMy02LjQ1NiAwLTEwLjg1LTQuNTk2LTEwLjg1LTExLjQ3Wm0xMS4yOTggOC40NWM0LjUyOSAwIDcuNzEyLTMuMzcxIDcuNzEyLTguNDUgMC00Ljk5LTMuMTgzLTguMzYyLTcuNzEyLTguMzYyLTQuNjE3IDAtNy42NjYgMy4xOTctNy42NjYgOC4zNjIgMCA1LjE2NiAzLjA0OSA4LjQ1IDcuNjY2IDguNDVaTTk2Ljc1IDQ1LjMwNGgzLjc2N2MuMTM0IDIuNDA4IDEuODM4IDQuNjg1IDYuNTAxIDQuNjg1IDQuMzk0IDAgNy4wODQtMi41NCA3LjA4NC03LjE4MXYtMi42OTZjLTIuMDI0IDIuMzQ2LTQuNjc1IDMuNDA0LTcuOSAzLjQwNC01Ljg0OSAwLTkuOTQ0LTQuMTE5LTkuOTQ0LTEwLjM4MyAwLTYuNzE4IDMuNzY2LTEwLjcyNiA5Ljk5OC0xMC43MjYgNC40NDcgMCA2LjY4IDIuMzIgNy44OSAzLjk0di0zLjI4M2gzLjYzMnYxOS40MzhjMCA2Ljc0Mi00LjM0OSAxMC40Mi0xMC43NiAxMC40Mi02LjU5MSAwLTkuOTA5LTIuOTMzLTEwLjI2Ny03LjYxOFptMTAuMjI4LTQuODExYzQuNDA5IDAgNy4xMjQtMy4yNSA3LjEyNC03LjQ0OCAwLTQuNTgtMi43MTUtNy42MTgtNy4xMjQtNy42MTgtNC40NTIgMC03LjA3OSAyLjk5NS03LjA3OSA3LjYxOCAwIDQuMjQxIDIuNjI3IDcuNDQ4IDcuMDc5IDcuNDQ4WiIgZmlsbD0iIzIzMjIyOSIvPjwvc3ZnPg=="
            alt="">
        </a>
        <div class="header__menu-right">
          <?
          $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "main-menu-right",
            [
              "ROOT_MENU_TYPE" => "top2",
              "MAX_LEVEL" => "3",
              "CHILD_MENU_TYPE" => "left",
              "USE_EXT" => "Y",
              "DELAY" => "N",
              "ALLOW_MULTI_SELECT" => "Y",
              "MENU_CACHE_TYPE" => "N",
              "MENU_CACHE_TIME" => "3600",
              "MENU_CACHE_USE_GROUPS" => "Y",
              "MENU_CACHE_GET_VARS" => [],
              "COMPONENT_TEMPLATE" => "main-menu-right"
            ],
            false
          );
          ?>
          <div class="header__buttons">
            <a href="/search/" class="header__button header__button--search descheader">
              <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M13.0001 6.4165C10.1006 6.4165 7.75006 8.76701 7.75006 11.6665C7.75006 13.1165 8.33686 14.4279 9.28775 15.3788C10.2386 16.3297 11.5501 16.9165 13.0001 16.9165C15.8996 16.9165 18.2501 14.566 18.2501 11.6665C18.2501 8.76701 15.8996 6.4165 13.0001 6.4165ZM6.25006 11.6665C6.25006 7.93858 9.27213 4.9165 13.0001 4.9165C16.728 4.9165 19.7501 7.93858 19.7501 11.6665C19.7501 15.3944 16.728 18.4165 13.0001 18.4165C11.4066 18.4165 9.94124 17.8636 8.78683 16.9404L5.53039 20.1968L4.46973 19.1362L7.72617 15.8797C6.80292 14.7253 6.25006 13.26 6.25006 11.6665Z"
                      fill="#232229"/>
              </svg>

            </a>
            <?php if ($USER->IsAuthorized()): ?>
              <a href="/personal/" class="header__button">
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M12 6.4165C9.65279 6.4165 7.75 8.31929 7.75 10.6665C7.75 13.0137 9.65279 14.9165 12 14.9165C14.3472 14.9165 16.25 13.0137 16.25 10.6665C16.25 8.31929 14.3472 6.4165 12 6.4165ZM6.25 10.6665C6.25 7.49087 8.82436 4.9165 12 4.9165C15.1756 4.9165 17.75 7.49087 17.75 10.6665C17.75 13.8421 15.1756 16.4165 12 16.4165C8.82436 16.4165 6.25 13.8421 6.25 10.6665Z"
                        fill="#232229"/>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M12 16.5415C9.841 16.5415 7.84726 18.2292 6.69517 21.0731L6.41357 21.7682L5.02332 21.205L5.30492 20.5099C6.57408 17.377 8.97783 15.0415 12 15.0415C15.0223 15.0415 17.426 17.377 18.6952 20.5099L18.9768 21.205L17.5865 21.7682L17.3049 21.0731C16.1528 18.2292 14.1591 16.5415 12 16.5415Z"
                        fill="#232229"/>
                </svg>
              </a>
            <?php else: ?>
              <button class="header__button" type="button" id="open-profile-modal-auth">
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M12 6.4165C9.65279 6.4165 7.75 8.31929 7.75 10.6665C7.75 13.0137 9.65279 14.9165 12 14.9165C14.3472 14.9165 16.25 13.0137 16.25 10.6665C16.25 8.31929 14.3472 6.4165 12 6.4165ZM6.25 10.6665C6.25 7.49087 8.82436 4.9165 12 4.9165C15.1756 4.9165 17.75 7.49087 17.75 10.6665C17.75 13.8421 15.1756 16.4165 12 16.4165C8.82436 16.4165 6.25 13.8421 6.25 10.6665Z"
                        fill="#232229"/>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M12 16.5415C9.841 16.5415 7.84726 18.2292 6.69517 21.0731L6.41357 21.7682L5.02332 21.205L5.30492 20.5099C6.57408 17.377 8.97783 15.0415 12 15.0415C15.0223 15.0415 17.426 17.377 18.6952 20.5099L18.9768 21.205L17.5865 21.7682L17.3049 21.0731C16.1528 18.2292 14.1591 16.5415 12 16.5415Z"
                        fill="#232229"/>
                </svg>
              </button>
            <?php endif; ?>
            <a href="/favourite/" class="header__button">
              <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M3.74175 6.63008C4.69476 5.69149 5.98492 5.16619 7.32783 5.16619C8.6661 5.16619 9.95199 5.68786 10.904 6.62037L12.0006 7.62621L13.0972 6.62038C14.0492 5.68787 15.3351 5.16619 16.6734 5.16619C18.0163 5.16619 19.3065 5.69149 20.2595 6.63008C21.2129 7.56906 21.7506 8.84504 21.7506 10.178C21.7506 11.51 21.2136 12.7851 20.2614 13.7239C20.2608 13.7246 20.2601 13.7252 20.2595 13.7258L12.0006 21.9763L3.7398 13.7239C2.78762 12.7851 2.25061 11.51 2.25061 10.178C2.25061 8.84504 2.78835 7.56906 3.74175 6.63008ZM7.32783 6.66619C6.37543 6.66619 5.46431 7.03892 4.7943 7.69879C4.12467 8.35829 3.75061 9.2503 3.75061 10.178C3.75061 11.1056 4.12467 11.9976 4.7943 12.6571L4.7981 12.6609L12.0006 19.8561L19.2069 12.6571C19.8765 11.9976 20.2506 11.1056 20.2506 10.178C20.2506 9.2503 19.8765 8.35829 19.2069 7.69879C18.5369 7.03892 17.6258 6.66619 16.6734 6.66619C15.721 6.66619 14.8099 7.03892 14.1399 7.69879L14.1304 7.70814L12.0006 9.66165L9.87085 7.70814L9.86136 7.69879C9.19135 7.03892 8.28022 6.66619 7.32783 6.66619Z"
                      fill="#232229"/>
              </svg>
              <span class="header__favourite-count" id="header-favourite-count">0</span>
            </a>
            <a href="javascript:" class="header__button js--modal" data-modal="cart" onclick="loadCartContent()">
              <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M7.75 8.6665C7.75 9.52846 8.09241 10.3551 8.7019 10.9646C9.3114 11.5741 10.138 11.9165 11 11.9165H12V13.4165H11C9.74022 13.4165 8.53204 12.9161 7.64124 12.0253C6.75045 11.1345 6.25 9.92628 6.25 8.6665H7.75Z"
                      fill="#232229"/>
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M15.2981 10.9646C15.9076 10.3551 16.25 9.52846 16.25 8.6665H17.75C17.75 9.92628 17.2496 11.1345 16.3588 12.0253C15.468 12.9161 14.2598 13.4165 13 13.4165H12V11.9165H13C13.862 11.9165 14.6886 11.5741 15.2981 10.9646Z"
                      fill="#232229"/>
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M2.25 4.9165H21.75V20.4165H2.25V4.9165ZM3.75 6.4165V18.9165H20.25V6.4165H3.75Z" fill="#232229"/>
              </svg>
              <span class="header__cart-count" id="header-cart-count">0</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Модальное окно авторизации в стиле lkmodal -->
  <div class="lkmodal" id="profile-modal-auth">
    <div class="lkmodal__header">
      <p class="lkmodal__title">Вход</p>
      <button class="lkmodal__close js--close" type="button">
        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M18 20.5L12 12.5M6 4.5L12 12.5M12 12.5L18 4.5M12 12.5L6 20.5" stroke="#232229" stroke-width="1.5"/>
        </svg>
      </button>
    </div>
    <div class="lkmodal__body">
      <!-- Шаг 1: выбор действия -->
      <div class="lkmodal__form profile-modal__step profile-modal__step--1 mode-initial">
        <p class="lkmodal__form-descr">Зарегистрируйтесь или войдите в свой аккаунт, чтобы воспользоваться программой лояльности</p>
        <div class="lkmodal__form-el">
          <button class="lkmodal__form-submit primary-button-active" type="button" id="enter-as-guest">Войти / Зарегистрироваться</button>
        </div>
        <?/*
        <div class="lkmodal__form-el">
          <button class="lkmodal__form-submit primary-button" type="button" id="enter-as-guest">Продолжить как гость</button>
        </div>
        */?>
      </div>
      <!-- Шаг 2: ввод телефона -->
      <form class="lkmodal__form profile-modal__step profile-modal__step--2 hide mode-guest" id="form--send--sms" autocomplete="off">
        <p class="lkmodal__form-descr">Мы отправим на номер SMS-сообщение с кодом подтверждения.</p>
        <div class="lkmodal__form-el">
          <div class="inputel">
            <input class="input mobile-phone-input js_phone" id="phone" name="phone" placeholder="+7 (___) ___-__-__" type="tel" required>
            <label for="phone">Ваш номер телефона</label>
          </div>
        </div>
        <div class="lkmodal__form-el">
          <button class="lkmodal__form-submit primary-button" type="submit">Отправить</button>
        </div>
      </form>
      <!-- Шаг 3: ввод кода -->
      <form class="lkmodal__form profile-modal__step profile-modal__step--3 hide mode-code" id="form--verify--sms" autocomplete="off">
        <div class="lkmodal__form-el">
          <button class="lkmodal__back back-button" type="button">
            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M15 19L8 12.5L15 6" stroke="#232229" stroke-width="1.5"/>
            </svg>
            <span>Назад</span>
          </button>
        </div>
        <p class="lkmodal__form-descr">Мы отправили код на номер</p>
        <div id="check--error" class="lkmodal__form-error"></div>
        <div class="lkmodal__form-el">
          <div class="inputel">
            <input class="input" id="verificationCode" name="verificationCode" placeholder="----" maxlength="4" required>
            <label for="verificationCode">Код из SMS</label>
          </div>
        </div>
        <div class="lkmodal__form-el">
          <button class="lkmodal__form-submit primary-button" type="submit">Подтвердить телефон</button>
        </div>
        <div class="lkmodal__form-el">
          <button id="get--code--repeat" class="lkmodal__form-submit primary-button" type="button">Получить код повторно</button>
        </div>
        <input type="hidden" name="phone" id="verifed--phone"/>
      </form>
    </div>
  </div>
</div>

<main class="homepage" id="root">
