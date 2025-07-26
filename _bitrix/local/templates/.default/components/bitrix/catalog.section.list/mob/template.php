<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
$amount_per_collumn = ceil(count($arResult['SECTIONS']) / 2);
$total_amount = count($arResult['SECTIONS']);
?>
<div class="catalog-underlist modal-top modal-right">
  <div class="modal-top-content modal-right-content">
    <div class="buttonchik">
      <button class="close-button">
        <img src="/assets/img/icons/close.svg" alt="close"/>
      </button>
    </div>
    <div class="filter-modal-content">
      <ul class="filter-modal-content__list"></ul>
      <ul class="filter-modal-content__list">
        <?
        $index = 1;
        $current = 1;
        $collumn = 1;
        foreach ($arResult['SECTIONS'] as $arSection){
        ?>
        <li>
          <a href="<?= $arSection['SECTION_PAGE_URL'] ?>" class="filter-modal-content__button"><?= $arSection['NAME'] ?></a>
        </li>
        <? if ($index == $amount_per_collumn && $current < $total_amount){
        ?>
      </ul>
      <ul class="filter-modal-content__list">
        <? $index = 0;
        $collumn++;
        } ?>
        <? $index++;
        $current++;
        } ?>
      </ul>
      <div>
        <img
          src="/assets/img/products/filter-img.png"
          alt=""
          class="filter-modal-content__img"/>
      </div>
    </div>
  </div>
</div>
