<?php

use local\php_interface\MyTools;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Адреса доставки");
?>

<section class="infopage lk">
  <div class="infopage__wrap">
    <div class="container">
      <div class="infopage__row">
        <?php include __DIR__ . '/../menu.php'; ?>
        <div class="infopage__main">
          <h1 class="lk__title">
            Адреса
          </h1>
          <div class="lk-locations">
            <div class="lk-locations__list">
              <?php
              global $USER;
              CModule::IncludeModule('iblock');
              $addresses = [];
              if ($USER->IsAuthorized()) {
                $addresses = MyTools::getAddresses($USER->GetID());
              }
              if (!empty($addresses)):
                foreach ($addresses as $address): ?>
                  <div class="lk-locations__item" id="addr<?= $address['ID'] ?>">
                    <p class="lk-locations__item-txt">
                      <?= htmlspecialchars($address['NAME']) ?>
                    </p>
                    <div class="lk-locations__item-buttons">
                      <a class="lk-locations__item-edit js-edit-address"
                         href="#"
                         data-id="<?= $address['ID'] ?>"
                         data-name="<?= htmlspecialchars($address['NAME']) ?>"
                         data-address="<?= htmlspecialchars($address['ADDRESS']) ?>"
                         data-house="<?= htmlspecialchars($address['HOUSE']) ?>"
                         data-entrance="<?= htmlspecialchars($address['ENTRANCE']) ?>"
                         data-apartment="<?= htmlspecialchars($address['APARTMENT']) ?>"
                         data-floor="<?= htmlspecialchars($address['FLOOR']) ?>"
                         data-comment="<?= htmlspecialchars($address['COMMENT']) ?>"
                         title="Редактировать">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path
                            d="M18.5342 6.57227L7.81738 17.624H2.375V12.1885L13.457 1.10547L18.5342 6.57227ZM3.875 12.8096V16.124H7.18262L16.4658 6.5498L13.417 3.2666L3.875 12.8096Z"
                            fill="#232229" fill-opacity="0.5"/>
                          <path d="M15.5303 8.84375L14.4697 9.9043L10.0947 5.5293L11.1553 4.46875L15.5303 8.84375Z" fill="#232229"
                                fill-opacity="0.5"/>
                        </svg>
                      </a>
                      <button class="lk-locations__item-delete" onclick="del_addr(<?= $address['ID'] ?>)" title="Удалить">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M3.125 3.625H16.875V5.125H3.125V3.625Z" fill="#232229"
                                fill-opacity="0.5"/>
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M13.125 2.625H6.875V1.125H13.125V2.625Z" fill="#232229"
                                fill-opacity="0.5"/>
                          <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5.125 16.125V4.375H3.625V17.625H16.375V4.375H14.875V16.125H5.125Z" fill="#232229"
                                fill-opacity="0.5"/>
                        </svg>
                      </button>
                    </div>
                  </div>
                <?php endforeach;
              else: ?>
                <p>Пока здесь пусто</p>
              <?php endif; ?>
            </div>
            <a href="#" class="lk-locations__add">Добавить</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function del_addr(id) {
    if (confirm('Вы уверены, что хотите удалить этот адрес?')) {
      $.ajax({
        url: '/ajax/sale.php',
        type: 'POST',
        data: {
          command: 'del_addr',
          id: id
        },
        success: function (response) {
          var data = JSON.parse(response);
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
  }

  $(document).on('click', '.js-edit-address', function (e) {
    e.preventDefault();
    const id = $(this).data('id');
    const name = $(this).data('name');
    const address = $(this).data('address');
    const house = $(this).data('house');
    const entrance = $(this).data('entrance');
    const apartment = $(this).data('apartment');
    const floor = $(this).data('floor');
    const comment = $(this).data('comment');
    // Заполнение полей модалки
    $('#editadress input#street').val(address);
    $('#editadress input#home').val(house);
    $('#editadress input#podesz').val(entrance);
    $('#editadress input#room').val(apartment);
    $('#editadress input#floor').val(floor);
    $('#editadress input#comment').val(comment);
    $('#editadress').data('id', id); // для отправки формы
    // Меняем текст кнопки
    $('#editadress .lkmodal__form-submit').text('Редактировать').removeClass('js--modal').removeAttr('data-modal');
    // Открытие модалки
    $('#editadress').addClass('open');
    if ($('.backdrop').length) $('.backdrop').addClass('open');
    return false;
  });

  // Обработка нажатия на кнопку "Редактировать" в модалке
  $(document).on('click', '#editadress .lkmodal__form-submit', async function (e) {
    e.preventDefault();
    const id = $('#editadress').data('id');
    const address = $('#editadress input#street').val();
    const house = $('#editadress input#home').val();
    const entrance = $('#editadress input#podesz').val();
    const apartment = $('#editadress input#room').val();
    const floor = $('#editadress input#floor').val();
    const comment = $('#editadress input#comment').val();
    if (!id) return;
    try {
      const response = await $.ajax({
        url: '/ajax/sale.php',
        type: 'POST',
        data: {
          command: 'edit_addr',
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
      if (response.result === 'ok') {
        $('#editadress').removeClass('open');
        if ($('.backdrop').length) $('.backdrop').removeClass('open');
        // Меняем текст и действие кнопки в модалке подтверждения
        $('#editadress_ok .lkmodal__form-submit').text('Закрыть').off('click').on('click', function (e) {
          e.preventDefault();
          $('#editadress_ok').removeClass('open');
          if ($('.backdrop').length) $('.backdrop').removeClass('open');
        });
        $('#editadress_ok').addClass('open');
      } else {
        alert(response.message || 'Ошибка при редактировании адреса');
      }
    } catch (err) {
      alert('Ошибка соединения');
    }
  });
</script>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
