<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="search-modal-recommendations">
    <p>Рекомендации</p>
    <ul>
        <?foreach ($arResult['ITEMS'] as $arItem):?>
        <li><a class="primary-button" href="/search/?q=<?=urlencode($arItem['NAME'])?>"><?=$arItem['NAME']?></a></li>
        <?endforeach;?>
    </ul>
</div>