<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
  die();
}

if (!empty($arResult)) {
  $out = '';

  foreach ($arResult as $index => $arItem) {
    if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) {
      continue;
    }
    $active = $arItem["SELECTED"] ? 'active' : '';
    if ($arItem['LINK'] == '/' and $APPLICATION->GetCurPage() != '/') {
      $active = '';
    }

    $out .= '
      <a class="header__menu-link" href="' . $arItem["LINK"] . '">
        ' . $arItem["TEXT"];

    $out .= '</a>';
  }
  echo $out;
}

?>
