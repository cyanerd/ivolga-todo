<div class="profile-menu">
    <h1 class="profile-menu__title title">Личный кабинет</h1>
    <ul class="profile-menu__links">
        <li><a class="profile-link<?if($arResult['CURRENT_PAGE'] == 'index'):?>-active<?endif?>" href="/personal/">Профиль</a></li>
        </li>
        <li>
        <li><a class="profile-link<?if($arResult['CURRENT_PAGE'] == 'wishlist'):?>-active<?endif?>" href="/personal/wishlist/">Вишлист</a></li>
        </li>
        <li>
        <li><a class="profile-link<?if($arResult['CURRENT_PAGE'] == 'orders'):?>-active<?endif?>" href="/personal/orders/">История заказов</a></li>
        </li>
        <li>
        <li><a class="profile-link<?if($arResult['CURRENT_PAGE'] == 'addresses'):?>-active<?endif?>" href="/personal/addresses/">Адресная книга</a></li>
        </li>
        <li>
        <li><a class="profile-link<?if($arResult['CURRENT_PAGE'] == 'settings'):?>-active<?endif?>" href="/personal/settings/">Настройки</a></li>
        </li>
    </ul>
</div>
