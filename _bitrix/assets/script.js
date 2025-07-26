$('document').ready(function () {
  // выбор размера
  $('.product-config__size-list a.product-config__size-button').click(function () {
    $('.product-config__size-list a.product-config__size-button').removeClass('active');
    $(this).addClass('active');
    const price = $(this).data('price');
    $('#price-block').html(price);
    const id = $(this).data('id');
    $('.product-config__container [data-product]').attr('data-product', id);
    $('.product-config__container [data-id]').attr('data-id', id);
  });


  // выбор адреса
  $('#addr').change(function () {
    const addr_id = $(this).val();
    $.postJSON('/ajax/sale.php', {command: 'get_addr', addr_id}, function (res_data) {
      $('#address').val(res_data.addr)
      $('#comment').val(res_data.comment)
    })
  });

  // соаздание заказа
  $('#order_create').click(function () {
    var _this = $(this)
    //if(_this.hasClass('order-busy')) return false;
    _this.addClass('order-busy')
    _this.html('<img src="/assets/img/ajax-loader.gif" height="30" />');

    var data = {};
    data.delivery_id = $('.delivery-button.active').data('id');
    data.form = $('#checkout-form').serialize();
    data.payment_id = $('[name="radio-name"]:checked').val();
    data.address = $('#address_delivery_form').serialize();
    data.agreement = $('#personal-agreement').is(':checked');
    data.cdek = $('#cdek').text();

    $.postJSON('/ajax/order.php', {data}, function (res) {
      if (res.error) {
        _this.removeClass('order-busy')
        _this.html('Подтвердить заказ')
        $('#error-container').show().html(res.error_text)
      } else {
        $('#error-container').hide().html('')
      }
      if (res.ret_url) {
        location.href = res.ret_url;
      }
    })

    return false;
  });

  $('.delivery-button').click(function () {
    updatecart();
  });

  //Избранное
  $(document).on('click', '.favorite', function (e) {
    var element = $(this);
    var id = $(element).attr('data-id');
    $.getJSON("/ajax/ajax.php?command=like&id=" + id,
      function (data) {
        if (data.result == 'on') {
          $(element).addClass('checked');
        }
        if (data.result == 'off') {
          $(element).removeClass('checked');
        }
      }
    );

    return false;
  })

  $('#form--send--sms button.primary-button').prop('disabled', false);
  $('.profile-modal__step--3 .back-button').click(function () {
    $('.profile-modal__step--1').addClass('hide')
    $('.profile-modal__step--2').removeClass('hide')
    $('.profile-modal__step--3').addClass('hide')
    return false;
  });

  $('#form--send--sms').submit(function () {
    var _this = $(this);
    _this.find('[type=submit]').prop('disabled', true)
    $('#verificationCode').val('');
    $.post('/ajax/auth.php', _this.serialize(), function (output) {
      _this.find('[type=submit]').prop('disabled', false)
      $('.profile-modal__step--1').addClass('hide')
      $('.profile-modal__step--2').addClass('hide')
      $('.profile-modal__step--3').removeClass('hide')
      $('#verifed--phone').val(output.phone)
    }, 'json');
    return false;
  })

  $('#form--verify--sms').submit(function () {
    var _this = $(this);
    _this.find('[type=submit]').prop('disabled', true)
    $.post('/ajax/check.php', _this.serialize(), function (output) {
      _this.find('[type=submit]').prop('disabled', false)
      if (output.status == 'error') {
        $('#check--error').html(output.message);
        $('#verificationCode').val('')
      }
      if (output.status == 'success') {
        location.reload()
      }
    }, 'json');
    return false;
  })

  $('.auth-modal-buttons .primary-button-active').click(function () {
    $('.profile-modal__step--1').addClass('hide')
    $('.profile-modal__step--2').removeClass('hide')
  })
  $('#get--code--repeat').click(function () {
    $('.profile-modal__step--1').addClass('hide')
    $('.profile-modal__step--2').removeClass('hide')
    $('.profile-modal__step--3').addClass('hide')
  })

  // добавить в корзину
  $('.to-cart').click(function () {
    if ($(this).hasClass('processing')) return false
    $(this).addClass('processing')
    const product_id = $(this).attr('data-product')
    const _this = $(this)
    $(this).html('...')
    $.postJSON('/ajax/sale.php', {command: 'add_to_cart', item_id: product_id}, function (res_data) {
      $(_this).removeClass('processing')
      $(_this).html('Купить')
      opencart()
    })

    return false;
  })
})
$.postJSON = function (url, data, func) {
  $.post(url, data, func, 'json');
}
const opencart = () => {
  $('body').addClass('modal-open');
  $('.modal-right.basket-modal').addClass('active');
  updatecart();
  return false;
}
const closecart = () => {
  $('body').removeClass('modal-open');
  $('.modal-right.basket-modal').removeClass('active');
  return false;
}
const updatecart = () => {
  // обновляем корзину в модалке, либо на страничке
  if ($('#checkout-order-container').length) {
    $('#checkout-order-container').addClass('loading');
    $('#checkout-order-container').css('opacity', 0.5)

    // получаем ID доставки
    const delivery_id = $('.delivery-button.active').data('id');

    $('.cart-block').hide();
    if (delivery_id == 2 || delivery_id == 194 || delivery_id == 195) {
      $('#address_delivery').css('display', 'flex');
    }
    if (delivery_id == 193) {
      $('.pickup-shipping').css('display', 'flex');
    }


    $.postJSON('/ajax/sale.php', {command: 'get_cart', format: 'checkout', delivery_id}, function (res_data) {
      $('#checkout-order-container').html(res_data.body);
      $('#checkout-order-container').removeClass('loading');
      $('#checkout-order-container').css('opacity', 1)
    })
  } else {
    $('#basket-js__content').addClass('loading');
    $('#basket-js__content').css('opacity', 0.5)
    $.postJSON('/ajax/sale.php', {command: 'get_cart', format: 'modal'}, function (res_data) {
      $('#basket-js__content').html(res_data.body);
      $('#basket-js__content').removeClass('loading');
      $('#basket-js__content').css('opacity', 1)
    })
  }
}
const del_cart = (cart_id) => {
  if ($('.order-busy').length) return false;

  $.postJSON('/ajax/sale.php', {command: 'del', id: cart_id}, function (res_data) {
    updatecart()
  })
}
const del_addr = (id) => {
  $.postJSON('/ajax/sale.php', {command: 'del_addr', id: id}, function (res_data) {
    $('#addr' + id).css('opacity', '0.5');
    if (res_data.result == 'ok') {
      $('#addr' + id).remove();
    }
  })
  return false;
}
const plus_cart = (id) => {
  if ($('.order-busy').length) return false;

  $.postJSON('/ajax/sale.php', {command: 'plus_cart', id: id}, function (res_data) {
    updatecart();
  })
}
const minus_cart = (id) => {
  if ($('.order-busy').length) return false;

  $.postJSON('/ajax/sale.php', {command: 'minus_cart', id: id}, function (res_data) {
    updatecart();
  })
}
const updatecartamount = (id, value) => {
  $.postJSON('/ajax/sale.php', {command: 'update_cart_amount', id, value}, function (res_data) {
    updatecart();
  })
}
$(window).load(function () {
  if (location.hash == '#modal-subscr-n') {
    $('body').addClass('modal-open');
    $('.modal-right.subscribe-modal').addClass('active');
  }
  if (location.hash == '#modal-subscr-y') {
    $('body').addClass('modal-open');
    $('.modal-right.subscribe-n-modal').addClass('active');
  }
})


if (window.matchMedia("(min-width: 760px)").matches) {
  $('.catalog-link').hover(function () {
      $('.catalog-underlist').addClass('active');
    },
    function () {

    });

  $('.catalog-underlist .modal-top-content').hover(function () {
      $('.catalog-underlist').addClass('active');
    },
    function () {
      $('.catalog-underlist').removeClass('active');
    });
} else {
  $('.catalog-link').click(function (evt) {
    evt.preventDefault();
    $('.second').addClass('active');
  })

  $('.nav-link-close').click(function (evt) {
    evt.preventDefault();
    $('.second').removeClass('active');
  })
}
