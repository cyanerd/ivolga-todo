<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
  die();
}

if (!empty($arResult)) {
  $out = '<div class="header__menu-left">';

  foreach ($arResult as $index => $arItem) {
    if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) {
      continue;
    }
    $active = $arItem["SELECTED"] ? 'active' : '';
    if ($arItem['LINK'] == '/' and $APPLICATION->GetCurPage() != '/') {
      $active = '';
    }

    $class = $arItem['LINK'] === '/catalog/' ? 'header__menu-link--dropdown' : '';

    $out .= '
      <a class="header__menu-link '.$class.'" href="' . $arItem["LINK"] . '">
        ' . $arItem["TEXT"];

    if ($arItem['LINK'] === '/catalog/') {
      $out .= '<i>
              <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M12.75 11.9165V6.6665H11.25V11.9165H3V13.4165H11.25V18.6665H12.75V13.4165H21V11.9165H12.75Z"
                      fill="#232229"/>
              </svg>
            </i>';
    }
    if ($arItem['LINK'] === '/live/') {
      $out .= '<i>
              <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="6" cy="6.6665" r="6" fill="#F95F5F"/>
              </svg>
            </i>';
    }


    $out .= '</a>';
  }
  $out .= '</div>';
  echo $out;
}

?>
