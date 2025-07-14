<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<section class="collectionsinfo">
  <div class="container">
    <div class="collectionsinfo__content collectionsinfo__content_first">
      <h2>
        <?= htmlspecialcharsbx($arResult['NAME']) ?>
      </h2>
    </div>
  </div>
  <? if ($arResult['PROPERTIES']['PICTURE']['VALUE']): ?>
    <div class="collectionsinfo__fullimage">
      <img src="<?= CFile::GetPath($arResult['PROPERTIES']['PICTURE']['VALUE']) ?>" alt="<?= htmlspecialcharsbx($arResult['NAME']) ?>">
    </div>
  <? endif; ?>
  <div class="container">
    <div class="collectionsinfo__content">
      <? if ($arResult['PROPERTIES']['SUBTITLE']['VALUE']): ?>
        <h3><?= htmlspecialcharsbx($arResult['PROPERTIES']['SUBTITLE']['VALUE']) ?></h3><? endif; ?>
    </div>
  </div>
  <? if (is_array($arResult['PROPERTIES']['ITEMS']['VALUE']) && count($arResult['PROPERTIES']['ITEMS']['VALUE'])): ?>
    <div class="collectionsinfo__row">
      <? foreach ($arResult['PROPERTIES']['ITEMS']['VALUE'] as $itemImg): ?>
        <div class="collectionsinfo__col">
          <div class="collectionsinfo-image">
            <img src="<?= CFile::GetPath($itemImg) ?>" alt="<?= htmlspecialcharsbx($arResult['NAME']) ?>">
          </div>
        </div>
      <? endforeach; ?>
    </div>
  <? endif; ?>
  <div class="container">
    <div class="collectionsinfo__content">
      <? if ($arResult['DETAIL_TEXT']): ?><?= $arResult['DETAIL_TEXT'] ?><? endif; ?>
    </div>
  </div>
  <? if (is_array($arResult['PROPERTIES']['GALLERY']['VALUE']) && count($arResult['PROPERTIES']['GALLERY']['VALUE'])): ?>
    <div class="collectionsinfo__gallery">
      <div class="collectionsinfo__gallery-slider swiper">
        <div class="swiper-wrapper">
          <? foreach ($arResult['PROPERTIES']['GALLERY']['VALUE'] as $galleryImg): ?>
            <div class="swiper-slide">
              <div class="collectionsinfo__gallery-item">
                <img src="<?= CFile::GetPath($galleryImg) ?>" alt="<?= htmlspecialcharsbx($arResult['NAME']) ?>">
              </div>
            </div>
          <? endforeach; ?>
        </div>
      </div>
      <div class="collectionsinfo__gallery-nav">
        <button class="collectionsinfo__gallery-prev">
          <svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="1.5" y="1" width="30" height="30" rx="15" stroke="white" stroke-width="2"/>
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M12.75 21L12.75 20C12.75 18.2051 11.2949 16.75 9.5 16.75L9.5 15.25C12.1234 15.25 14.25 17.3766 14.25 20L14.25 21L12.75 21Z"
                  fill="white"/>
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M9.5 15.25C11.2949 15.25 12.75 13.7949 12.75 12L12.75 11L14.25 11L14.25 12C14.25 14.6234 12.1234 16.75 9.5 16.75L9.5 15.25Z"
                  fill="white"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.5 15.25L27.5 15.25L27.5 16.75L9.5 16.75L9.5 15.25Z" fill="white"/>
          </svg>
        </button>
        <div class="collectionsinfo__gallery-counter">
          <span class="current">01</span> / <span
            class="total"><?= str_pad(count($arResult['PROPERTIES']['GALLERY']['VALUE']), 2, '0', STR_PAD_LEFT) ?></span>
        </div>
        <button class="collectionsinfo__gallery-next">
          <svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="1.5" y="1" width="30" height="30" rx="15" stroke="white" stroke-width="2"/>
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M21.4141 11.8335V12.6668C21.4141 14.0936 22.5707 15.2502 23.9974 15.2502V16.7502C21.7422 16.7502 19.9141 14.922 19.9141 12.6668V11.8335H21.4141Z"
                  fill="white"/>
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M23.9974 16.75C22.5707 16.75 21.4141 17.9066 21.4141 19.3333V20.1667H19.9141V19.3333C19.9141 17.0782 21.7422 15.25 23.9974 15.25V16.75Z"
                  fill="white"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M24 16.75H9V15.25H24V16.75Z" fill="white"/>
          </svg>
        </button>
      </div>
    </div>
  <? endif; ?>
</section>
