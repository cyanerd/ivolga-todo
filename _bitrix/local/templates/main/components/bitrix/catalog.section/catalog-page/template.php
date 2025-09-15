<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
global $APPLICATION;

$isNotCatalog = substr_count($APPLICATION->GetCurPage(), '/collections/')
  || substr_count($APPLICATION->GetCurPage(), '/looks/')
  || substr_count($APPLICATION->GetCurPage(), '/search/');
?>

<?php
// Если запрос только для обновления фильтров, возвращаем только их
if ($_GET['update_filters'] === 'Y') {
  $APPLICATION->RestartBuffer();
}
?>

<? if (!$isNotCatalog) { ?>
  <div class="container">
    <? if ($arResult["SECTIONS"]): ?>
      <ul class="catalogpage__nav">
        <?
        // Вычисляем общее количество товаров
        $totalElements = 0;

        // Способ 1: через NAV_RESULT
        if (is_object($arResult["NAV_RESULT"]) && method_exists($arResult["NAV_RESULT"], "NavRecordCount")) {
          $totalElements = $arResult["NAV_RESULT"]->NavRecordCount;
        } // Способ 2: через секции
        elseif ($arResult["SECTIONS"]) {
          foreach ($arResult["SECTIONS"] as $arSection) {
            $totalElements += $arSection["ELEMENT_CNT"];
          }
        } // Способ 3: через ELEMENT_CNT
        elseif ($arResult["ELEMENT_CNT"]) {
          $totalElements = $arResult["ELEMENT_CNT"];
        } // Способ 4: через количество товаров в текущем результате
        elseif ($arResult["ITEMS"]) {
          $totalElements = count($arResult["ITEMS"]);
        }
        ?>
        <li>
          <a href="<?= $arResult["SECTION_PAGE_URL"] ?>" class="<?= !$arResult["SECTION"]["ID"] ? 'active' : '' ?>">
            Вся одежда
            <span>(<?= $totalElements ?>)</span>
          </a>
        </li>
        <? foreach ($arResult["SECTIONS"] as $arSection): ?>
          <li>
            <a href="<?= $arSection["SECTION_PAGE_URL"] ?>"
               class="<?= $arResult["SECTION"]["ID"] == $arSection["ID"] ? 'active' : '' ?>">
              <?= $arSection["NAME"] ?>
              <span>(<?= $arSection["ELEMENT_CNT"] ?>)</span>
            </a>
          </li>
        <? endforeach; ?>
      </ul>
    <? endif; ?>

    <div class="catalogpage__heading-wrap">
      <div class="catalogpage__heading">
        <div class="catalogpage__heading-left">
          <button class="catalogpage__togfilter">
            <i>
              <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M9.75 7.6665C8.92157 7.6665 8.25 8.33808 8.25 9.1665C8.25 9.99493 8.92157 10.6665 9.75 10.6665C10.5784 10.6665 11.25 9.99493 11.25 9.1665C11.25 8.33808 10.5784 7.6665 9.75 7.6665ZM6.75 9.1665C6.75 7.50965 8.09315 6.1665 9.75 6.1665C11.4069 6.1665 12.75 7.50965 12.75 9.1665C12.75 10.8234 11.4069 12.1665 9.75 12.1665C8.09315 12.1665 6.75 10.8234 6.75 9.1665Z"
                      fill="#232229"/>
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M15.75 14.6665C14.9216 14.6665 14.25 15.3381 14.25 16.1665C14.25 16.9949 14.9216 17.6665 15.75 17.6665C16.5784 17.6665 17.25 16.9949 17.25 16.1665C17.25 15.3381 16.5784 14.6665 15.75 14.6665ZM12.75 16.1665C12.75 14.5096 14.0931 13.1665 15.75 13.1665C17.4069 13.1665 18.75 14.5096 18.75 16.1665C18.75 17.8234 17.4069 19.1665 15.75 19.1665C14.0931 19.1665 12.75 17.8234 12.75 16.1665Z"
                      fill="#232229"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M20.25 9.9165H12V8.4165H20.25V9.9165Z" fill="#232229"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 9.9165H3.75V8.4165H7.5V9.9165Z" fill="#232229"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M20.25 16.9165H18V15.4165H20.25V16.9165Z" fill="#232229"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.5 16.9165H3.75V15.4165H13.5V16.9165Z" fill="#232229"/>
              </svg>
            </i>
            <span>Фильтры</span>
          </button>
        </div>

        <div class="catalogpage__mobsort mob">
          Сортировать
          <i>
            <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 9.4165H4V7.9165H12V9.4165Z" fill="#232229"/>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 6.4165H1.5V4.9165H14.5V6.4165Z" fill="#232229"/>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M9.5 12.4165H6.5V10.9165H9.5V12.4165Z" fill="#232229"/>
            </svg>
          </i>
        </div>
        <?
        // Получаем текущие параметры сортировки
        $currentSort = $_REQUEST["sort"] ?: "sort";
        $currentOrder = $_REQUEST["order"] ?: "asc";

        // Отладочная информация для сортировки
        error_log("Sort debug - REQUEST sort: " . ($_REQUEST["sort"] ?? 'not set'));
        error_log("Sort debug - REQUEST order: " . ($_REQUEST["order"] ?? 'not set'));
        error_log("Sort debug - currentSort: " . $currentSort);
        error_log("Sort debug - currentOrder: " . $currentOrder);
        ?>
        <div class="catalogpage__sort <?= $currentOrder == 'desc' ? 'desc' : 'asc' ?>">
          <p>Сортировать</p>
          <form method="GET" action="">
            <? if ($_REQUEST["SECTION_CODE"]): ?>
              <input type="hidden" name="SECTION_CODE" value="<?= htmlspecialcharsbx($_REQUEST["SECTION_CODE"]) ?>">
            <? endif; ?>
            <? if ($_REQUEST["SECTION_ID"]): ?>
              <input type="hidden" name="SECTION_ID" value="<?= htmlspecialcharsbx($_REQUEST["SECTION_ID"]) ?>">
            <? endif; ?>
            <? if ($_REQUEST["SECTION_CODE_PATH"]): ?>
              <input type="hidden" name="SECTION_CODE_PATH" value="<?= htmlspecialcharsbx($_REQUEST["SECTION_CODE_PATH"]) ?>">
            <? endif; ?>
            <? if ($_REQUEST["size"]): ?>
              <input type="hidden" name="size" value="<?= htmlspecialcharsbx($_REQUEST["size"]) ?>">
            <? endif; ?>
            <? if ($_REQUEST["color"]): ?>
              <input type="hidden" name="color" value="<?= htmlspecialcharsbx($_REQUEST["color"]) ?>">
            <? endif; ?>
            <? if ($_REQUEST["material"]): ?>
              <input type="hidden" name="material" value="<?= htmlspecialcharsbx($_REQUEST["material"]) ?>">
            <? endif; ?>
            <? if ($_REQUEST["collection"]): ?>
              <input type="hidden" name="collection" value="<?= htmlspecialcharsbx($_REQUEST["collection"]) ?>">
            <? endif; ?>
            <div class="catalogpage__sort-select">
              <select name="sort">
                <option value="sort" <?= $currentSort == "sort" ? 'selected' : '' ?>>по умолчанию</option>
                <option value="name" <?= $currentSort == "name" ? 'selected' : '' ?>>по названию</option>
                <option
                  value="price" <?= $currentSort == "price" || $currentSort == "catalog_PRICE_1" || $currentSort == "catalog_PRICE_7" ? 'selected' : '' ?>>
                  по цене
                </option>
                <option value="date" <?= $currentSort == "date" ? 'selected' : '' ?>>по дате</option>
              </select>
            </div>
            <input type="hidden" name="order" value="<?= $currentOrder ?>">
            <button type="button" class="sort-order-btn" onclick="toggleSortOrder()" title="Изменить направление сортировки">
              <i>
                <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                     style="transform: <?= $currentOrder == 'desc' ? 'none' : 'rotate(180deg)' ?>">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M15 11.375H5V9.875H15V11.375Z" fill="#232229"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M18.125 7.625H1.875V6.125H18.125V7.625Z" fill="#232229"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M11.875 15.125H8.125V13.625H11.875V15.125Z" fill="#232229"/>
                </svg>
              </i>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
<? } ?>

<div class="catalogpage__items">
  <div class="catalogpage__main">
    <? if ($arResult["ITEMS"]): ?>
      <? foreach (
        $arResult["ITEMS"] as $arItem): ?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), ["CONFIRM" => GetMessage('CT_BCE_ELEMENT_DELETE_CONFIRM')]);
        ?>
        <div class="catalogpage__col" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
          <div class="product-card" data-product-id="<?= $arItem['ID'] ?>">
            <div class="product-card__image">
              <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="product-card__slider">
                <div class="product-card__slider-track">
                  <? if (!empty($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"])): ?>
                    <? foreach ($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $imageId): ?>
                      <div class="product-card__slide">
                        <img src="<?= CFile::GetPath($imageId) ?>" alt="<?= $arItem['PROPERTIES']['NAIMENOVANIE_TOVARA_NA_SAYTE_ETIKETKE']['VALUE'] ?: $arItem["NAME"] ?>">
                      </div>
                    <? endforeach; ?>
                  <? else: ?>
                    <div class="product-card__slide">
                      <img src="/assets/img/no-photo.jpg" alt="<?= $arItem['PROPERTIES']['NAIMENOVANIE_TOVARA_NA_SAYTE_ETIKETKE']['VALUE'] ?: $arItem["NAME"] ?>">
                    </div>
                  <? endif; ?>
                </div>
              </a>
              <div class="product-card__pagination">
                <? if (!empty($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"])): ?>
                  <? foreach ($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $index => $imageId): ?>
                    <span class="product-card__pagination-dot<?= $index === 0 ? ' active' : '' ?>"></span>
                  <? endforeach; ?>
                <? else: ?>
                  <span class="product-card__pagination-dot active"></span>
                <? endif; ?>
              </div>
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
              <h3 class="product-card__title"><?= $arItem['PROPERTIES']['NAIMENOVANIE_TOVARA_NA_SAYTE_ETIKETKE']['VALUE'] ?: $arItem["NAME"] ?></h3>
              <?php
              // --- Цена ---
              $price = null;
              $oldPrice = null;
              $discount = null;
              if (!empty($arItem['OFFERS']) && is_array($arItem['OFFERS'])) {
                $minPrice = null;
                foreach ($arItem['OFFERS'] as $offer) {
                  if (!empty($offer['PRICES'])) {
                    foreach ($offer['PRICES'] as $priceType) {
                      $offerPrice = $priceType['DISCOUNT_VALUE'] ?? $priceType['VALUE'] ?? null;
                      if ($offerPrice !== null && ($minPrice === null || $offerPrice < $minPrice)) {
                        $minPrice = $offerPrice;
                        $price = $priceType['PRINT_DISCOUNT_VALUE'] ?: $priceType['PRINT_VALUE'];
                        $oldPrice = $priceType['PRINT_VALUE'] !== $priceType['PRINT_DISCOUNT_VALUE'] ? $priceType['PRINT_VALUE'] : null;
                        $discount = !empty($priceType['DISCOUNT_DIFF_PERCENT']) ? round($priceType['DISCOUNT_DIFF_PERCENT']) : null;
                      }
                    }
                  } elseif (!empty($offer['CATALOG_PRICE_1'])) {
                    $offerPrice = $offer['CATALOG_PRICE_1'];
                    if ($minPrice === null || $offerPrice < $minPrice) {
                      $minPrice = $offerPrice;
                      $price = number_format($offerPrice, 0, '', ' ') . '₽';
                    }
                  } elseif (!empty($offer['CATALOG_PRICE_7'])) {
                    $offerPrice = $offer['CATALOG_PRICE_7'];
                    if ($minPrice === null || $offerPrice < $minPrice) {
                      $minPrice = $offerPrice;
                      $price = number_format($offerPrice, 0, '', ' ') . '₽';
                    }
                  }
                }
              }
              if (!$price && !empty($arItem['MIN_PRICE'])) {
                $price = $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ?: $arItem['MIN_PRICE']['PRINT_VALUE'];
                $oldPrice = $arItem['MIN_PRICE']['PRINT_VALUE'] !== $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] ? $arItem['MIN_PRICE']['PRINT_VALUE'] : null;
                $discount = !empty($arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']) ? round($arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']) : null;
              }
              // Добавляем обработку ITEM_PRICES
              if (!$price && !empty($arItem['OFFERS'][0]['ITEM_PRICES'][0]['PRINT_PRICE'])) {
                $price = $arItem['OFFERS'][0]['ITEM_PRICES'][0]['PRINT_PRICE'];
                // Если есть скидка, можно добавить обработку $arItem['ITEM_PRICES'][0]['PRINT_BASE_PRICE'] и ['PERCENT']
                if (!empty($arItem['OFFERS'][0]['ITEM_PRICES'][0]['PRINT_BASE_PRICE']) && $arItem['OFFERS'][0]['ITEM_PRICES'][0]['PRINT_BASE_PRICE'] !== $arItem['OFFERS'][0]['ITEM_PRICES'][0]['PRINT_PRICE']) {
                  $oldPrice = $arItem['OFFERS'][0]['ITEM_PRICES'][0]['PRINT_BASE_PRICE'];
                  $discount = !empty($arItem['OFFERS'][0]['ITEM_PRICES'][0]['PERCENT']) ? $arItem['OFFERS'][0]['ITEM_PRICES'][0]['PERCENT'] : null;
                }
              }
              ?>
              <div class="product-card__price">
                <div class="product-card__price-current">
                  <span><?= $price ?></span>
                  <? if ($discount): ?>
                    <div class="product-card__discount">-<?= $discount ?>%</div>
                  <? endif; ?>
                </div>
                <? if ($oldPrice): ?>
                  <span class="product-card__price-old"><?= $oldPrice ?></span>
                <? endif; ?>
              </div>
            </a>

            <div class="product-card__footer">
              <?php
              // --- Цвета ---
              $colors = [];
              if (!empty($arItem['PROPERTIES']['CML2_ARTICLE']['VALUE'])) {
                $colors = MyTools::getVariantColors($arItem['PROPERTIES']['CML2_ARTICLE']['VALUE']);
              }
              ?>
              <div class="product-card__colors">
                <?php foreach ($colors as $color => $detail_page_url): ?>
                  <a href="<?= $detail_page_url ?>" class="product-card__colors-item product-card-color-small"
                     style="background-image: url(<?= MyTools::getColor($color) ?>)"></a>
                <?php endforeach; ?>
              </div>
              <?php
              // --- Размеры ---
              $sizes_list = [];
              $arInfo = CCatalogSKU::GetInfoByProductIBlock($arItem["IBLOCK_ID"]);
              if ($arInfo && !empty($arInfo['IBLOCK_ID']) && !empty($arInfo['SKU_PROPERTY_ID'])) {
                $rsOffers = CIBlockElement::GetList(
                  [],
                  [
                    'IBLOCK_ID' => $arInfo['IBLOCK_ID'],
                    'PROPERTY_' . $arInfo['SKU_PROPERTY_ID'] => $arItem['ID']
                  ],
                  false,
                  false,
                  ["ID", "IBLOCK_ID", "NAME", "PROPERTY_RAZMER"]
                );
                while ($rs = $rsOffers->GetNextElement()) {
                  $arOffer = $rs->getFields();
                  $arOffer['PROPERTIES'] = $rs->getProperties();
                  if (!empty($arOffer['PROPERTIES']['RAZMER']['VALUE'])) {
                    $sizes_list[] = [
                      'id' => $arOffer['ID'],
                      'title' => $arOffer['PROPERTIES']['RAZMER']['VALUE'],
                    ];
                  }
                }
              }
              ?>
              <div class="product-card__sizes">
                <?php foreach ($sizes_list as $size): ?>
                  <span class="product-card__sizes-item"><?= htmlspecialchars($size['title']) ?></span>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      <? endforeach; ?>
    <? else: ?>
      <?php
      // Проверяем, есть ли активные фильтры
      $hasActiveFilters = !empty($_GET['size']) || !empty($_GET['color']) || !empty($_GET['material']) || !empty($_GET['collection']);
      ?>
      <div class="catalogpage__no-results">
        <div class="catalogpage__no-results-content">
          <div class="catalogpage__no-results-icon">
            <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M32 8C18.745 8 8 18.745 8 32C8 45.255 18.745 56 32 56C45.255 56 56 45.255 56 32C56 18.745 45.255 8 32 8ZM32 52C21.514 52 12 42.486 12 32C12 21.514 21.514 12 32 12C42.486 12 52 21.514 52 32C52 42.486 42.486 52 32 52Z"
                fill="#232229"/>
              <path
                d="M32 20C30.895 20 30 20.895 30 22V30C30 31.105 30.895 32 32 32C33.105 32 34 31.105 34 30V22C34 20.895 33.105 20 32 20Z"
                fill="#232229"/>
              <path
                d="M32 36C30.895 36 30 36.895 30 38V42C30 43.105 30.895 44 32 44C33.105 44 34 43.105 34 42V38C34 36.895 33.105 36 32 36Z"
                fill="#232229"/>
            </svg>
          </div>
          <h3 class="catalogpage__no-results-title">
            <?= $hasActiveFilters ? 'По вашему запросу ничего не найдено' : 'В данной категории пока нет товаров' ?>
          </h3>
          <p class="catalogpage__no-results-text">
            <?= $hasActiveFilters ? 'Попробуйте изменить параметры фильтрации или сбросить фильтры' : 'Попробуйте выбрать другую категорию или загляните позже' ?>
          </p>
          <?php if ($hasActiveFilters): ?>
            <button class="catalogpage__no-results-reset" onclick="resetFilters()">
              Сбросить фильтры
            </button>
          <?php endif; ?>
        </div>
      </div>
    <? endif; ?>
  </div>
</div>
<? if (is_object($arResult["NAV_RESULT"]) && $arResult["NAV_RESULT"]->NavPageCount > $arResult["NAV_RESULT"]->NavPageNomer) { ?>
  <button class="catalogpage__more" data-page="<?= $arResult["NAV_RESULT"]->NavPageNomer ?>">
    Показать ещё
  </button>
<? } ?>



<?php
// Получаем категории (разделы) с такой же структурой как в $arResult["SECTIONS"]
$categories = [];
$rsSections = CIBlockSection::GetList([
  'SORT' => 'ASC'
], [
  'IBLOCK_ID' => 29,
  'ACTIVE' => 'Y',
  'GLOBAL_ACTIVE' => 'Y',
//  'DEPTH_LEVEL' => 2
], true, ['ID', 'NAME', 'ELEMENT_CNT', 'SECTION_PAGE_URL']);
while ($arSection = $rsSections->GetNext()) {
  $categories[] = [
    'ID' => $arSection['ID'],
    'NAME' => $arSection['NAME'],
    'CODE' => $arSection['CODE'],
    'ELEMENT_CNT' => $arSection['ELEMENT_CNT'],
    'SECTION_PAGE_URL' => $arSection['SECTION_PAGE_URL']
  ];
}

// Получаем уникальные размеры для текущего раздела
$sizes = [];
$arInfo = CCatalogSKU::GetInfoByProductIBlock(29);
if ($arInfo && !empty($arInfo['IBLOCK_ID'])) {
  // Сначала получаем ID товаров из текущего раздела
  $productIds = [];
  $sectionFilter = ['IBLOCK_ID' => 29, 'ACTIVE' => 'Y'];

  // Если мы в конкретном разделе, добавляем фильтр по разделу
  if (!empty($_REQUEST["SECTION_ID"])) {
    $sectionFilter['SECTION_ID'] = $_REQUEST["SECTION_ID"];
  } elseif (!empty($_REQUEST["SECTION_CODE"])) {
    $sectionFilter['SECTION_CODE'] = $_REQUEST["SECTION_CODE"];
  }

  $rsProducts = CIBlockElement::GetList([], $sectionFilter, false, false, ['ID']);
  while ($arProduct = $rsProducts->GetNext()) {
    $productIds[] = $arProduct['ID'];
  }

  // Теперь получаем размеры только для этих товаров
  if (!empty($productIds)) {
    $rsOffers = CIBlockElement::GetList([], [
      'IBLOCK_ID' => $arInfo['IBLOCK_ID'],
      'ACTIVE' => 'Y',
      'PROPERTY_CML2_LINK' => $productIds
    ], false, false, ['ID', 'IBLOCK_ID', 'PROPERTY_RAZMER']);

    while ($arOffer = $rsOffers->GetNext()) {
      $size = trim($arOffer['PROPERTY_RAZMER_VALUE']);
      if ($size && !in_array($size, $sizes)) {
        $sizes[] = $size;
      }
    }
  }
}
// Получаем уникальные цвета для текущего раздела
$colors = [];
$sectionFilter = ['IBLOCK_ID' => 29, 'ACTIVE' => 'Y'];

// Если мы в конкретном разделе, добавляем фильтр по разделу
if (!empty($_REQUEST["SECTION_ID"])) {
  $sectionFilter['SECTION_ID'] = $_REQUEST["SECTION_ID"];
} elseif (!empty($_REQUEST["SECTION_CODE"])) {
  $sectionFilter['SECTION_CODE'] = $_REQUEST["SECTION_CODE"];
}

$rsElements = CIBlockElement::GetList([], $sectionFilter, false, false, ['ID', 'PROPERTY_TSVET']);
while ($arEl = $rsElements->GetNext()) {
  $color = trim($arEl['PROPERTY_TSVET_VALUE']);
  if ($color && !in_array($color, $colors)) {
    $colors[] = $color;
  }
}

// Если цвета не найдены через элементы, попробуем получить их из справочника свойств
if (empty($colors)) {
  error_log("No colors found in elements, trying property enum...");
  $property_enums = CIBlockPropertyEnum::GetList(
    ["SORT" => "ASC"],
    ["IBLOCK_ID" => 29, "CODE" => "TSVET"]
  );
  while ($enum_fields = $property_enums->GetNext()) {
    $colors[] = $enum_fields["VALUE"];
  }
  error_log("Colors from property enum: " . print_r($colors, true));
}

// Отладочная информация
if (empty($colors)) {
  error_log("No colors found for section: " . ($_REQUEST["SECTION_ID"] ?? $_REQUEST["SECTION_CODE"] ?? 'all'));
} else {
  error_log("Colors found: " . print_r($colors, true));
  error_log("Selected colors: " . print_r($selectedColors ?? [], true));
}
// Получаем уникальные материалы для текущего раздела
$materials = [];
$rsElements = CIBlockElement::GetList([], $sectionFilter, false, false, ['ID', 'PROPERTY_MATERIAL']);
while ($arEl = $rsElements->GetNext()) {
  $mat = trim($arEl['PROPERTY_MATERIAL_VALUE']);
  if ($mat && !in_array($mat, $materials)) {
    $materials[] = $mat;
  }
}

// Если материалы не найдены через элементы, попробуем получить их из справочника свойств
if (empty($materials)) {
  error_log("No materials found in elements, trying property enum...");
  $property_enums = CIBlockPropertyEnum::GetList(
    ["SORT" => "ASC"],
    ["IBLOCK_ID" => 29, "CODE" => "MATERIAL"]
  );
  while ($enum_fields = $property_enums->GetNext()) {
    $materials[] = $enum_fields["VALUE"];
  }
  error_log("Materials from property enum: " . print_r($materials, true));
}

// Получаем уникальные коллекции для текущего раздела
$collections = [];
$rsElements = CIBlockElement::GetList([], $sectionFilter, false, false, ['ID', 'PROPERTY_KOLLEKTSIYA']);
while ($arEl = $rsElements->GetNext()) {
  $coll = trim($arEl['PROPERTY_KOLLEKTSIYA_VALUE']);
  if ($coll && !in_array($coll, $collections)) {
    $collections[] = $coll;
  }
}

// Если коллекции не найдены через элементы, попробуем получить их из справочника свойств
if (empty($collections)) {
  error_log("No collections found in elements, trying property enum...");
  $property_enums = CIBlockPropertyEnum::GetList(
    ["SORT" => "ASC"],
    ["IBLOCK_ID" => 29, "CODE" => "KOLLEKTSIYA"]
  );
  while ($enum_fields = $property_enums->GetNext()) {
    $collections[] = $enum_fields["VALUE"];
  }
  error_log("Collections from property enum: " . print_r($collections, true));
}
?>
<div class="catdrop">
  <div class="catdrop__header">
    <p class="catdrop__header-title">Фильтры</p>
    <i class="catdrop__header-ico js--close">
      <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18 20.6665L12 12.6665M6 4.6665L12 12.6665M12 12.6665L18 4.6665M12 12.6665L6 20.6665" stroke="#232229"
              stroke-width="1.5"/>
      </svg>
    </i>
  </div>
  <div class="catdrop__main">
    <?php if (!empty($categories)): ?>
      <div class="catdrop-block" data-type="Категория">
        <button class="catdrop-block__open"><span>Категории</span><i>...</i></button>
        <div class="catdrop-block__wrap">
          <div class="catdrop-block__body">
            <div class="catdrop-block__radios">
              <?php foreach ($categories as $i => $cat): ?>
                <div class="catdrop-block__radios-item">
                  <input
                    data-val="<?= htmlspecialchars($cat['CODE']) ?>"
                    type="radio"
                    value="<?= htmlspecialchars($cat['NAME']) ?>"
                    name="categories"
                    id="categories-<?= $cat['CODE'] ?>"
                    <?= (!empty($_REQUEST['SECTION_CODE']) && $_REQUEST['SECTION_CODE'] === $cat['CODE']) ? ' checked' : '' ?>
                  >
                  <label for="categories-<?= $cat['CODE'] ?>"><?= htmlspecialchars($cat['NAME']) ?></label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <?php
    $selectedSizes = [];
    if (!empty($_GET['size'])) {
      $selectedSizes = explode(',', $_GET['size']);
    }
    ?>
    <?php if (!empty($sizes)): ?>
      <div class="catdrop-block" data-type="Размер">
        <button class="catdrop-block__open"><span>Размер</span><i>...</i></button>
        <div class="catdrop-block__wrap">
          <div class="catdrop-block__body">
            <div class="catdrop-block__checks">
              <?php foreach ($sizes as $i => $size): ?>
                <div class="catdrop-block__checks-item">
                  <input type="checkbox" value="<?= htmlspecialchars($size) ?>" name="size"
                         id="size-<?= $i ?>" <?= in_array($size, $selectedSizes) ? 'checked' : '' ?>>
                  <label for="size-<?= $i ?>"><?= htmlspecialchars($size) ?></label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <?php
    $selectedColors = [];
    if (!empty($_GET['color'])) {
      $selectedColors = explode(',', $_GET['color']);
    }
    ?>
    <?php if (!empty($colors)): ?>
      <div class="catdrop-block" data-type="Цвет">
        <button class="catdrop-block__open"><span>Цвет</span><i>...</i></button>
        <div class="catdrop-block__wrap">
          <div class="catdrop-block__body">
            <div class="catdrop-block__color">
              <?php foreach ($colors as $i => $color): ?>
                <div class="catdrop-block__color-item">
                  <input type="checkbox" name="color" value="<?= htmlspecialchars($color) ?>"
                         id="color-<?= $i ?>" <?= in_array($color, $selectedColors) ? 'checked' : '' ?>>
                  <label for="color-<?= $i ?>"><span
                      style="background-image: url(<?= MyTools::getColor($color) ?>)"></span></label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <?php
    $selectedMaterials = [];
    if (!empty($_GET['material'])) {
      $selectedMaterials = explode(',', $_GET['material']);
    }
    ?>
    <?php if (!empty($materials)): ?>
      <div class="catdrop-block" data-type="Материалы">
        <button class="catdrop-block__open"><span>Материалы</span><i>...</i></button>
        <div class="catdrop-block__wrap">
          <div class="catdrop-block__body">
            <div class="catdrop-block__checks">
              <?php foreach ($materials as $i => $mat): ?>
                <div class="catdrop-block__checks-item">
                  <input type="checkbox" value="<?= htmlspecialchars($mat) ?>" name="material"
                         id="material-<?= $i ?>" <?= in_array($mat, $selectedMaterials) ? 'checked' : '' ?>>
                  <label for="material-<?= $i ?>"><?= htmlspecialchars($mat) ?></label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <?php
    $selectedCollections = [];
    if (!empty($_GET['collection'])) {
      $selectedCollections = explode(',', $_GET['collection']);
    }
    ?>
    <?php if (!empty($collections)): ?>
      <div class="catdrop-block" data-type="Коллекции">
        <button class="catdrop-block__open"><span>Коллекции</span><i>...</i></button>
        <div class="catdrop-block__wrap">
          <div class="catdrop-block__body">
            <div class="catdrop-block__checks">
              <?php foreach ($collections as $i => $coll): ?>
                <div class="catdrop-block__checks-item">
                  <input type="checkbox" value="<?= htmlspecialchars($coll) ?>" name="collection"
                         id="collections-<?= $i ?>" <?= in_array($coll, $selectedCollections) ? 'checked' : '' ?>>
                  <label for="collections-<?= $i ?>"><?= htmlspecialchars($coll) ?></label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
  <div class="catdrop__footer">
    <button class="catdrop__reset">Сбросить всё</button>
    <button class="catdrop__apply js--close">Показать</button>
  </div>
</div>

<?php
// Если запрос только для обновления фильтров, завершаем выполнение
if ($_GET['update_filters'] === 'Y') {
  die();
}
?>

<div class="backdrop"></div>
<?php
$APPLICATION->IncludeComponent(
    'mindbox:view.category',
    '',
    ['CATEGORY_ID' => $arResult['ID']]
);
?>
