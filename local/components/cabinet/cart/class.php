<?php
declare(strict_types = 1);


use Bitrix\Main\Context;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
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

        if($variables['ACTION']){
            $this->page = $variables['ACTION'];
        }

        if($this->page == 'success') {
            $request = \Bitrix\Main\Context::getCurrent()->getRequest();
            $ORDER_ID = $request['order_id'];
            if(!$ORDER_ID) die('error');
            $this->arResult['ORDER_ID'] = $ORDER_ID;

            $order = \Bitrix\Sale\Order::load($ORDER_ID);
            if(!$order) die('error');


            //проверяем, может быть заказ уже оплачен
            if($order->isPaid()):
                //echo 'Заказ уже оплачен!';
            else:
                /** @var \Bitrix\Sale\PaymentCollection $paymentCollection */
                $paymentCollection = $order->getPaymentCollection();
                //проверяем есть ли оплаты или пусто
                $empty = true;
                foreach ($paymentCollection as $payment):
                    $psID = $payment->getPaymentSystemId();
                    if($psID):
                        $empty = false;
                        $PAY_SYSTEM_ID = $psID;
                        break;
                    endif;
                endforeach;

                $service = \Bitrix\Sale\PaySystem\Manager::getObjectById($PAY_SYSTEM_ID);

                if($empty):
                    $payment = $paymentCollection->createItem(
                        Bitrix\Sale\PaySystem\Manager::getObjectById($PAY_SYSTEM_ID)
                    );
                    $payment->setField("SUM", $order->getPrice());
                    $payment->setField("CURRENCY", $order->getCurrency());
                    $order->save();
                endif;
                ob_start();
                /** @var \Bitrix\Sale\Payment $payment */
                foreach ($paymentCollection as $payment)
                {
                    $context = \Bitrix\Main\Application::getInstance()->getContext();
                    $service->initiatePay($payment, $context->getRequest());
                    break;
                }
                $this->arResult['PAY_CONTENT'] = ob_get_contents();
                //if(!$arResult['PAY_CONTENT'])$arResult['PAY_CONTENT'] = '<p>Ваш заказ оплачен!</p>';
                ob_get_clean();

            endif;
        }

        if($this->page == 'index') {
            $delivery_types = getDeliveryTypes();
            $payments = getPayments();
            $delivery_summ = $delivery_types[0]['PRICE'];
            $this->arResult['DELIVERY_TYPES'] = $delivery_types;
            $this->arResult['DELIVERY_SUMM'] = $delivery_summ;
            $this->arResult['PAYMENTS'] = $payments;

            $arUser = [];
            if ($USER->IsAuthorized()) {
                $arUser = MyTools::getUserByFilter(['ID' => $USER->GetID()]);
                $this->arResult['ADDRESSES'] = MyTools::getAddresses($arUser['ID']);
            }
            $this->arResult['USER'] = $arUser;

            $this->arResult['BASKET'] = MyTools::getBasket();

        }


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

}
