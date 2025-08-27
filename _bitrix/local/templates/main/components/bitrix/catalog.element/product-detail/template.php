<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>

<div class="breadcrumbs">
  <div class="container">
    <div class="breadcrumbs__row desc">
      <a href="/">
        Главная
      </a>
      <a href="/catalog/">
        Каталог
      </a>
      <? if ($arResult["SECTION"]["NAME"]): ?>
        <a href="<?= $arResult["SECTION"]["SECTION_PAGE_URL"] ?>">
          <?= $arResult["SECTION"]["NAME"] ?>
        </a>
      <? endif; ?>
      <span>
        <?= $arResult["PROPERTIES"]["NAIMENOVANIE_TOVARA_NA_SAYTE_ETIKETKE"]["VALUE"] ?: $arResult["NAME"] ?>
      </span>
    </div>
    <a href="/catalog/" class="breadcrumbs__back mob">
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

<section class="pageprod">
  <div class="pageprod__wrap">
    <div class="container">
      <div class="pageprod__row">
        <div class="pageprod__left">
          <div class="pageprod__gallery">
            <div class="pageprod__gallery-thumbs swiper">
              <div class="swiper-wrapper">
                <? if ($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"]): ?>
                  <? foreach ($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $photoId): ?>
                    <? $photo = CFile::GetFileArray($photoId); ?>
                    <div class="swiper-slide">
                      <div class="pageprod__gallery-thumb">
                        <img src="<?= $photo["SRC"] ?>" alt="<?= $arResult["NAME"] ?>">
                      </div>
                    </div>
                  <? endforeach; ?>
                <? else: ?>
                  <? if ($arResult["PREVIEW_PICTURE"]["SRC"]): ?>
                    <div class="swiper-slide">
                      <div class="pageprod__gallery-thumb">
                        <img src="<?= $arResult["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $arResult["NAME"] ?>">
                      </div>
                    </div>
                  <? else: ?>
                    <div class="swiper-slide">
                      <div class="pageprod__gallery-thumb">
                        <img src="/assets/img/no-photo.jpg" alt="<?= $arResult["NAME"] ?>">
                      </div>
                    </div>
                  <? endif; ?>
                <? endif; ?>
              </div>
            </div>
            <div class="pageprod__gallery-main swiper">
              <div class="swiper-wrapper">
                <? if ($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"]): ?>
                  <? foreach ($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $photoId): ?>
                    <? $photo = CFile::GetFileArray($photoId); ?>
                    <div class="swiper-slide">
                      <a href="<?= $photo["SRC"] ?>" data-fancybox="gallery" class="pageprod__gallery-slide">
                        <img src="<?= $photo["SRC"] ?>" alt="<?= $arResult["NAME"] ?>">
                      </a>
                    </div>
                  <? endforeach; ?>
                <? else: ?>
                  <? if ($arResult["PREVIEW_PICTURE"]["SRC"]): ?>
                    <div class="swiper-slide">
                      <a href="<?= $arResult["PREVIEW_PICTURE"]["SRC"] ?>" data-fancybox="gallery"
                         class="pageprod__gallery-slide">
                        <img src="<?= $arResult["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $arResult["NAME"] ?>">
                      </a>
                    </div>
                  <? else: ?>
                    <div class="swiper-slide">
                      <a href="/assets/img/no-photo.jpg" data-fancybox="gallery" class="pageprod__gallery-slide">
                        <img src="/assets/img/no-photo.jpg" alt="<?= $arResult["NAME"] ?>">
                      </a>
                    </div>
                  <? endif; ?>
                <? endif; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="pageprod__right">
          <h1 class="pageprod__title">
            <?= $arResult["PROPERTIES"]["NAIMENOVANIE_TOVARA_NA_SAYTE_ETIKETKE"]["VALUE"] ?: $arResult["NAME"] ?>
          </h1>

          <p class="pageprod__prices">
            <?
            // Получаем торговые предложения для цены
            $arInfo = CCatalogSKU::GetInfoByProductIBlock($arResult["IBLOCK_ID"]);
            $rsOffers = CIBlockElement::GetList([], ['IBLOCK_ID' => $arInfo['IBLOCK_ID'], 'PROPERTY_' . $arInfo['SKU_PROPERTY_ID'] => $arResult['ID']], false, false, ["ID", "IBLOCK_ID", "NAME", "PRICE_7"]);
            $arOffer = $rsOffers->GetNext();
            $price = $arOffer ? $arOffer['PRICE_7'] : 0;
            ?>
            <?= number_format($price, 0, '.', ' ') ?>₽
          </p>

          <div class="pageprod__params prodpar">
            <?
            // Получаем цвета через функцию MyTools::getVariantColors
            $colors_list = MyTools::getVariantColors($arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]);
            if ($colors_list) { ?>
              <div class="prodpar__block prodpar__block_color">
                <p class="prodpar__block-title">
                  Цвет
                </p>
                <div class="prodpar__block-colors">
                  <? foreach ($colors_list as $color => $detail_page) { ?>
                    <div class="prodpar__block-color">
                      <input
                        data-url="<?= $detail_page ?>"
                        type="radio"
                        name="color"
                        id="color-<?= $color ?>"
                        value="<?= $color ?>"
                        <?= (basename($detail_page) === basename($_SERVER['REQUEST_URI'])) ? 'checked' : '' ?>
                      >
                      <label for="color-<?= $color ?>">
                        <span style="background-image: url(<?= MyTools::getColor($color) ?>)"></span>
                        <p><?= $color ?></p>
                      </label>
                    </div>
                  <? } ?>
                </div>
              </div>
            <? } ?>

            <?
            // Получаем размеры из торговых предложений
            $arInfo = CCatalogSKU::GetInfoByProductIBlock($arResult["IBLOCK_ID"]);
            $rsOffers = CIBlockElement::GetList([], ['IBLOCK_ID' => $arInfo['IBLOCK_ID'], 'PROPERTY_' . $arInfo['SKU_PROPERTY_ID'] => $arResult['ID']], false, false, ["ID", "IBLOCK_ID", "NAME", "PROPERTY_RAZMER"]);
            $sizes_list = [];
            while ($rs = $rsOffers->GetNextElement()) {
              $arOffer = $rs->getFields();
              $arOffer['PROPERTIES'] = $rs->getProperties();
              $sizes_list[] = [
                'id' => $arOffer['ID'],
                'title' => $arOffer['PROPERTIES']['RAZMER']['VALUE'],
              ];
            }
            if ($sizes_list): ?>
              <div class="prodpar__block">
                <p class="prodpar__block-title">
                  Размер
                </p>
                <div class="prodpar__block-sizes">
                  <? foreach ($sizes_list as $size): ?>
                    <div class="prodpar__block-size">
                      <input type="radio" name="size" id="size-<?= $size['id'] ?>" value="<?= $size['title'] ?>">
                      <label for="size-<?= $size['id'] ?>">
                        <?= $size['title'] ?>
                      </label>
                    </div>
                  <? endforeach; ?>
                </div>
                <button class="prodpar__block-guide js--modal" data-modal="modalguide">
                  Гайд по размерам
                </button>
              </div>
            <? endif; ?>
          </div>

          <div class="pageprod__buy">
            <div class="pageprod__buy-top">
              <button class="pageprod__buy-cart" data-product-id="<?= $arResult["ID"] ?>" data-offer-id="">
                В корзину
              </button>
              <button class="pageprod__buy-like product-card__like" data-product-id="<?= $arResult["ID"] ?>"
                      style="position: relative; top: auto; left: auto; bottom: auto; right: auto; opacity: 1;">
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg" class="default">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M3.74114 6.13008C4.69415 5.19149 5.98431 4.6662 7.32722 4.6662C8.66549 4.6662 9.95138 5.18787 10.9034 6.12038L12 7.12621L13.0966 6.12038C14.0486 5.18787 15.3345 4.6662 16.6728 4.6662C18.0157 4.6662 19.3058 5.19149 20.2589 6.13008C21.2123 7.06906 21.75 8.34504 21.75 9.67796C21.75 11.01 21.213 12.2851 20.2608 13.2239C20.2601 13.2246 20.2595 13.2252 20.2589 13.2258L12 21.4763L3.73919 13.2239C2.78701 12.2851 2.25 11.01 2.25 9.67796C2.25 8.34504 2.78774 7.06906 3.74114 6.13008ZM7.32722 6.1662C6.37482 6.1662 5.4637 6.53892 4.79369 7.1988C4.12406 7.85829 3.75 8.75031 3.75 9.67796C3.75 10.6056 4.12406 11.4976 4.79369 12.1571L4.79749 12.1609L12 19.3561L19.2063 12.1571C19.8759 11.4976 20.25 10.6056 20.25 9.67796C20.25 8.75031 19.8759 7.85829 19.2063 7.1988C18.5363 6.53892 17.6252 6.1662 16.6728 6.1662C15.7204 6.1662 14.8093 6.53892 14.1392 7.1988L14.1298 7.20814L12 9.16165L9.87024 7.20814L9.86075 7.1988C9.19074 6.53892 8.27961 6.1662 7.32722 6.1662Z"
                        fill="#232229"/>
                </svg>

                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="check">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M3.74187 5.96389C4.69488 5.02529 5.98505 4.5 7.32795 4.5C8.66622 4.5 9.95211 5.02167 10.9041 5.95418L12.0007 6.96001L13.0973 5.95418C14.0494 5.02167 15.3352 4.5 16.6735 4.5C18.0164 4.5 19.3066 5.02529 20.2596 5.96389C21.213 6.90286 21.7507 8.17884 21.7507 9.51177C21.7507 10.8438 21.2137 12.1189 20.2615 13.0577L20.2596 13.0596L12.0007 21.3101L3.73992 13.0577C2.78774 12.1189 2.25073 10.8438 2.25073 9.51177C2.25073 8.17884 2.78847 6.90286 3.74187 5.96389ZM7.32795 6C6.37556 6 5.46443 6.37272 4.79442 7.0326C4.1248 7.69209 3.75073 8.58411 3.75073 9.51177C3.75073 10.4394 4.1248 11.3314 4.79442 11.9909L4.79822 11.9947L12.0007 19.1899L19.207 11.9909C19.8767 11.3314 20.2507 10.4394 20.2507 9.51177C20.2507 8.58411 19.8767 7.69209 19.207 7.0326C18.537 6.37272 17.6259 6 16.6735 6C15.7211 6 14.81 6.37272 14.14 7.0326L14.1305 7.04194L12.0007 8.99545L9.87098 7.04194L9.86148 7.0326C9.19147 6.37272 8.28035 6 7.32795 6Z"
                        fill="#232229"/>
                  <path
                    d="M4.79442 7.0326C5.46443 6.37272 6.37556 6 7.32795 6C8.28035 6 9.19147 6.37272 9.86148 7.0326L9.87098 7.04194L12.0007 8.99545L14.1305 7.04194L14.14 7.0326C14.81 6.37272 15.7211 6 16.6735 6C17.6259 6 18.537 6.37272 19.207 7.0326C19.8767 7.69209 20.2507 8.58411 20.2507 9.51177C20.2507 10.4394 19.8767 11.3314 19.207 11.9909L12.0007 19.1899L4.79822 11.9947L4.79442 11.9909C4.1248 11.3314 3.75073 10.4394 3.75073 9.51177C3.75073 8.58411 4.1248 7.69209 4.79442 7.0326Z"
                    fill="#232229"/>
                </svg>
              </button>
            </div>

            <? if ($arResult["PRICES"]["BASE"]["DISCOUNT_VALUE"]): ?>
              <a href="" class="pageprod__buy-dolyami">
                <div class="pageprod__buy-left">
                  <i class="pageprod__buy-ico">
                    <svg width="86" height="25" viewBox="0 0 86 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect y="0.166504" width="86" height="24" rx="1" fill="#232229"/>
                      <path d="M20.4241 7.1665H18.7555V15.6276H20.4241V7.1665Z" fill="white"/>
                      <path d="M16.8389 7.63996H15.1704V16.1009H16.8389V7.63996Z" fill="white"/>
                      <path d="M13.2537 8.16852H11.5852V16.631H13.2537V8.16852Z" fill="white"/>
                      <path d="M9.66852 8.70296H8L8.00001 17.1665H9.66853L9.66852 8.70296Z" fill="white"/>
                      <path
                        d="M64.4933 11.6743L61.8068 8.68726H60.2362V15.6032H61.876V11.1907L64.3287 13.805H64.6318L67.0424 11.1907V15.6032H68.6822V8.68726H67.1116L64.4933 11.6743Z"
                        fill="white"/>
                      <path
                        d="M76.4946 8.68726L72.4302 13.1824V8.68726H70.7904V15.6032H72.2927L76.3572 11.1081V15.6032H77.997V8.68726H76.4946Z"
                        fill="white"/>
                      <path
                        d="M51.4036 11.2179C51.4036 12.319 52.0057 13.1864 52.93 13.5501L51.1969 15.6032H53.204L54.7806 13.7355H56.4867V15.6032H58.1265V8.68726H53.9517C52.3951 8.68726 51.4036 9.75211 51.4036 11.2179ZM56.4877 10.2105V12.2556H54.2557C53.5111 12.2556 53.1117 11.8405 53.1117 11.232C53.1117 10.6235 53.5251 10.2085 54.2557 10.2085L56.4877 10.2105Z"
                        fill="white"/>
                      <path
                        d="M43.7834 10.0705C43.683 12.449 43.1812 13.9843 42.1988 13.9843H41.9529V15.6445L42.2148 15.6586C44.1848 15.7684 45.2737 14.0397 45.4523 10.2639H48.0435V15.6032H49.6804V8.68726H43.8386L43.7834 10.0705Z"
                        fill="white"/>
                      <path
                        d="M37.6105 8.59064C35.3926 8.59064 33.797 10.1259 33.797 12.1448C33.797 14.2332 35.5331 15.7141 37.6105 15.7141C39.7742 15.7141 41.4552 14.1506 41.4552 12.1448C41.4552 10.139 39.7742 8.59064 37.6105 8.59064ZM37.6105 14.0539C36.3571 14.0539 35.503 13.2379 35.503 12.1448C35.503 11.0246 36.3581 10.2307 37.6105 10.2307C38.863 10.2307 39.7461 11.0608 39.7461 12.1448C39.7461 13.2288 38.8509 14.0539 37.6105 14.0539Z"
                        fill="white"/>
                      <path
                        d="M32.0578 8.70031H26.2702L26.215 10.0835C26.1327 12.0762 25.6129 13.9711 24.6304 13.9984L24.1758 14.0125V17.1664L25.8297 17.1631V15.6042H31.5751V17.1631H33.243V13.9984H32.0578V8.70031ZM30.418 13.9984H26.9185C27.5106 13.0997 27.8278 11.7991 27.883 10.2779H30.418V13.9984Z"
                        fill="white"/>
                    </svg>
                  </i>
                  <p class="pageprod__buy-txt">
                    4 платежа по <?= number_format($arResult["PRICES"]["BASE"]["DISCOUNT_VALUE"] / 4, 0, '.', ' ') ?> ₽
                  </p>
                </div>
                <i class="pageprod__buy-arrow">
                  <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M9.08203 4.1665V2.6665H7.58203V4.1665C7.58203 6.81852 9.23625 9.05631 11.602 10.1665C9.23625 11.2767 7.58203 13.5145 7.58203 16.1665V17.6665H9.08203V16.1665C9.08203 13.3394 11.6547 10.9165 14.9987 10.9165V9.4165C11.6547 9.4165 9.08203 6.99362 9.08203 4.1665Z"
                          fill="#232229"/>
                  </svg>
                </i>
              </a>
            <? endif; ?>
          </div>

          <div class="pageprod__info">
            <? if ($arResult["PREVIEW_TEXT"]): ?>
              <p class="pageprod__info-txt">
                <?= $arResult["PREVIEW_TEXT"] ?>
              </p>
            <? endif; ?>

            <? if ($arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]): ?>
              <p class="pageprod__info-artikul">
                Артикул: <?= $arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"] ?>
              </p>
            <? endif; ?>

            <? if ($arResult["DETAIL_TEXT"]): ?>
              <p class="pageprod__info-artikul">
                <?= $arResult["DETAIL_TEXT"] ?>
              </p>
            <? endif; ?>

            <div class="pageprod-accords">
              <? if ($arResult["PROPERTIES"]["UKHOD"]["VALUE"]): ?>
                <div class="pageprod-accords__item">
                  <button class="pageprod-accords__open">
                    <p>Детали и уход</p>
                    <i><span></span><span></span></i>
                  </button>
                  <div class="pageprod-accords__wrap">
                    <div class="pageprod-accords__body">
                      <p><?
                        $ukhod = $arResult["PROPERTIES"]["UKHOD"]["VALUE"];
                        if (is_array($ukhod) && isset($ukhod["TEXT"])) {
                          echo $ukhod["TEXT"];
                        } else {
                          echo $ukhod;
                        }
                        ?></p>
                    </div>
                  </div>
                </div>
              <? endif; ?>


              <div class="pageprod-accords__item">
                <button class="pageprod-accords__open">
                  <p>Доставка и оплата</p>
                  <i><span></span><span></span></i>
                </button>
                <div class="pageprod-accords__wrap">
                  <div class="pageprod-accords__body">
                    <p>
                      — Доставка: курьером по городу — 1-2 дня, в регионы — 3-7 дней. Самовывоз из пунктов выдачи доступен.
                      <br>— Оплата: онлайн на сайте, картой при получении или наличными. Возврат и обмен в течение 14 дней.
                    </p>
                  </div>
                </div>
              </div>

              <div class="pageprod-accords__item">
                <button class="pageprod-accords__open">
                  <p>Задать вопрос про товар</p>
                  <i><span></span><span></span></i>
                </button>
                <div class="pageprod-accords__wrap">
                  <div class="pageprod-accords__body">
                    <p>
<!--                      <a href="">Online-чат</a> <br><br>-->
<!--                      <a href="">Whatsapp</a> <br><br>-->
                      <a href="https://t.me/ivolgafashion" target="_blank">Telegram</a> <br><br>
                      <a href="https://vk.com/ivolgamoscow" target="_blank">vk.com</a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Функции избранного подключены в custom.js -->
<script>
  // Инициализация состояния кнопки избранного на детальной странице
  document.addEventListener('DOMContentLoaded', function () {
    const likeButton = document.querySelector('.pageprod__buy-like');
    if (likeButton) {
      const productId = likeButton.dataset.productId;
      if (productId && isFavourite(productId)) {
        likeButton.classList.add('active');
      }
    }

    // Обработчик выбора размера для обновления ID торгового предложения
    const sizeInputs = document.querySelectorAll('input[name="size"]');
    const colorInputs = document.querySelectorAll('input[name="color"]');
    const addToCartButton = document.querySelector('.pageprod__buy-cart');

    // Функция для проверки состояния кнопки
    function updateAddToCartButtonState() {
      if (!addToCartButton) return;

      const hasSelectedSize = addToCartButton.dataset.offerId && addToCartButton.dataset.offerId !== '';
      const hasSelectedColor = !colorInputs.length || (addToCartButton.dataset.selectedColor && addToCartButton.dataset.selectedColor !== '');

      if (sizeInputs.length > 0 && !hasSelectedSize) {
        addToCartButton.disabled = true;
        addToCartButton.style.opacity = '0.5';
        addToCartButton.style.cursor = 'not-allowed';
        addToCartButton.textContent = 'Выберите размер';
      } else if (colorInputs.length > 0 && !hasSelectedColor) {
        addToCartButton.disabled = true;
        addToCartButton.style.opacity = '0.5';
        addToCartButton.style.cursor = 'not-allowed';
        addToCartButton.textContent = 'Выберите цвет';
      } else {
        addToCartButton.disabled = false;
        addToCartButton.style.opacity = '1';
        addToCartButton.style.cursor = 'pointer';
        addToCartButton.textContent = 'В корзину';
      }
    }

    if (sizeInputs.length > 0 && addToCartButton) {
      sizeInputs.forEach(input => {
        input.addEventListener('change', function () {
          const offerId = this.id.replace('size-', '');
          addToCartButton.dataset.offerId = offerId;
          console.log('Selected offer ID:', offerId);
          updateAddToCartButtonState();
        });
      });
    }

    // Обработчик выбора цвета (если есть)
    if (colorInputs.length > 0 && addToCartButton) {
      colorInputs.forEach(input => {
        input.addEventListener('change', function () {
          const selectedColor = this.value;
          addToCartButton.dataset.selectedColor = selectedColor;
          console.log('Selected color:', selectedColor);
          console.log('Button dataset after color selection:', addToCartButton.dataset);
          updateAddToCartButtonState();
        });
      });
    }

    // Инициализируем состояние кнопки
    updateAddToCartButtonState();
  });

  // Функция для открытия уведомления о добавлении в корзину
  const openAlert = () => {
    const cartaler = document.querySelector('.cartaler');
    if (cartaler) {
      cartaler.classList.add('open');

      // Автоматически закрываем через 3 секунды
      setTimeout(() => {
        cartaler.classList.remove('open');
      }, 3000);
    }
  };

  // Функция для обновления информации о товаре в модальном окне
  const updateCartAlertInfo = (productId) => {
    const cartaler = document.querySelector('.cartaler');
    if (!cartaler) return;

    // Получаем информацию о товаре со страницы
    const productName = document.querySelector('.pageprod__title')?.textContent?.trim() || 'Товар';
    // Ищем фото: сначала в .pageprod__img img, если нет — в .product-card__image img
    const productImage = document.querySelector('.pageprod__img img, .product-card__image img')?.src || '/assets/img/no-photo.jpg';
    // Цена — из .pageprod__prices
    const productPrice = document.querySelector('.pageprod__prices')?.textContent?.trim() || '';
    // Старая цена (если есть)
    const productOldPrice = document.querySelector('.pageprod__price-old')?.textContent?.trim() || '';

    // Получаем выбранные характеристики
    const selectedSize = document.querySelector('input[name="size"]:checked')?.nextElementSibling?.textContent?.trim() || '';
    const selectedColor = document.querySelector('input[name="color"]:checked')?.value || '';
    // Также получаем выбранный цвет из кнопки, если он там есть
    const addToCartButton = document.querySelector('.pageprod__buy-cart');
    const buttonSelectedColor = addToCartButton?.dataset?.selectedColor || '';
    const finalSelectedColor = selectedColor || buttonSelectedColor;

    // Обновляем изображение товара
    const cartalerImg = cartaler.querySelector('.cartaler__img img');
    if (cartalerImg) {
      cartalerImg.src = productImage;
      cartalerImg.alt = productName;
    }
    // Обновляем название товара
    const cartalerTitle = cartaler.querySelector('.cartaler__title');
    if (cartalerTitle) {
      cartalerTitle.textContent = productName;
    }
    // Обновляем цены
    const cartalerPriceOld = cartaler.querySelector('.cartaler__price-old');
    if (cartalerPriceOld && productOldPrice) {
      cartalerPriceOld.textContent = productOldPrice;
    }
    const cartalerPriceCurrent = cartaler.querySelector('.cartaler__price-current');
    if (cartalerPriceCurrent && productPrice) {
      cartalerPriceCurrent.textContent = productPrice;
    }
    // Обновляем информацию о характеристиках
    const cartalerInfo = cartaler.querySelector('.cartaler__info');
    if (cartalerInfo) {
      let infoText = '';
      if (finalSelectedColor) {
        infoText += `Цвет: ${finalSelectedColor}`;
      }
      if (selectedSize) {
        if (infoText) infoText += '<br>';
        infoText += `Размер: ${selectedSize}`;
      }
      cartalerInfo.innerHTML = infoText;
    }
  };

  // Функция для закрытия уведомления о добавлении в корзину
  const closeAlert = () => {
    const cartaler = document.querySelector('.cartaler');
    if (cartaler) {
      cartaler.classList.remove('open');
    }
  };
</script>

<? if ($arResult["PROPERTIES"]["RELATED_PRODUCTS"]["VALUE"]): ?>
  <section class="new-products new-products_more">
    <div class="container">
      <div class="new-products__header">
        <h2 class="new-products__title">Дополнит образ</h2>
      </div>
    </div>
    <div class="new-products__slider">
      <div class="swiper new-products__swiper">
        <div class="swiper-wrapper">
          <? foreach ($arResult["PROPERTIES"]["RELATED_PRODUCTS"]["VALUE"] as $relatedProductId): ?>
            <?
            $relatedProduct = CIBlockElement::GetByID($relatedProductId)->GetNext();
            if ($relatedProduct):
              $relatedProduct["DETAIL_PAGE_URL"] = $relatedProduct["DETAIL_PAGE_URL"];
              $relatedProduct["PREVIEW_PICTURE"] = CFile::GetFileArray($relatedProduct["PREVIEW_PICTURE"]);
              ?>
              <div class="swiper-slide">
                <div class="product-card" data-product-id="<?= $relatedProduct['ID'] ?>">
                  <div class="product-card__image">
                    <div class="product-card__slider">
                      <div class="product-card__slider-track">
                        <? if ($relatedProduct["PREVIEW_PICTURE"]["SRC"]): ?>
                          <div class="product-card__slide">
                            <img src="<?= $relatedProduct["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $relatedProduct["NAME"] ?>">
                          </div>
                        <? endif; ?>
                      </div>
                      <div class="product-card__pagination">
                        <span class="product-card__pagination-dot active"></span>
                      </div>
                    </div>
                    <div class="product-card__tags">
                      <? if ($relatedProduct["PROPERTIES"]["NEW"]["VALUE"]): ?>
                        <span class="product-card__tag">Новинка</span>
                      <? endif; ?>
                      <? if ($relatedProduct["PROPERTIES"]["PREORDER"]["VALUE"]): ?>
                        <span class="product-card__tag">Предзаказ</span>
                      <? endif; ?>
                    </div>
                    <i class="product-card__like" data-product-id="<?= $relatedProduct["ID"] ?>">
                      <svg class="activelike" width="20" height="18" viewBox="0 0 20 18" fill="none"
                           xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M1.74163 2.13008C2.69464 1.19149 3.9848 0.666199 5.32771 0.666199C6.66597 0.666199 7.95186 1.18787 8.9039 2.12038L10.0005 3.12621L11.0971 2.12038C12.0491 1.18787 13.335 0.666199 14.6733 0.666199C16.0162 0.666199 17.3063 1.19149 18.2593 2.13008C19.2127 3.06906 19.7505 4.34504 19.7505 5.67796C19.7505 7.00999 19.2135 8.28515 18.2613 9.22394L18.2593 9.22584L10.0005 17.4763L1.73968 9.22392C0.787496 8.28512 0.250488 7.00998 0.250488 5.67796C0.250488 4.34504 0.78823 3.06906 1.74163 2.13008ZM5.32771 2.1662C4.37531 2.1662 3.46419 2.53892 2.79417 3.1988C2.12455 3.85829 1.75049 4.75031 1.75049 5.67796C1.75049 6.60562 2.12455 7.49764 2.79417 8.15713L2.79797 8.16087L10.0005 15.3561L17.2068 8.15712C17.8764 7.49762 18.2505 6.60562 18.2505 5.67796C18.2505 4.75031 17.8764 3.85829 17.2068 3.1988C16.5368 2.53892 15.6257 2.1662 14.6733 2.1662C13.7209 2.1662 12.8097 2.53892 12.1397 3.1988L12.1302 3.20814L10.0005 5.16165L7.87073 3.20814L7.86124 3.1988C7.19123 2.53892 6.2801 2.1662 5.32771 2.1662Z"
                              fill="#232229"/>
                        <path
                          d="M2.79417 3.1988C3.46419 2.53892 4.37531 2.1662 5.32771 2.1662C6.2801 2.1662 7.19123 2.53892 7.86124 3.1988L7.87073 3.20814L10.0005 5.16165L12.1302 3.20814L12.1397 3.1988C12.8097 2.53892 13.7209 2.1662 14.6733 2.1662C15.6257 2.1662 16.5368 2.53892 17.2068 3.1988C17.8764 3.85829 18.2505 4.75031 18.2505 5.67796C18.2505 6.60562 17.8764 7.49762 17.2068 8.15712L10.0005 15.3561L2.79797 8.16087L2.79417 8.15713C2.12455 7.49764 1.75049 6.60562 1.75049 5.67796C1.75049 4.75031 2.12455 3.85829 2.79417 3.1988Z"
                          fill="#232229"/>
                      </svg>
                      <svg class="deflike" width="21" height="18" viewBox="0 0 21 18" fill="none"
                           xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M2.24212 1.96389C3.19513 1.02529 4.48529 0.5 5.8282 0.5C7.16646 0.5 8.45235 1.02167 9.40439 1.95418L10.501 2.96001L11.5976 1.95418C12.5496 1.02167 13.8355 0.5 15.1738 0.5C16.5167 0.5 17.8068 1.02529 18.7598 1.96389C19.7132 2.90286 20.251 4.17884 20.251 5.51177C20.251 6.84379 19.714 8.11895 18.7618 9.05774C18.7611 9.05838 18.7605 9.05901 18.7598 9.05964L10.501 17.3101L2.24017 9.05772C1.28798 8.11893 0.750977 6.84378 0.750977 5.51177C0.750977 4.17884 1.28872 2.90286 2.24212 1.96389ZM5.8282 2C4.8758 2 3.96467 2.37272 3.29466 3.0326C2.62504 3.69209 2.25098 4.58411 2.25098 5.51177C2.25098 6.43942 2.62504 7.33144 3.29466 7.99093L3.29846 7.99468L10.501 15.1899L17.7073 7.99092C18.3769 7.33143 18.751 6.43942 18.751 5.51177C18.751 4.58411 18.3769 3.69209 17.7073 3.0326C17.0373 2.37272 16.1262 2 15.1738 2C14.2214 2 13.3102 2.37272 12.6402 3.0326L12.6307 3.04194L10.501 4.99545L8.37122 3.04194L8.36173 3.0326C7.69172 2.37272 6.78059 2 5.8282 2Z"
                              fill="#232229"/>
                      </svg>
                    </i>
                  </div>
                  <a href="<?= $relatedProduct["DETAIL_PAGE_URL"] ?>" class="product-card__info">
                    <h3 class="product-card__title"><?= $relatedProduct["NAME"] ?></h3>
                    <div class="product-card__price">
                      <div class="product-card__price-current">
                        <span><?= number_format($relatedProduct["PRICES"]["BASE"]["VALUE"], 0, '.', ' ') ?>₽</span>
                        <? if ($relatedProduct["PRICES"]["BASE"]["DISCOUNT_DIFF"] > 0): ?>
                          <div class="product-card__discount">
                            -<?= round(($relatedProduct["PRICES"]["BASE"]["DISCOUNT_DIFF"] / $relatedProduct["PRICES"]["BASE"]["VALUE"]) * 100) ?>
                            %
                          </div>
                        <? endif; ?>
                      </div>
                      <? if ($relatedProduct["PRICES"]["BASE"]["DISCOUNT_VALUE"]): ?>
                        <span
                          class="product-card__price-old"><?= number_format($relatedProduct["PRICES"]["BASE"]["VALUE"], 0, '.', ' ') ?>₽</span>
                      <? endif; ?>
                    </div>
                  </a>
                  <div class="product-card__footer">
                    <? if ($relatedProduct["PROPERTIES"]["COLORS"]["VALUE"]): ?>
                      <div class="product-card__colors">
                        <? foreach (array_slice($relatedProduct["PROPERTIES"]["COLORS"]["VALUE"], 0, 5) as $key => $color): ?>
                          <a href="<?= $relatedProduct["DETAIL_PAGE_URL"] ?>" class="product-card__colors-item"
                             style="background-color: <?= $relatedProduct["PROPERTIES"]["COLORS"]["VALUE_XML_ID"][$key] ?: '#f6f5f3'; ?>;"></a>
                        <? endforeach; ?>
                      </div>
                    <? endif; ?>
                    <? if ($relatedProduct["PROPERTIES"]["SIZES"]["VALUE"]): ?>
                      <div class="product-card__sizes">
                        <? foreach (array_slice($relatedProduct["PROPERTIES"]["SIZES"]["VALUE"], 0, 5) as $size): ?>
                          <a href="<?= $relatedProduct["DETAIL_PAGE_URL"] ?>" class="product-card__sizes-item"><?= $size ?></a>
                        <? endforeach; ?>
                      </div>
                    <? endif; ?>
                  </div>
                </div>
              </div>
            <? endif; ?>
          <? endforeach; ?>
        </div>
        <div class="new-products__nav">
          <button class="new-products__nav-prev">
            <svg width="32" height="33" viewBox="0 0 32 33" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect x="1" y="1.1665" width="30" height="30" rx="15" stroke="#232229" stroke-width="2"/>
              <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M12.25 21.1665L12.25 20.1665C12.25 18.3716 10.7949 16.9165 9 16.9165L9 15.4165C11.6234 15.4165 13.75 17.5432 13.75 20.1665L13.75 21.1665L12.25 21.1665Z"
                    fill="#232229"/>
              <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M9 15.4165C10.7949 15.4165 12.25 13.9614 12.25 12.1665L12.25 11.1665L13.75 11.1665L13.75 12.1665C13.75 14.7899 11.6234 16.9165 9 16.9165L9 15.4165Z"
                    fill="#232229"/>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M9 15.4165L27 15.4165L27 16.9165L9 16.9165L9 15.4165Z"
                    fill="#232229"/>
            </svg>
          </button>
          <button class="new-products__nav-next">
            <svg width="32" height="33" viewBox="0 0 32 33" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect x="1" y="1.1665" width="30" height="30" rx="15" stroke="#232229" stroke-width="2"/>
              <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M20.9166 11.9999V12.8332C20.9166 14.2599 22.0732 15.4165 23.5 15.4165V16.9165C21.2448 16.9165 19.4166 15.0884 19.4166 12.8332V11.9999H20.9166Z"
                    fill="#232229"/>
              <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M23.5 16.9165C22.0732 16.9165 20.9166 18.0731 20.9166 19.4998V20.3332H19.4166V19.4998C19.4166 17.2447 21.2448 15.4165 23.5 15.4165V16.9165Z"
                    fill="#232229"/>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M23.5 16.9165H8.5V15.4165H23.5V16.9165Z" fill="#232229"/>
            </svg>
          </button>
        </div>
        <div class="new-products__pag mob"></div>
      </div>
    </div>
  </section>
<? endif; ?>
