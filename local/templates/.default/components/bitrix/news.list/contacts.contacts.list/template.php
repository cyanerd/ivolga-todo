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
<div style="opacity: 1; transform: none;">
    <div class="contacts-info-container">
        <div class="contacts-info">
            <ul class="faq-info__contacts">
                <?foreach ($arResult['ITEMS'] as $arItem):?>
                <li>
                    <div class="faq-info__contact">
                        <p><?=$arItem['NAME']?></p>
                        <p><?=$arItem['PROPERTIES']['EMAIL']['VALUE']?></p>
                    </div>
                </li>
                <?endforeach;?>
            </ul>
        </div>
    </div>
</div>
