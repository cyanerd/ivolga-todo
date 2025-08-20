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
  0 => 
  array (
    'CONDITION' => '#^/collections/([a-zA-Z0-9-_]+)/?.*#',
    'RULE' => 'CODE=$1',
    'ID' => '',
    'PATH' => '/collections/detail.php',
    'SORT' => 100,
  ),
  6 => 
  array (
    'CONDITION' => '#^/product/([a-zA-Z0-9-_]+)/?.*#',
    'RULE' => 'ELEMENT_CODE=$1',
    'ID' => 'bitrix:catalog.element',
    'PATH' => '/product/index.php',
    'SORT' => 100,
  ),
  7 => 
  array (
    'CONDITION' => '#^/catalog/([^/]+?)/\\??(.*)#',
    'RULE' => 'SECTION_CODE=$1&$2',
    'ID' => 'bitrix:catalog.section',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
  11 => 
  array (
    'CONDITION' => '#^/favourite/?.*#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.section',
    'PATH' => '/favourite/index.php',
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
);
