<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>

<? if ($arResult["SECTIONS"]): ?>
  <ul class="catalogpage__nav">
    <?
    // Вычисляем общее количество товаров с остатками (учитываем торговые предложения)
    $totalElements = 0;

    // Получаем все товары из основного каталога
    $filter = [
      'IBLOCK_ID' => 29,
      'ACTIVE' => 'Y'
    ];
    
    $res = CIBlockElement::GetList([], $filter, false, false, ['ID']);
    while ($product = $res->Fetch()) {
      $hasAvailableOffers = false;
      
      // Проверяем торговые предложения (SKU) для каждого товара
      $offerFilter = [
        'IBLOCK_ID' => 30, // ID инфоблока торговых предложений
        'ACTIVE' => 'Y',
        'PROPERTY_CML2_LINK' => $product['ID'],
        '>CATALOG_QUANTITY' => 0
      ];
      
      $offerRes = CIBlockElement::GetList([], $offerFilter, false, false, ['ID']);
      if ($offer = $offerRes->Fetch()) {
        $hasAvailableOffers = true;
      }
      
      if ($hasAvailableOffers) {
        $totalElements++;
      }
    }

    ?>
    <li>
      <a href="/catalog/" class="<?= !$_REQUEST['SECTION_CODE'] ? 'active' : '' ?>">
        Вся одежда
        <span>(<?= $totalElements ?>)</span>
      </a>
    </li>
    <? foreach ($arResult["SECTIONS"] as $arSection): ?>
      <?
      $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
      $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), ["CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')]);
      
      // Подсчитываем товары с остатками в данной секции (учитываем торговые предложения)
      $sectionElementCount = 0;
      
      $filter = [
        'IBLOCK_ID' => 29,
        'ACTIVE' => 'Y',
        'SECTION_ID' => $arSection['ID'],
        'INCLUDE_SUBSECTIONS' => 'Y'
      ];
      
      $res = CIBlockElement::GetList([], $filter, false, false, ['ID']);
      while ($product = $res->Fetch()) {
        $hasAvailableOffers = false;
        
        // Проверяем торговые предложения (SKU) для каждого товара
        $offerFilter = [
          'IBLOCK_ID' => 30, // ID инфоблока торговых предложений
          'ACTIVE' => 'Y',
          'PROPERTY_CML2_LINK' => $product['ID'],
          '>CATALOG_QUANTITY' => 0
        ];
        
        $offerRes = CIBlockElement::GetList([], $offerFilter, false, false, ['ID']);
        if ($offer = $offerRes->Fetch()) {
          $hasAvailableOffers = true;
        }
        
        if ($hasAvailableOffers) {
          $sectionElementCount++;
        }
      }
      ?>
      <? if ($sectionElementCount > 0): ?>
        <li id="<?= $this->GetEditAreaId($arSection['ID']); ?>">
          <a href="<?= $arSection["SECTION_PAGE_URL"] ?>"
             class="<?= $_REQUEST['SECTION_CODE'] == $arSection["CODE"] ? 'active' : '' ?>">
            <?= $arSection["NAME"] ?>
            <span>(<?= $sectionElementCount ?>)</span>
          </a>
        </li>
      <? endif; ?>
    <? endforeach; ?>
  </ul>
<? endif; ?>
