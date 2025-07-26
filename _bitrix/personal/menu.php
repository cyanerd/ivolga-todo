<div class="infopage__aside">
  <p class="infopage__aside-title">
    Личный кабинет
  </p>
  <ul class="infopage__aside-list">
    <li>
      <a href="/personal/" id="menu-profile-link">
        Профиль
      </a>
    </li>
    <li>
      <a href="/personal/orders/" id="menu-orders-link">
        История заказов
      </a>
    </li>
    <li>
      <a href="/personal/addresses/" id="menu-addresses-link">
        Адреса
      </a>
    </li>
    <li>
      <a id="logout-btn" class="logout-confirm" data-logout="true" href="/?logout=yes">
        Выйти
      </a>
    </li>
  </ul>
</div>
<script>
  // Подсвечиваем активный пункт меню
  (function () {
    const path = window.location.pathname;
    if (path === '/personal/' || path === '/personal/index.php') {
      document.getElementById('menu-profile-link').classList.add('active');
    } else if (path.startsWith('/personal/orders')) {
      document.getElementById('menu-orders-link').classList.add('active');
    } else if (path.startsWith('/personal/addresses')) {
      document.getElementById('menu-addresses-link').classList.add('active');
    }
  })();
</script>
