<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>

<? if ($arResult["SECTIONS"]): ?>
  <ul class="catalogpage__nav">
    <?
    // Вычисляем общее количество товаров
    $totalElements = 0;

    // Способ 1: через NAV_RESULT
    if (is_object($arResult["NAV_RESULT"]) && method_exists($arResult["NAV_RESULT"], "NavRecordCount")) {
      $totalElements = $arResult["NAV_RESULT"]->NavRecordCount;
    }
    // Способ 2: через секции
    elseif ($arResult["SECTIONS"]) {
      foreach ($arResult["SECTIONS"] as $arSection) {
        $totalElements += $arSection["ELEMENT_CNT"];
      }
    }
    // Способ 3: через ELEMENT_CNT
    elseif ($arResult["ELEMENT_CNT"]) {
      $totalElements = $arResult["ELEMENT_CNT"];
    }
    // Способ 4: через количество товаров в текущем результате
    elseif ($arResult["ITEMS"]) {
      $totalElements = count($arResult["ITEMS"]);
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
      $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
      ?>
      <li id="<?= $this->GetEditAreaId($arSection['ID']); ?>">
        <a href="<?= $arSection["SECTION_PAGE_URL"] ?>" class="<?= $_REQUEST['SECTION_CODE'] == $arSection["CODE"] ? 'active' : '' ?>">
          <?= $arSection["NAME"] ?>
          <span>(<?= $arSection["ELEMENT_CNT"] ?>)</span>
        </a>
      </li>
    <? endforeach; ?>
  </ul>
<? endif; ?>
