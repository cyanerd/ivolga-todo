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
        <?foreach ($arResult['ITEMS'] as $arItem):?>
        <div class="contacts-info">
            <h1 class="faq-info__title"><?=$arItem['NAME']?></h1>
            <ul class="faq-info__contacts">
                <li>
                    <div class="faq-info__contact">
                        <?if($arItem['PROPERTIES']['ADDRESS']['VALUE']):?><p><?=$arItem['PROPERTIES']['ADDRESS']['VALUE']?></p><?endif;?>
                        <?if($arItem['PROPERTIES']['SHEDULE']['VALUE']):?><p><?=$arItem['PROPERTIES']['SHEDULE']['VALUE']?></p><?endif;?>
                    </div>
                </li>
                <?if($arItem['PROPERTIES']['PHONE']['VALUE']):?>
                <li>
                    <div class="faq-info__contact">
                        <p>Телефон</p>
                        <p><?=$arItem['PROPERTIES']['PHONE']['VALUE']?></p>
                    </div>
                </li>
                <?endif;?>
            </ul>
            <?if($arItem['DISPLAY_PROPERTIES']['PICTURE']['VALUE']):?>
            <img src="<?=$arItem['DISPLAY_PROPERTIES']['PICTURE']['FILE_VALUE']['SRC']?>" alt="<?=$arItem['NAME']?>">
            <?endif;?>
        </div>
        <?endforeach;?>
    </div>
</div>