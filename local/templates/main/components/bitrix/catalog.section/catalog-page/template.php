<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>

  <div class="container">
    <? if ($arResult["SECTIONS"]): ?>
      <ul class="catalogpage__nav">
        <?
        // Вычисляем общее количество товаров
        $totalElements = 0;

        // Способ 1: через NAV_RESULT
        if (is_object($arResult["NAV_RESULT"]) && method_exists($arResult["NAV_RESULT"], "NavRecordCount")) {
          $totalElements = $arResult["NAV_RESULT"]->NavRecordCount;
        }
        // Способ 2: через секции
        elseif ($arResult["SECTIONS"]) {
          foreach ($arResult["SECTIONS"] as $arSection) {
            $totalElements += $arSection["ELEMENT_CNT"];
          }
        }
        // Способ 3: через ELEMENT_CNT
        elseif ($arResult["ELEMENT_CNT"]) {
          $totalElements = $arResult["ELEMENT_CNT"];
        }
        // Способ 4: через количество товаров в текущем результате
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
            <a href="<?= $arSection["SECTION_PAGE_URL"] ?>" class="<?= $arResult["SECTION"]["ID"] == $arSection["ID"] ? 'active' : '' ?>">
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
        ?>
        <div class="catalogpage__sort desc">
          <p>Сортировать</p>
          <form method="GET" action="">
            <? if ($_REQUEST["SECTION_CODE"]): ?>
              <input type="hidden" name="SECTION_CODE" value="<?= htmlspecialcharsbx($_REQUEST["SECTION_CODE"]) ?>">
            <? endif; ?>
            <? if ($_REQUEST["SECTION_ID"]): ?>
              <input type="hidden" name="SECTION_ID" value="<?= htmlspecialcharsbx($_REQUEST["SECTION_ID"]) ?>">
            <? endif; ?>
            <div class="catalogpage__sort-select">
              <select name="sort" onchange="this.form.submit()">
                <option value="sort" <?= $currentSort == "sort" ? 'selected' : '' ?>>по умолчанию</option>
                <option value="name" <?= $currentSort == "name" ? 'selected' : '' ?>>по названию</option>
                <option value="price" <?= $currentSort == "price" ? 'selected' : '' ?>>по цене</option>
                <option value="date" <?= $currentSort == "date" ? 'selected' : '' ?>>по дате</option>
              </select>
            </div>
            <input type="hidden" name="order" value="<?= $currentOrder ?>">
            <button type="button" class="sort-order-btn" onclick="toggleSortOrder()" title="Изменить направление сортировки">
              <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8 2L14 8L8 14" stroke="#232229" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" transform="<?= $currentOrder == 'desc' ? 'rotate(180 8 8)' : '' ?>"/>
              </svg>
            </button>
            <i>
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15 11.375H5V9.875H15V11.375Z" fill="#232229"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M18.125 7.625H1.875V6.125H18.125V7.625Z" fill="#232229"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.875 15.125H8.125V13.625H11.875V15.125Z" fill="#232229"/>
              </svg>
            </i>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="catalogpage__main">
    <? if ($arResult["ITEMS"]): ?>
      <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCE_ELEMENT_DELETE_CONFIRM')));
        ?>
        <div class="catalogpage__col" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
          <div class="product-card" data-product-id="<?= $arItem['ID'] ?>">
            <div class="product-card__image">
              <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="product-card__slider">
                <div class="product-card__slider-track">
                  <? if ($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"]): ?>
                    <? foreach ($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $imageId): ?>
                      <div class="product-card__slide">
                        <img src="<?= CFile::GetPath($imageId) ?>" alt="<?= $arItem["NAME"] ?>">
                      </div>
                    <? endforeach; ?>
                  <? else: ?>
                    <? if ($arItem["PREVIEW_PICTURE"]["SRC"]): ?>
                      <div class="product-card__slide">
                        <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $arItem["NAME"] ?>">
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
              <i class="product-card__like<?= $arItem["PROPERTIES"]["FAVORITE"]["VALUE"] ? ' active' : '' ?>" data-product-id="<?= $arItem["ID"] ?>">
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
                        -<?= round((($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"] - $arItem["PROPERTIES"]["PRICE"]["VALUE"]) / $arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"]) * 100) ?>%
                      </div>
                    <? endif; ?>
                  </div>
                  <? if ($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"]): ?>
                    <span class="product-card__price-old"><?= number_format($arItem["PROPERTIES"]["OLD_PRICE"]["VALUE"], 0, '.', ' ') ?>₽</span>
                  <? endif; ?>
                <? endif; ?>
              </div>
            </a>

            <div class="product-card__footer">
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

function toggleSortOrder() {
  const form = document.querySelector('.catalogpage__sort form');
  const orderInput = form.querySelector('input[name="order"]');
  orderInput.value = orderInput.value === 'asc' ? 'desc' : 'asc';
  form.submit();
}
</script>
