<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
  die();
}

if (!empty($arResult)) {
  $out = '<nav id="main-menu" class="main-menu"><ul role="list">';

  $prevDepth = 1;
  $depthStack = [];

  foreach ($arResult as $index => $arItem) {
    if ($arItem["PERMISSION"] === "D") continue;

    $isParent = $arItem["IS_PARENT"];
    $depth = $arItem["DEPTH_LEVEL"];
    $link = htmlspecialchars($arItem["LINK"]);
    $text = htmlspecialchars($arItem["TEXT"]);
    $active = $arItem["SELECTED"] ? 'active' : '';
    $isModal = $link === '#info_modal' ? 'js-modal-link' : '';

    if ($depth < $prevDepth) {
      for ($i = $prevDepth - $depth; $i > 0; $i--) {
        $out .= "</ul></li>";
        array_pop($depthStack);
      }
    }

    if ($isParent) {
      $out .= '<li class="submenu-item ' . $active . '">';
      $out .= '<a href="' . $link . '">' . $text . '</a>';
      $out .= '<span class="icon icon-menu_arrow js-submenu-link"></span>';
      $out .= '<ul role="list">';
      array_push($depthStack, $depth);
    } else {
      $out .= '<li class="' . $active . '"><a class="' . $isModal . '" href="' . $link . '">' . $text . '</a></li>';
    }

    $prevDepth = $depth;
  }

  while (!empty($depthStack)) {
    $out .= "</ul></li>";
    array_pop($depthStack);
  }

  $out .= '</ul></nav>';

  echo $out;
}
?>
