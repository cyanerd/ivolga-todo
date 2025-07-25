<?
$DocID = 2553;
$res = CIBlockElement::GetByID($DocID);
$ar_res = $res->GetNextElement();
$arResult['INFO'] = $ar_res->GetProperties();
