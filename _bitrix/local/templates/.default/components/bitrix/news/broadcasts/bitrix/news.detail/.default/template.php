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
<main class="broadcast-content container">
  <div class="broadcast">
    <div class="broadcast-poster">
      <iframe width="560" height="315" src="https://www.youtube.com/embed/3tndOnnA9Lw?si=adWMG6vfkiMXcVeM"
              title="YouTube video player" frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              allowfullscreen></iframe>
      <!--<img src="/assets/img/broadcast/broadcast1.png" alt="" class="broadcast-video">-->
      <!--
      <div class="broadcast-elements">
          <p class="broadcast-state">Запись</p>
          <article class="broadcast-article">
              <h1 class="title">Готовим образы к осени</h1>
              <p>23 Июля</p>
          </article>
          <div class="broadcast-tools"><img src="/assets/img/icons/line-translation.png" alt="">
              <p>02:14 / 10:17</p>
          </div>
      </div>
      -->
      <div class="broadcast-swiper">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <li class="products-card--small"><a class="products-card__link" href="product.html"><img
                  src="/assets/img/broadcast/product.png" alt="product">
                <div class="products-card-title--small">
                  <p class="products-card-title__product">Топ черный из кашемира</p>
                  <p class="products-card-title__price">25 000&nbsp;₽</p>
                </div>
              </a>
              <div class="products-card__colors">
                <div class="products-card-color-small">
                  <div></div>
                </div>
              </div>


            </li>
          </div>
          <div class="swiper-slide">
            <li class="products-card--small"><a class="products-card__link" href="product.html"><img
                  src="/assets/img/broadcast/product.png" alt="product">
                <div class="products-card-title--small">
                  <p class="products-card-title__product">Топ черный из кашемира</p>
                  <p class="products-card-title__price">25 000&nbsp;₽</p>
                </div>
              </a>
              <div class="products-card__colors">
                <div class="products-card-color-small">
                  <div></div>
                </div>
              </div>


            </li>
          </div>
          <div class="swiper-slide">
            <li class="products-card--small"><a class="products-card__link" href="product.html"><img
                  src="/assets/img/broadcast/product.png" alt="product">
                <div class="products-card-title--small">
                  <p class="products-card-title__product">Топ черный из кашемира</p>
                  <p class="products-card-title__price">25 000&nbsp;₽</p>
                </div>
              </a>
              <div class="products-card__colors">
                <div class="products-card-color-small">
                  <div></div>
                </div>
              </div>


            </li>
          </div>
          <div class="swiper-slide">
            <li class="products-card--small"><a class="products-card__link" href="product.html"><img
                  src="/assets/img/broadcast/product.png" alt="product">
                <div class="products-card-title--small">
                  <p class="products-card-title__product">Топ черный из кашемира</p>
                  <p class="products-card-title__price">25 000&nbsp;₽</p>
                </div>
              </a>
              <div class="products-card__colors">
                <div class="products-card-color-small">
                  <div></div>
                </div>
              </div>


            </li>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="broadcast-products">
    <div class="container">
      <div class="products-card-head--centered container">
        <h2 class="title">Товары из трансляции</h2>
      </div>
      <div style="opacity: 1; transform: none;">
        <div class="products-card-container__content">
          <ul class="products-card-list products-card-list--2">
            <li class="products-card--small"><a class="products-card__link" href="product.html"><img
                  src="/assets/img/broadcast/product.png" alt="product">
                <div class="products-card-title--small">
                  <p class="products-card-title__product">Топ черный из кашемира</p>
                  <p class="products-card-title__price">25 000&nbsp;₽</p>
                </div>
              </a>
              <div class="products-card__colors">
                <div class="products-card-color-small">
                  <div></div>
                </div>
              </div>


            </li>
            <li class="products-card--small"><a class="products-card__link" href="product.html"><img
                  src="/assets/img/broadcast/product.png" alt="product">
                <div class="products-card-title--small">
                  <p class="products-card-title__product">Топ черный из кашемира</p>
                  <p class="products-card-title__price">25 000&nbsp;₽</p>
                </div>
              </a>
              <div class="products-card__colors">
                <div class="products-card-color-small">
                  <div></div>
                </div>
              </div>


            </li>
            <li class="products-card--small"><a class="products-card__link" href="product.html"><img
                  src="/assets/img/broadcast/product.png" alt="product">
                <div class="products-card-title--small">
                  <p class="products-card-title__product">Топ черный из кашемира</p>
                  <p class="products-card-title__price">25 000&nbsp;₽</p>
                </div>
              </a>
              <div class="products-card__colors">
                <div class="products-card-color-small">
                  <div></div>
                </div>
              </div>


            </li>
            <li class="products-card--small"><a class="products-card__link" href="product.html"><img
                  src="/assets/img/broadcast/product.png" alt="product">
                <div class="products-card-title--small">
                  <p class="products-card-title__product">Топ черный из кашемира</p>
                  <p class="products-card-title__price">25 000&nbsp;₽</p>
                </div>
              </a>
              <div class="products-card__colors">
                <div class="products-card-color-small">
                  <div></div>
                </div>
              </div>


            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</main>
