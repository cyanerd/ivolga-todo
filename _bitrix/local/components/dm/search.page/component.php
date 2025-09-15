<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
if (!CModule::IncludeModule("search")) {
  ShowError(GetMessage("SEARCH_MODULE_UNAVAILABLE"));
  return;
}
global $APPLICATION;
CModule::IncludeModule("iblock");
$q = $_REQUEST['q'];
//находим товары
if (empty($_REQUEST['q'])) {    //nothing to search
  if ($this->InitComponentTemplate('')) $this->ShowComponentTemplate();
  return;
}
//search index for keyword
$module_id = "iblock";
$obSearch = new CSearch;
//$obSearch->SetLimit(200);

$obSearch->Search([
  "QUERY" => $q,
  "MODULE_ID" => $module_id,
],
  false,
  [
    [
      "MODULE_ID" => "iblock",
      "PARAM2" => [29,],
    ],
  ]
);

$obSearch->NavStart(25, false);
//$obSearch->nPageWindow = $arParams["PAGE_NAVIGATION_WINDOW"];
//$arResult["NAV_RESULT"] = $obSearch;
$arResult["NAV_STRING"] = $obSearch->GetPageNavStringEx($navComponentObject, 'Пагинация', '');

if ($obSearch->errorno) {    //invalid search word syntax, display error
  $arResult["error"] = [
    'code' => $obSearch->errorno,
    'text' => $obSearch->error
  ];
  if ($this->InitComponentTemplate('')) $this->ShowComponentTemplate();
  return;
}
$arResult['AMOUNT'] = $obSearch->AffectedRowsCount();
//результаты распределяем по категориям (товар, раздел, бренд, новость)
$arItems = [];
$arSections = [];
while ($arSearchResult = $obSearch->GetNext()) {
  //различаем товар от секции
  if ($arSearchResult['PARAM1'] == 'CRM_PRODUCT_CATALOG' and (intval($arSearchResult['ITEM_ID']))) {

//    d($arSearchResult['ACTIVE']);
//    d($q);
//    d(mb_stripos($arSearchResult['TITLE'], $q) !== false);
//    echo '<br>===========<br>';

    if (mb_stripos($arSearchResult['TITLE'], $q) !== false) {
      $arSearchResult['TYPE'] = 'ITEM';
      $arItems[] = $arSearchResult;
    }
  }
}

$arResult['q'] = htmlspecialchars($q);
$arResult['ITEMS'] = array_merge($arItems);

$this->IncludeComponentTemplate();
?>
