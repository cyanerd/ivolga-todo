<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

// Подключаем необходимые модули
if (!CModule::IncludeModule('iblock')) {
  ShowError('Модуль Информационных блоков не установлен');
  return;
}
if (!CModule::IncludeModule('catalog')) {
  ShowError('Модуль Торгового каталога не установлен');
  return;
}

$APPLICATION->SetTitle("Оформление заказа");
$APPLICATION->SetPageProperty("title", "Оформление заказа - IVOLGA");

// Получаем корзину пользователя
$basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), SITE_ID);
$basketItems = $basket->getBasketItems();

// Проверяем, есть ли товары в корзине
if (empty($basketItems)) {
  // Если корзина пуста, перенаправляем в каталог
  LocalRedirect('/catalog/');
  return;
}

// Подсчитываем итоги
$totalPrice = 0;
$totalDiscount = 0;
$totalQuantity = 0;

foreach ($basketItems as $item) {
  $totalPrice += $item->getFinalPrice();
  $totalDiscount += $item->getDiscountPrice();
  $totalQuantity += $item->getQuantity();
}

?>
<section class="order">
  <div class="container">
    <div class="order__wrapper">
      <div class="order__row order-row">
        <?php if (!$USER->IsAuthorized()): ?>
          <div class="order-row__item">
            <div class="order-alert order-alert--action">
              <p><span>Авторизуйтесь</span>, и получайте кэшбэк с каждого заказа</p>
            </div>
          </div>
        <?php endif; ?>
        <div class="order-row__item order__delivery">
          <h2 class="order-row__title">Адрес и доставка</h2>
          <div class="order-select form-group">
            <select name="" id="">
              <option value="0">Выберите город</option>
              <option value="Москва">Москва</option>
              <option value="Санкт-Петербург">Санкт-Петербург</option>
              <option value="Казань">Казань</option>
              <option value="Краснодар">Краснодар</option>
            </select>
          </div>
          <div class="order-alert order-alert--area">
            <p><span>Для отображения опции доставки введите город</span></p>
          </div>
          <!-- Скрытые поля с информацией о корзине для JavaScript -->
          <input type="hidden" id="basket-total" value="<?= $totalPrice ?>">
          <input type="hidden" id="basket-quantity" value="<?= $totalQuantity ?>">
          
          <div class="order-methods hidden">
            <div class="order-methods__row" id="delivery-methods-container">
              <!-- Варианты доставки будут загружены динамически -->
            </div>
            <button class="order-methods__button js--modal" data-modal="modal-pickup">Выбрать пункт выдачи</button>
            <div class="order-methods__card">
              <table>
                <tbody>
                <tr>
                  <td>СДЭК</td>
                  <td>Профсоюзная 11</td>
                </tr>
                <tr>
                  <td>Ближайшая дата доставки:</td>
                  <td>Завтра или позже</td>
                </tr>
                <tr>
                  <td>Максимальный срок хранения:</td>
                  <td>4 дня<br> После указанного срока товары будут возвращены на склад</td>
                </tr>
                </tbody>
              </table>
              <button class="js--modal" data-modal="modal-pickup">Поменять пункт выдачи</button>
            </div>
            <div class="order-methods__card">
              <h2>Адрес шоурума</h2>
              <p>Шоу-рум Ivolga, Дизайн-завод Флакон, Большая Новодмитровская ул., 36</p>
              <button class="js--modal" data-modal="modal-address">Открыть на карте</button>
            </div>
          </div>
          <?php if ($USER->IsAuthorized()): ?>
            <div class="order-alert order-alert--action hidden">
              <p><span>выбрать из использовавшихся адресов</span></p>
            </div>
          <?php endif; ?>
          <div class="order-controls order-controls--address hidden">
            <div class="order-controls__group w-50">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Улица">
                <label class="form-label">Улица</label>
              </div>
            </div>
            <div class="order-controls__group w-50">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Дом">
                <label class="form-label">Дом</label>
              </div>
            </div>
            <div class="order-controls__group w-33">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Квартира">
                <label class="form-label">Квартира</label>
              </div>
            </div>
            <div class="order-controls__group w-33">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Подъезд">
                <label class="form-label">Подъезд</label>
              </div>
            </div>
            <div class="order-controls__group w-33">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Этаж">
                <label class="form-label">Этаж</label>
              </div>
            </div>
            <div class="order-controls__group w-100">
              <div class="form-group">
                <textarea name="" id="" class="form-control textarea" placeholder="Комментарий к заказу"></textarea>
                <label class="form-label">Комментарий к заказу</label>
              </div>
            </div>
            <div class="order-controls__group w-100">
              <div class="order-controls__preprice">Цена доставки: 500 ₽</div>
            </div>
          </div>
          <? if ($USER->IsAuthorized() && false) { ?>
            <div class="order-saving">
              <div class="order-saving__checkbox">
                <label class="checkbox">
                  <input type="checkbox" name="">
                  <p>Запомнить адрес для следующих заказов</p>
                </label>
              </div>
              <div class="order-saving__group form-group">
                <input type="text" class="form-control" placeholder="Название адреса">
                <label class="form-label">Название адреса</label>
              </div>
              <button class="order-saving__button">Сохранить</button>
            </div>
          <? } ?>
        </div>
        <div class="order-row__item order__persondata">
          <h2 class="order-row__title">Получатель</h2>
          <?php if ($USER->IsAuthorized()): ?>
            <div class="order-alert order-alert--action">
              <p><span>Заполнить автоматически</span> из профиля <?= htmlspecialchars($USER->GetFullName()) ?></p>
            </div>
          <?php endif; ?>
          <div class="order-controls">
            <div class="order-controls__group w-50">
              <div class="form-group">
                <input type="text" class="form-control" id="checkout-firstname" name="firstname" placeholder="Имя">
                <label class="form-label">Имя</label>
              </div>
            </div>
            <div class="order-controls__group w-50">
              <div class="form-group">
                <input type="text" class="form-control" id="checkout-lastname" name="lastname" placeholder="Фамилия">
                <label class="form-label">Фамилия</label>
              </div>
            </div>
            <div class="order-controls__group w-50">
              <div class="form-group">
                <input type="email" class="form-control" id="checkout-email" name="email" placeholder="E-mail">
                <label class="form-label">E-mail</label>
              </div>
            </div>
            <div class="order-controls__group w-50">
              <div class="form-group">
                <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="Телефон">
                <label class="form-label">Телефон</label>
              </div>
            </div>
          </div>
        </div>
        <div class="order-row__item order__payment">
          <h2 class="order-row__title">Оплата</h2>
          <div class="order-methods">
            <div class="order-methods__row">
              <label class="order-methods__item">
                <h2>Картой онлайн</h2>
                <input type="radio" name="method-payment" checked>
              </label>
              <label class="order-methods__item">
                <h2>Долями от Т-банка</h2>
                <p>4 платежа по 4800 ₽</p>
                <input type="radio" name="method-payment">
              </label>
            </div>
          </div>
          <?php if (!$USER->IsAuthorized()): ?>
            <div class="order-alert order-alert--action">
              <p><span>Авторизуйтесь</span>, чтобы оплачивать баллами</p>
            </div>
          <?php endif; ?>
          <?php if ($USER->IsAuthorized()): ?>
            <div class="order-promo">
              <h2 class="order-promo__title">Кэшбэк: <?= number_format(($totalPrice + 500) * 0.07, 0, '.', ' ') ?> баллов (1 балл
                = 1 ₽)</h2>
              <div class="order-promo__form">
                <div class="order-promo__group form-group">
                  <input type="text" class="form-control" placeholder="Сколько баллов вы хотите потратить?">
                  <label class="form-label">Сколько баллов вы хотите потратить?</label>
                </div>
                <button class="order-promo__button">Применить</button>
              </div>
              <h3 class="order-promo__result">Останется: <?= number_format(($totalPrice + 500) * 0.07, 0, '.', ' ') ?> Баллов</h3>
            </div>
          <?php else: ?>
            <div class="order-promo">
              <h2 class="order-promo__title">Кэшбэк: <?= number_format(($totalPrice + 500) * 0.07, 0, '.', ' ') ?> баллов (1 балл
                = 1 ₽)</h2>
              <div class="order-alert order-alert--action">
                <p><span>Авторизуйтесь</span>, чтобы использовать баллы</p>
              </div>
            </div>
          <?php endif; ?>
          <div class="order-promo">
            <div class="order-promo__form">
              <div class="order-promo__group form-group">
                <input type="text" class="form-control" placeholder="Промокод">
                <label class="form-label">Промокод</label>
              </div>
              <button class="order-promo__button">Применить</button>
            </div>
            <h3 class="order-promo__result">-0 ₽</h3>
          </div>
        </div>
        <div class="order-row__item order-submit">
          <div class="order-submit__accept">
            <label class="checkbox">
              <input type="checkbox" name="">
              <p>Я принимаю условия <a href="/info/offer/" target="_blank">публичной оферты</a></p>
            </label>
          </div>
          <div class="order-submit__accept">
            <label class="checkbox">
              <input type="checkbox" name="">
              <p>Я хочу получать новости от Ivolga на свой Email</p>
            </label>
          </div>
          <button class="order-submit__button">Подтвердить заказ</button>
        </div>
      </div>
      <div class="order__aside">
        <div class="order-aside">
          <h2 class="order-aside__title">ваш заказ</h2>
          <div class="order-aside__cart">
            <ul>
              <?php foreach ($basketItems as $item): ?>
                <li>
                  <picture>
                    <?php
                    $productId = $item->getProductId();

                    // Получаем информацию о товаре
                    $rsElement = \CIBlockElement::GetList([], ['ACTIVE' => 'Y', '=ID' => $productId], false, [], ['ID', 'NAME', 'DETAIL_PICTURE', 'PREVIEW_PICTURE']);
                    $arElement = $rsElement->GetNext();

                    // Получаем родительский товар (если это SKU)
                    $parent_product = CCatalogSku::GetProductInfo($arElement['ID']);
                    if ($parent_product) {
                      $rsParentProduct = \CIBlockElement::GetList([], ['ACTIVE' => 'Y', '=ID' => $parent_product['ID']], false, [], ['ID', 'NAME', 'DETAIL_PICTURE', 'PREVIEW_PICTURE']);
                      $arParentProduct = $rsParentProduct->GetNext();
                      $image = $arParentProduct['DETAIL_PICTURE'] ?: $arParentProduct['PREVIEW_PICTURE'];
                      $productName = $arParentProduct['NAME'];
                    } else {
                      $image = $arElement['DETAIL_PICTURE'] ?: $arElement['PREVIEW_PICTURE'];
                      $productName = $arElement['NAME'];
                    }

                    if ($image) {
                      $imageUrl = CFile::GetPath($image);
                    } else {
                      $imageUrl = '/assets/img/no-photo.jpg';
                    }
                    ?>
                    <img src="<?= $imageUrl ?>" alt="<?= htmlspecialchars($productName) ?>">
                  </picture>
                </li>
              <?php endforeach; ?>
            </ul>
            <button class="js--modal" data-modal="cart">Изменить корзину</button>
          </div>
          <table class="order-aside__table">
            <tbody>
            <tr>
              <td><?= $totalQuantity ?> <?= pluralForm($totalQuantity, ["товар", "товара", "товаров"]) ?>:</td>
              <td><?= number_format($totalPrice + $totalDiscount, 0, '.', ' ') ?> ₽</td>
            </tr>
            <tr>
              <td>Баллами:</td>
              <td>-0 ₽</td>
            </tr>
            <tr>
              <td>Промокод:</td>
              <td>-0 ₽</td>
            </tr>
            <tr>
              <td>Скидка:</td>
              <td>-<?= number_format($totalDiscount, 0, '.', ' ') ?> ₽</td>
            </tr>
            <tr>
              <td>Доставка:</td>
              <td>500 ₽</td>
            </tr>
            <tr>
              <td>Итого:<br><span>*Без учёта возможной стоимости доставки</span></td>
              <td><?= number_format($totalPrice + 500, 0, '.', ' ') ?> ₽</td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
              <td>Вернётся баллами:</td>
              <td><?= number_format(($totalPrice + 500) * 0.07, 0, '.', ' ') ?> ₽</td>
            </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal modal-address" id="modal-pickup">
  <div class="modal__dialog">
    <div class="modal__wrapper">
      <div class="modal__map">
        <div id="map">
          <img src="/html/assets/img/map.png" alt="">
        </div>
      </div>
      <div class="modal__content">
        <div class="modal__header">
          <h2 class="modal__title">Пункты самовывоза</h2>
          <button class="modal__close" modal-close>
            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M18 20.5L12 12.5M6 4.5L12 12.5M12 12.5L18 4.5M12 12.5L6 20.5" stroke="#232229" stroke-width="1.5"/>
            </svg>
          </button>
        </div>
        <div class="modal__body">
          <div class="modal__item">
            <h3>Выберите службу выдачи</h3>
            <div class="modal-address__select">
              <select>
                <?php
                // Получаем активные службы доставки
                $deliveryServices = \Bitrix\Sale\Delivery\Services\Manager::getActiveList();
                foreach ($deliveryServices as $service) {
                  if ($service['ACTIVE'] == 'Y') {
                    echo '<option value="' . htmlspecialchars($service['ID']) . '">' . htmlspecialchars($service['NAME']) . '</option>';
                  }
                }
                ?>
              </select>
            </div>
          </div>
          <div class="modal__item">
            <h3>Адреса пунктов</h3>
            <div class="modal-address__action js--modal" data-modal="modal-address">
              <p>Поиск по адресу</p>
            </div>
            <div class="modal-address__list">
              <div class="spoiler-address">
                <div class="spoiler-address__head">
                  <h4 class="spoiler-address__title">СДЭК</h4>
                  <p class="spoiler-address__excerpt">Профсоюзная 11</p>
                </div>
                <div class="spoiler-address__body">
                  <table class="spoiler-address__table">
                    <tbody>
                    <tr>
                      <td>Ближайшая дата доставки:</td>
                      <td>Завтра или позже</td>
                    </tr>
                    <tr>
                      <td>Максимальный срок хранения:</td>
                      <td>4 дня <br>После указанного срока товары будут возвращены на склад</td>
                    </tr>
                    </tbody>
                  </table>
                  <button class="spoiler-address__button">Привезти сюда</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-address" id="modal-address">
  <div class="modal__dialog">
    <div class="modal__wrapper">
      <div class="modal__map">
        <div id="map">
          <img src="/_bitrix/html/assets/img/map.png" alt="">
        </div>
      </div>
      <div class="modal__content">
        <div class="modal__header">
          <div class="modal__back js--modal" data-modal="modal-pickup">
            <svg width="24" height="25" viewBox="0 0 24 25" xmlns="http://www.w3.org/2000/svg">
              <path d="M9 12.4497L15 18.4497L15.707 17.7427L10.0605 12.0962L15.707 6.44971L15 5.74268L9 11.7427L9 12.4497Z"/>
            </svg>
            <span>Назад</span>
          </div>
          <button class="modal__close" modal-close>
            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M18 20.5L12 12.5M6 4.5L12 12.5M12 12.5L18 4.5M12 12.5L6 20.5" stroke="#232229" stroke-width="1.5"/>
            </svg>
          </button>
        </div>
        <div class="modal__body">
          <div class="modal__item">
            <h3>Поиск по адресу</h3>
            <div class="modal-address__search search-address">
              <div class="search-address__group">
                <input type="search" class="form-control" placeholder="Введите адрес">
                <button class="search-address__button">
                  <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M17.5 10.5C17.5 6.63401 14.366 3.5 10.5 3.5C6.63401 3.5 3.5 6.63401 3.5 10.5C3.5 14.366 6.63401 17.5 10.5 17.5C12.4331 17.5 14.1829 16.7175 15.4502 15.4502C16.7175 14.1829 17.5 12.4331 17.5 10.5ZM18.5 10.5C18.5 12.529 17.7417 14.38 16.4971 15.79L21.707 21L21 21.707L15.79 16.4971C14.38 17.7417 12.529 18.5 10.5 18.5C6.08172 18.5 2.5 14.9183 2.5 10.5C2.5 6.07172 6.08172 2.5 10.5 2.5C14.9183 2.5 18.5 6.07172 18.5 10.5Z"/>
                  </svg>
                </button>
              </div>
              <ul class="search-address__results">
                <li>г. Москва, ул. Профсоюзная, д. 122А</li>
                <li>г. Москва, ул. Профсоюзная, д. 12</li>
                <li>г. Москва, ул. Профсоюзная, д. 36</li>
                <li>г. Москва, ул. Профсоюзная, д. 147</li>
              </ul>
            </div>
          </div>
          <div class="modal__item">
            <h3>Результаты поиска</h3>
            <div class="modal-address__list">
              <div class="result-address">
                <h4 class="result-address__title">СДЭК</h4>
                <p class="result-address__excerpt">Шоу-рум Ivolga, Дизайн-завод Флакон, Большая Новодмитровская ул., 36</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const openAlert = () => {
    document.querySelector('.cartaler').classList.add('open')
  }

  const phoneInputs = document.querySelectorAll('input[type="tel"]');

  // Определяем маску для русского телефона
  const maskOptions = {
    mask: '+7 (000) 000-00-00'
  };

  // Применяем маску к каждому полю ввода
  phoneInputs.forEach(input => {
    IMask(input, maskOptions);
  });
</script>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
