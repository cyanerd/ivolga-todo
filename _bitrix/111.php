<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Sale\Exchange\ManagerExport;

echo "isCRMCompatibility = ".(ManagerExport::isCRMCompatibility() ? "Y":"N").PHP_EOL;
echo "isB24Mode         = ".(ManagerExport::isB24Mode() ? "Y":"N").PHP_EOL;
echo "isSaleB24Mode     = ".(ManagerExport::isSaleB24Mode() ? "Y":"N").PHP_EOL;
echo "isB24SaleMode     = ".(ManagerExport::isB24SaleMode() ? "Y":"N").PHP_EOL;

// Покажем, какие опции модуля sale могут влиять
$keys = [
  'IS_SALE_CRM_SITE_MASTER_FINISH',
  'IS_SALE_BSM_SITE_MASTER_FINISH',
  'SALE_B24',
  'SALE_B24_ACTIVE',
  'SALE_CRM_COMPATIBILITY',
];
foreach ($keys as $k) {
  echo $k.' = '.var_export(COption::GetOptionString('sale', $k, ''), true).PHP_EOL;
}
