<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<section class="new-products">
  <div class="container">
    <a href="/catalog/" class="new-products__header">
      <h2 class="new-products__title">Новое</h2>
      <div class="new-products__link">
        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
                d="M17.75 7.1665V8.1665C17.75 9.96143 19.2051 11.4165 21 11.4165V12.9165C18.3766 12.9165 16.25 10.7899 16.25 8.1665V7.1665H17.75Z"
                fill="#232229"/>
          <path fill-rule="evenodd" clip-rule="evenodd"
                d="M21 12.9165C19.2051 12.9165 17.75 14.3716 17.75 16.1665V17.1665H16.25V16.1665C16.25 13.5432 18.3766 11.4165 21 11.4165V12.9165Z"
                fill="#232229"/>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M21 12.9165H3V11.4165H21V12.9165Z" fill="#232229"/>
        </svg>
      </div>
    </a>
  </div>
  <div class="new-products__slider">
    <div class="swiper new-products__swiper">
      <div class="swiper-wrapper">
        <? foreach ($arResult["ITEMS"] as $arItem): ?>
          <div class="swiper-slide" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
            <div class="product-card" data-product-id="<?= $arItem['ID'] ?>">
              <div class="product-card__image">
                <div class="product-card__slider">
                  <div class="product-card__slider-track">
                    <? foreach ($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $imageId): ?>
                      <div class="product-card__slide">
                        <img src="<?= CFile::GetPath($imageId) ?>" alt="<?= $arItem["NAME"] ?>">
                      </div>
                    <? endforeach; ?>
                  </div>
                  <div class="product-card__pagination">
                    <? foreach ($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $index => $imageId): ?>
                      <span class="product-card__pagination-dot<?= $index === 0 ? ' active' : '' ?>"></span>
                    <? endforeach; ?>
                  </div>
                </div>
                <div class="product-card__tags">
                  <span class="product-card__tag">Новинка</span>
                  <span class="product-card__tag">Предзаказ</span>
                </div>
                <i class="product-card__like" data-product-id="<?= $arItem["ID"] ?>">
                  <svg class="deflike" width="21" height="18" viewBox="0 0 21 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M2.24212 1.96389C3.19513 1.02529 4.48529 0.5 5.8282 0.5C7.16646 0.5 8.45235 1.02167 9.40439 1.95418L10.501 2.96001L11.5976 1.95418C12.5496 1.02167 13.8355 0.5 15.1738 0.5C16.5167 0.5 17.8068 1.02529 18.7598 1.96389C19.7132 2.90286 20.251 4.17884 20.251 5.51177C20.251 6.84379 19.714 8.11895 18.7618 9.05774C18.7611 9.05838 18.7605 9.05901 18.7598 9.05964L10.501 17.3101L2.24017 9.05772C1.28798 8.11893 0.750977 6.84378 0.750977 5.51177C0.750977 4.17884 1.28872 2.90286 2.24212 1.96389ZM5.8282 2C4.8758 2 3.96467 2.37272 3.29466 3.0326C2.62504 3.69209 2.25098 4.58411 2.25098 5.51177C2.25098 6.43942 2.62504 7.33144 3.29466 7.99093L3.29846 7.99468L10.501 15.1899L17.7073 7.99092C18.3769 7.33143 18.751 6.43942 18.751 5.51177C18.751 4.58411 18.3769 3.69209 17.7073 3.0326C17.0373 2.37272 16.1262 2 15.1738 2C14.2214 2 13.3102 2.37272 12.6402 3.0326C12.6307 3.04194L10.501 4.99545L8.37122 3.04194L8.36173 3.0326C7.69172 2.37272 6.78059 2 5.8282 2Z"
                          fill="#232229"/>
                  </svg>

                  <svg class="activelike" width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M1.74163 2.13008C2.69464 1.19149 3.9848 0.666199 5.32771 0.666199C6.66597 0.666199 7.95186 1.18787 8.9039 2.12038L10.0005 3.12621L11.0971 2.12038C12.0491 1.18787 13.335 0.666199 14.6733 0.666199C16.0162 0.666199 17.3063 1.19149 18.2593 2.13008C19.2127 3.06906 19.7505 4.34504 19.7505 5.67796C19.7505 7.00999 19.2135 8.28515 18.2613 9.22394L18.2593 9.22584L10.0005 17.4763L1.73968 9.22392C0.787496 8.28512 0.250488 7.00998 0.250488 5.67796C0.250488 4.34504 0.78823 3.06906 1.74163 2.13008ZM5.32771 2.1662C4.37531 2.1662 3.46419 2.53892 2.79417 3.1988C2.12455 3.85829 1.75049 4.75031 1.75049 5.67796C1.75049 6.60562 2.12455 7.49764 2.79417 8.15713L2.79797 8.16087L10.0005 15.3561L17.2068 8.15712C17.8764 7.49762 18.2505 6.60562 18.2505 5.67796C18.2505 4.75031 17.8764 3.85829 17.2068 3.1988C16.5368 2.53892 15.6257 2.1662 14.6733 2.1662C13.7209 2.1662 12.8097 2.53892 12.1397 3.1988L12.1302 3.20814L10.0005 5.16165L7.87073 3.20814L7.86124 3.1988C7.19123 2.53892 6.2801 2.1662 5.32771 2.1662Z"
                          fill="#232229"/>
                    <path
                      d="M2.79417 3.1988C3.46419 2.53892 4.37531 2.1662 5.32771 2.1662C6.2801 2.1662 7.19123 2.53892 7.86124 3.1988L7.87073 3.20814L10.0005 5.16165L12.1302 3.20814L12.1397 3.1988C12.8097 2.53892 13.7209 2.1662 14.6733 2.1662C15.6257 2.1662 16.5368 2.53892 17.2068 3.1988C17.8764 3.85829 18.2505 4.75031 18.2505 5.67796C18.2505 6.60562 17.8764 7.49762 17.2068 8.15712L10.0005 15.3561L2.79797 8.16087L2.79417 8.15713C2.12455 7.49764 1.75049 6.60562 1.75049 5.67796C1.75049 4.75031 2.12455 3.85829 2.79417 3.1988Z"
                      fill="#232229"/>
                  </svg>
                </i>
              </div>
              <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="product-card__info">
                <h3 class="product-card__title"><?= $arItem["NAME"] ?></h3>
                <div class="product-card__price">
                  <div class="product-card__price-current">
                    <span>12 000₽</span>
                    <div class="product-card__discount">-25%</div>
                  </div>
                  <span class="product-card__price-old">16 000₽</span>
                </div>
              </a>
              <div class="product-card__footer">
                <div class="product-card__colors">
                  <a href="" class="product-card__colors-item" style="background-color: #3b3465;"></a>
                  <a href="" class="product-card__colors-item" style="background-color: #34654f;"></a>
                  <a href="" class="product-card__colors-item" style="background-color: #ba6868;"></a>
                  <a href="" class="product-card__colors-item" style="background-color: #232229;"></a>
                  <a href="" class="product-card__colors-item" style="background-color: #fff;"></a>
                </div>
                <div class="product-card__sizes">
                  <a href="" class="product-card__sizes-item">S</a>
                  <a href="" class="product-card__sizes-item">M</a>
                  <a href="" class="product-card__sizes-item">L</a>
                  <a href="" class="product-card__sizes-item">XL</a>
                  <a href="" class="product-card__sizes-item">2XL</a>
                </div>
              </div>
            </div>
          </div>
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
