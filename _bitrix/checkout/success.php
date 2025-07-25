<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказ оформлен");
?>

<main class="checkout-success">
    <div class="container">
        <div class="checkout-success__content">
            <div class="checkout-success__icon">
                <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="40" cy="40" r="40" fill="#4CAF50"/>
                    <path d="M25 40L35 50L55 30" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            
            <h1 class="checkout-success__title">
                Заказ успешно оформлен!
            </h1>
            
            <p class="checkout-success__text">
                Спасибо за ваш заказ. Мы получили ваше заявление и в ближайшее время свяжемся с вами для подтверждения.
            </p>
            
            <?php
            $orderId = $_GET['order_id'] ?? '';
            if ($orderId): ?>
                <div class="checkout-success__order-info">
                    <p><strong>Номер заказа:</strong> <?= htmlspecialchars($orderId) ?></p>
                </div>
            <?php endif; ?>
            
            <div class="checkout-success__actions">
                <a href="/" class="btn btn--primary">
                    Вернуться в магазин
                </a>
                <a href="/personal/" class="btn btn--secondary">
                    Личный кабинет
                </a>
            </div>
        </div>
    </div>
</main>

<style>
.checkout-success {
    padding: 60px 0;
    text-align: center;
}

.checkout-success__content {
    max-width: 600px;
    margin: 0 auto;
}

.checkout-success__icon {
    margin-bottom: 30px;
}

.checkout-success__title {
    font-size: 32px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #232229;
}

.checkout-success__text {
    font-size: 18px;
    line-height: 1.6;
    margin-bottom: 30px;
    color: #666;
}

.checkout-success__order-info {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
}

.checkout-success__order-info p {
    margin: 0;
    font-size: 16px;
    color: #232229;
}

.checkout-success__actions {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    display: inline-block;
    padding: 12px 24px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn--primary {
    background: #232229;
    color: white;
}

.btn--primary:hover {
    background: #000;
}

.btn--secondary {
    background: transparent;
    color: #232229;
    border: 2px solid #232229;
}

.btn--secondary:hover {
    background: #232229;
    color: white;
}

@media (max-width: 768px) {
    .checkout-success {
        padding: 40px 20px;
    }
    
    .checkout-success__title {
        font-size: 24px;
    }
    
    .checkout-success__text {
        font-size: 16px;
    }
    
    .checkout-success__actions {
        flex-direction: column;
        align-items: center;
    }
}
</style>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?> 