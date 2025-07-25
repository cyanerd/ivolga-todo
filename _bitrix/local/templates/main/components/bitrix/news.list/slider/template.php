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

<section class="main-banner">
  <div class="swiper main-banner__swiper">
    <div class="swiper-wrapper">

      <?foreach($arResult["ITEMS"] as $arItem):?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <div class="swiper-slide main-banner__slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
          <div class="main-banner__image">
            <?if($arItem["PREVIEW_PICTURE"]["SRC"]):?>
              <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["NAME"]?>">
            <?endif;?>
            <div class="main-banner__overlay"></div>
          </div>
          <div class="main-banner__content">
            <?if($arItem["PROPERTIES"]["DESC"]["VALUE"]):?>
              <h2 class="main-banner__title"><?=$arItem["PROPERTIES"]["DESC"]["VALUE"]?></h2>
            <?endif;?>
            <?if($arItem["PROPERTIES"]["LINK"]["VALUE"]):?>
              <a href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>" class="main-banner__link">
                <span><?=$arItem["NAME"]?></span>
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M11 6.4165L12 6.4165C13.7949 6.4165 15.25 4.96143 15.25 3.1665L16.75 3.1665C16.75 5.78986 14.6234 7.9165 12 7.9165L11 7.9165L11 6.4165Z"
                        fill="white"/>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M16.75 3.1665C16.75 4.96143 18.2051 6.4165 20 6.4165L21 6.4165L21 7.9165L20 7.9165C17.3766 7.9165 15.25 5.78986 15.25 3.1665L16.75 3.1665Z"
                        fill="white"/>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M16.75 20.9165L3 20.9165L3 19.4165L15.25 19.4165L15.25 3.16651L16.75 3.16651L16.75 20.9165Z"
                        fill="white"/>
                </svg>
              </a>
            <?else:?>
              <div class="main-banner__link">
                <span><?=$arItem["NAME"]?></span>
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M11 6.4165L12 6.4165C13.7949 6.4165 15.25 4.96143 15.25 3.1665L16.75 3.1665C16.75 5.78986 14.6234 7.9165 12 7.9165L11 7.9165L11 6.4165Z"
                        fill="white"/>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M16.75 3.1665C16.75 4.96143 18.2051 6.4165 20 6.4165L21 6.4165L21 7.9165L20 7.9165C17.3766 7.9165 15.25 5.78986 15.25 3.1665L16.75 3.1665Z"
                        fill="white"/>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M16.75 20.9165L3 20.9165L3 19.4165L15.25 19.4165L15.25 3.16651L16.75 3.16651L16.75 20.9165Z"
                        fill="white"/>
                </svg>
              </div>
            <?endif;?>
          </div>
        </div>
      <?endforeach;?>

    </div>
    <div class="swiper-pagination main-banner__pagination"></div>
  </div>
</section>
