// Обработка оформления заказа
document.addEventListener('DOMContentLoaded', function() {
    const orderButton = document.getElementById('order_create');
    const errorContainer = document.getElementById('error-container');
    
    if (orderButton) {
        orderButton.addEventListener('click', async function(e) {
            e.preventDefault();
            
            // Показываем индикатор загрузки
            orderButton.disabled = true;
            orderButton.textContent = 'Создание заказа...';
            
            try {
                // Собираем данные формы
                const formData = new FormData();
                
                // Данные получателя
                formData.append('firstName', document.getElementById('firstName').value);
                formData.append('lastName', document.getElementById('lastName').value);
                formData.append('email', document.getElementById('email').value);
                formData.append('phone', document.getElementById('phone').value);
                
                // Адрес доставки
                formData.append('address', document.getElementById('address').value);
                formData.append('comment', document.getElementById('comment').value);
                
                // Способ доставки
                const activeDeliveryButton = document.querySelector('.delivery-button.active');
                if (activeDeliveryButton) {
                    formData.append('deliveryType', activeDeliveryButton.dataset.id);
                }
                
                // Способ оплаты
                const selectedPayment = document.querySelector('input[name="radio-name"]:checked');
                if (selectedPayment) {
                    formData.append('paymentType', selectedPayment.value);
                }
                
                // Согласие с условиями
                const agreement = document.getElementById('personal-agreement').checked;
                formData.append('agreement', agreement ? 'Y' : 'N');
                
                // Отправляем запрос
                const response = await fetch('/ajax/create_order.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Показываем успешное сообщение
                    showNotification(result.message, 'success');
                    
                    // Перенаправляем на страницу успеха
                    setTimeout(() => {
                        window.location.href = '/checkout/success.php?order_id=' + result.orderId;
                    }, 2000);
                } else {
                    // Показываем ошибку
                    showNotification(result.message, 'error');
                    errorContainer.innerHTML = '<p class="error">' + result.message + '</p>';
                }
                
            } catch (error) {
                console.error('Order creation error:', error);
                showNotification('Ошибка при создании заказа', 'error');
                errorContainer.innerHTML = '<p class="error">Ошибка при создании заказа</p>';
            } finally {
                // Восстанавливаем кнопку
                orderButton.disabled = false;
                orderButton.textContent = 'Подтвердить заказ';
            }
        });
    }
    
    // Обработка выбора способа доставки
    const deliveryButtons = document.querySelectorAll('.delivery-button');
    deliveryButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Убираем активный класс у всех кнопок
            deliveryButtons.forEach(btn => btn.classList.remove('active'));
            // Добавляем активный класс к выбранной кнопке
            this.classList.add('active');
        });
    });
    
    // Валидация формы
    function validateForm() {
        const requiredFields = ['firstName', 'lastName', 'email', 'phone', 'address'];
        let isValid = true;
        
        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field && !field.value.trim()) {
                field.classList.add('error');
                isValid = false;
            } else if (field) {
                field.classList.remove('error');
            }
        });
        
        // Проверяем согласие с условиями
        const agreement = document.getElementById('personal-agreement');
        if (agreement && !agreement.checked) {
            agreement.classList.add('error');
            isValid = false;
        } else if (agreement) {
            agreement.classList.remove('error');
        }
        
        return isValid;
    }
    
    // Добавляем валидацию при отправке
    if (orderButton) {
        orderButton.addEventListener('click', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                showNotification('Пожалуйста, заполните все обязательные поля', 'error');
                return false;
            }
        });
    }
});

// Функция для показа уведомлений
function showNotification(message, type = 'info') {
    // Создаем элемент уведомления
    const notification = document.createElement('div');
    notification.className = `notification notification--${type}`;
    notification.textContent = message;
    
    // Добавляем стили
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 5px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        max-width: 300px;
        word-wrap: break-word;
    `;
    
    // Цвета в зависимости от типа
    if (type === 'success') {
        notification.style.backgroundColor = '#4CAF50';
    } else if (type === 'error') {
        notification.style.backgroundColor = '#f44336';
    } else {
        notification.style.backgroundColor = '#2196F3';
    }
    
    // Добавляем на страницу
    document.body.appendChild(notification);
    
    // Удаляем через 5 секунд
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 5000);
} 