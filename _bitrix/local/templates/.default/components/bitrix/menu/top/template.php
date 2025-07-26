<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? foreach ($arResult as $arItem): ?>
  <li><a
      class="<? if ($arItem['SELECTED']): ?>nav-link-active active<? else: ?>nav-link<? endif ?> <?= $arItem['PARAMS']['CLASS'] ?>"
      href="<?= $arItem['LINK'] ?>"><?= $arItem['TEXT'] ?></a></li>
<? endforeach; ?>
