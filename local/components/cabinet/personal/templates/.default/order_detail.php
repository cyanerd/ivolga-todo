<main class="profile">
    <?require "left-menu.php";?>
    <div style="opacity: 1; transform: none;">
        <div class="right-container">
            <div class="orders-details-container"><a class="back-button" href="/personal/orders/"><img
                        src="/assets/img/icons/arrow-left.svg" alt="">
                    <p>Назад</p>
                </a>
                <h1 class="orders-details-title">Заказ #<?=$arResult['ORDER']->getId()?></h1>
                <ul class="orders-details-items">
                    <? foreach ($arResult['BASKET'] as $arItem) {
                        $product_id = $arItem->getProductId();
                        $rsElement = \CIBlockElement::GetList([], ['IBLOCK' => 29, 'ACTIVE' => 'Y', '=ID' => $product_id], false, array(), ['ID', 'NAME', 'CATALOG_PRICE_7',]);
                        $arElement = $rsElement->GetNext();
                        //$picture_id = getGallery($arElement['PROPERTY_ID_VALUE'], $arElement['PROPERTY_TSVET_VALUE'])[0];
                        //$product_preview = CFile::ResizeImageGet($picture_id, array("width" => 140, "height" => 140))['src'];
                        $amount_el = $arItem->getQuantity();
                        $product_price = intval($arElement['CATALOG_PRICE_7']);
                        $product_price_total = round($product_price * $amount_el);

                        $parent_product = CCatalogSku::GetProductInfo($arElement['ID']);
                        $rsParentProduct = \CIBlockElement::GetList([], ['ACTIVE' => 'Y', '=ID' => $parent_product['ID']], false, array(), ['ID', 'NAME', 'DETAIL_PICTURE', 'DETAIL_PAGE_URL', 'PROPERTY_TSVET',]);
                        $arParentProduct = $rsParentProduct->GetNext();

                        $DETAIL_PAGE_URL = $arParentProduct['DETAIL_PAGE_URL'];
                        $img_src = isset($arParentProduct['~DETAIL_PICTURE']) ?
                            \CFile::ResizeImageGet(
                                $arParentProduct['~DETAIL_PICTURE'],
                                array("width" => 326, "height" => 517),
                                BX_RESIZE_IMAGE_EXACT
                            )['src']
                            : '/assets/img/no-photo.jpg';

                        $color = $arParentProduct['PROPERTY_TSVET_VALUE'];
                        $color_code = MyTools::getColor($color);
                        ?>
                        <li class="products-card--small">
                            <a class="products-card__link" href="<?=$DETAIL_PAGE_URL?>">
                                <img src="<?=$img_src?>" alt="product">
                                <div class="products-card-title--small">
                                    <p class="products-card-title__product"><?=$arElement['NAME']?></p>
                                    <p class="products-card-title__price"><?=number_format($product_price_total, 0, ' ', ' ')?>&nbsp;₽</p>
                                </div>
                            </a>
                            <div class="products-card__colors">
                                <div class="products-card-color-small">
                                    <div style="background-image: url(<?=$color_code?>)"></div>
                                </div>
                            </div>
                        </li>
                    <? } ?>
                </ul>
                <ul class="orders-details-list">
                    <li class="orders-detail">
                        <p>Стоимость доставки</p>
                        <p><?=number_format($arResult['ORDER']->getDeliveryPrice(), 0, ' ', ' ')?>&nbsp;₽</p>
                    </li>
                    <li class="orders-detail">
                        <p>Итого</p>
                        <p><?=number_format($arResult['ORDER']->getPrice() + $arResult['ORDER']->getDeliveryPrice(), 0, ' ', ' ')?>&nbsp;₽</p>
                    </li>
                    <li class="orders-detail">
                        <p>Статус заказа</p>
                        <?
                        $STATUS_ID = $arResult['ORDER']->getField('STATUS_ID');
                        $arStatus = CSaleStatus::GetByID($STATUS_ID,LANGUAGE_ID)
                        ?>
                        <p><?=$arStatus['NAME'];?></p>
                    </li>
                    <li class="orders-detail">
                        <p>Способ оплаты</p>
                        <p><?=$arResult['PAYMENT']?></p>
                    </li>
                    <li class="orders-detail">
                        <p>Способ доставки</p>
                        <p><?=$arResult['DELIVERY']?></p>
                    </li>
                    <?/*
                    <li class="orders-detail">
                        <p>Адрес</p>
                        <p><?=$arResult['ADDRESS']?></p>
                    </li>
                    */?>
                </ul>
            </div>
        </div>
    </div>
</main>