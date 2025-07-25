<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<ul class="faq-menu__links">
    <? foreach ($arResult as $arItem): ?>
        <li><a class="<?=$arItem['SELECTED'] ? 'faq-link-active' : 'faq-link'?>" href="<?=$arItem['LINK']?>"><?=$arItem['TEXT']?></a></li>
    <? endforeach; ?>
</ul>