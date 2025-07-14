<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<section class="blog">
  <div class="container">
    <a href="/blog/" class="blog__header">
      <h2 class="blog__title">Ivolga Blog</h2>
      <div class="blog__link">
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

  <div class="blog__slider">
    <div class="swiper blog__swiper">
      <div class="swiper-wrapper">
        <? foreach ($arResult["ITEMS"] as $arItem): ?>
          <div class="swiper-slide" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
            <a href="<?= $arItem["PROPERTIES"]["LINK"]["VALUE"] ?>" target="_blank" class="blog-card">
              <div class="blog-card__image">
                <? if ($arItem["PREVIEW_PICTURE"]["SRC"]): ?>
                  <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $arItem["NAME"] ?>" class="blog-card__img">
                <? endif; ?>
              </div>
              <div class="blog-card__info">
                <h3 class="blog-card__title"><?= $arItem["NAME"] ?></h3>
                <div class="blog-card__meta">
                  <span class="blog-card__type">Коллаборация</span>
                  <span class="blog-card__dot"></span>
                  <span class="blog-card__date"><?= $arItem["PROPERTIES"]["DATE"]["VALUE"] ?></span>
                </div>
              </div>
            </a>
          </div>
        <? endforeach; ?>
      </div>

      <div class="blog__nav">
        <button class="blog__nav-prev">
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
        <button class="blog__nav-next">
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
    </div>
    <div class="blog__pag mob"></div>
  </div>
</section>
