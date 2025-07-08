<?php
$arUrlRewrite=array (
  9 => 
  array (
    'CONDITION' => '#^/bitrix/services/yandexpay.pay/trading/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/yandexpay.pay/trading/index.php',
    'SORT' => 1,
  ),
  7 => 
  array (
    'CONDITION' => '#^/catalog/([^/]+?)/\\??(.*)#',
    'RULE' => 'SECTION_CODE=$1&$2',
    'ID' => 'bitrix:catalog.section',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
  3 => 
  array (
    'CONDITION' => '#^/collections/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/collections/index.php',
    'SORT' => 100,
  ),
  2 => 
  array (
    'CONDITION' => '#^/broadcasts/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/broadcasts/index.php',
    'SORT' => 100,
  ),
  4 => 
  array (
    'CONDITION' => '#^/personal/#',
    'RULE' => '',
    'ID' => 'cabinet:personal',
    'PATH' => '/personal/index.php',
    'SORT' => 100,
  ),
  10 => 
  array (
    'CONDITION' => '#^/checkout/#',
    'RULE' => '',
    'ID' => 'cabinet:cart',
    'PATH' => '/checkout/index.php',
    'SORT' => 100,
  ),
  6 => 
  array (
    'CONDITION' => '#^/product/#',
    'RULE' => '',
    'ID' => 'dm:element',
    'PATH' => '/product/index.php',
    'SORT' => 100,
  ),
);
