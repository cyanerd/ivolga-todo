<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>

<div class="catalogpage__main">
  <? if ($arResult["ITEMS"]): ?>
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
      <?
      $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
      $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), ["CONFIRM" => GetMessage('CT_BCE_ELEMENT_DELETE_CONFIRM')]);
      ?>
      <div class="catalogpage__col" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
        <div class="product-card" data-product-id="<?= $arItem['ID'] ?>">
          <div class="product-card__image">
            <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="product-card__slider">
              <div class="product-card__slider-track">
                <? if ($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"]): ?>
                  <? foreach ($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $imageId): ?>
                    <div class="product-card__slide product-card__slide--3">
                      <img src="<?= CFile::GetPath($imageId) ?>" alt="<?= $arItem["NAME"] ?>">
                    </div>
                  <? endforeach; ?>
                <? else: ?>
                  <? if ($arItem["PREVIEW_PICTURE"]["SRC"]): ?>
                    <div class="product-card__slide product-card__slide--4">
                      <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $arItem["NAME"] ?>">
                    </div>
                  <? else: ?>
                    <div class="product-card__slide product-card__slide--5">
                      <img src="/assets/img/no-photo.jpg" alt="<?= $arItem["NAME"] ?>">
                    </div>
                  <? endif; ?>
                <? endif; ?>
              </div>
              <div class="product-card__pagination">
                <? if ($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"]): ?>
                  <? foreach ($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $index => $imageId): ?>
                    <span class="product-card__pagination-dot<?= $index === 0 ? ' active' : '' ?>"></span>
                  <? endforeach; ?>
                <? else: ?>
                  <span class="product-card__pagination-dot active"></span>
                <? endif; ?>
              </div>
            </a>
            <div class="product-card__tags">
              <? if ($arItem["PROPERTIES"]["NEW"]["VALUE"]): ?>
                <span class="product-card__tag">Новинка</span>
              <? endif; ?>
              <? if ($arItem["PROPERTIES"]["PREORDER"]["VALUE"]): ?>
                <span class="product-card__tag">Предзаказ</span>
              <? endif; ?>
            </div>
            <i class="product-card__like<?= $arItem["PROPERTIES"]["FAVORITE"]["VALUE"] ? ' active' : '' ?>"
               data-product-id="<?= $arItem["ID"] ?>">
              <svg class="activelike" width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M1.74163 2.13008C2.69464 1.19149 3.9848 0.666199 5.32771 0.666199C6.66597 0.666199 7.95186 1.18787 8.9039 2.12038L10.0005 3.12621L11.0971 2.12038C12.0491 1.18787 13.335 0.666199 14.6733 0.666199C16.0162 0.666199 17.3063 1.19149 18.2593 2.13008C19.2127 3.06906 19.7505 4.34504 19.7505 5.67796C19.7505 7.00999 19.2135 8.28515 18.2613 9.22394L18.2593 9.22584L10.0005 17.4763L1.73968 9.22392C0.787496 8.28512 0.250488 7.00998 0.250488 5.67796C0.250488 4.34504 0.78823 3.06906 1.74163 2.13008ZM5.32771 2.1662C4.37531 2.1662 3.46419 2.53892 2.79417 3.1988C2.12455 3.85829 1.75049 4.75031 1.75049 5.67796C1.75049 6.60562 2.12455 7.49764 2.79417 8.15713L2.79797 8.16087L10.0005 15.3561L17.2068 8.15712C17.8764 7.49762 18.2505 6.60562 18.2505 5.67796C18.2505 4.75031 17.8764 3.85829 17.2068 3.1988C16.5368 2.53892 15.6257 2.1662 14.6733 2.1662C13.7209 2.1662 12.8097 2.53892 12.1397 3.1988L12.1302 3.20814L10.0005 5.16165L7.87073 3.20814L7.86124 3.1988C7.19123 2.53892 6.2801 2.1662 5.32771 2.1662Z"
                      fill="#232229"/>
                <path
                  d="M2.79417 3.1988C3.46419 2.53892 4.37531 2.1662 5.32771 2.1662C6.2801 2.1662 7.19123 2.53892 7.86124 3.1988L7.87073 3.20814L10.0005 5.16165L12.1302 3.20814L12.1397 3.1988C12.8097 2.53892 13.7209 2.1662 14.6733 2.1662C15.6257 2.1662 16.5368 2.53892 17.2068 3.1988C17.8764 3.85829 18.2505 4.75031 18.2505 5.67796C18.2505 6.60562 17.8764 7.49762 17.2068 8.15712L10.0005 15.3561L2.79797 8.16087L2.79417 8.15713C2.12455 7.49764 1.75049 6.60562 1.75049 5.67796C1.75049 4.75031 2.12455 3.85829 2.79417 3.1988Z"
                  fill="#232229"/>
              </svg>

              <svg class="deflike" width="21" height="18" viewBox="0 0 21 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M2.24212 1.96389C3.19513 1.02529 4.48529 0.5 5.8282 0.5C7.16646 0.5 8.45235 1.02167 9.40439 1.95418L10.501 2.96001L11.5976 1.95418C12.5496 1.02167 13.8355 0.5 15.1738 0.5C16.5167 0.5 17.8068 1.02529 18.7598 1.96389C19.7132 2.90286 20.251 4.17884 20.251 5.51177C20.251 6.84379 19.714 8.11895 18.7618 9.05774C18.7611 9.05838 18.7605 9.05901 18.7598 9.05964L10.501 17.3101L2.24017 9.05772C1.28798 8.11893 0.750977 6.84378 0.750977 5.51177C0.750977 4.17884 1.28872 2.90286 2.24212 1.96389ZM5.8282 2C4.8758 2 3.96467 2.37272 3.29466 3.0326C2.62504 3.69209 2.25098 4.58411 2.25098 5.51177C2.25098 6.43942 2.62504 7.33144 3.29466 7.99093L3.29846 7.99468L10.501 15.1899L17.7073 7.99092C18.3769 7.33143 18.751 6.43942 18.751 5.51177C18.751 4.58411 18.3769 3.69209 17.7073 3.0326C17.0373 2.37272 16.1262 2 15.1738 2C14.2214 2 13.3102 2.37272 12.6402 3.0326L12.6307 3.04194L10.501 4.99545L8.37122 3.04194L8.36173 3.0326C7.69172 2.37272 6.78059 2 5.8282 2Z"
                      fill="#232229"/>
              </svg>
            </i>
          </div>
          <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="product-card__info">
            <h3 class="product-card__title"><?= $arItem["NAME"] ?></h3>
            <div class="product-card__price">
              <? if ($arItem["PROPERTIES"]["PRICE"]["VALUE"]): ?>
                <div class="product-card__price-current">
                  <span><?= number_format($arItem["PROPERTIES"]["PRICE"]["VALUE"], 0, '.', ' ') ?>₽</span>
                  <? if ($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"]): ?>
                    <div class="product-card__discount">
                      -<?= round((($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"] - $arItem["PROPERTIES"]["PRICE"]["VALUE"]) / $arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"]) * 100) ?>
                      %
                    </div>
                  <? endif; ?>
                </div>
                <? if ($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"]): ?>
                  <span
                    class="product-card__price-old"><?= number_format($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"], 0, '.', ' ') ?>₽</span>
                <? endif; ?>
              <? endif; ?>
            </div>
          </a>

          <div class="product-card__footer product-card__footer1">
            <? if ($arItem["PROPERTIES"]["COLORS"]["VALUE"]): ?>
              <div class="product-card__colors">
                <? foreach ($arItem["PROPERTIES"]["COLORS"]["VALUE"] as $color): ?>
                  <a href="" class="product-card__colors-item" style="background-color: <?= $color ?>;"></a>
                <? endforeach; ?>
              </div>
            <? endif; ?>
            <? if ($arItem["PROPERTIES"]["SIZES"]["VALUE"]): ?>
              <div class="product-card__sizes">
                <? foreach ($arItem["PROPERTIES"]["SIZES"]["VALUE"] as $size): ?>
                  <a href="" class="product-card__sizes-item"><?= $size ?></a>
                <? endforeach; ?>
              </div>
            <? endif; ?>
          </div>
        </div>
      </div>
    <? endforeach; ?>
  <? endif; ?>
</div>

<? if ($arResult["NAV_STRING"]): ?>
  <div class="catalogpage__pagination">
    <?= $arResult["NAV_STRING"] ?>
  </div>
<? endif; ?>

<? if (is_object($arResult["NAV_RESULT"]) && method_exists($arResult["NAV_RESULT"], "GetPageCount") && $arResult["NAV_RESULT"]->GetPageCount() > 1): ?>
  <button class="catalogpage__more" onclick="loadMoreProducts()">
    Показать ещё
  </button>
<? endif; ?>

<script>
  function loadMoreProducts() {
    // Здесь будет логика загрузки дополнительных товаров
    console.log('Загрузка дополнительных товаров...');
  }
</script>
