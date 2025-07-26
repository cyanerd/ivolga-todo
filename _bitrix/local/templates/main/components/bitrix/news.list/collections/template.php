<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<div class="categories__row" id="collections-list">
  <? foreach ($arResult["ITEMS"] as $arItem):
    $img = $arItem["PREVIEW_PICTURE"]["SRC"] ?: $arItem["DETAIL_PICTURE"]["SRC"] ?: CFile::GetPath($arItem["PROPERTIES"]["PICTURE"]["VALUE"]);
    $title = $arItem["NAME"];
    $subtitle = $arItem["PROPERTIES"]["SUBTITLE"]["VALUE"];
    $url = $arItem["DETAIL_PAGE_URL"]; // $arItem["PROPERTIES"]["URL"]["VALUE"] ?:
    ?>
    <a href="<?= $url ?>" class="category-card" data-id="<?= $arItem['ID'] ?>">
      <div class="category-card__image">
        <? if ($img):?><img src="<?= $img ?>" alt="<?= $title ?>" class="category-card__img"><? endif; ?>
        <div class="category-card__overlay"></div>
      </div>
      <div class="category-card__content">
        <h3 class="category-card__title"><?= $title ?></h3>
        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
                d="M11 6.4165L12 6.4165C13.7949 6.4165 15.25 4.96143 15.25 3.1665L16.75 3.1665C16.75 5.78986 14.6234 7.9165 12 7.9165L11 7.9165L11 6.4165Z"
                fill="white"/>
          <path fill-rule="evenodd" clip-rule="evenodd"
                d="M16.75 3.1665C16.75 4.96143 18.2051 6.4165 20 6.4165L21 6.4165L21 7.9165L20 7.9165C17.3766 7.9165 15.25 5.78986 15.25 3.1665L16.75 3.1665Z"
                fill="white"/>
          <path fill-rule="evenodd" clip-rule="evenodd"
                d="M16.75 20.9165L3 20.9165L3 19.4165L15.25 19.4165L15.25 3.16651L16.75 3.16651L16.75 20.9165Z" fill="white"/>
        </svg>
      </div>
    </a>
  <? endforeach; ?>
</div>
<? if ($arParams["DISPLAY_BOTTOM_PAGER"] && $arResult["NAV_STRING"]): ?>
  <script>
    window.collectionsTotal = <?=intval($arResult["NAV_RESULT"]->NavRecordCount)?>;
  </script>
  <div class="container">
    <button class="pagecollect__btn" id="collections-more" data-navnum="<?= $arResult["NAV_RESULT"]->NavNum ?>">
      Показать ещё
    </button>
    <div style="display:none;">
      <?= $arResult["NAV_STRING"] ?>
    </div>
  </div>
  <script>
    document.getElementById('collections-more').addEventListener('click', function () {
      var nav = document.querySelector('div[style*="display:none;"]');
      if (!nav) return;
      var next = nav.querySelector('a[rel="next"], a[title=\"Следующая страница\"], a');
      if (!next) return;
      var url = next.getAttribute('href');
      fetch(url, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
        .then(r => r.text())
        .then(html => {
          var temp = document.createElement('div');
          temp.innerHTML = html;
          var newItems = temp.querySelectorAll('#collections-list .category-card');
          var list = document.getElementById('collections-list');
          var added = 0;
          newItems.forEach(function (card) {
            if (!list.querySelector('a.category-card[data-id="' + card.getAttribute('data-id') + '"]')) {
              list.appendChild(card);
              added++;
            }
          });
          // Обновить навигацию
          var newNav = temp.querySelector('div[style*="display:none;"]');
          if (newNav) nav.parentNode.replaceChild(newNav, nav);
          // Скрыть кнопку если больше нет страниц, не добавлено ни одной новой карточки,
          // или общее количество карточек на странице >= общего количества коллекций
          var hasNext = newNav && newNav.querySelector('a[rel="next"], a[title="Следующая страница"], a');
          if (!hasNext || added === 0 || (window.collectionsTotal && list.querySelectorAll('a.category-card').length >= window.collectionsTotal)) {
            document.getElementById('collections-more').style.display = 'none';
          }
        });
    });
  </script>
<? endif; ?>
