<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	
	use Bitrix\Main\Localization\Loc;
	use Bitrix\Sale\Order;
	
	Loc::loadMessages(__FILE__);
	
	$APPLICATION->SetTitle(Loc::getMessage("PAGE_TITLE"));
	
	if (empty($_GET['ORDER_ID'])){
		die(Loc::getMessage("ORDER_NOT_FOUND"));
	}
	
	$order=Order::load($_GET['ORDER_ID']);
	$payment = $order->getPaymentCollection()->current();
	$ps = $payment->getPaySystem();
	$ps_params = $ps->getParamsBusValue($payment);
	
	$email = $order->getPropertyCollection()->getUserEmail()->getValue();
	$phone = $order->getPropertyCollection()->getPhone()->getValue();
	
	$hash=md5($_SERVER["HTTP_HOST"].$_GET['ORDER_ID'].$order->getPrice().$email);
	
	if ($_GET['hash']!=$hash)
	{
		echo Loc::getMessage("WRONG_HASH");
		die();
	}
	
	if ($order->getField("STATUS_ID")==$ps_params['STATUS_AU'])
	{
		echo Loc::getMessage("WRONG_AU_STATUS");
		die();
	}
	
	if ($order->isPaid())
	{
		echo Loc::getMessage("WRONG_ORDER_PAY");
		die();
	}
	
	if ($ps_params["CHECKONLINE"] != 'N') {
		$data=array();
		$items=array();
		
		foreach ($order->getBusket()->getBasketItems() as $basketItem) {
			$item = array(
				'label' => $basketItem->getField('NAME'),
				'price' => number_format($basketItem->getField('PRICE'), 2, ".", ''),
				'quantity' => $basketItem->getQuantity(),
				'vat' => is_null($basketItem->getField('VAT_RATE')) ? null : $basketItem->getField('VAT_RATE')  * 100,
				"object" => $ps_params['PREDMET_RASCHETA1'] ?: 0,
				"method" => $ps_params['SPOSOB_RASCHETA1'] ?: 0,
			);
			
			$item['amount'] = number_format($item['price'] * $item['quantity'], 2, ".", '');
			
			foreach ($basketItem->getPropertyCollection() as $property) {
				if ($property->getField('CODE') === 'SPIC')
					$item["spic"] = $property->getField('VALUE');
				if ($property->getField('CODE') === 'PACKAGE_CODE')
					$item["packageCode"] = $property->getField('VALUE');
			}
			
			$items[] = $item;
		}
		
		if ($order->getDeliveryPrice() > 0 && $order->getField("DELIVERY_ID"))
		{
			$item_d = array(
				'label' => GetMessage('DELIVERY_TXT'),
				'price' => number_format($order->getDeliveryPrice(), 2, ".", ''),
				'quantity' => 1,
				'amount' => number_format($order->getDeliveryPrice(), 2, ".", ''),
				'vat' => $ps_params['VAT_DELIVERY' . $order->getField("DELIVERY_ID")] ?: NULL,
				'object' => "4",
				'method' => $ps_params['SPOSOB_RASCHETA1'] ?: 0
			);
			
			if (!empty($ps_params['SPIC']))
				$item_d['spic'] = $ps_params['SPIC'];
			if (!empty($ps_params['PACKAGE_CODE']))
				$item_d['packageCode'] = $ps_params['PACKAGE_CODE'];
			
			$items[] = $item_d;
		}
		
		$data['cloudPayments']['customerReceipt']['Items']=$items;
		$data['cloudPayments']['customerReceipt']['taxationSystem']=$ps_params['TYPE_NALOG'];
		$data['cloudPayments']['customerReceipt']['email']=$email;
		$data['cloudPayments']['customerReceipt']['phone']=$phone;
	}
	
	$data['PAY_SYSTEM_ID']=$payment->getPaymentSystemId();
	
	$widget_url = "https://widget.cloudpayments." . ($ps_params['WIDGET_URL'] ?: 'ru') . "/bundles/cloudpayments?cms=1CBitrix";
	$widget_f= $ps_params['TYPE_SYSTEM'] ? 'auth' : 'charge';
	$lang_widget = $ps_params['WIDGET_LANG'] ?: 'ru-RU';
	$description = Loc::getMessage('WIDGET_DESC', array(
		"#ORDER_ID#" => $order->getId(),
		"#SITE_NAME#" => $_SERVER['HTTP_HOST'],
		"#DATE#" => $order->getDateInsert()
	));
?>


  <script type="text/javascript" src="/bitrix/js/main/jquery/jquery-1.8.3.min.js?151126639193636"></script>
  <script src="<?=$widget_url?>" async></script>
  <div>
    <p><?=Loc::getMessage('SUCCESS_MESSAGE', array("#ORDER_ID#" => $order->getId(), "#DATE#" => $order->getDateInsert()))?></p>
    <p><?=Loc::getMessage('ORDER_NUMBER', array("#ORDER_ID#" => $order->getId()))?></p>
    <p><?=Loc::getMessage('PERSONAL_LINK')?></p>
    <p><?=Loc::getMessage('WARNING_MESSAGE')?></p>
  </div>
  <button class="cloudpay_button" id="payButton"><?=Loc::getMessage('PAY_BUTTON')?></button>
  <div id="result" style="display:none"></div>

  <script type="text/javascript" defer>
      var payHandler = function () {
          var widget = new cp.CloudPayments({language:'<?=$lang_widget?>'});
          widget.<?=$widget_f?>({
                  publicId: '<?=$ps_params['APIPASS']?>',
                  description: '<?=$description?>',
                  amount: <?=number_format($payment->getSum(), 2, '.', '')?>,
                  currency: '<?=$order->getCurrency()?>',
                  email: '<?=$email?>',
                  invoiceId: '<?=$order->getId()?>',
                  accountId: '<?=htmlspecialcharsbx($order->getUserId());?>',
                  data: <?=CUtil::PhpToJSObject($data,false,true)?>,
              },
              function (options) {
                  BX("result").innerHTML = "<?=GetMessage('VBCH_CLOUDPAY_SUCCESS')?>";
                  BX.style(BX("result"), "color", "green");
                  BX.style(BX("result"), "display", "block");
				  
				  <?if ($ps_params['SUCCESS_URL'])
				  echo "window.location.href='".$ps_params['SUCCESS_URL']."?InvId=".htmlspecialcharsbx($ps_params["ORDER_ID"])."'"; ?>
              },
              function (reason, options) {
                  BX("result").innerHTML = reason;
                  BX.style(BX("result"), "color", "red");
                  BX.style(BX("result"), "display", "block");
				  <?if ($ps_params['FAIL_URL'])
				  echo "window.location.href='".$ps_params['FAIL_URL']."?InvId=".htmlspecialcharsbx($ps_params["ORDER_ID"])."'"; ?>
              });
      };
      document.getElementById('payButton').addEventListener('click', payHandler)
  </script>

<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>