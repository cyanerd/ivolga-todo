<?
define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_STATISTIC", true);
define('NOT_CHECK_PERMISSIONS', true);

use Bitrix\Main;
use Bitrix\Main\Loader;
use Bitrix\Sale\Location;
use Bitrix\Sale\Location\Admin\LocationHelper as Helper;

require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php');

Loader::includeModule('sale');

$result = [
  'ERRORS' => [],
  'DATA' => []
];

$siteId = '';
if ($_REQUEST['SITE_ID'] <> '') {
  $siteId = $_REQUEST['SITE_ID'];
} elseif (mb_strlen(SITE_ID)) {
  $siteId = SITE_ID;
}

if ($_REQUEST['ACT'] != 'GET_LOCS_BY_ZIP') {
  $item = Helper::getLocationsByZip($_REQUEST['ZIP'], ['limit' => 1])->fetch();

  if (!isset($item['LOCATION_ID'])) {
    $result['ERRORS'] = ['Not found'];
  } else {
    $result['DATA']['ID'] = intval($item['LOCATION_ID']);

    if ($siteId <> '') {
      if (!Location\SiteLocationTable::checkConnectionExists($siteId, $result['DATA']['ID'])) {
        $result['ERRORS'] = ['Found, but not connected'];
      }
    }
  }
} else {
  $dbRes = Helper::getLocationsByZip($_REQUEST['ZIP'], ['select' => ['PARENT_ID' => 'LOCATION.PARENT_ID']]);
  $locationsId = [];

  while ($item = $dbRes->fetch()) {
    if (!isset($item['LOCATION_ID']))
      continue;

    $locationId = intval($item['LOCATION_ID']);

    if ($siteId <> '') {
      if (!Location\SiteLocationTable::checkConnectionExists($siteId, $locationId)) {
        continue;
      }
    }

    $parentId = intval($item['PARENT_ID']);

    if (!is_array($locationsId[$parentId]))
      $locationsId[$parentId] = [];

    $locationsId[$parentId][] = $locationId;
  }

  /* If we have several locations on different levels, choose it with maximal count. */
  if (!empty($locationsId)) {
    $maxIdsCountParentId = 0;

    foreach ($locationsId as $parentId => $ids)
      if (count($ids) > $maxIdsCountParentId)
        $maxIdsCountParentId = $parentId;

    if ($maxIdsCountParentId > 0) {
      $result['DATA']['PARENT_ID'] = $maxIdsCountParentId;
      $result['DATA']['IDS'] = $locationsId[$maxIdsCountParentId];
    }
  }

  if (!isset($result['DATA']['PARENT_ID'])) {
    $result['ERRORS'] = ['Not found'];
  }
}

header('Content-Type: application/x-javascript; charset=' . LANG_CHARSET);

print(CUtil::PhpToJSObject([
  'result' => empty($result['ERRORS']),
  'errors' => $result['ERRORS'],
  'data' => $result['DATA']
], false, false, true));
