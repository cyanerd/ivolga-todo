<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<ul class="main-footer__links">
    <? foreach ($arResult as $arItem): ?>
        <li><a class="footer-link" href="<?=$arItem['LINK']?>"><?=$arItem['TEXT']?></a></li>
    <? endforeach; ?>
</ul>