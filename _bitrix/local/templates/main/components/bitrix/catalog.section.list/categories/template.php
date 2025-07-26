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

<section class="categories">
  <div class="categories__row">
    <?
    $count = 0;
    foreach ($arResult["SECTIONS"] as $arSection):
      if (empty($arSection["PICTURE"]["SRC"])) continue;
      $count++;
      if ($count > 2) break;
      $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
      $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), ["CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')]);
      ?>
      <a href="<?= $arSection["SECTION_PAGE_URL"] ?>" class="category-card" id="<?= $this->GetEditAreaId($arSection['ID']); ?>">
        <div class="category-card__image">
          <img src="<?= $arSection["PICTURE"]["SRC"] ?>" alt="<?= $arSection["NAME"] ?>" class="category-card__img">
          <div class="category-card__overlay"></div>
        </div>
        <div class="category-card__content">
          <h3 class="category-card__title"><?= $arSection["NAME"] ?></h3>
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
</section>
