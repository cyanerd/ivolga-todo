// Функция для форматирования чисел
function number_format(number, decimals, dec_point, thousands_sep) {
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
  const n = !isFinite(+number) ? 0 : +number;
  const prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
  const sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
  const dec = (typeof dec_point === 'undefined') ? '.' : dec_point;
  let s = '';

  const toFixedFix = function (n, prec) {
    const k = Math.pow(10, prec);
    return '' + Math.round(n * k) / k;
  };

  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if ((sep.length > 0) && (s[0].length > 3)) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((prec > 0) && (s[1].length < prec)) {
    s[1] = s[1] + '0'.repeat(prec - s[1].length);
  }
  return s.join(dec);
}

const maskOptions = {
  mask: '+7 (000) 000-00-00'
};

const formatPrice = (price) => {
  return Math.floor(price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
}

$(document).ready(function () {

  $('.prodpar__block-colors input[name="color"]').bind('change', function () {
    location.href = $(this).data('url');
  });

  const phoneInputs = document.querySelectorAll('input[type="tel"]');
  phoneInputs.forEach(input => {
    IMask(input, maskOptions);
  });

  loadCartContent();

  window.USE_CATALOG_AJAX = true;

  const getCatalogParams = () => {
    const params = {};

    // Обрабатываем категорию отдельно - она будет в URL пути, а не в параметрах
    const cat = $("input[name='categories']:checked").data('val');

    const sizes = $("input[name='size']:checked").map(function () {return this.value;}).get();
    if (sizes.length) params.size = sizes.join(',');
    const colors = $("input[name='color']:checked").map(function () {return this.value;}).get();
    if (colors.length) params.color = colors.join(',');
    const materials = $("input[name='material']:checked").map(function () {return this.value;}).get();
    if (materials.length) params.material = materials.join(',');
    const collections = $("input[name='collection']:checked").map(function () {return this.value;}).get();
    if (collections.length) params.collection = collections.join(',');

    // Добавляем параметры сортировки
    const sortValue = $('select[name="sort"]').val();
    const orderValue = $('input[name="order"]').val();
    if (sortValue) params.sort = sortValue;
    if (orderValue) params.order = orderValue;

    // Формируем базовый URL с категорией в пути
    let baseUrl = '/catalog/';
    if (cat) {
      baseUrl += cat + '/';
    }

    // Формируем параметры запроса
    const queryString = Object.keys(params).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(params[key])).join('&');

    // Возвращаем объект с URL и параметрами
    return {
      url: baseUrl,
      params: queryString,
      fullUrl: baseUrl + (queryString ? '?' + queryString : '')
    };
  }

  window.getCatalogParams = getCatalogParams;

  function updateCatalogAjax(catalogData) {
    // Если передана строка (для обратной совместимости), используем текущий путь
    let url, ajaxUrl;
    if (typeof catalogData === 'string') {
      url = window.location.pathname + (catalogData ? ('?' + catalogData) : '');
      ajaxUrl = url + (catalogData ? '&' : '?') + 'ajax=Y';
    } else {
      // Новый формат - объект с url и params
      url = catalogData.fullUrl;
      ajaxUrl = catalogData.url + (catalogData.params ? ('?' + catalogData.params + '&ajax=Y') : '?ajax=Y');
    }

    window.history.pushState({}, '', url);
    $("#catalog-ajax-container").addClass('loading');
    closeModal('.catdrop', true);

    $.get(ajaxUrl, function (data) {
      const $container = $(data).filter('#catalog-ajax-container');
      const html = $container.length ? $container.html() : $(data).find('#catalog-ajax-container').html();
      $('#catalog-ajax-container').html(html);
      $("#catalog-ajax-container").removeClass('loading');
      // window.scrollTo({top: $("#catalog-ajax-container").offset().top - 50, behavior: 'smooth'});
      $(html).removeClass('locked');
      initFilters();
      initSortHandlers(); // Переинициализируем обработчики сортировки

      // Обновляем активный пункт навигации
      updateCatalogNavigation(url);

      // Проверяем, обновился ли класс сортировки
      const $sortContainer = $('.catalogpage__sort');
    }).fail(function (xhr, status, error) {
      console.error('AJAX request failed:', status, error);
      $("#catalog-ajax-container").removeClass('loading');
    });
  }

  // Функция для обновления активного пункта навигации в каталоге
  function updateCatalogNavigation(currentUrl) {
    // Убираем параметры из URL, оставляем только путь
    const urlPath = currentUrl.split('?')[0];
    
    // Убираем все активные классы
    $('.catalogpage__nav a').removeClass('active');
    
    // Находим соответствующий пункт навигации и делаем его активным
    $('.catalogpage__nav a').each(function() {
      const navHref = $(this).attr('href');
      if (navHref === urlPath) {
        $(this).addClass('active');
        return false; // Прерываем цикл
      }
    });
    
    // Если точное совпадение не найдено и это путь каталога без категории
    if (urlPath === '/catalog/' && !$('.catalogpage__nav a.active').length) {
      $('.catalogpage__nav a[href="/catalog/"]').addClass('active');
    }
  }

  window.updateCatalogAjax = updateCatalogAjax;

  // Фильтрация каталога по выбранным фильтрам (AJAX или обычная перезагрузка)
  $(document).on('click', '.catdrop__apply', function (e) {
    const catalogData = getCatalogParams();

    if (window.USE_CATALOG_AJAX) {
      e.preventDefault();
      updateCatalogAjax(catalogData);
      // Обновляем связанные фильтры
      setTimeout(updateRelatedFilters, 500);
    } else {
      window.location.href = catalogData.fullUrl;
    }
  });

  // Сбросить все фильтры (AJAX)
  $(document).on('click', '.catdrop__reset', function (e) {
    e.preventDefault();
    resetFilters();
  });

  // Функция для сброса фильтров
  window.resetFilters = function () {
    $('.catdrop').find('input[type=checkbox], input[type=radio]').prop('checked', false);
    if (window.USE_CATALOG_AJAX) {
      updateCatalogAjax('');
    } else {
      window.location.href = window.location.pathname;
    }
  };

  // Функция для обновления связанных фильтров
  function updateRelatedFilters() {
    const catalogData = getCatalogParams();
    if (!catalogData.params) return; // Если нет параметров, не обновляем

    // Добавляем индикатор загрузки
    $('.catdrop-block').addClass('loading');

    const updateUrl = catalogData.url + (catalogData.params ? ('?' + catalogData.params + '&ajax=Y&update_filters=Y') : '?ajax=Y&update_filters=Y');
    $.get(updateUrl, function (data) {
      const $html = $('<div>').html(data);
      const $newFilters = $html.find('.catdrop-block');

      // Обновляем каждый блок фильтров
      $newFilters.each(function () {
        const filterType = $(this).data('type');
        const $currentFilter = $('.catdrop-block[data-type="' + filterType + '"]');

        if ($currentFilter.length) {
          // Сохраняем выбранные значения
          const selectedValues = [];
          $currentFilter.find('input:checked').each(function () {
            selectedValues.push($(this).val());
          });

          // Обновляем содержимое
          $currentFilter.find('.catdrop-block__body').html($(this).find('.catdrop-block__body').html());

          // Восстанавливаем выбранные значения
          selectedValues.forEach(function (value) {
            $currentFilter.find('input[value="' + value + '"]').prop('checked', true);
          });
        }
      });

      // Убираем индикатор загрузки
      $('.catdrop-block').removeClass('loading');
    }).fail(function () {
      // Убираем индикатор загрузки в случае ошибки
      $('.catdrop-block').removeClass('loading');
    });
  }

  // Поддержка истории браузера (назад/вперёд)
  window.addEventListener('popstate', function () {
    const params = window.location.search.replace(/^\?/, '');
    updateCatalogAjax(params);
  });

  // Обработка сортировки
  $(document).on('change', 'select[name="sort"]', function () {
    const form = $(this).closest('form');
    const sortValue = $(this).val();
    const orderValue = form.find('input[name="order"]').val();

    // Обновляем URL с новыми параметрами сортировки
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('sort', sortValue);
    urlParams.set('order', orderValue);

    if (window.USE_CATALOG_AJAX) {
      updateCatalogAjax(urlParams.toString());
    } else {
      form.submit();
    }
  });

  // Дополнительная проверка инициализации обработчиков сортировки
  function initSortHandlers() {
    const $sortSelect = $('select[name="sort"]');

    if ($sortSelect.length) {
      $sortSelect.off('change').on('change', function () {
        const form = $(this).closest('form');
        const sortValue = $(this).val();
        const orderValue = form.find('input[name="order"]').val();

        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('sort', sortValue);
        urlParams.set('order', orderValue);

        if (window.USE_CATALOG_AJAX) {
          updateCatalogAjax(urlParams.toString());
        } else {
          form.submit();
        }
      });
    }
  }

  // Вызываем инициализацию при загрузке страницы
  initSortHandlers();

  // Функция для изменения направления сортировки
  window.toggleSortOrder = function () {
    const form = document.querySelector('.catalogpage__sort form');

    if (!form) {
      console.error('Form not found');
      return;
    }

    const orderInput = form.querySelector('input[name="order"]');
    const sortInput = form.querySelector('select[name="sort"]');

    orderInput.value = orderInput.value === 'asc' ? 'desc' : 'asc';

    if (window.USE_CATALOG_AJAX) {
      const urlParams = new URLSearchParams(window.location.search);
      urlParams.set('sort', sortInput.value);
      urlParams.set('order', orderInput.value);
      updateCatalogAjax(urlParams.toString());
    } else {
      form.submit();
    }
  };

  let catalogPaginationLoading = false;
  $(document).on('click', '.catalogpage__more', function (e) {

    e.preventDefault();
    if (catalogPaginationLoading) return;
    catalogPaginationLoading = true;
    const $btn = $(this);
    let page = parseInt($btn.data('page') || 1, 10) + 1;
    const params = new URLSearchParams(window.location.search);
    params.set('ajax', 'Y');
    params.set('PAGEN_1', page);

    $.get(window.location.pathname + '?' + params.toString(), function (data) {
      const $html = $('<div>').html(data);
      const $newItems = $html.find('.catalogpage__items > div').children();
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

  $('.modal .modal__close').on('click', function () {
    $(this).parents('.modal').removeClass('open');
    $('body').removeClass('modal-open');
    $('.backdrop').removeClass('open');
    $('html').removeClass('locked');
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
  window.openModal = function (id, bySelector = false) {
    let modal;
    if (!bySelector) modal = document.getElementById(id);
    else modal = document.querySelector(id);

    if (modal) {
      modal.classList.add('open');
      if ($('.backdrop').length) $('.backdrop').addClass('open');
    }
  }

  $(document).on('click', '.js--close', function (e) {
    closeModals();
  });

  window.closeModals = function () {
    $('html').removeClass('locked');
    $('.lkmodal.open').removeClass('open');
    if ($('.backdrop').length) $('.backdrop').removeClass('open');
  }

  window.closeModal = function (id, bySelector = false) {

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
    const maskOptions = {mask: '+7 (000) 000-00-00'};
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

  buttons.forEach((button, index) => {

    let productId;
    if (button.dataset.productId) productId = button.dataset.productId;
    else {
      const productCard = button.closest('.product-card');
      if (productCard) {
        productId = productCard.dataset.productId;
      }
    }

    if (productId) {
      if (isFavourite(productId)) {
        button.classList.add('active');
      } else {
        button.classList.remove('active');
      }
    }
  });
}

function favouriteAjax(productId) {
  var param = 'id=' + productId;

  $.ajax({
    url: '/ajax/favourites.php',
    type: "GET",
    dataType: "html",
    data: param,
    success: function (response) {
    },
    error: function (jqXHR, textStatus, errorThrown) { // Если ошибка, то выкладываем печаль в консоль
      console.log('Error: ' + errorThrown);
    }
  });
}

// Обработчик кликов на кнопки избранного
function initFavouriteButtons() {
  // Проверяем, не добавлен ли уже обработчик
  if (window.favouriteButtonsInitialized) {
    return;
  }

  // Обработчик для десктопа
  document.addEventListener('click', function (e) {
    // Проверяем, кликнули ли мы на кнопку избранного или её содержимое
    const likeButton = e.target.closest('.product-card__like');
    if (likeButton) {
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
          removeFromFavourite(productId);
        } else {
          addToFavourite(productId);
        }
      } else {
        console.error('Product ID not found!');
      }

      favouriteAjax(productId);
    }
  });

  // Обработчик для мобильных устройств
  document.addEventListener('touchstart', function (e) {
    const likeButton = e.target.closest('.product-card__like');
    if (likeButton) {
      e.preventDefault();
      e.stopPropagation();
    }
  }, {passive: false});

  document.addEventListener('touchend', function (e) {
    const likeButton = e.target.closest('.product-card__like');
    if (likeButton) {
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
          removeFromFavourite(productId);
        } else {
          addToFavourite(productId);
        }
      } else {
        console.error('Product ID not found!');
      }
    }
  }, {passive: false});

  window.favouriteButtonsInitialized = true;
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function () {
  initFavouriteButtons();
  updateFavouriteButtons();
  updateFavouriteCounter();
});

// Функция для обновления состояния кнопки "В корзину"
async function updateAddToCartButtonState() {
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

  // Проверяем доступность товара на складе
  /*
  if (!isDisabled) {
    const productId = addToCartButton.dataset.productId;
    if (productId) {
      try {
        const response = await fetch(`/ajax/check_stock.php?product_id=${productId}`);
        const result = await response.json();

        if (result.success && result.available_quantity <= 0) {
          isDisabled = true;
          buttonText = 'Нет в наличии';
        }
      } catch (error) {
        console.error('Error checking stock:', error);
      }
    }
  }
  */

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
    const response = await fetch('/ajax/sale.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `command=add_to_cart&item_id=${productId}`
    });

    const result = await response.json();

    if (result.result === 'ok') {
      // Обновляем информацию о товаре в модальном окне
      updateCartAlertInfo(productId);

      // Открываем модальное окно уведомления о добавлении в корзину
      if (typeof openAlert === 'function') {
        openAlert();
      }

      // Обновляем счетчик корзины
      updateCartCounter();
    } else if (result.result === 'error') {
      // Показываем ошибку от сервера
      showNotification(result.message || 'Ошибка при добавлении в корзину', 'error');
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
    // Проверяем, не превышает ли запрашиваемое количество доступное на складе
    const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
    if (cartItem) {
      const counter = cartItem.querySelector('.js--count');
      const maxQuantity = parseInt(counter.dataset.maxQuantity) || 999;

      if (quantity > maxQuantity) {
        showNotification('Нельзя добавить больше товара, чем есть на складе', 'warning');
        return;
      }
    }

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

      // Обновляем состояние кнопок увеличения количества
      const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
      if (cartItem) {
        const button = cartItem.querySelector('.counter__next');
        const input = cartItem.querySelector('.counter__number');
        const counter = cartItem.querySelector('.js--count');
        const maxQuantity = parseInt(counter.dataset.maxQuantity) || 999;

        if (quantity >= maxQuantity) {
          button.disabled = true;
        } else {
          button.disabled = false;
        }
      }
    } else if (result.result === 'error') {
      // Показываем ошибку от сервера
      showNotification(result.message || 'Ошибка при обновлении количества', 'error');
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
    const response = await fetch('/ajax/get_cart_modal.php', {
      method: 'GET'
    });

    const result = await response.json();

    if (result.success) {
      const cartContent = document.getElementById('cart-content');
      if (cartContent) {
        cartContent.innerHTML = result.html;
        initCartEventListeners();
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

  // Если мы на странице checkout, обновляем её тоже
  if (window.location.pathname.includes('/checkout/')) {
    updateCheckoutPage();
  }
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

  // Обновляем состояние кнопок увеличения количества
  document.querySelectorAll('.counter__next').forEach(button => {
    const cartItem = button.closest('.modalcart-item');
    const input = cartItem.querySelector('.counter__number');
    const currentQuantity = parseInt(input.value);
    const counter = cartItem.querySelector('.js--count');
    const maxQuantity = parseInt(counter.dataset.maxQuantity) || 999;

    // Отключаем кнопку, если достигнут лимит
    if (currentQuantity >= maxQuantity) {
      button.disabled = true;
    } else {
      button.disabled = false;
    }
  });

  document.querySelectorAll('.counter__next').forEach(button => {
    button.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      const cartItem = this.closest('.modalcart-item');
      const cartId = cartItem.dataset.cartId;
      const input = cartItem.querySelector('.counter__number');
      const currentQuantity = parseInt(input.value);
      const counter = cartItem.querySelector('.js--count');
      const maxQuantity = parseInt(counter.dataset.maxQuantity) || 999;

      if (currentQuantity < maxQuantity) {
        updateCartQuantity(cartId, currentQuantity + 1);
      } else {
        // Показываем уведомление о том, что достигнут лимит
        showNotification('Достигнуто максимальное доступное количество товара на складе', 'warning');
      }
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

  // Обработчик для закрытия модального окна корзины
  const cartModal = document.getElementById('cart');
  if (cartModal) {
    const closeButtons = cartModal.querySelectorAll('.js--close');
    closeButtons.forEach(button => {
      button.addEventListener('click', function () {
        // Если мы на странице checkout, обновляем её
        if (window.location.pathname.includes('/checkout/')) {
          setTimeout(() => {
            updateCheckoutPage();
          }, 300); // Небольшая задержка для закрытия модального окна
        }
      });
    });

    // Обработчик для backdrop (фона модального окна)
    const backdrop = document.querySelector('.backdrop');
    if (backdrop) {
      backdrop.addEventListener('click', function () {
        // Если мы на странице checkout, обновляем её
        if (window.location.pathname.includes('/checkout/')) {
          setTimeout(() => {
            updateCheckoutPage();
          }, 300); // Небольшая задержка для закрытия модального окна
        }
      });
    }

    // Обработчик для клавиши Escape
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        const cartModal = document.getElementById('cart');
        if (cartModal && (cartModal.style.display === 'block' || cartModal.style.display === 'flex')) {
          // Если мы на странице checkout, обновляем её
          if (window.location.pathname.includes('/checkout/')) {
            setTimeout(() => {
              updateCheckoutPage();
            }, 300); // Небольшая задержка для закрытия модального окна
          }
        }
      }
    });
  }
}

// Обработчик для кнопок "В корзину"
async function initAddToCartButtons() {
  // Инициализируем состояние кнопки при загрузке
  await updateAddToCartButtonState();

  // Обработчики для выбора цвета
  document.addEventListener('change', async function (e) {
    if (e.target.name === 'color') {
      const addToCartButton = document.querySelector('.pageprod__buy-cart');
      if (addToCartButton) {
        addToCartButton.dataset.selectedColor = e.target.value;
        await updateAddToCartButtonState();
      }
    }
  });

  // Обработчики для выбора размера
  document.addEventListener('change', async function (e) {
    if (e.target.name === 'size') {
      await updateAddToCartButtonState();
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
        } else {
        }
      } else {
      }

      addToCart(itemIdToAdd);
    }
  });
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', async function () {
  await initAddToCartButtons();
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
  $('#profile-form').on('submit', function (e) {
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
window.updateCheckoutPage = updateCheckoutPage;

// Функция для обновления страницы checkout
async function updateCheckoutPage() {
  try {
    // Обновляем информацию о товарах в корзине
    const response = await fetch('/ajax/get_checkout_info.php', {
      method: 'GET'
    });

    const result = await response.json();

    if (result.success) {
      // Обновляем список товаров
      const cartItemsList = document.querySelector('.order-aside__cart ul');
      if (cartItemsList && result.cartItems) {
        cartItemsList.innerHTML = result.cartItems;

        // Если корзина пуста, скрываем кнопку "Изменить корзину"
        const changeCartButton = document.querySelector('.order-aside__cart .js--modal');
        if (changeCartButton) {
          if (result.cartItems.includes('cart-empty-message')) {
            changeCartButton.style.display = 'none';

            // Если корзина пуста, можно показать сообщение или перенаправить
            // Пока просто скрываем кнопку
          } else {
            changeCartButton.style.display = 'block';
          }
        }
      }

      // Обновляем итоговую информацию
      if (result.totalInfo) {
        // Обновляем количество товаров
        const totalQuantityElement = document.querySelector('.order-aside__table tbody tr:first-child td:first-child');
        if (totalQuantityElement) {
          totalQuantityElement.textContent = result.totalInfo.totalQuantityText + ':';
        }

        // Обновляем общую сумму
        const totalPriceElement = document.querySelector('.order-aside__table tbody tr:first-child td:last-child');
        if (totalPriceElement) {
          totalPriceElement.textContent = result.totalInfo.priceWithoutDiscount + ' ₽';
        }


        // Обновляем скидку
        const discountElement = document.querySelector('.order-aside__table tbody tr:nth-child(4) td:last-child');
        if (discountElement) {
          discountElement.textContent = '-' + result.totalInfo.discount + ' ₽';
        }

        // Обновляем итоговую сумму
        const finalPriceElement = document.querySelector('.order-aside__table tbody tr:nth-child(6) td:last-child');
        if (finalPriceElement) {
          finalPriceElement.textContent = result.totalInfo.finalPrice + ' ₽';
        }

        // Обновляем кэшбэк
        const cashbackElement = document.querySelector('.order-aside__table tfoot tr td:last-child');
        if (cashbackElement) {
          cashbackElement.textContent = result.totalInfo.cashback + ' ₽';
        }

        // Если корзина пуста, обновляем все значения на 0
        if (result.totalInfo.totalQuantity === 0) {
          if (totalPriceElement) totalPriceElement.textContent = '0 ₽';
          if (discountElement) discountElement.textContent = '-0 ₽';
          if (finalPriceElement) finalPriceElement.textContent = '500 ₽'; // Только доставка
          if (cashbackElement) cashbackElement.textContent = '35 ₽'; // 7% от 500
        }
      }
    }
  } catch (error) {
    console.error('Error updating checkout page:', error);
  }
}

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

  if ($('._order').length) {
    let added = false;

    const getDeliveryItem = (name) => {
      return $('#bx-soa-delivery .order-methods [data-delivery-name="' + name + '"]');
    }

    const getPaymentItem = (name) => {
      return $('#bx-soa-paysystem .order-methods [data-payment-name="' + name + '"]');
    }

    setInterval(function () {
      if ($('#loading_screen').length && $('#loading_screen').attr('style') !== 'display: none;') return;

      const e1 = $('div[data-property-id-row="25"] input.bx-ui-sls-fake').val();
      const e2 = $('div[data-property-id-row="25"] input.bx-ui-sls-route').val();

      if (window.IMask) {
        const inp = $('input[name="ORDER_PROP_22"]');
        if (inp) {
          IMask(inp[0], maskOptions);
        }
      }

      if (!added) {
        $('#_styles').remove();
        $('#bx-soa-delivery .order-methods').before(
          `<div class="order-alert order-alert--area" style="display: none;">
            <p><span>Для отображения опций доставки выберите город</span></p>
          </div>`
        );
        added = true;
      }

      if (e1 && e2) {
        const isMoscow = e1 === 'Москва' && e2 === 'Москва, Россия';

        $('#bx-soa-delivery .order-methods + div').show();
        $('#bx-soa-delivery .order-methods').show();
        $('.order-alert--area').hide();
        const selectedDeliveryMethod = $('#bx-soa-delivery .order-methods__row .order-methods__item.bx-selected h2').text();
        console.log('selectedDeliveryMethod', selectedDeliveryMethod);

        if (!isMoscow) {
          getDeliveryItem('Самовывоз из шоурума').hide();
          getDeliveryItem('Курьер').hide();
        } else {
          getDeliveryItem('Самовывоз из шоурума').show();
          getDeliveryItem('Курьер').show();
        }

        if (selectedDeliveryMethod === 'Пункт выдачи СДЭК') {
          $('#hehe1').show();
        } else {
          $('#hehe1').hide();
        }

        if (
          selectedDeliveryMethod === 'Курьер СДЭК' ||
          selectedDeliveryMethod === 'Пункт выдачи СДЭК' ||
          selectedDeliveryMethod === 'Самовывоз из шоурума' ||
          selectedDeliveryMethod === 'Пункт выдачи заказов Почта России'
        ) {
          getPaymentItem('Банковской картой при получении').hide();
          getPaymentItem('Наличными при получении').hide();
        } else {
          getPaymentItem('Банковской картой при получении').show();
          getPaymentItem('Наличными при получении').show();
        }

        if (selectedDeliveryMethod === 'Курьер СДЭК' || selectedDeliveryMethod === 'Курьер') {
          $('#_order-address').show();
        } else {
          $('#_order-address').hide();
        }

        if (selectedDeliveryMethod === 'Пункт выдачи заказов Почта России') {
          $('._order #bx-soa-delivery .bx-soa-pp-desc-container').show();
        } else {
          $('._order #bx-soa-delivery .bx-soa-pp-desc-container').hide();
        }

        if (selectedDeliveryMethod === 'Самовывоз из шоурума') {
          $('input[name="ORDER_PROP_26"]').val('Шоурум ívolga, ул. Яузская, 5. Бизнес-центр "Яузская, 5"');
        }
      } else {
        $('#bx-soa-delivery .order-methods').hide();
        $('#bx-soa-delivery .order-methods + div').hide();
        $('.order-alert--area').show();
        $('#bx-soa-pickup').hide();
        $('#hehe1').hide();
        $('#_order-address').hide();
      }
    }, 100);
  }

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
    const city = $(this).data('city');
    const comment = $(this).data('comment');
    $('#editadress-title').text('Редактировать адрес');
    $('#editadress-submit').text('Редактировать');
    $('#editadress').data('id', id);
    $('#editadress input#city').val(city);
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
    const city = $('#editadress input#city').val();
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
          comment: comment,
          city
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
    $('html').removeClass('locked');
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

// ====== МОБИЛЬНОЕ МЕНЮ ======
$(document).ready(function () {
  // Функция для закрытия мобильного меню
  function closeMobileMenu() {
    const $body = $('body');
    const $mobileNav = $('.mobile-header__nav');
    const $burgerBtn = $('.header__menu-burger');

    $mobileNav.removeClass('active');
    $body.removeClass('modal-open');
    $burgerBtn.removeClass('active');
  }

  // Обработчик для кнопки мобильного меню
  $(document).on('click', '.header__menu-burger', function (e) {
    e.preventDefault();
    e.stopPropagation();

    const $body = $('body');
    const $mobileNav = $('.mobile-header__nav');

    if ($mobileNav.length) {
      if ($mobileNav.hasClass('active')) {
        // Закрываем меню
        closeMobileMenu();
      } else {
        // Открываем меню
        $mobileNav.addClass('active');
        $body.addClass('modal-open');
        $(this).addClass('active');
      }
    }
  });

  // Обработчик для кнопки закрытия мобильного меню
  $(document).on('click', '.mobile-header__close', function (e) {
    e.preventDefault();
    e.stopPropagation();
    closeMobileMenu();
  });

  // Закрытие мобильного меню по клику на оверлей
  $(document).on('click', '.mobile-header__nav', function (e) {
    if (e.target === this) {
      closeMobileMenu();
    }
  });

  // Закрытие мобильного меню по клику на ссылки
  $(document).on('click', '.mobile-header__nav .nav-link', function () {
    closeMobileMenu();
  });

  // Закрытие мобильного меню по нажатию Escape
  $(document).on('keydown', function (e) {
    if (e.key === 'Escape' && $('.mobile-header__nav').hasClass('active')) {
      closeMobileMenu();
    }
  });
});

// Функция для показа уведомлений
const showNotification = (message, type = 'info') => {
  // Создаем элемент уведомления
  const $notification = $(`
    <div class="notification notification--${type}" style="
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 15px 20px;
      background: ${type === 'success' ? '#4caf50' : type === 'error' ? '#f44336' : '#2196f3'};
      color: white;
      border-radius: 5px;
      z-index: 10000;
      max-width: 300px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    ">
      ${message}
    </div>
  `);

  // Добавляем на страницу
  $('body').append($notification);

  // Убираем через 3 секунды
  setTimeout(function () {
    $notification.fadeOut(300, function () {
      $(this).remove();
    });
  }, 3000);
}
window.showNotification = showNotification;

const fillAddressForm = (addressData) => {
  const $citySelect = $('select').filter(function () {
    return $(this).find('option[value="' + addressData.CITY + '"]').length > 0;
  });
  if ($citySelect.length) {
    $citySelect.val(addressData.CITY);
  }

  $('input[placeholder="Улица"]').val(addressData.ADDRESS);
  $('input[placeholder="Дом"]').val(addressData.HOUSE);
  $('input[placeholder="Квартира"]').val(addressData.APARTMENT);
  $('input[placeholder="Подъезд"]').val(addressData.ENTRANCE);
  $('input[placeholder="Этаж"]').val(addressData.FLOOR);

  // Если есть комментарий, добавляем его в поле комментария к заказу
  if (addressData.COMMENT) {
    $('textarea[placeholder="Комментарий к заказу"]').val(addressData.COMMENT);
  }

  // Обновляем название адреса если есть поле для него
  const $addressNameField = $('input[placeholder="Название адреса"]');
  if ($addressNameField.length) {
    $addressNameField.val(addressData.NAME);
  }
}

window.fillAddressForm = fillAddressForm;

// Функция для обновления информации о доставке
function updateDeliveryInfo(deliveryInfo) {
  // Обновляем цену доставки в форме
  const $deliveryPriceElement = $('.order-controls__preprice');
  if ($deliveryPriceElement.length && deliveryInfo.methods) {
    const selectedMethod = $('input[name="method-delivery"]:checked');
    if (selectedMethod.length) {
      const methodValue = selectedMethod.val();
      const methodData = deliveryInfo.methods[methodValue];
      if (methodData) {
        const price = methodData.price > 0 ? methodData.price_formatted : 'Бесплатно';
        $deliveryPriceElement.text('Цена доставки: ' + price);
      }
    }
  }
}

// Функция для обновления видимости блоков доставки
function updateDeliveryVisibility() {
  const $citySelect = $('select').filter(function () {
    return $(this).find('option[value="0"]').length > 0;
  });

  const selectedCity = $citySelect.val();
  const selectedDeliveryMethod = $('input[name="method-delivery"]:checked').val();
  const selectedDeliveryMethodText = $('input[name="method-delivery"]:checked').closest('label').find('h2').text().trim();

  // Сохраняем предыдущий метод доставки для сравнения
  const previousMethod = $citySelect.data('previous-delivery-method');

  // Если город не выбран, сбрасываем все формы и скрываем все блоки
  if (selectedCity === '0') {
    // Сбрасываем форму адреса только если она была заполнена
    if (previousMethod && previousMethod !== '0') {
      resetAddressForm();

      // Сбрасываем выбор метода доставки
      $('input[name="method-delivery"]').prop('checked', false);
    }
  }

  // 1. Блок "Для отображения опций доставки выберите город"
  const $cityAlert = $('.order-alert--area');
  if ($cityAlert.length) {
    if (selectedCity === '0') {
      $cityAlert.removeClass('hidden');
    } else {
      $cityAlert.addClass('hidden');
    }
  }

  // 2. Блок с методами доставки
  const $orderMethods = $('.order-methods');
  if ($orderMethods.length) {
    if (selectedCity === '0') {
      $orderMethods.addClass('hidden');
    } else {
      $orderMethods.removeClass('hidden');

      // Показываем основную сетку методов доставки
      $orderMethods.find('.order-methods__row').removeClass('hidden');
    }
  }

  // 3. Блок "Адрес шоурума" - показываем только для самовывоза
  const $showroomCard = $('.order-methods__card').filter(function () {
    return $(this).find('h2').text().includes('Адрес шоурума');
  });
  if ($showroomCard.length) {
    if (selectedDeliveryMethod === 'pickup') {
      $showroomCard.removeClass('hidden');
    } else {
      $showroomCard.addClass('hidden');
    }
  }

  // 4. Блоки СДЭК - показываем только для метода СДЭК
  const $cdekButton = $('.order-methods__button[data-modal="modal-pickup"]');
  const $cdekCard = $('.order-methods__card').filter(function () {
    return $(this).find('table tbody tr:first-child td:first-child').text().includes('СДЭК');
  });

  if ($cdekButton.length && $cdekCard.length) {
    if (selectedDeliveryMethod === 'cdek') {
      $cdekButton.removeClass('hidden');
      $cdekCard.removeClass('hidden');
    } else {
      $cdekButton.addClass('hidden');
      $cdekCard.addClass('hidden');
    }
  }

  // 5. Блоки адреса и формы - показываем только для курьера
  const $addressAlert = $('.order-alert--action').filter(function () {
    return $(this).find('span').text().includes('выбрать из использовавшихся адресов');
  });
  const $orderControls = $('.order-controls--address');
  const $orderSaving = $('.order-saving');

  // Всегда скрываем блоки адреса по умолчанию
  if ($addressAlert.length) {
    $addressAlert.addClass('hidden');
  }
  if ($orderControls.length) {
    $orderControls.addClass('hidden');
  }
  if ($orderSaving.length) {
    $orderSaving.addClass('hidden');
  }

  // Показываем блоки адреса только для курьера
  if (selectedDeliveryMethod === 'courier' && selectedCity !== '0') {
    if ($addressAlert.length) {
      $addressAlert.removeClass('hidden');
    }
    if ($orderControls.length) {
      $orderControls.removeClass('hidden');
    }
    if ($orderSaving.length) {
      $orderSaving.removeClass('hidden');
    }
  } else {
    // Если метод доставки изменился и предыдущий был курьером, сбрасываем форму адреса
    if (previousMethod && previousMethod !== selectedDeliveryMethod && previousMethod === 'courier') {
      resetAddressForm();
    }
  }

  // Сохраняем текущий метод доставки для следующего сравнения
  $citySelect.data('previous-delivery-method', selectedDeliveryMethod);
}

// Функция для сброса формы адреса
function resetAddressForm() {
  // Сбрасываем поля формы адреса
  $('input[placeholder="Улица"]').val('');
  $('input[placeholder="Дом"]').val('');
  $('input[placeholder="Квартира"]').val('');
  $('input[placeholder="Подъезд"]').val('');
  $('input[placeholder="Этаж"]').val('');
  $('textarea[placeholder="Комментарий к заказу"]').val('');

  // Сбрасываем название адреса если есть
  const $addressNameField = $('input[placeholder="Название адреса"]');
  if ($addressNameField.length) {
    $addressNameField.val('');
  }

  // Сбрасываем чекбокс "Запомнить адрес"
  const $rememberAddressCheckbox = $('.order-saving input[type="checkbox"]');
  if ($rememberAddressCheckbox.length) {
    $rememberAddressCheckbox.prop('checked', false);
  }
}

// Функция для валидации формы заказа
function validateCheckoutForm() {
  const $citySelect = $('select').filter(function () {
    return $(this).find('option[value="0"]').length > 0;
  });

  const selectedCity = $citySelect.val();
  const selectedDeliveryMethod = $('input[name="method-delivery"]:checked').closest('label').find('h2').text().trim();

  // Проверяем выбор города
  if (selectedCity === '0') {
    showNotification('Пожалуйста, выберите город доставки', 'error');
    return false;
  }

  // Проверяем выбор метода доставки
  if (!selectedDeliveryMethod) {
    showNotification('Пожалуйста, выберите метод доставки', 'error');
    return false;
  }

  // Если выбран курьер, проверяем обязательные поля адреса
  if (selectedDeliveryMethod === 'Курьер') {
    const street = $('input[placeholder="Улица"]').val().trim();
    const house = $('input[placeholder="Дом"]').val().trim();

    if (!street) {
      showNotification('Пожалуйста, укажите улицу', 'error');
      return false;
    }

    if (!house) {
      showNotification('Пожалуйста, укажите номер дома', 'error');
      return false;
    }
  }

  // Проверяем обязательные поля получателя
  const firstname = $('#checkout-firstname').val().trim();
  const lastname = $('#checkout-lastname').val().trim();
  const email = $('#checkout-email').val().trim();
  const phone = $('#checkout-phone').val().trim();

  if (!firstname) {
    showNotification('Пожалуйста, укажите имя', 'error');
    return false;
  }

  if (!lastname) {
    showNotification('Пожалуйста, укажите фамилию', 'error');
    return false;
  }

  if (!email) {
    showNotification('Пожалуйста, укажите email', 'error');
    return false;
  }

  if (!phone) {
    showNotification('Пожалуйста, укажите телефон', 'error');
    return false;
  }

  return true;
}

// Обработчик отправки формы заказа
$(document).on('submit', 'form[name="ORDER_FORM"]', function (e) {
  // Проверяем, находимся ли мы на странице checkout
  if (window.location.pathname.includes('/checkout/')) {
    if (!validateCheckoutForm()) {
      e.preventDefault();
      return false;
    }
  }
});

