<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<main class="broadcasts-content">
    <ul class="broadcasts-list container">
        <?foreach ($arResult['ITEMS'] as $arItem):?>
        <li class="broadcasts-item">
            <div class="broadcasts-translation"><a class="broadcasts__link" href="<?=$arItem['DETAIL_PAGE_URL']?>"><img
                            src="/assets/img/broadcasts/poster1.png" alt="broadcast" class="broadcasts-poster">
                    <div class="broadcasts-elements">
                        <p class="broadcasts-state">В эфире</p>
                        <article class="broadcasts-article">
                            <h1>Готовим образы к осени</h1>
                            <p>23 Июля</p>
                        </article>
                    </div>
                </a></div>
            <ul class="broadcasts-products">
                <div class="swiper-wrapper">
                    <li class="swiper-slide">
                        <img src="/assets/img/looks/small/look1.png" alt="look">
                    </li>
                    <li class="swiper-slide">
                        <img src="/assets/img/looks/small/look2.png" alt="look">
                    </li>
                    <li class="swiper-slide">
                        <img src="/assets/img/looks/small/look3.png" alt="look">
                    </li>
                    <li class="swiper-slide">
                        <img src="/assets/img/looks/small/look4.png" alt="look">
                    </li>
                </div>

            </ul>
        </li>
        <?endforeach;?>
    </ul>
</main>
