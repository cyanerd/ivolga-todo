<?php
include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
include($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/log_helper.php");

CModule::IncludeModule("catalog");
CModule::IncludeModule("iblock");

$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$product_id = $request['product_id'];

if (!$product_id) {
  echo json_encode(['success' => false, 'message' => 'Не указан ID товара']);
  die;
}

// Проверяем доступное количество на складе
$availableQuantity = 0;
$rsStore = CCatalogStoreProduct::GetList(
  [],
  ['PRODUCT_ID' => $product_id],
  false,
  false,
  ['AMOUNT']
);
while ($arStore = $rsStore->GetNext()) {
  $availableQuantity += $arStore['AMOUNT'];
}

echo json_encode([
  'success' => true,
  'available_quantity' => $availableQuantity
]);
?>
