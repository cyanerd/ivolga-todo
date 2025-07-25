<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die(); ?>

<div class="breadcrumbs">
  <div class="container">
    <div class="breadcrumbs__row desc">
      <a href="/">
        Главная
      </a>
      <? foreach ($arResult as $arItem) { ?>
        <a href="<?=$arItem['LINK']?>">
          <?=$arItem['TITLE']?>
        </a>
      <? } ?>
      <span>
                    Сарафан молочный с цветочным принтом
                </span>
    </div>
    <a href="" class="breadcrumbs__back mob">
      <i>
        <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
                d="M8.58333 3.3665C8.58333 5.53088 6.60759 7.4165 4 7.4165V8.9165C6.60759 8.9165 8.58333 10.8021 8.58333 12.9665V14.1665H10.0833V12.9665C10.0833 10.8809 8.84622 9.11574 7.0523 8.1665C8.84622 7.21727 10.0833 5.45208 10.0833 3.3665V2.1665H8.58333V3.3665Z"
                fill="#232229" fill-opacity="0.5"/>
        </svg>
      </i>
      Назад
    </a>
  </div>
</div>
