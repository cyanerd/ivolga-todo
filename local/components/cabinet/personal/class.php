<?php
declare(strict_types = 1);

namespace cabinet\personal;

use Bitrix\Main\Context;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use Bitrix\Main\Page\Asset;
use Bitrix\Sale;
use Bitrix\Sale\Delivery\Services\Manager;

class Personal extends \CBitrixComponent {

    /**
     * шаблоны путей по умолчанию
     * @var array
     */
    protected $defaultUrlTemplates404 = array();

    /**
     * переменные шаблонов путей
     * @var array
     */
    protected $componentVariables = array();

    /**
     * страница шаблона
     * @var string
     */
    protected $page = '';

    public function executeComponent()
    {
        try {
            $this->run();
            $this->includeComponentTemplate($this->page);
        } catch (SystemException $e) {
            ShowError($e->getMessage());
        }
    }

    private function run()
    {

        global $USER;

        if (!$USER->IsAuthorized()) {
            $this->page = 'no-auth';
            return true;
        }

        $request = \Bitrix\Main\Context::getCurrent()->getRequest()->toArray();

        $rsUser = \CUser::GetByID($USER->GetID());
        $arUser = $rsUser->Fetch();

        if ($this->arParams['SEF_MODE'] == 'Y') {
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
            if (!isset($this->page))
                $this->page = 'index';
            \CComponentEngine::InitComponentVariables(
                $this->page,
                $this->componentVariables, $variableAliases,
                $variables
            );
        } else {
            $this->page = 'index';
        }


        if ($this->page == 'order_detail') {
            $order_id = (int)$variables['ORDER_ID'];
            $order = Sale\Order::load($order_id);

            $order_user_id = $order->getUserId();
            if($arUser['ID'] != $order_user_id) {
                \Bitrix\Iblock\Component\Tools::process404( '404 Не найдено', 
                    true,
                    true,
                    true,
                    false);
                die;
            }

            $this->arResult['ORDER'] = $order;
            $deliveryIds = $order->getDeliverySystemId(); // массив id способов доставки
            $this->arResult['DELIVERY'] = Manager::getObjectById($deliveryIds[0])->getName();
            $paymentCollection = $order->getPaymentCollection();
            foreach ($paymentCollection as $payment) {
                $psName = $payment->getPaymentSystemName(); // название платежной системы
            }
            $this->arResult['PAYMENT'] = $psName;

            $propertyCollection = $order->getPropertyCollection();
            $this->arResult['ADDRESS']  = $propertyCollection->getAddress();

            $this->arResult['BASKET'] = $order->getBasket();
        }

        if($variables['ACTION']){
            $this->page = $variables['ACTION'];
        }
        $this->arResult['CURRENT_PAGE'] = $this->page;

        $this->arResult['USER'] = $arUser;

        if($this->page == 'new-address') {
            Asset::getInstance()->addString('<link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@20.3.0/dist/css/suggestions.min.css" rel="stylesheet" />');
            Asset::getInstance()->addString('<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@20.3.0/dist/js/jquery.suggestions.min.js"></script>');
        }
        if($this->page == 'addresses') {
            $this->getAddresses($arUser['ID']);
        }
        if($this->page == 'orders') {
            $this->getOrders($arUser['ID']);
        }
        if($this->page == 'change_addresses') {
            Asset::getInstance()->addString('<link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@20.3.0/dist/css/suggestions.min.css" rel="stylesheet" />');
            Asset::getInstance()->addString('<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@20.3.0/dist/js/jquery.suggestions.min.js"></script>');
            $this->getAddress($request['id']);
        }

        $el = new \CIBlockElement;
        // действия
        switch ($request['action']) {
            case 'subscribe':
                // отписываем или подписываем
                $is_subscribed = !$arUser['UF_NOT_SUBSCRIBED'];
                $user = new \CUser;
                $user->Update($USER->GetID(), ['UF_NOT_SUBSCRIBED' => $is_subscribed]);
                LocalRedirect('/personal/#modal-subscr-'.($is_subscribed ? 'y': 'n') );
                break;
            case 'update_user':
                $user = new \CUser;
                $arFields = [];
                if($request['firstName']) $arFields['NAME'] = $request['firstName'];
                if($request['lastName']) $arFields['LAST_NAME'] = $request['lastName'];
                if($request['dateOfBirth']) $arFields['PERSONAL_BIRTHDATE'] = $request['dateOfBirth'];
                if($request['email']) $arFields['EMAIL'] = filter_var($request['email'], FILTER_VALIDATE_EMAIL);
                $user->Update($USER->GetID(), $arFields);
                LocalRedirect('/personal/settings/?updated=Y');
                break;
            case 'add_address':
                $arLoadProductArray = Array(
                    "IBLOCK_ID"      => 23,
                    "PROPERTY_VALUES"=> [
                        'USER_ID' => $USER->GetID(),
                        'ADDRESS' => $request['address'],
                        'COMMENT' => $request['comment'],
                    ],
                    "NAME"           => $request['title'],
                    "ACTIVE"         => "Y",
                );
                $el->Add($arLoadProductArray);
                LocalRedirect('/personal/addresses/');
                break;
            case 'update_address':
                $arLoadProductArray = Array(
                    "IBLOCK_ID"      => 23,
                    "PROPERTY_VALUES"=> [
                        'USER_ID' => $USER->GetID(),
                        'ADDRESS' => $request['address'],
                        'COMMENT' => $request['comment'],
                    ],
                    "NAME"           => $request['title'],
                    "ACTIVE"         => "Y",
                );
                $el->Update($request['id'], $arLoadProductArray);
                LocalRedirect('/personal/addresses/');
                break;
        }
        $this->arResult['updated'] = $request['updated'] == 'Y';
    }

    private function render($template = "")
    {
        ob_start();
        $this->initComponentTemplate($template);
        $this->showComponentTemplate();
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }

    private function getAddresses($user_id) {
        $filter = array(
            'IBLOCK_ID' => 23,
            '=PROPERTY_USER_ID' => $user_id,
            'ACTIVE' => 'Y'
        );
        $sort = array(
            'DATE_ACTIVE_FROM' => 'DESC',
            'SORT' => 'DESC',
        );
        $select = array(
            'ID',
            'NAME',
            'IBLOCK_ID',
            'PROPERTY_USER_ID',
            'PROPERTY_CITY',
            'PROPERTY_ADDRESS',
            'PROPERTY_COMMENT',
        );
        $rsElement = \CIBlockElement::GetList($sort, $filter, false, array(), $select);
        while ($arElement = $rsElement->GetNext()) {
            $this->arResult['ADDRESS'][] = array(
                'ID' => $arElement['ID'],
                'NAME' => $arElement['NAME'],
                'USER_ID' => $arElement['PROPERTY_USER_ID_VALUE'],
                'CITY' => $arElement['PROPERTY_CITY_VALUE'],
                'ADDRESS' => $arElement['PROPERTY_ADDRESS_VALUE'],
                'COMMENT' => $arElement['PROPERTY_COMMENT_VALUE'],
            );
        }
    }
    private function getAddress($id)
    {
        $resElement = \CIBlockElement::GetList([], ['=ID' => $id], false, false, ['ID', 'IBLOCK_ID', 'NAME',])->GetNextElement();
        if ($resElement) {
            $this->arResult['ADDRESS'] = $resElement->getFields();
            $this->arResult['ADDRESS']['PROPERTIES'] = $resElement->getProperties();
        }
    }
    private function getOrders($user_id)
    {
        $arOrders = [];
        $parameters = [
            'filter' => [
                "USER_ID" => $user_id,
            ],
            'order' => ["DATE_INSERT" => "ASC"]
        ];
        $dbRes = \Bitrix\Sale\Order::getList($parameters);
        while ($order = $dbRes->fetch())
        {
            $order['ORDER'] = \Bitrix\Sale\Order::load($order['ID']);
            $order['BASKET'] = $order['ORDER']->getBasket();
            $arOrders[] = $order;
        }
        $this->arResult['ORDERS'] = $arOrders;
    }
}
