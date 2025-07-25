<?

function getHBEntityClass($iblockID)
{
    if (empty($iblockID) || $iblockID < 1) {
        return false;
    }
    CModule::IncludeModule('iblock');
    CModule::IncludeModule('highloadblock');
    $hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($iblockID)->fetch();
    $entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
    $entityClass = $entity->getDataClass();
    return $entityClass;
}

function getHBItem($itemID, $iblockID)
{
    $entityClass = getHBEntityClass($iblockID);
    return $entityClass::getList(array(
        'select' => array('*'),
        'filter' => array('ID' => $itemID)
    ))->fetch();
}

function getHBItems($iblockID = false, $select = false, $filter = false, $group = false, $order = false, $entityDataClass = false)
{
  $entityClass = $entityDataClass ?: getHBEntityClass($iblockID);
  $params = [];
  $params['select'] = $select ?: ['*'];

  if ($filter):
    $params['filter'] = $filter;
  endif;

  if ($group):
    $params['group'] = $group;
  endif;

  if ($order):
    $params['order'] = $order;
  endif;

  return $entityClass::getList($params)->fetchAll();
}

function updateHBItem($itemID, $iblockID, $updateArr)
{
    $entityClass = getHBEntityClass($iblockID);
    return $entityClass::update($itemID, $updateArr);
}

function deleteHBItems($iblockID)
{
    $items = getHBItems($iblockID);
    foreach ($items as $item) {
        deleteHBItem($item['ID'], $iblockID);
    }
    return true;
}

function deleteHBItem($itemID, $iblockID)
{
    $entityClass = getHBEntityClass($iblockID);
    $entityClass::delete($itemID);
}

function addHBItem($iblockID, $addArr)
{
    $entityClass = getHBEntityClass($iblockID);
    return $entityClass::add($addArr);
}

?>