<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

// Включаем обработку ошибок
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Получаем данные из POST запроса
$input = json_decode(file_get_contents('php://input'), true);
$productIds = $input['product_ids'] ?? [];

if (empty($productIds)) {
  echo json_encode([]);
  exit;
}

// Получаем данные товаров
$arProducts = [];
foreach ($productIds as $productId) {
  $rsElement = CIBlockElement::GetByID($productId);
  if ($arElement = $rsElement->GetNext()) {
    // Получаем свойства товара
    $rsProps = CIBlockElement::GetProperty($arElement['IBLOCK_ID'], $productId, ["sort" => "asc"], ["CODE" => "MORE_PHOTO"]);
    $arProps = [];
    while ($arProp = $rsProps->GetNext()) {
      $arProps[$arProp['CODE']] = $arProp;
    }

    // Если свойство MORE_PHOTO не найдено, создаем пустой массив
    if (!isset($arProps['MORE_PHOTO'])) {
      $arProps['MORE_PHOTO'] = ['VALUE' => []];
    }

    // Получаем остальные свойства отдельно
    $rsPropsNew = CIBlockElement::GetProperty($arElement['IBLOCK_ID'], $productId, ["sort" => "asc"], ["CODE" => "NEW"]);
    if ($arProp = $rsPropsNew->GetNext()) {
      $arProps['NEW'] = $arProp;
    } else {
      $arProps['NEW'] = ['VALUE' => 'N'];
    }

    $rsPropsPreorder = CIBlockElement::GetProperty($arElement['IBLOCK_ID'], $productId, ["sort" => "asc"], ["CODE" => "PREORDER"]);
    if ($arProp = $rsPropsPreorder->GetNext()) {
      $arProps['PREORDER'] = $arProp;
    } else {
      $arProps['PREORDER'] = ['VALUE' => 'N'];
    }

    $rsPropsTsvet = CIBlockElement::GetProperty($arElement['IBLOCK_ID'], $productId, ["sort" => "asc"], ["CODE" => "TSVET"]);
    if ($arProp = $rsPropsTsvet->GetNext()) {
      $arProps['TSVET'] = $arProp;
    } else {
      $arProps['TSVET'] = ['VALUE' => ''];
    }

    $rsPropsName = CIBlockElement::GetProperty($arElement['IBLOCK_ID'], $productId, ["sort" => "asc"], ["CODE" => "NAIMENOVANIE_TOVARA_NA_SAYTE_ETIKETKE"]);
    if ($arProp = $rsPropsName->GetNext()) {
      $arProps['NAIMENOVANIE_TOVARA_NA_SAYTE_ETIKETKE'] = $arProp;
    } else {
      $arProps['NAIMENOVANIE_TOVARA_NA_SAYTE_ETIKETKE'] = ['VALUE' => ''];
    }

    // Получаем изображения
    $arImages = [];
    if (isset($arProps['MORE_PHOTO']['VALUE']) && $arProps['MORE_PHOTO']['VALUE']) {
      $morePhotoValue = $arProps['MORE_PHOTO']['VALUE'];
      if (is_array($morePhotoValue)) {
        foreach ($morePhotoValue as $imageId) {
          $arImage = CFile::GetFileArray($imageId);
          if ($arImage) {
            $arImages[] = $arImage['SRC'];
          }
        }
      } else {
        // Если это строка, обрабатываем как одно изображение
        $arImage = CFile::GetFileArray($morePhotoValue);
        if ($arImage) {
          $arImages[] = $arImage['SRC'];
        }
      }
    } elseif ($arElement['PREVIEW_PICTURE']) {
      $arImage = CFile::GetFileArray($arElement['PREVIEW_PICTURE']);
      if ($arImage) {
        $arImages[] = $arImage['SRC'];
      }
    }

    // Получаем цены
    $arInfo = CCatalogSKU::GetInfoByProductIBlock($arElement['IBLOCK_ID']);
    $price = 0;
    $oldPrice = 0;

    if ($arInfo) {
      $rsOffers = CIBlockElement::GetList([], ['IBLOCK_ID' => $arInfo['IBLOCK_ID'], 'PROPERTY_' . $arInfo['SKU_PROPERTY_ID'] => $productId], false, false, ["ID", "IBLOCK_ID", "NAME", "PRICE_7"]);
      if ($arOffer = $rsOffers->GetNext()) {
        $price = $arOffer['PRICE_7'];
        $oldPrice = $arOffer['PRICE_7']; // Можно добавить логику для старой цены
      }
    }

    // Получаем артикул товара
    $rsPropsArticle = CIBlockElement::GetProperty($arElement['IBLOCK_ID'], $productId, ["sort" => "asc"], ["CODE" => "CML2_ARTICLE"]);
    $article = '';
    if ($arProp = $rsPropsArticle->GetNext()) {
      $article = $arProp['VALUE'];
    }

    // Получаем цвета правильным способом
    $arColors = [];

    // Сначала пытаемся получить цвета через MyTools::getVariantColors
    if ($article) {
      try {
        $colors_list = MyTools::getVariantColors($article);
        foreach ($colors_list as $color => $detail_page) {
          $arColors[] = [
            'name' => $color,
            'code' => MyTools::getColor($color),
            'detail_page' => $detail_page
          ];
        }
      } catch (Exception $e) {
        // Если MyTools не сработал, получаем цвета из торговых предложений
        if ($arInfo) {
          $rsOffers = CIBlockElement::GetList([], ['IBLOCK_ID' => $arInfo['IBLOCK_ID'], 'PROPERTY_' . $arInfo['SKU_PROPERTY_ID'] => $productId], false, false, ["ID", "IBLOCK_ID", "NAME"]);
          $colors_from_offers = [];
          while ($rs = $rsOffers->GetNextElement()) {
            $arOffer = $rs->getFields();
            $arOffer['PROPERTIES'] = $rs->getProperties();
            if (!empty($arOffer['PROPERTIES']['TSVET']['VALUE'])) {
              $color_name = $arOffer['PROPERTIES']['TSVET']['VALUE'];
              if (!isset($colors_from_offers[$color_name])) {
                $colors_from_offers[$color_name] = [
                  'name' => $color_name,
                  'code' => MyTools::getColor($color_name)
                ];
              }
            }
          }
          $arColors = array_values($colors_from_offers);
        }
      }
    }

    // Получаем размеры
    $arSizes = [];
    if ($arInfo) {
      $rsOffers = CIBlockElement::GetList([], ['IBLOCK_ID' => $arInfo['IBLOCK_ID'], 'PROPERTY_' . $arInfo['SKU_PROPERTY_ID'] => $productId], false, false, ["ID", "IBLOCK_ID", "NAME"]);
      $sizes_unique = [];
      while ($rs = $rsOffers->GetNextElement()) {
        $arOffer = $rs->getFields();
        $arOffer['PROPERTIES'] = $rs->getProperties();
        if (!empty($arOffer['PROPERTIES']['RAZMER']['VALUE'])) {
          $size_value = $arOffer['PROPERTIES']['RAZMER']['VALUE'];
          if (!in_array($size_value, $sizes_unique)) {
            $sizes_unique[] = $size_value;
          }
        }
      }
      $arSizes = $sizes_unique;
    }

    $arProducts[] = [
      'id' => $productId,
      'name' => $arProps['NAIMENOVANIE_TOVARA_NA_SAYTE_ETIKETKE']['VALUE'] ?: $arElement['NAME'],
      'detail_url' => $arElement['DETAIL_PAGE_URL'],
      'images' => $arImages,
      'price' => $price,
      'old_price' => $oldPrice,
      'is_new' => isset($arProps['NEW']['VALUE']) ? $arProps['NEW']['VALUE'] == 'Y' : false,
      'is_preorder' => isset($arProps['PREORDER']['VALUE']) ? $arProps['PREORDER']['VALUE'] == 'Y' : false,
      'colors' => $arColors,
      'sizes' => $arSizes
    ];
  }
}

// Возвращаем результат в JSON
header('Content-Type: application/json');
echo json_encode($arProducts);
?>
