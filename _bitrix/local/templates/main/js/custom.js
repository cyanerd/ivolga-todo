$(document).ready(function () {

  window.USE_CATALOG_AJAX = true;

  const getCatalogParams = () => {
    const params = {};
    const cat = $("input[name='categories']:checked").val();
    if (cat) params.category = cat;
    const sizes = $("input[name='size']:checked").map(function () {return this.value;}).get();
    if (sizes.length) params.size = sizes.join(',');
    const colors = $("input[name='color']:checked").map(function () {return this.value;}).get();
    if (colors.length) params.color = colors.join(',');
    const materials = $("input[name='material']:checked").map(function () {return this.value;}).get();
    if (materials.length) params.material = materials.join(',');
    const collections = $("input[name='collections']:checked").map(function () {return this.value;}).get();
    if (collections.length) params.collection = collections.join(',');
    return Object.keys(params).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(params[key])).join('&');
  }

  window.getCatalogParams = getCatalogParams;

  function updateCatalogAjax(params) {
    const url = window.location.pathname + (params ? ('?' + params) : '');
    window.history.pushState({}, '', url);
    $("#catalog-ajax-container").addClass('loading');
    closeModal('.catdrop', true);

    $.get(url + (params ? '&' : '?') + 'ajax=Y', function (data) {
      const $container = $(data).filter('#catalog-ajax-container');
      const html = $container.length ? $container.html() : $(data).find('#catalog-ajax-container').html();
      $('#catalog-ajax-container').html(html);
      $("#catalog-ajax-container").removeClass('loading');
      // window.scrollTo({top: $("#catalog-ajax-container").offset().top - 50, behavior: 'smooth'});
      $(html).removeClass('locked');
      initFilters();
    });
  }

  window.updateCatalogAjax = updateCatalogAjax;

  // Фильтрация каталога по выбранным фильтрам (AJAX или обычная перезагрузка)
  $(document).on('click', '.catdrop__apply', function (e) {
    const search = getCatalogParams();

    if (window.USE_CATALOG_AJAX) {
      e.preventDefault();
      updateCatalogAjax(search);
    } else {
      window.location.href = window.location.pathname + (search ? ('?' + search) : '');
    }
  });

  // Сбросить все фильтры (AJAX)
  $(document).on('click', '.catdrop__reset', function (e) {
    e.preventDefault();
    $(this).closest('.catdrop').find('input[type=checkbox], input[type=radio]').prop('checked', false);
    if (window.USE_CATALOG_AJAX) {
      updateCatalogAjax('');
    } else {
      window.location.href = window.location.pathname;
    }
  });

  // Поддержка истории браузера (назад/вперёд)
  window.addEventListener('popstate', function () {
    const params = window.location.search.replace(/^\?/, '');
    updateCatalogAjax(params);
  });

  let catalogPaginationLoading = false;
  $(document).on('click', '.catalogpage__more', function(e) {

    console.log('click');
    e.preventDefault();
    if (catalogPaginationLoading) return;
    catalogPaginationLoading = true;
    const $btn = $(this);
    let page = parseInt($btn.data('page') || 1, 10) + 1;
    const params = new URLSearchParams(window.location.search);
    params.set('ajax', 'Y');
    params.set('PAGEN_1', page);

    $.get(window.location.pathname + '?' + params.toString(), function(data) {
      const $html = $('<div>').html(data);
      const $newItems = $html.find('.catalogpage__items > div').children();
      console.log('$newItems.length', $newItems.length);
      if ($newItems.length) {
        $('.catalogpage__items > div').append($newItems);
      }
      // Проверяем, есть ли ещё страницы
      const $newBtn = $html.find('.catalogpage__more');
      if ($newBtn.length) {
        $btn.data('page', page);
      } else {
        $btn.remove();
      }
      catalogPaginationLoading = false;
    });
  });

  let authMode = 'initial';

  const $openBtn = $('#open-profile-modal-auth');
  const $modal = $('#profile-modal-auth');

  if ($openBtn.length && $modal.length) {
    $openBtn.on('click', function () {
      $modal.addClass('open');
      $('body').addClass('modal-open');
    });
  }

  $('.lkmodal__back.back-button').on('click', function () {
    authMode = 'guest';
    onAuthModeChange();
  });

  // Закрытие модалки по крестику
  $('#profile-modal-auth .lkmodal__close').on('click', function () {
    $modal.removeClass('open');
    $('body').removeClass('modal-open');
  });

  $('#enter-as-guest').bind('click', function () {
    authMode = 'guest';
    onAuthModeChange();
  });

  $('.main-header__button.modal-button[data-src=".profile-modal"]').each(function () {
    $(this).on('click', function () {
      const $modal = $('.modal-right.profile-modal');
      if ($modal.length) {
        $modal.find('.profile-modal__step').addClass('hide');
        const $step1 = $modal.find('.profile-modal__step--1');
        if ($step1.length) $step1.removeClass('hide');
        $modal.addClass('active');
        $('body').addClass('modal-open');
      }
    });
  });

  const $formSendSms = $('#form--send--sms');
  if ($formSendSms.length) {
    $formSendSms.on('submit', function (e) {
      e.preventDefault();
      const $form = $(this);
      const $btn = $form.find('button[type="submit"]');
      $btn.prop('disabled', true);

      const formData = new FormData(this);

      $.ajax({
        url: '/ajax/auth.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (data) {
          authMode = 'code';
          $btn.prop('disabled', false);
          onAuthModeChange();
        }
      });
    });
  }

  $('#get--code--repeat').bind('click', function () {
    $formSendSms.submit();
    $('.lkmodal__form.mode-code .lkmodal__form-descr').text('Мы повторно отправили код на номер');
  });

  const $formVerifySms = $('#form--verify--sms');
  if ($formVerifySms.length) {
    $formVerifySms.on('submit', function (e) {
      e.preventDefault();
      const $form = $(this);
      const $btn = $form.find('button[type="submit"]');
      $btn.prop('disabled', true);

      const formData = new FormData(this);

      // Получаем номер телефона из скрытого поля (или из input, если нужно)
      const phone = $('#verifed--phone').val() || $('#phone').val();
      if (phone) {
        formData.set('phone', phone); // set перезапишет, append — добавит ещё одно поле
      }

      $.ajax({
        url: '/ajax/check.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (data) {
          $btn.prop('disabled', false);
          const $errorDiv = $('#check--error');
          if (data.status === 'error') {
            if ($errorDiv.length) $errorDiv.text(data.message || 'Ошибка');
            const $codeInput = $('#verificationCode');
            if ($codeInput.length) $codeInput.val('');
          }
          if (data.status === 'success') {
            location.href = '/personal/';
          }
        }
      });
    });
  }

  const onAuthModeChange = () => {
    $('.lkmodal__form').addClass('hide');
    $('.lkmodal__form.mode-' + authMode).removeClass('hide');
  }

  // --- Модалки open/close ---
  window.openModal = function(id, bySelector = false) {
    let modal;
    if (!bySelector) modal = document.getElementById(id);
    else modal = document.querySelector(id);

    if (modal) {
      modal.classList.add('open');
      if ($('.backdrop').length) $('.backdrop').addClass('open');
    }
  }
  window.closeModal = function(id, bySelector = false) {

    let modal;
    if (!bySelector) modal = document.getElementById(id);
    else modal = document.querySelector(id);

    $('html').removeClass('locked');

    if (modal) {
      modal.classList.remove('open');
      if ($('.backdrop').length) $('.backdrop').removeClass('open');
    }
  }

  // --- Смена пароля ---
  var form = document.getElementById('changePassForm');
  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var data = new FormData(form);
      var errorBlock = document.getElementById('changePassError');
      errorBlock.style.display = 'none';
      fetch('/ajax/change_password.php', {
        method: 'POST',
        body: data
      })
        .then(r => r.json())
        .then(res => {
          if (res.success) {
            window.closeModal('changepass');
            window.openModal('changepass_ok');
            form.reset();
          } else {
            errorBlock.textContent = res.error || 'Ошибка';
            errorBlock.style.display = 'block';
          }
        })
        .catch(() => {
          errorBlock.textContent = 'Ошибка соединения';
          errorBlock.style.display = 'block';
        });
    });
  }

  // --- Маска телефона ---
  if (window.IMask) {
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    const maskOptions = { mask: '+7 (000) 000-00-00' };
    phoneInputs.forEach(input => {
      IMask(input, maskOptions);
    });
  }

  // --- Добавление адреса (форма) ---
  var addForm = document.querySelector('#newadress .lkmodal__form');
  if (addForm) {
    addForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var street = document.getElementById('street').value.trim();
      var home = document.getElementById('home').value.trim();
      var podesz = document.getElementById('podesz').value.trim();
      var room = document.getElementById('room').value.trim();
      var floor = document.getElementById('floor').value.trim();
      var comment = document.getElementById('comment').value.trim();
      var address = street + (home ? ', д. ' + home : '') + (podesz ? ', подъезд ' + podesz : '') + (room ? ', кв. ' + room : '') + (floor ? ', этаж ' + floor : '');
      var data = new FormData();
      data.append('action', 'add_address');
      data.append('title', street + (home ? ', д. ' + home : ''));
      data.append('address', address);
      data.append('comment', comment);
      fetch('/personal/', {
        method: 'POST',
        body: data
      })
        .then(r => r.text())
        .then(res => {
          window.closeModal('newadress');
          window.openModal('newadress_ok');
          setTimeout(function () {
            window.location.href = '/personal/addresses/';
          }, 1200);
        })
        .catch(() => {
          alert('Ошибка при добавлении адреса');
        });
    });
  }
  // --- Добавление адреса (div, не form) ---
  var addFormDiv = document.querySelector('#newadress .lkmodal__form');
  var addBtn = addFormDiv ? addFormDiv.querySelector('.lkmodal__form-submit') : null;
  if (addFormDiv && addBtn) {
    addBtn.type = 'button';
    addBtn.addEventListener('click', function (e) {
      e.preventDefault();
      if (addBtn.disabled) return;
      addBtn.disabled = true;
      var street = document.getElementById('street').value.trim();
      var home = document.getElementById('home').value.trim();
      var podesz = document.getElementById('podesz').value.trim();
      var room = document.getElementById('room').value.trim();
      var floor = document.getElementById('floor').value.trim();
      var comment = document.getElementById('comment').value.trim();
      var address = street + (home ? ', д. ' + home : '') + (podesz ? ', подъезд ' + podesz : '') + (room ? ', кв. ' + room : '') + (floor ? ', этаж ' + floor : '');
      var data = new FormData();
      data.append('action', 'add_address');
      data.append('title', street + (home ? ', д. ' + home : ''));
      data.append('address', address);
      data.append('comment', comment);
      fetch('/personal/', {
        method: 'POST',
        body: data
      })
        .then(r => r.text())
        .then(res => {
          window.closeModal('newadress');
          window.openModal('newadress_ok');
          setTimeout(function () {
            window.location.href = '/personal/addresses/';
          }, 1200);
        })
        .catch(() => {
          alert('Ошибка при добавлении адреса');
        })
        .finally(() => {
          addBtn.disabled = false;
        });
    });
  }

  // Валидация даты рождения (только дата, не в будущем)
  $('#date').on('change blur', function () {
    const value = $(this).val();
    // Проверяем формат YYYY-MM-DD и что дата не в будущем
    const isValid = /^\d{4}-\d{2}-\d{2}$/.test(value) && new Date(value) <= new Date();
    if (!isValid && value !== '') {
      $(this).addClass('input-error');
      this.setCustomValidity('Введите корректную дату рождения');
    } else {
      $(this).removeClass('input-error');
      this.setCustomValidity('');
    }
  });
});


// ===== ФУНКЦИИ ДЛЯ РАБОТЫ С ИЗБРАННЫМ =====

// Функция для получения избранных товаров из localStorage
function getFavouriteProducts() {
  return JSON.parse(localStorage.getItem('favourite_products') || '[]');
}

// Функция для добавления товара в избранное
function addToFavourite(productId) {
  let favourites = getFavouriteProducts();
  if (!favourites.includes(productId)) {
    favourites.push(productId);
    localStorage.setItem('favourite_products', JSON.stringify(favourites));
    updateFavouriteCounter();
    updateFavouriteButtons();
  }
}

// Функция для удаления товара из избранного
function removeFromFavourite(productId) {
  let favourites = getFavouriteProducts();
  favourites = favourites.filter(id => id !== productId);
  localStorage.setItem('favourite_products', JSON.stringify(favourites));

  // Обновляем счетчик
  updateFavouriteCounter();

  // Удаляем карточку товара из DOM (если мы на странице избранного)
  const productCard = document.querySelector(`.__favourite [data-product-id="${productId}"]`);
  if (productCard) {
    productCard.remove();

    // Если товаров нет, показываем сообщение
    const container = document.getElementById('favourite-products');
    if (container && container.children.length === 0) {
      container.innerHTML = '<div class="empty-favourites"><p>В избранном пока ничего нет</p></div>';
    }
  }

  // Обновляем кнопки избранного
  updateFavouriteButtons();
}

// Функция для проверки, находится ли товар в избранном
function isFavourite(productId) {
  const favourites = getFavouriteProducts();
  return favourites.includes(productId);
}

// Функция для обновления счетчика избранного
function updateFavouriteCounter() {
  const favourites = getFavouriteProducts();
  const countElements = document.querySelectorAll('.favourite-count, #favourite-count, #header-favourite-count');

  countElements.forEach(element => {
    if (favourites.length > 0) {
      element.textContent = favourites.length;
      element.style.display = element.dataset.dd || 'flex';
    } else {
      element.textContent = '';
      element.style.display = 'none';
    }
  });
}

// Функция для обновления всех кнопок избранного на странице
function updateFavouriteButtons() {
  const buttons = document.querySelectorAll('.product-card__like');
  console.log('Found', buttons.length, 'favourite buttons');

  buttons.forEach((button, index) => {
    const productCard = button.closest('.product-card');
    console.log(`Button ${index}:`, button);
    console.log(`Button ${index} classes:`, button.classList);
    console.log(`Button ${index} dataset:`, button.dataset);

    if (productCard) {
      const productId = productCard.dataset.productId;
      console.log(`Button ${index} productId:`, productId);

      if (productId) {
        if (isFavourite(productId)) {
          console.log(`Button ${index}: adding active class`);
          button.classList.add('active');
        } else {
          console.log(`Button ${index}: removing active class`);
          button.classList.remove('active');
        }
      }
    }
  });
}

// Обработчик кликов на кнопки избранного
function initFavouriteButtons() {
  // Проверяем, не добавлен ли уже обработчик
  if (window.favouriteButtonsInitialized) {
    return;
  }

  document.addEventListener('click', function (e) {
    // Проверяем, кликнули ли мы на кнопку избранного или её содержимое
    const likeButton = e.target.closest('.product-card__like');
    if (likeButton) {
      console.log('Favourite button clicked!');
      console.log('Like button classes:', likeButton.classList);
      console.log('Like button dataset:', likeButton.dataset);
      e.preventDefault();
      e.stopPropagation();

      // Ищем родительскую карточку товара
      const productCard = likeButton.closest('.product-card');

      // Пробуем получить ID из разных мест
      let productId = likeButton.dataset.productId;
      if (!productId && productCard) {
        productId = productCard.dataset.productId;
      }

      if (productId) {
        if (isFavourite(productId)) {
          console.log('Removing from favourite:', productId);
          removeFromFavourite(productId);
        } else {
          console.log('Adding to favourite:', productId);
          addToFavourite(productId);
        }
      } else {
        console.error('Product ID not found!');
      }
    }
  });

  window.favouriteButtonsInitialized = true;
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function () {
  console.log('Initializing favourite functionality');
  initFavouriteButtons();
  updateFavouriteButtons();
  updateFavouriteCounter();
});

// Функция для обновления состояния кнопки "В корзину"
function updateAddToCartButtonState() {
  const addToCartButton = document.querySelector('.pageprod__buy-cart');
  if (!addToCartButton) return;

  // Проверяем, есть ли цвета для выбора
  const colorInputs = document.querySelectorAll('input[name="color"]');
  const hasColors = colorInputs.length > 0;

  // Проверяем, есть ли размеры для выбора
  const sizeInputs = document.querySelectorAll('input[name="size"]');
  const hasSizes = sizeInputs.length > 0;

  // Проверяем выбор цвета
  const selectedColor = document.querySelector('input[name="color"]:checked')?.value || addToCartButton.dataset.selectedColor || '';

  // Проверяем выбор размера
  const selectedSize = document.querySelector('input[name="size"]:checked');

  let isDisabled = false;
  let buttonText = 'В корзину';

  // Проверяем цвет
  if (hasColors && (!selectedColor || selectedColor === '')) {
    isDisabled = true;
    buttonText = 'Выберите цвет';
  }
  // Проверяем размер
  else if (hasSizes && !selectedSize) {
    isDisabled = true;
    buttonText = 'Выберите размер';
  }

  // Обновляем состояние кнопки
  addToCartButton.disabled = isDisabled;
  addToCartButton.textContent = buttonText;

  if (isDisabled) {
    addToCartButton.classList.add('disabled');
  } else {
    addToCartButton.classList.remove('disabled');
  }
}

// ===== ФУНКЦИИ ДЛЯ РАБОТЫ С КОРЗИНОЙ =====

// Функция для добавления товара в корзину
async function addToCart(productId, quantity = 1) {
  try {
    console.log('Adding to cart:', productId);
    const response = await fetch('/ajax/sale.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `command=add_to_cart&item_id=${productId}`
    });

    const result = await response.json();
    console.log('Add to cart result:', result);

    if (result.result === 'ok') {
      // Обновляем информацию о товаре в модальном окне
      updateCartAlertInfo(productId);

      // Открываем модальное окно уведомления о добавлении в корзину
      if (typeof openAlert === 'function') {
        openAlert();
      }

      // Обновляем счетчик корзины
      updateCartCounter();
    } else {
      console.error('Error adding to cart: server error');
    }
  } catch (error) {
    console.error('Error adding to cart:', error);
  }
}

// Функция для обновления количества товара в корзине
async function updateCartQuantity(cartId, quantity) {
  try {
    const response = await fetch('/ajax/sale.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `command=update_cart_amount&id=${cartId}&value=${quantity}`
    });

    const result = await response.json();

    if (result.result === 'ok') {
      updateCartContent();
      updateCartCounter();
    }
  } catch (error) {
    console.error('Error updating cart quantity:', error);
  }
}

// Функция для удаления товара из корзины
async function removeFromCart(cartId) {
  try {
    const response = await fetch('/ajax/sale.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `command=del&id=${cartId}`
    });

    const result = await response.json();

    if (result.result === 'ok') {
      updateCartContent();
      updateCartCounter();
    }
  } catch (error) {
    console.error('Error removing from cart:', error);
  }
}

// Функция для получения количества товаров в корзине
async function getCartCount() {
  try {
    const response = await fetch('/ajax/get_cart_modal.php', {
      method: 'GET'
    });

    const result = await response.json();

    if (result.success) {
      return result.count;
    }
    return 0;
  } catch (error) {
    console.error('Error getting cart count:', error);
    return 0;
  }
}

// Функция для загрузки содержимого корзины
async function loadCartContent() {
  try {
    console.log('Loading cart content...');
    const response = await fetch('/ajax/get_cart_modal.php', {
      method: 'GET'
    });

    const result = await response.json();
    console.log('Cart response:', result);

    if (result.success) {
      const cartContent = document.getElementById('cart-content');
      if (cartContent) {
        cartContent.innerHTML = result.html;
        initCartEventListeners();
        console.log('Cart content updated, count:', result.count);
      }
    }
  } catch (error) {
    console.error('Error loading cart content:', error);
  }
}

// Функция для обновления содержимого корзины
function updateCartContent() {
  // Просто вызываем loadCartContent напрямую
  loadCartContent();
}

// Функция для обновления счетчика корзины
async function updateCartCounter() {
  const cartCount = await getCartCount();
  const cartCountElement = document.getElementById('header-cart-count');

  if (cartCountElement) {
    if (cartCount > 0) {
      cartCountElement.textContent = cartCount;
      cartCountElement.style.display = 'flex';
    } else {
      cartCountElement.textContent = '';
      cartCountElement.style.display = 'none';
    }
  }
}

// Функция для инициализации обработчиков событий корзины
function initCartEventListeners() {
  // Обработчики для кнопок увеличения/уменьшения количества
  document.querySelectorAll('.counter__prev').forEach(button => {
    button.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      const cartItem = this.closest('.modalcart-item');
      const cartId = cartItem.dataset.cartId;
      const input = cartItem.querySelector('.counter__number');
      const currentQuantity = parseInt(input.value);
      if (currentQuantity > 1) {
        updateCartQuantity(cartId, currentQuantity - 1);
      }
    });
  });

  document.querySelectorAll('.counter__next').forEach(button => {
    button.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      const cartItem = this.closest('.modalcart-item');
      const cartId = cartItem.dataset.cartId;
      const input = cartItem.querySelector('.counter__number');
      const currentQuantity = parseInt(input.value);
      updateCartQuantity(cartId, currentQuantity + 1);
    });
  });

  // Обработчики для кнопок удаления
  document.querySelectorAll('.modalcart-item__cart').forEach(button => {
    button.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      const cartItem = this.closest('.modalcart-item');
      const cartId = cartItem.dataset.cartId;
      removeFromCart(cartId);
    });
  });
}

// Обработчик для кнопок "В корзину"
function initAddToCartButtons() {
  // Инициализируем состояние кнопки при загрузке
  updateAddToCartButtonState();

  // Обработчики для выбора цвета
  document.addEventListener('change', function (e) {
    if (e.target.name === 'color') {
      const addToCartButton = document.querySelector('.pageprod__buy-cart');
      if (addToCartButton) {
        addToCartButton.dataset.selectedColor = e.target.value;
        updateAddToCartButtonState();
      }
    }
  });

  // Обработчики для выбора размера
  document.addEventListener('change', function (e) {
    if (e.target.name === 'size') {
      updateAddToCartButtonState();
    }
  });

  document.addEventListener('click', function (e) {
    const addToCartButton = e.target.closest('.pageprod__buy-cart');
    if (addToCartButton) {
      e.preventDefault();
      e.stopPropagation();

      // Проверяем, отключена ли кнопка
      if (addToCartButton.disabled) {
        return;
      }

      // Проверяем, есть ли выбранное торговое предложение
      const offerId = addToCartButton.dataset.offerId;
      const productId = addToCartButton.dataset.productId;

      // Проверяем, есть ли цвета для выбора
      const colorInputs = document.querySelectorAll('input[name="color"]');
      const hasColors = colorInputs.length > 0;

      // Проверяем, есть ли размеры для выбора
      const sizeInputs = document.querySelectorAll('input[name="size"]');
      const hasSizes = sizeInputs.length > 0;

      // Проверяем выбор цвета, если он требуется
      const selectedColor = document.querySelector('input[name="color"]:checked')?.value || addToCartButton.dataset.selectedColor || '';
      if (hasColors && (!selectedColor || selectedColor === '')) {
        return;
      }

      // Проверяем выбор размера, если он требуется
      const selectedSize = document.querySelector('input[name="size"]:checked');
      if (hasSizes && !selectedSize) {
        return;
      }

      // Определяем ID товара для добавления в корзину
      let itemIdToAdd = productId; // По умолчанию используем ID основного товара

      if (hasSizes && selectedSize) {
        // Если есть размеры и выбран размер, используем ID торгового предложения
        const sizeOfferId = selectedSize.id.replace('size-', '');
        if (sizeOfferId) {
          itemIdToAdd = sizeOfferId;
          console.log('Adding offer to cart:', sizeOfferId);
        } else {
          console.log('Adding product to cart:', productId);
        }
      } else {
        console.log('Adding product to cart:', productId);
      }

      addToCart(itemIdToAdd);
    }
  });
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function () {
  console.log('Initializing cart functionality');
  initAddToCartButtons();
  updateCartCounter(); // Загружаем счетчик корзины при загрузке страницы

  // Загружаем содержимое корзины при открытии модального окна
  const cartModal = document.getElementById('cart');
  if (cartModal) {
    const observer = new MutationObserver(function (mutations) {
      mutations.forEach(function (mutation) {
        if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
          const isVisible = cartModal.style.display === 'block' || cartModal.style.display === 'flex';
          if (isVisible) {
            loadCartContent();
          }
        }
      });
    });

    observer.observe(cartModal, {
      attributes: true,
      attributeFilter: ['style']
    });
  }

  // Обработчик для кнопки "Оформить заказ" в модальном окне корзины
  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('modalcart__order')) {
      e.preventDefault();

      // Закрываем модальное окно корзины
      const cartModal = document.getElementById('cart');
      if (cartModal) {
        cartModal.style.display = 'none';
      }

      // Перенаправляем на страницу оформления заказа
      window.location.href = '/checkout/';
    }
  });

  // === Логика для alert-main ===
  const alertMain = document.getElementById('alert-main');
  const alertClose = document.getElementById('alert-close');
  const alertClosedKey = 'alertMainClosed';

  if (alertMain) {
    if (localStorage.getItem(alertClosedKey) === '1') {
      alertMain.style.display = 'none';
    } else {
      alertMain.style.display = '';
      if (alertClose) {
        alertClose.addEventListener('click', function () {
          alertMain.style.display = 'none';
          localStorage.setItem(alertClosedKey, '1');
        });
      }
    }
  }

  // === Newsletter subscribe AJAX ===
  const newsletterForm = document.getElementById('newsletter-form');
  if (newsletterForm) {
    newsletterForm.addEventListener('submit', async function (e) {
      e.preventDefault();
      const input = newsletterForm.querySelector('input[type="email"]');
      const email = input.value.trim();
      const button = newsletterForm.querySelector('button[type="submit"]');
      button.disabled = true;
      let msg = document.querySelector('.newsletter-msg');
      if (!msg) {
        msg = document.createElement('div');
        msg.className = 'newsletter-msg';
        msg.style.marginTop = '10px';
        msg.style.textAlign = 'center';
        newsletterForm.parentNode.insertBefore(msg, newsletterForm.nextSibling);
      }
      msg.textContent = '';
      try {
        const res = await fetch('/ajax/ajax.php', {
          method: 'POST',
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          body: `command=newsletter_subscribe&email=${encodeURIComponent(email)}`
        });
        const data = await res.json();
        if (data.status === 'success') {
          msg.textContent = data.message;
          msg.style.color = 'green';
          input.value = '';
        } else {
          msg.textContent = data.message || 'Ошибка';
          msg.style.color = 'red';
        }
      } catch (err) {
        msg.textContent = 'Ошибка соединения';
        msg.style.color = 'red';
      }
      button.disabled = false;
    });
  }

  // AJAX-сохранение профиля
  $('#profile-form').on('submit', function(e) {
    e.preventDefault();
    const $form = $(this);

    // Получаем дату и преобразуем
    const $date = $form.find('input[name="PERSONAL_BIRTHDAY"]');
    const val = $date.val();
    let formattedDate = val;
    if (val && /^\d{4}-\d{2}-\d{2}$/.test(val)) {
      const parts = val.split('-');
      formattedDate = parts[2] + '.' + parts[1] + '.' + parts[0];
    }

    const $btn = $form.find('button[type="submit"]');
    $btn.prop('disabled', true);
    const formData = new FormData(this);
    formData.set('PERSONAL_BIRTHDAY', formattedDate);
    if (!formData.has('sessid')) {
      formData.append('sessid', $('input[name="sessid"]').val());
    }
    if (!formData.has('save')) {
      formData.append('save', 'Y');
    }
    $.ajax({
      url: '/ajax/update_profile.php',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function (data) {
        if (data.success) {
          openModal('updateprofile');
        } else {
          alert(data.error || 'Ошибка при сохранении профиля');
        }
        $btn.prop('disabled', false);
      },
      error: function () {
        $btn.prop('disabled', false);
        alert('Ошибка при сохранении профиля. Попробуйте ещё раз.');
      }
    });
    return false;
  });
});

// Делаем функции глобально доступными
window.addToFavourite = addToFavourite;
window.removeFromFavourite = removeFromFavourite;
window.isFavourite = isFavourite;
window.getFavouriteProducts = getFavouriteProducts;
window.updateFavouriteCounter = updateFavouriteCounter;
window.updateFavouriteButtons = updateFavouriteButtons;
window.updateAddToCartButtonState = updateAddToCartButtonState;
window.addToCart = addToCart;
window.updateCartQuantity = updateCartQuantity;
window.removeFromCart = removeFromCart;
window.loadCartContent = loadCartContent;
window.updateCartCounter = updateCartCounter;
window.getCartCount = getCartCount;
window.updateCartAlertInfo = updateCartAlertInfo;

// Функция для обновления информации о товаре в модальном окне
function updateCartAlertInfo(productId) {
  const cartaler = document.querySelector('.cartaler');
  if (!cartaler) return;

  // Получаем информацию о товаре со страницы
  const productName = document.querySelector('.pageprod__title')?.textContent?.trim() || 'Товар';
  // Ищем фото: сначала в .pageprod__img img, если нет — в .product-card__image img
  const productImage = document.querySelector('.pageprod__img img, .product-card__image img, .pageprod__gallery-slide img')?.src || '/assets/img/no-photo.jpg';
  // Цена — из .pageprod__prices
  const productPrice = document.querySelector('.pageprod__prices')?.textContent?.trim() || '';
  // Старая цена (если есть)
  const productOldPrice = document.querySelector('.pageprod__price-old')?.textContent?.trim() || '';

  // Получаем выбранные характеристики
  const selectedSize = document.querySelector('input[name="size"]:checked')?.nextElementSibling?.textContent?.trim() || '';
  const selectedColor = document.querySelector('input[name="color"]:checked')?.value || '';
  // Также получаем выбранный цвет из кнопки, если он там есть
  const addToCartButton = document.querySelector('.pageprod__buy-cart');
  const buttonSelectedColor = addToCartButton?.dataset?.selectedColor || '';
  const finalSelectedColor = selectedColor || buttonSelectedColor;

  // Обновляем изображение товара
  const cartalerImg = cartaler.querySelector('.cartaler__img img');
  if (cartalerImg) {
    cartalerImg.src = productImage;
    cartalerImg.alt = productName;
  }
  // Обновляем название товара
  const cartalerTitle = cartaler.querySelector('.cartaler__title');
  if (cartalerTitle) {
    cartalerTitle.textContent = productName;
  }
  // Обновляем цены
  const cartalerPriceOld = cartaler.querySelector('.cartaler__price-old');
  if (cartalerPriceOld && productOldPrice) {
    cartalerPriceOld.textContent = productOldPrice;
  } else {
    cartalerPriceOld.textContent = '';
  }
  const cartalerPriceCurrent = cartaler.querySelector('.cartaler__price-current');
  if (cartalerPriceCurrent && productPrice) {
    cartalerPriceCurrent.textContent = productPrice;
  }
  // Обновляем информацию о характеристиках
  const cartalerInfo = cartaler.querySelector('.cartaler__info');
  if (cartalerInfo) {
    let infoText = '';
    if (finalSelectedColor) {
      infoText += `Цвет: ${finalSelectedColor}`;
    }
    if (selectedSize) {
      if (infoText) infoText += '<br>';
      infoText += `Размер: ${selectedSize}`;
    }
    cartalerInfo.innerHTML = infoText;
  }
}

// Функции для работы с уведомлением о добавлении в корзину
window.openAlert = () => {
  const cartaler = document.querySelector('.cartaler');
  if (cartaler) {
    cartaler.classList.add('open');

    // Автоматически закрываем через 3 секунды
    setTimeout(() => {
      cartaler.classList.remove('open');
    }, 3000);
  }
};

window.closeAlert = () => {
  const cartaler = document.querySelector('.cartaler');
  if (cartaler) {
    cartaler.classList.remove('open');
  }
};

$(document).on('click', '#logout-btn', function (e) {
  e.preventDefault();
  openModal('logout-modal');
});

$(document).ready(function () {
  $('#logout-yes').on('click', function () {

    $.ajax({
      url: '/ajax/logout.php',
      type: 'POST',
      dataType: 'json',
      success: function (response) {
        if (response.result === 'ok') {
          window.location.href = '/';
        } else {
          alert('Вы уже не авторизованы');
          window.location.reload();
        }
      },
      error: function () {
        alert('Ошибка при выходе');
      }
    });

  });

  $('#logout-no').on('click', function () {
    closeModal('logout-modal');
  });
});

// ====== AJAX отмена заказа ======
$(function () {
  $(document).on('click', '.singleorder-footer__cancel', function (e) {
    e.preventDefault();
    var $btn = $(this);
    var orderId = $('input[name="order_id"]').val() || $btn.data('order-id');
    if (!orderId) {
      alert('Не удалось определить номер заказа.');
      return;
    }
    if (!confirm('Вы уверены, что хотите отменить заказ?')) return;
    $.ajax({
      url: '/ajax/cancel_order.php',
      type: 'POST',
      data: {order_id: orderId},
      dataType: 'json',
      success: function (data) {
        if (data.status === 'success') {
          $btn.hide();
          window.location.href = '/personal/orders/';
        } else {
          alert(data.message || 'Ошибка при отмене заказа.');
        }
      },
      error: function () {
        alert('Ошибка соединения.');
      }
    });
  });
});

// ====== АДРЕСА: добавление, редактирование, удаление ======
$(function () {
  // Открытие модалки для добавления адреса
  $(document).on('click', '.lk-locations__add', function (e) {
    e.preventDefault();
    $('#editadress-title').text('Добавить новый адрес');
    $('#editadress-submit').text('Добавить');
    $('#editadress').removeData('id');
    $('#editadress input').val('');
    $('#editadress').addClass('open');
    if ($('.backdrop').length) $('.backdrop').addClass('open');
  });

  // Открытие модалки для редактирования адреса
  $(document).on('click', '.js-edit-address', function (e) {
    e.preventDefault();
    const id = $(this).data('id');
    const address = $(this).data('address');
    const house = $(this).data('house');
    const entrance = $(this).data('entrance');
    const apartment = $(this).data('apartment');
    const floor = $(this).data('floor');
    const comment = $(this).data('comment');
    $('#editadress-title').text('Редактировать адрес');
    $('#editadress-submit').text('Редактировать');
    $('#editadress').data('id', id);
    $('#editadress input#street').val(address);
    $('#editadress input#home').val(house);
    $('#editadress input#podesz').val(entrance);
    $('#editadress input#room').val(apartment);
    $('#editadress input#floor').val(floor);
    $('#editadress input#comment').val(comment);
    $('#editadress').addClass('open');
    if ($('.backdrop').length) $('.backdrop').addClass('open');
  });

  // Сохранение (добавление или редактирование)
  $(document).on('click', '#editadress-submit', async function (e) {
    e.preventDefault();
    const id = $('#editadress').data('id');
    const address = $('#editadress input#street').val();
    const house = $('#editadress input#home').val();
    const entrance = $('#editadress input#podesz').val();
    const apartment = $('#editadress input#room').val();
    const floor = $('#editadress input#floor').val();
    const comment = $('#editadress input#comment').val();
    const isEdit = !!id;
    const command = isEdit ? 'edit_addr' : 'add_addr';
    try {
      const response = await $.ajax({
        url: '/ajax/sale.php',
        type: 'POST',
        data: {
          command: command,
          id: id,
          address: address,
          house: house,
          entrance: entrance,
          apartment: apartment,
          floor: floor,
          comment: comment
        },
        dataType: 'json'
      });
      $('#editadress').removeClass('open');
      if (response.result === 'ok') {
        $('#editadress-ok-title').text('Готово!');
        $('#editadress-ok-msg').text(isEdit ? 'Адрес успешно сохранён' : 'Адрес успешно добавлен');
        $('#editadress_ok').addClass('open');
        setTimeout(function () { location.reload(); }, 1000);
      } else {
        alert(response.message || 'Ошибка при сохранении адреса');
      }
    } catch (err) {
      alert('Ошибка соединения');
    }
  });

  // Удаление адреса
  window.del_addr = function (id) {
    if (confirm('Вы уверены, что хотите удалить этот адрес?')) {
      $.ajax({
        url: '/ajax/sale.php',
        type: 'POST',
        data: {
          command: 'del_addr',
          id: id
        },
        success: function (response) {
          var data = typeof response === 'object' ? response : JSON.parse(response);
          if (data.result === 'ok') {
            $('#addr' + id).remove();
            if ($('.lk-locations__item').length === 0) {
              location.reload();
            }
          } else {
            alert('Ошибка при удалении адреса');
          }
        },
        error: function () {
          alert('Ошибка при удалении адреса');
        }
      });
    }
  };

  // Закрытие модалки подтверждения
  $(document).on('click', '#editadress_ok .lkmodal__form-submit, #editadress_ok .lkmodal__close', function (e) {
    e.preventDefault();
    $('#editadress_ok').removeClass('open');
    if ($('.backdrop').length) $('.backdrop').removeClass('open');
  });

  // Закрытие модалки по клику на оверлей
  $(document).on('click', '.backdrop', function (e) {
    $('.lkmodal').removeClass('open');
    $('#editadress').removeClass('open');
    $('#editadress_ok').removeClass('open');
    $('.catdrop').removeClass('open');
    $(this).removeClass('open');
  });
});

// Открытие карточки товара по клику на картинку в избранном
$(document).on('click', '.catalogpage__main .product-card__image', function (e) {
  // Не реагируем на клик по лайку
  if ($(e.target).closest('.product-card__like').length) return;
  const $card = $(this).closest('.product-card');
  const $info = $card.find('.product-card__info');
  if ($info.length) {
    window.location.href = $info.attr('href');
  }
});

$(document).on('click', '.catalogpage__togfilter1', function (e) {
  e.preventDefault();
  openModal('.catdrop', true);
});

