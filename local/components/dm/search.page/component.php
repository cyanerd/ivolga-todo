<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(!CModule::IncludeModule("search"))
{
	ShowError(GetMessage("SEARCH_MODULE_UNAVAILABLE"));
	return;
}
CModule::IncludeModule("iblock");

$q = $_REQUEST['q'];
//находим товары
if (empty($_REQUEST['q'])) {    //nothing to search
    $this->ShowComponentTemplate();
    return;
}
//search index for keyword
$module_id = "iblock";
$obSearch = new CSearch;
//$obSearch->SetLimit(200);
$obSearch->Search(array(
    "QUERY" => $q,
    "MODULE_ID" => $module_id,
    ),
    false,
    array(
        array(
            "MODULE_ID" => "iblock",
            "PARAM2" => [29,],
        ),
    )
);
$obSearch->NavStart(25, false);
//$obSearch->nPageWindow = $arParams["PAGE_NAVIGATION_WINDOW"];
//$arResult["NAV_RESULT"] = $obSearch;
$arResult["NAV_STRING"] = $obSearch->GetPageNavStringEx($navComponentObject, 'Пагинация', '');

if ($obSearch->errorno) {    //invalid search word syntax, display error
    $arResult["error"] = array(
        'code' => $obSearch->errorno,
        'text' => $obSearch->error
    );
    $this->ShowComponentTemplate();
    return;
}
$arResult['AMOUNT'] = $obSearch->AffectedRowsCount();
//результаты распределяем по категориям (товар, раздел, бренд, новость)
$arItems = array(); $arSections = array();
while($arSearchResult = $obSearch->GetNext()):
	//различаем товар от секции
	if($arSearchResult['PARAM1'] == 'CRM_PRODUCT_CATALOG' AND (intval($arSearchResult['ITEM_ID']))):
		$arSearchResult['TYPE'] = 'ITEM';
		$arItems[] = $arSearchResult;
	endif;
endwhile;

$arResult['q'] = htmlspecialchars($q);
$arResult['ITEMS'] = array_merge($arItems,);

$this->IncludeComponentTemplate();
?>