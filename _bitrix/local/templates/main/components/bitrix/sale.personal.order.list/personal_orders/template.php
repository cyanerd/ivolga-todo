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

<div class="lk-orders">
  <? if ($arResult["NAV_STRING"]): ?>
    <div class="lk-orders__nav">
      <?= $arResult["NAV_STRING"] ?>
    </div>
  <? endif; ?>

  <? if ($arResult["ORDERS"]): ?>
    <? foreach ($arResult["ORDERS"] as $arOrder): ?>
      <div class="lk-orders__item">
        <div class="lk-orders__header">
          <a href="/personal/order/detail/?ID=<?= $arOrder["ORDER"]["ID"] ?>" class="lk-orders__left">
            <p class="lk-orders__num">
              №<?= $arOrder["ORDER"]["ACCOUNT_NUMBER"] ?>
            </p>
            <p class="lk-orders__tag">
              <?= $arResult['INFO']['STATUS'][$arOrder['ORDER']['STATUS_ID']]['NAME'] ?>
            </p>
            <p class="lk-orders__date">
              от <?= $arOrder["ORDER"]["DATE_INSERT_FORMATED"] ?>
            </p>
          </a>
          <a href="/personal/order/detail/?ID=<?= $arOrder["ORDER"]["ID"] ?>" class="lk-orders__buttons">
            <p class="lk-orders__status">
              <?= $arResult['INFO']['STATUS'][$arOrder['ORDER']['STATUS_ID']]['NAME'] ?>
            </p>
            <p class="lk-orders__price">
              <?= $arOrder["ORDER"]["FORMATED_PRICE"] ?>
              <i>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M9.08301 4C9.08301 6.73877 11.4974 9.09837 14.6885 9.24316L15 9.25V10.75C11.656 10.75 9.08301 13.1729 9.08301 16V17.5H7.58301V16C7.58301 13.3469 9.23917 11.1097 11.6064 10C9.23917 8.89026 7.58301 6.65308 7.58301 4V2.5H9.08301V4Z"
                    fill="#232229"/>
                </svg>
              </i>
            </p>
          </a>
        </div>
        <div class="lk-orders__main">
          <? foreach ($arOrder["BASKET_ITEMS"] as $arItem): ?>
            <?php
            $imgSrc = '/assets/img/no-photo.jpg';
            $detailPageUrl = '#';
            if ($arItem['PRODUCT_ID']) {
              // Получаем картинку торгового предложения (SKU)
              $arFilter = ['ID' => $arItem['PRODUCT_ID']];
              $arSelect = ['ID', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'PROPERTY_MORE_PHOTO'];
              $res = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
              $fields = null;
              if ($ob = $res->GetNextElement()) {
                $fields = $ob->GetFields();
                if ($fields['PREVIEW_PICTURE']) {
                  $resize = CFile::ResizeImageGet(
                    $fields['PREVIEW_PICTURE'],
                    ['width' => 200, 'height' => 262],
                    BX_RESIZE_IMAGE_PROPORTIONAL,
                    true
                  );
                  $imgSrc = $resize['src'];
                } elseif ($fields['DETAIL_PICTURE']) {
                  $resize = CFile::ResizeImageGet(
                    $fields['DETAIL_PICTURE'],
                    ['width' => 200, 'height' => 262],
                    BX_RESIZE_IMAGE_PROPORTIONAL,
                    true
                  );
                  $imgSrc = $resize['src'];
                } elseif (!empty($fields['PROPERTY_MORE_PHOTO'])) {
                  $morePhoto = $fields['PROPERTY_MORE_PHOTO'];
                  if (is_array($morePhoto)) {
                    $firstPhoto = reset($morePhoto);
                    if ($firstPhoto) {
                      $resize = CFile::ResizeImageGet(
                        $firstPhoto,
                        ['width' => 200, 'height' => 262],
                        BX_RESIZE_IMAGE_PROPORTIONAL,
                        true
                      );
                      $imgSrc = $resize['src'];
                    }
                  } elseif ($morePhoto) {
                    $resize = CFile::ResizeImageGet(
                      $morePhoto,
                      ['width' => 200, 'height' => 262],
                      BX_RESIZE_IMAGE_PROPORTIONAL,
                      true
                    );
                    $imgSrc = $resize['src'];
                  }
                }
              }
              // Если не нашли картинку у SKU, ищем у родителя
              if ($imgSrc === '/assets/img/no-photo.jpg' && CModule::IncludeModule('catalog')) {
                $parent = CCatalogSku::GetProductInfo($arItem['PRODUCT_ID']);
                if ($parent && $parent['ID']) {
                  $rsParent = CIBlockElement::GetList([], ['ID' => $parent['ID']], false, false, ['ID', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'PROPERTY_MORE_PHOTO', 'DETAIL_PAGE_URL']);
                  if ($arParent = $rsParent->GetNext()) {
                    // Ссылка на детальную страницу
                    $detailPageUrl = $arParent['DETAIL_PAGE_URL'];
                    // Картинка родителя
                    if ($arParent['PREVIEW_PICTURE']) {
                      $resize = CFile::ResizeImageGet(
                        $arParent['PREVIEW_PICTURE'],
                        ['width' => 200, 'height' => 262],
                        BX_RESIZE_IMAGE_PROPORTIONAL,
                        true
                      );
                      $imgSrc = $resize['src'];
                    } elseif ($arParent['DETAIL_PICTURE']) {
                      $resize = CFile::ResizeImageGet(
                        $arParent['DETAIL_PICTURE'],
                        ['width' => 200, 'height' => 262],
                        BX_RESIZE_IMAGE_PROPORTIONAL,
                        true
                      );
                      $imgSrc = $resize['src'];
                    } elseif (!empty($arParent['PROPERTY_MORE_PHOTO'])) {
                      $morePhoto = $arParent['PROPERTY_MORE_PHOTO'];
                      if (is_array($morePhoto)) {
                        $firstPhoto = reset($morePhoto);
                        if ($firstPhoto) {
                          $resize = CFile::ResizeImageGet(
                            $firstPhoto,
                            ['width' => 200, 'height' => 262],
                            BX_RESIZE_IMAGE_PROPORTIONAL,
                            true
                          );
                          $imgSrc = $resize['src'];
                        }
                      } elseif ($morePhoto) {
                        $resize = CFile::ResizeImageGet(
                          $morePhoto,
                          ['width' => 200, 'height' => 262],
                          BX_RESIZE_IMAGE_PROPORTIONAL,
                          true
                        );
                        $imgSrc = $resize['src'];
                      }
                    }
                  }
                }
              } else {
                // Если нашли картинку у SKU, всё равно пробуем получить ссылку на родителя
                if (CModule::IncludeModule('catalog')) {
                  $parent = CCatalogSku::GetProductInfo($arItem['PRODUCT_ID']);
                  if ($parent && $parent['ID']) {
                    $rsParent = CIBlockElement::GetList([], ['ID' => $parent['ID']], false, false, ['ID', 'DETAIL_PAGE_URL']);
                    if ($arParent = $rsParent->GetNext()) {
                      $detailPageUrl = $arParent['DETAIL_PAGE_URL'];
                    }
                  }
                }
              }
            }
            ?>
            <a href="<?= $detailPageUrl ?>" class="lk-orders__prod">
              <img src="<?= $imgSrc ?>" alt="<?= htmlspecialcharsbx($arItem["NAME"]) ?>">
            </a>
          <? endforeach; ?>
        </div>
      </div>
    <? endforeach; ?>
  <? else: ?>
    <div class="lk-orders__empty">
      <p>У вас пока нет заказов</p>
    </div>
  <? endif; ?>
</div>
