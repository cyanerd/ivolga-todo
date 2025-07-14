console.log('custom.js loaded');

// ===== ФУНКЦИИ ДЛЯ РАБОТЫ С ИЗБРАННЫМ =====

// Функция для получения избранных товаров из localStorage
function getFavouriteProducts() {
  const favourites = JSON.parse(localStorage.getItem('favourite_products') || '[]');
  return favourites;
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
      element.style.display = 'flex';
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

  document.addEventListener('click', function(e) {
    console.log('Click detected on:', e.target);
    console.log('Target classList:', e.target.classList);
    console.log('Target tagName:', e.target.tagName);

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

      console.log('Like button:', likeButton);
      console.log('Product card:', productCard);
      console.log('Product ID from button:', likeButton.dataset.productId);
      console.log('Product ID from card:', productCard ? productCard.dataset.productId : 'no card');
      console.log('Final Product ID:', productId);

      if (productId) {
        if (isFavourite(productId)) {
          console.log('Removing from favourite:', productId);
          removeFromFavourite(productId);
          showNotification('Товар удален из избранного', 'success');
        } else {
          console.log('Adding to favourite:', productId);
          addToFavourite(productId);
          showNotification('Товар добавлен в избранное', 'success');
        }
      } else {
        console.error('Product ID not found!');
        showNotification('Ошибка: не удалось определить товар', 'error');
      }
    }
  });

  window.favouriteButtonsInitialized = true;
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
  console.log('Initializing favourite functionality');
  initFavouriteButtons();
  updateFavouriteButtons();
  updateFavouriteCounter();
});

// Функция для показа уведомлений
function showNotification(message, type = 'info') {
  // Создаем элемент уведомления
  const notification = document.createElement('div');
  notification.className = `notification notification--${type}`;
  notification.innerHTML = `
    <div class="notification__content">
      <span class="notification__message">${message}</span>
      <button class="notification__close">&times;</button>
    </div>
  `;

  // Добавляем на страницу
  document.body.appendChild(notification);

  // Показываем уведомление
  setTimeout(() => {
    notification.style.transform = 'translateX(0)';
  }, 100);

  // Обработчик закрытия
  const closeBtn = notification.querySelector('.notification__close');
  closeBtn.addEventListener('click', () => {
    notification.style.transform = 'translateX(100%)';
    setTimeout(() => {
      if (document.body.contains(notification)) {
        document.body.removeChild(notification);
      }
    }, 300);
  });

  // Автоматически скрываем через 3 секунды
  setTimeout(() => {
    if (document.body.contains(notification)) {
      notification.style.transform = 'translateX(100%)';
      setTimeout(() => {
        if (document.body.contains(notification)) {
          document.body.removeChild(notification);
        }
      }, 300);
    }
  }, 3000);
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
      showNotification('Ошибка при добавлении товара', 'error');
    }
  } catch (error) {
    console.error('Error adding to cart:', error);
    showNotification('Ошибка при добавлении товара', 'error');
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
      showNotification('Товар удален из корзины', 'success');
      updateCartContent();
      updateCartCounter();
    }
  } catch (error) {
    console.error('Error removing from cart:', error);
    showNotification('Ошибка при удалении товара', 'error');
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
    button.addEventListener('click', function(e) {
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
    button.addEventListener('click', function(e) {
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
    button.addEventListener('click', function(e) {
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
  document.addEventListener('click', function(e) {
    const addToCartButton = e.target.closest('.pageprod__buy-cart');
    if (addToCartButton) {
      e.preventDefault();
      e.stopPropagation();

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
      console.log('Color check:', {
        hasColors,
        selectedColor,
        colorInputs: colorInputs.length,
        checkedColorInput: document.querySelector('input[name="color"]:checked')?.value,
        buttonSelectedColor: addToCartButton.dataset.selectedColor
      });
      if (hasColors && (!selectedColor || selectedColor === '')) {
        showNotification('Пожалуйста, выберите цвет', 'error');
        return;
      }

      // Проверяем выбор размера, если он требуется
      const selectedSize = document.querySelector('input[name="size"]:checked');
      console.log('Size check:', {
        hasSizes,
        selectedSize: selectedSize?.id,
        offerId,
        sizeInputs: sizeInputs.length
      });
      if (hasSizes && !selectedSize) {
        showNotification('Пожалуйста, выберите размер', 'error');
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
document.addEventListener('DOMContentLoaded', function() {
  console.log('Initializing cart functionality');
  initAddToCartButtons();
  updateCartCounter(); // Загружаем счетчик корзины при загрузке страницы

  // Загружаем содержимое корзины при открытии модального окна
  const cartModal = document.getElementById('cart');
  if (cartModal) {
    const observer = new MutationObserver(function(mutations) {
      mutations.forEach(function(mutation) {
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
});

// Делаем функции глобально доступными
window.addToFavourite = addToFavourite;
window.removeFromFavourite = removeFromFavourite;
window.isFavourite = isFavourite;
window.getFavouriteProducts = getFavouriteProducts;
window.updateFavouriteCounter = updateFavouriteCounter;
window.updateFavouriteButtons = updateFavouriteButtons;
window.showNotification = showNotification;
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
