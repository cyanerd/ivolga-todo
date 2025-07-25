<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<main class="collections-content">
    <h2 class="collections-list__title" style="display: none;"></h2>
    <ul class="collections-list container">
        <?foreach ($arResult['ITEMS'] as $arItem):?>
        <li class="collections-item"><a class="collections-item__link" href="<?=$arItem['DETAIL_PAGE_URL']?>">
                <img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" alt="product" class="collections-item__img">
                <p class="collections-item__title"><?=$arItem['NAME']?></p>
            </a></li>
        <?endforeach;?>
    </ul>
</main>