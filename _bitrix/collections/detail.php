<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle('Коллекции');
?>
<?
$code = $_REQUEST['CODE'];
$APPLICATION->IncludeComponent(
  'bitrix:news.detail',
  'collections-detail',
  [
    'IBLOCK_TYPE' => 'content',
    'IBLOCK_ID' => '21',
    'ELEMENT_CODE' => $code,
    'FIELD_CODE' => ['ID', 'NAME', 'PREVIEW_TEXT', 'DETAIL_TEXT', 'PREVIEW_PICTURE', 'DETAIL_PICTURE'],
    'PROPERTY_CODE' => ['SUBTITLE', 'PICTURE', 'ITEMS', 'GALLERY', 'IMAGES'],
    'SET_TITLE' => 'Y',
    'SET_CANONICAL_URL' => 'N',
    'SET_BROWSER_TITLE' => 'Y',
    'SET_META_KEYWORDS' => 'Y',
    'SET_META_DESCRIPTION' => 'Y',
    'SET_LAST_MODIFIED' => 'N',
    'INCLUDE_IBLOCK_INTO_CHAIN' => 'N',
    'ADD_SECTIONS_CHAIN' => 'N',
    'ACTIVE_DATE_FORMAT' => 'd.m.Y',
    'CACHE_TYPE' => 'A',
    'CACHE_TIME' => '3600',
    'CACHE_GROUPS' => 'Y',
    'DISPLAY_PANEL' => 'N',
    'SET_STATUS_404' => 'Y',
    'SHOW_404' => 'Y',
    'MESSAGE_404' => 'Коллекция не найдена',
  ],
  false
);
?>

<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'); ?>
