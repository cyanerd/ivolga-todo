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
<main class="collection-content">
    <div class="collection-content__title">
        <p><?=$arResult['NAME']?></p>
    </div>
    <ul class="collection-list container">
        <li class="collection-item--vertical">
            <img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="collection" />

        </li>
        <li class="collection-item--horizontal">
            <?=$arResult['FIELDS']['DETAIL_TEXT']?>
        </li>
    </ul>
    <?/*
    <h2 class="collections-list__title">Ещё больше коллекций</h2>
    <ul class="collections-list container">
        <li class="collections-item">
            <a class="collections-item__link" href="collection.html"
            ><img
                        src="/assets/img/collections/product4.png"
                        alt="product"
                        class="collections-item__img" />
                <p class="collections-item__title">Весна/Лето 2024, Лукбук</p></a
            >
        </li>
        <li class="collections-item">
            <a class="collections-item__link" href="collection.html"
            ><img
                        src="/assets/img/collections/product2.png"
                        alt="product"
                        class="collections-item__img" />
                <p class="collections-item__title">Весна/Лето 2024, Лукбук</p></a
            >
        </li>
        <li class="collections-item">
            <a class="collections-item__link" href="collection.html"
            ><img
                        src="/assets/img/collections/product3.png"
                        alt="product"
                        class="collections-item__img" />
                <p class="collections-item__title">Весна/Лето 2024, Лукбук</p></a
            >
        </li>
    </ul>
    */?>
</main>
