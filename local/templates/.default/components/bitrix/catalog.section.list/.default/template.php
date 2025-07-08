<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
$amount_per_collumn = ceil(count($arResult['SECTIONS']) / 2); $total_amount = count($arResult['SECTIONS']);
?>
<div class="filter-modal-content">
    <ul class="filter-modal-content__list"></ul>
    <ul class="filter-modal-content__list">
        <?
        $index = 1; $current = 1; $collumn = 1;
        foreach ($arResult['SECTIONS'] as $arSection){?>
            <li><a href="<?=$arSection['SECTION_PAGE_URL']?>" class="filter-modal-content__button"><?=$arSection['NAME']?></a></li>
            <?if($index == $amount_per_collumn && $current < $total_amount){?>
                <?if($collumn == 1)echo'<li><a href="/catalog/" class="filter-modal-content__button-reset">Сбросить фильтр</a></li>';?>
                </ul><ul class="filter-modal-content__list">
                <?$index = 0; $collumn++;
            }?>
        <?$index++;$current++;}?>
    </ul>
    <div><img src="/assets/img/products/filter-img.png" alt="" class="filter-modal-content__img">
    </div>
</div>