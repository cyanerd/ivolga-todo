$(document).ready(function() {

   // Добавляем класс loaded к модалкам
   $('.modal').addClass('loaded');

   // Функция изменения позиции order__aside
   function changeTopPositionOrderAside() {
      if ($('.order__aside').length) {
         $('.order__aside').css('top', $('.topblock').outerHeight() + 'px');
      }
   }

   // Инициализация позиции и обработчик ресайза
   changeTopPositionOrderAside();
   $(window).on('resize', changeTopPositionOrderAside);

   // Автовысота для textarea (делегированный обработчик)
   $(document).on('input', '.textarea', function(e) {
      e.preventDefault();
      const $textarea = $(this);
      const currentHeight = $textarea.outerHeight();
      $textarea.css('height', 'auto');
      $textarea.css('height', ($textarea[0].scrollHeight + 2) + 'px');
   });

   // Инициализация высоты для существующих textarea
   $('.textarea').each(function() {
      const $textarea = $(this);
      $textarea.css('height', ($textarea.prop('scrollHeight') + 2) + 'px');
   });

   // Offcanvas открытие (делегированный обработчик)
   $(document).on('click', '[data-offcanvas]', function() {
      $('html').addClass('locked');
      $('.offcanvas.show').removeClass('show');
      $('.modal.show').removeClass('show');
      $('.modal-backdrop').addClass('show');
      $($(this).data('offcanvas')).addClass('show');
   });

   // Закрытие offcanvas (делегированный обработчик)
   $(document).on('click', '[offcanvas-close]', function() {
      const addressData = $('.offcanvas__list').find('[type="radio"]:checked').attr('data-address');
      if (addressData) {
         window.fillAddressForm(JSON.parse(addressData));
         window.showNotification('Адрес выбран и заполнен в форме', 'success');
      }

      $('html').removeClass('locked');
      $('.offcanvas.show').removeClass('show');
      $('.modal.show').removeClass('show');
      $('.modal-backdrop').removeClass('show');
   });

   // Закрытие по клику на backdrop (делегированный обработчик)
   $(document).on('click', '.modal-backdrop', function() {
      $('html').removeClass('locked');
      $('.offcanvas.show').removeClass('show');
      $('.modal.show').removeClass('show');
      $('.modal-backdrop').removeClass('show');
   });

   // Modal открытие (делегированный обработчик)
   $(document).on('click', '[data-modal]', function() {
      if ($(this).data('modal') === 'cart') return;
      $('html').addClass('locked');
      $('.offcanvas.show').removeClass('show');
      $('.modal.show').removeClass('show');
      $('.modal-backdrop').addClass('show');
      $($(this).data('modal')).addClass('show');
   });

   // Закрытие modal (делегированный обработчик)
   $(document).on('click', '[modal-close]', function() {
      $('html').removeClass('locked');
      $('.offcanvas.show').removeClass('show');
      $('.modal.show').removeClass('show');
      $('.modal-backdrop').removeClass('show');
   });

   // Spoiler address (делегированный обработчик)
   $(document).on('click', '.spoiler-address__head', function() {
      $(this).closest('.spoiler-address').toggleClass('active');
   });

});
