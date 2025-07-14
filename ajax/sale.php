<?php
include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
include($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/log_helper.php");

CModule::IncludeModule("catalog");
CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");

use Bitrix\Sale;
global $USER;

$request = \Bitrix\Main\Context::getCurrent()->getRequest();

$command = $request['command'];

/*
 * добавить в корзину
 */
if ($command == 'add_to_cart'):
    $product_id = $request['item_id'];
    $quantity = 1;

    projectDebugLog('Add to cart: Product ID: ' . $product_id, 'cart_add');

    $arFilter = array("=ID" => $product_id, "ACTIVE" => "Y");
    $arProduct = CIBlockElement::GetList(array('SORT' => 'ASC'), $arFilter, false, false, ['ID', 'NAME'])->GetNext();
    if (!$arProduct['ID']):
        projectErrorLog('Add to cart: Product not found', 'cart_add');
        echo json_encode(['error' => 'Товар не найден']);
        die;
    endif;
    
    projectDebugLog('Add to cart: Found product: ' . $arProduct['NAME'], 'cart_add');

    $fields = [
        'PRODUCT_ID' => $arProduct['ID'], // ID товара, обязательно
        'QUANTITY' => $quantity, // количество, обязательно
        'PROPS' => [
        ],
    ];

    $r = Bitrix\Catalog\Product\Basket::addProduct($fields);
    projectDebugLog('Add to cart: Result: ' . print_r($r, true), 'cart_add');

    echo \Bitrix\Main\Web\Json::encode(
        ['result' => 'ok']
    );
endif;
/*
 * обновить кол-во в корзине
 */
if ($command == 'update_cart_amount'):
    $cart_id = $request['id'];
    $value = $request['value'];
    $arFields = array(
        "QUANTITY" => $value
    );
    CSaleBasket::Update($cart_id, $arFields);
    echo json_encode( ['result' => 'ok'] );
endif;
/*
 * удалить из корзины
 */
if ($command=='del'){
    $cart_id = $request['id'];
    CSaleBasket::Delete($cart_id);

    echo \Bitrix\Main\Web\Json::encode(['result' => 'ok',]);
}
/*
 * информация о корзине
 */
if ($command=='get_cart'){
    $basket = MyTools::getBasket();
    $format = $request['format'];
    $delivery_id = $request['delivery_id'];

    $basket_body = MyTools::getBasketBodyModal($basket, $format, $delivery_id);

    echo \Bitrix\Main\Web\Json::encode([
            'body' => $basket_body,
    ]);
}
/*
 * удалить адрес
 */
if($command == 'del_addr'){
    $id = $request['id'];
    $arElement = CIBlockElement::GetList([], ['=ID' => $id], false, false, ['ID', 'PROPERTY_USER_ID'])->GetNext();
    if($arElement['PROPERTY_USER_ID_VALUE'] == $USER->GetID()){
        CIBlockElement::Delete($id);
    }
    echo \Bitrix\Main\Web\Json::encode([
        'result' => 'ok',
    ]);
}
/*
 * получить адрес
 */
if($command == 'get_addr'){
    $id = $request['addr_id'];
    $addr = MyTools::getAddress($id);

    echo \Bitrix\Main\Web\Json::encode([
        'addr' => $addr['PROPERTIES']['ADDRESS']['VALUE'],
        'comment' => $addr['PROPERTIES']['COMMENT']['VALUE'],
    ]);
}