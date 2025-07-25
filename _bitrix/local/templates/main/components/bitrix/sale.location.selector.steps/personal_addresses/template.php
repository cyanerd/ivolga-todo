<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

<div class="lk-locations">
    <div class="lk-locations__list">
        <?if($arResult["ITEMS"]):?>
            <?foreach($arResult["ITEMS"] as $arAddress):?>
                <div class="lk-locations__item">
                    <p class="lk-locations__item-txt">
                        <?=$arAddress["ADDRESS"]?>
                    </p>
                    <div class="lk-locations__item-buttons">
                        <button class="lk-locations__item-edit" onclick="editAddress(<?=$arAddress["ID"]?>)">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.5342 6.57227L7.81738 17.624H2.375V12.1885L13.457 1.10547L18.5342 6.57227ZM3.875 12.8096V16.124H7.18262L16.4658 6.5498L13.417 3.2666L3.875 12.8096Z" fill="#232229" fill-opacity="0.5"/>
                                <path d="M15.5303 8.84375L14.4697 9.9043L10.0947 5.5293L11.1553 4.46875L15.5303 8.84375Z" fill="#232229" fill-opacity="0.5"/>
                            </svg>
                        </button>
                        <button class="lk-locations__item-delete" onclick="deleteAddress(<?=$arAddress["ID"]?>)">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.125 3.625H16.875V5.125H3.125V3.625Z" fill="#232229" fill-opacity="0.5"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.125 2.625H6.875V1.125H13.125V2.625Z" fill="#232229" fill-opacity="0.5"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.125 16.125V4.375H3.625V17.625H16.375V4.375H14.875V16.125H5.125Z" fill="#232229" fill-opacity="0.5"/>
                            </svg>
                        </button>
                    </div>
                </div>
            <?endforeach;?>
        <?else:?>
            <div class="lk-locations__empty">
                <p>У вас пока нет сохраненных адресов</p>
            </div>
        <?endif;?>
    </div>

    <button class="lk-locations__add js--modal" data-modal="newadress">
        Добавить
    </button>
</div>

<script>
function addAddress() {
    // Здесь можно добавить логику для добавления адреса
    console.log('Добавить адрес');
}

function editAddress(id) {
    // Здесь можно добавить логику для редактирования адреса
    console.log('Редактировать адрес', id);
}

function deleteAddress(id) {
    if (confirm('Вы уверены, что хотите удалить этот адрес?')) {
        // Здесь можно добавить логику для удаления адреса
        console.log('Удалить адрес', id);
    }
}
</script>
