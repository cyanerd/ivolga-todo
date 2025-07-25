<? use local\php_interface\MyTools;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<main class="product-content">
    <div class="product">
        <div class="product-common">
            <div class="product-images">
                <?if(!empty($arResult['ITEM']['PROPERTIES']['MORE_PHOTO']['VALUE'])):?>
                <div class="swiper-wrapper">
                    <?foreach ($arResult['ITEM']['PROPERTIES']['MORE_PHOTO']['VALUE'] as $picture_id):?>
                    <?
                    $img = CFile::ResizeImageGet($picture_id, array('width'=>566, 'height'=>895), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                    ?>
                    <div class="swiper-slide">
                        <img src="<?=$img['src']?>" alt="pick">
                    </div>
                    <?endforeach;?>
                    <?if(!empty($arResult['ITEM']['PROPERTIES']['FILES']['VALUE'])):
                        foreach ($arResult['ITEM']['PROPERTIES']['FILES']['VALUE'] as $file_id):?>
                        <div class="swiper-slide">
                            <video width="100%" height="900" controls class="product_video">
                                <source src="<?=CFile::GetPath($file_id)?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <?endforeach;
                    endif?>
                </div>
                <div class="swiper-pagination"></div>
                <?else:?>
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="/assets/img/no-photo.jpg" alt="pick">
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                <?endif?>
            </div>

            <div class="product-config">
                <div class="product-config__head">
                    <p class="product-config__title"><?= $arResult['ITEM']['PROPERTIES']['NAIMENOVANIE_TOVARA_NA_SAYTE_ETIKETKE']['VALUE'] ?? $arResult['ITEM']['NAME']?>
                    </p>
                    <p id="price-block"><?=number_format($arResult['OFFER']['PRICE_7'], 0, ' ', ' ')?>&nbsp;₽</p>
                </div>
                <div class="product-config__params">
                    <div><button class="product-config-detail-button">
                            <div style="text-align: left">
                            <?=$arResult['ITEM']['DETAIL_TEXT']?>
                            </div>
                            <?/*
                            <div class="product-config-detail-button__arrow"><img
                                    src="/assets/img/icons/arrow.svg" alt="">
                                <p>Детали</p>
                            </div>
                            */?>
                        </button>
                    </div>
                    <div class="product-config__size">
                        <ul class="product-config__size-list">
                            <?foreach ($arResult['SIZES_LIST'] as $arSize):?>
                            <li><a data-id="<?=$arSize['id']?>" data-price="<?=$arSize['price']?> ₽" href="javascript:" class="product-config__size-button<?=($arSize['id'] == $arResult['OFFER']['ID']) ? ' active':''?>"><?=$arSize['title']?></a></li>
                            <?endforeach;?>
                        </ul>
                        <button class="product-config__size-guide-button modal-button"
                                     data-src=".sizeGuide-right">Гид по
                            размерам</button>
                    </div>
                    <div class="product-config__colors">
                        <ul class="product-config__colors-list">
                            <?foreach ($arResult['COLORS_LIST'] as $color => $detail_page):?>
                            <li>
                                <a title="<?=$color?>" href="<?=$detail_page?>" class="product-config__colors-link<?if($color == $arResult['CURRENT_COLOR'])echo' selected'?>"><div style="background-image: url(<?=MyTools::getColor($color)?>)"></div></a>
                            </li>
                            <?endforeach;?>
                        </ul>
                        <p><?=$arColor['title']?></p>
                    </div>
                    <div class="product-config__container">
                        <button data-product="<?=$arResult['OFFER']['ID']?>" class="primary-button-active to-cart">Купить</button>
                        <?$is_like = MyTools::isFavourite($arResult['OFFER']['ID']);?>
                        <button data-id="<?=$arResult['OFFER']['ID']?>" class="products-card__wish-list-button favorite<?=$is_like ? ' checked':''?>">
                            <svg xmlns="http://www.w3.org/2000/svg"  id="Bold" viewBox="0 0 24 24" width="512" height="512">
                                <g id="_01_align_center" data-name="01 align center"><path fill="#374753" d="M17.5.917a6.4,6.4,0,0,0-5.5,3.3A6.4,6.4,0,0,0,6.5.917,6.8,6.8,0,0,0,0,7.967c0,6.775,10.956,14.6,11.422,14.932l.578.409.578-.409C13.044,22.569,24,14.742,24,7.967A6.8,6.8,0,0,0,17.5.917ZM12,20.846c-3.253-2.43-10-8.4-10-12.879a4.8,4.8,0,0,1,4.5-5.05A4.8,4.8,0,0,1,11,7.967h2a4.8,4.8,0,0,1,4.5-5.05A4.8,4.8,0,0,1,22,7.967C22,12.448,15.253,18.416,12,20.846Z"/></g>
                                <path class="checked" fill="#374753" d="M17.5.917a6.4,6.4,0,0,0-5.5,3.3A6.4,6.4,0,0,0,6.5.917,6.8,6.8,0,0,0,0,7.967c0,6.775,10.956,14.6,11.422,14.932l.578.409.578-.409C13.044,22.569,24,14.742,24,7.967A6.8,6.8,0,0,0,17.5.917Z"/>
                            </svg>
                        </button>
                    </div>
                    <ul class="product-config__info-list">
                        <?if(!empty($arResult['ITEM']['PROPERTIES']['UKHOD']['VALUE'])) {?>
                        <li class="product-config__info-item">
                            <button class="product-config__button">
                                <div class="product-config__button-title">
                                    <p>Детали и уход</p>
                                    <p class="product-config__symbol">+</p>
                                </div>
                                <div class="product-config-details-button__details "><?=$arResult['ITEM']['PROPERTIES']['UKHOD']['VALUE']?></div>
                            </button>
                        </li>
                        <?}?>
                        <li class="product-config__info-item"><button
                                class="product-config__button">
                                <div class="product-config__button-title">
                                    <p>Оплата и доставка</p>
                                    <p class="product-config__symbol">+</p>
                                </div>
                                <div class="product-config-details-button__details ">
                                    <?=$arResult['INFO']['PAYMENT_DELIVERY']['~VALUE']['TEXT']?>
                                </div>
                            </button>
                        </li>
                        <li class="product-config__info-item"><button
                                class="product-config__button">
                                <div class="product-config__button-title">
                                    <p>Возврат</p>
                                    <p class="product-config__symbol">+</p>
                                </div>
                                <div class="product-config-details-button__details ">
                                    <?=$arResult['INFO']['PAYBACK']['~VALUE']['TEXT']?>
                                </div>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="sizeGuide-right modal-right">
        <div class="modal-right-content ">
            <div class="modal-right-heading">
                <p>Гид по размерам</p><button class="close-button"><img
                        src="/assets/img/icons/close.svg" alt="close"></button>
            </div>
            <div class="sizeGuide-modal-content">
                <div class="sizeGuide-modal__table">
                    <h1 class="sizeGuide-table__title">Футболка</h1>
                    <table class="sizeGuide-table">
                        <thead>
                        <tr>
                            <th>Размер</th>
                            <th>Длина изделия</th>
                            <th>Ширина груди</th>
                            <th>Длина рукава</th>
                            <th>Длина плеча</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>XS</td>
                            <td>70</td>
                            <td>72</td>
                            <td>58</td>
                            <td>56</td>
                        </tr>
                        <tr>
                            <td>S</td>
                            <td>70</td>
                            <td>72</td>
                            <td>58</td>
                            <td>56</td>
                        </tr>
                        <tr>
                            <td>M</td>
                            <td>70</td>
                            <td>72</td>
                            <td>58</td>
                            <td>56</td>
                        </tr>
                        <tr>
                            <td>L</td>
                            <td>70</td>
                            <td>72</td>
                            <td>58</td>
                            <td>56</td>
                        </tr>
                        <tr>
                            <td>XL</td>
                            <td>70</td>
                            <td>72</td>
                            <td>58</td>
                            <td>56</td>
                        </tr>
                        </tbody>
                    </table>
                    <p class="sizeGuide-modal__table-info">Значения указаны в сантиметрах</p>
                </div><img src="/assets/img/icons/sizeguide.png" alt="size">
            </div>
        </div>
    </div>
    <?/*
    <div class="relevant-looks-container container">
        <h2>Релевантные образы</h2>
        <ul class="relevant-looks-images">
            <li><img src="/assets/img/relevant-looks/look1.png" alt="look"></li>
            <li><img src="/assets/img/relevant-looks/look2.png" alt="look"></li>
            <li><img src="/assets/img/relevant-looks/look3.png" alt="look"></li>
        </ul>
    </div>
    <div class="container">
        <div class="products-card-head--centered container">
            <h2 class="title">Бестселлеры</h2>
        </div>
        <div style="opacity: 1; transform: none;">
            <div class="products-card-container__content">
                <ul class="products-card-list products-card-list--4">
                    <li class="products-card--big"><a class="products-card__link"
                                                      href="product.html"><img src="/assets/img/products/product2.png"
                                                                               alt="product">
                            <div class="products-card-title--big">
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
                    <li class="products-card--big"><a class="products-card__link"
                                                      href="product.html"><img src="/assets/img/products/product3.png"
                                                                               alt="product">
                            <div class="products-card-title--big">
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
                    <li class="products-card--big"><a class="products-card__link"
                                                      href="product.html"><img src="/assets/img/products/product4.png"
                                                                               alt="product">
                            <div class="products-card-title--big">
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
                    <li class="products-card--big"><a class="products-card__link"
                                                      href="product.html"><img src="/assets/img/products/product5.png"
                                                                               alt="product">
                            <div class="products-card-title--big">
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
    */?>
</main>
