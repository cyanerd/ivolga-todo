# Интеграция сохраненных адресов через AJAX в sale.order.ajax

## Описание

Реализована интеграция функционала сохраненных адресов в стандартный компонент Битрикса `sale.order.ajax` через AJAX запросы. Пользователи могут выбирать из своих сохраненных адресов при оформлении заказа.

## Структура файлов

### Модифицированные файлы

1. **`local/templates/main/components/bitrix/sale.order.ajax/new/`** - Кастомный шаблон компонента
   - `template.php` - Основной шаблон
   - `script.js` - JavaScript с функционалом адресов
   - `order_ajax.js` - Основной JavaScript компонента
   - `style.css` - CSS стили

2. **`ajax/sale.php`** - AJAX обработчик
   - Добавлен обработчик `get_user_addresses`

3. **`checkout/index.php`** - Страница оформления заказа
   - Использует шаблон `new`

## Функционал

### 1. Загрузка адресов через AJAX

При инициализации компонента автоматически загружаются адреса пользователя:

```javascript
loadUserAddresses: function(callback) {
    var ctx = this;
    
    // Проверяем, авторизован ли пользователь
    if (!this.isUserAuthorized()) {
        if (callback) callback([]);
        return;
    }
    
    // Загружаем адреса через AJAX
    $.postJSON('/ajax/sale.php', {
        command: 'get_user_addresses'
    }, function(response) {
        if (response.success && response.addresses) {
            ctx.userAddresses = response.addresses;
            if (callback) callback(response.addresses);
        } else {
            ctx.userAddresses = [];
            if (callback) callback([]);
        }
    }).fail(function() {
        ctx.userAddresses = [];
        if (callback) callback([]);
    });
}
```

### 2. Создание селекта с адресами

После загрузки адресов создается выпадающий список:

```javascript
createAddressSelect: function(container, selectedAddressId) {
    var ctx = this;
    
    if (this.userAddresses.length === 0) {
        return;
    }
    
    // Создаем контейнер для селекта
    var selectContainer = BX.create('div', {
        props: {
            className: 'bx-soa-address-select-container'
        },
        style: {
            marginBottom: '15px'
        }
    });
    
    // Создаем label
    var label = BX.create('label', {
        props: {
            className: 'bx-soa-address-select-label'
        },
        text: 'Выбрать сохраненный адрес'
    });
    
    // Создаем селект
    var select = BX.create('select', {
        props: {
            className: 'bx-soa-address-select',
            id: 'saved-address-select'
        }
    });
    
    // Добавляем опцию по умолчанию
    var defaultOption = BX.create('option', {
        props: {
            value: ''
        },
        text: 'Выбрать адрес'
    });
    select.appendChild(defaultOption);
    
    // Добавляем адреса
    for (var i = 0; i < this.userAddresses.length; i++) {
        var address = this.userAddresses[i];
        var option = BX.create('option', {
            props: {
                value: address.ID
            },
            text: address.NAME
        });
        select.appendChild(option);
    }
    
    // Устанавливаем выбранное значение
    if (selectedAddressId) {
        select.value = selectedAddressId;
    }
    
    // Добавляем обработчик изменения
    BX.bind(select, 'change', function() {
        var addressId = this.value;
        if (addressId) {
            ctx.getAddressById(addressId, function(addressData) {
                if (addressData) {
                    // Заполняем поля адреса
                    var addressInput = BX('bx-soa-properties').querySelector('input[name*="ADDRESS"]');
                    var commentInput = BX('bx-soa-properties').querySelector('textarea[name*="COMMENT"]');
                    
                    if (addressInput) {
                        addressInput.value = addressData.addr || '';
                    }
                    if (commentInput) {
                        commentInput.value = addressData.comment || '';
                    }
                }
            });
        }
    });
    
    // Собираем элементы
    selectContainer.appendChild(label);
    selectContainer.appendChild(select);
    
    // Вставляем в контейнер
    container.appendChild(selectContainer);
}
```

### 3. Получение конкретного адреса

При выборе адреса из списка загружается его содержимое:

```javascript
getAddressById: function(addressId, callback) {
    if (!addressId) {
        if (callback) callback(null);
        return;
    }
    
    $.postJSON('/ajax/sale.php', {
        command: 'get_addr',
        addr_id: addressId
    }, function(response) {
        if (callback) callback(response);
    }).fail(function() {
        if (callback) callback(null);
    });
}
```

## AJAX обработчики

### 1. Получение адресов пользователя

**URL:** `/ajax/sale.php`  
**Метод:** POST  
**Параметры:**
- `command` = `get_user_addresses`

**Ответ:**
```json
{
    "success": true,
    "addresses": [
        {
            "ID": "123",
            "NAME": "Дом",
            "ADDRESS": "г. Москва, ул. Примерная, д. 1, кв. 1",
            "COMMENT": "Позвонить за час"
        }
    ]
}
```

### 2. Получение конкретного адреса

**URL:** `/ajax/sale.php`  
**Метод:** POST  
**Параметры:**
- `command` = `get_addr`
- `addr_id` = ID адреса

**Ответ:**
```json
{
    "addr": "г. Москва, ул. Примерная, д. 1, кв. 1",
    "comment": "Позвонить за час"
}
```

## CSS стили

Добавлены стили для селекта адресов:

```css
.bx-soa-address-select-container {
    margin-bottom: 20px;
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.bx-soa-address-select-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #232229;
    font-size: 14px;
}

.bx-soa-address-select {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 14px;
    background-color: #fff;
    transition: border-color 0.3s;
}

.bx-soa-address-select:focus {
    outline: none;
    border-color: #232229;
}
```

## Интеграция с компонентом

### 1. Инициализация

Функционал инициализируется в функции `bindEvents` компонента:

```javascript
bindEvents: function() {
    // ... существующий код ...
    
    // Инициализация функционала сохраненных адресов
    if (BX.saleOrderAjax && BX.saleOrderAjax.initAddressFunctionality) {
        BX.saleOrderAjax.initAddressFunctionality();
    }
}
```

### 2. Размещение в форме

Селект с адресами добавляется в начало блока свойств заказа (`bx-soa-properties`).

## Использование

### Для пользователей

1. **Авторизация** - пользователь должен быть авторизован
2. **Оформление заказа** - перейти к оформлению заказа
3. **Выбор адреса** - в блоке "Получатель" появится выпадающий список
4. **Автозаполнение** - при выборе адреса автоматически заполнятся поля

### Для разработчиков

1. **Проверка авторизации** - функционал работает только для авторизованных пользователей
2. **AJAX запросы** - используются существующие эндпоинты
3. **Интеграция** - не нарушает работу стандартного компонента

## Тестирование

### 1. Тестовый файл

Создан файл `test_address_ajax.php` для проверки функционала.

### 2. Консоль браузера

Для тестирования AJAX запросов:

```javascript
// Получение адресов пользователя
$.postJSON('/ajax/sale.php', {
    command: 'get_user_addresses'
}, function(response) {
    console.log(response);
});

// Получение конкретного адреса
$.postJSON('/ajax/sale.php', {
    command: 'get_addr',
    addr_id: 123
}, function(response) {
    console.log(response);
});
```

## Преимущества решения

1. **Неинвазивность** - не изменяет стандартный компонент
2. **AJAX загрузка** - адреса загружаются динамически
3. **Автозаполнение** - автоматическое заполнение полей
4. **Адаптивность** - работает на мобильных устройствах
5. **Безопасность** - проверка авторизации пользователя

## Расширение функционала

Возможные улучшения:

1. **Сохранение нового адреса** - добавление возможности сохранения адреса прямо в форме заказа
2. **Редактирование адресов** - возможность редактирования адресов
3. **Валидация** - проверка корректности адресов
4. **Геокодирование** - автоматическое определение координат
5. **Карта** - выбор адреса на карте

## Устранение неполадок

### 1. Адреса не загружаются

- Проверьте авторизацию пользователя
- Проверьте консоль браузера на ошибки AJAX
- Убедитесь, что функция `MyTools::getAddresses()` работает

### 2. Селект не появляется

- Проверьте, что у пользователя есть сохраненные адреса
- Проверьте консоль браузера на ошибки JavaScript
- Убедитесь, что CSS стили загружены

### 3. Поля не заполняются

- Проверьте правильность селекторов полей
- Убедитесь, что AJAX запрос возвращает корректные данные
- Проверьте консоль браузера на ошибки 