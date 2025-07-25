<?php
    use Bitrix\Main\Context;
    use Bitrix\Main\Localization\Loc;
    use Bitrix\Main\SystemException;
    use Bitrix\Main\Page\Asset;

    class Element extends \CBitrixComponent {
        public function executeComponent()
        {
            try {
                $this->run();
                $this->includeComponentTemplate();
            } catch (SystemException $e) {
                ShowError($e->getMessage());
            }
        }

        private function run()
        {
            global $APPLICATION;

            $this->defaultUrlTemplates404 = array(
                'element' => 'index.php',
            );

            $variables = array();
            $urlTemplates = \CComponentEngine::MakeComponentUrlTemplates(
                $this->defaultUrlTemplates404,
                $this->arParams['SEF_URL_TEMPLATES']
            );
            $variableAliases = \CComponentEngine::MakeComponentVariableAliases(
                $this->defaultUrlTemplates404,
                $this->arParams['VARIABLE_ALIASES']
            );
            $this->page = \CComponentEngine::ParseComponentPath(
                $this->arParams['SEF_FOLDER'],
                $urlTemplates,
                $variables
            );
            if (strlen($this->page) <= 0)
                $this->page = 'index';
            \CComponentEngine::InitComponentVariables(
                $this->page,
                $this->componentVariables, $variableAliases,
                $variables
            );


            $IBLOCK_ID = 29;
            $rsElement = \CIBlockElement::GetList([], ['IBLOCK_ID' => $IBLOCK_ID,'ACTIVE' => 'Y', '=CODE' => $variables['ELEMENT_CODE']], false, false, ['ID', 'IBLOCK_ID', 'NAME', 'DETAIL_TEXT', 'CODE', ]);
            $rsItem = $rsElement->GetNextElement();
            $arItem = $rsItem->getFields();
            $arItem['PROPERTIES'] = $rsItem->getProperties();

            $arInfo = CCatalogSKU::GetInfoByProductIBlock($IBLOCK_ID);
            //получаем торговые предложения
            $arOffers = [];
            $rsOffers = CIBlockElement::GetList(array(),array('IBLOCK_ID' => $arInfo['IBLOCK_ID'], 'PROPERTY_'.$arInfo['SKU_PROPERTY_ID'] => $arItem['ID']), false, false, array("ID", "IBLOCK_ID", "NAME", "PRICE_7"));
            while ($rs = $rsOffers->GetNextElement()) {
                $arOffer = $rs->getFields();
                $arOffer['PROPERTIES'] = $rs->getProperties();
                $arOffers[$arOffer['ID']] = $arOffer;
            }

            $this->arResult['ITEM'] = $arItem;
            $this->arResult['OFFERS'] = $arOffers;

            $colors_list = MyTools::getVariantColors($arItem['PROPERTIES']['CML2_ARTICLE']['VALUE']);
            $sizes_list = [];
            foreach($arOffers as $arOffer):
                $sizes_list[] = [
                    'id' => $arOffer['ID'],
                    'title' => $arOffer['PROPERTIES']['RAZMER']['VALUE'],
                    'price' => number_format($arOffer['PRICE_7'], 0, ' ', ' '),
                ];
            endforeach;

            $this->arResult['COLORS_LIST'] = $colors_list;
            $this->arResult['SIZES_LIST'] = $sizes_list;

            $this->arResult['CURRENT_COLOR'] = $this->arResult['ITEM']['PROPERTIES']['TSVET']['VALUE'];

            reset($arOffers);
            $this->arResult['OFFER'] = current($arOffers);

        }
    }