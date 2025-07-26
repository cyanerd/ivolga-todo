import Swiper from 'swiper/bundle';
import {Fancybox} from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox/fancybox.css";
import customSelect from 'custom-select';
import 'custom-select/src/css/custom-select.css'
// import styles bundle
import 'swiper/css/bundle';

import '../scss/main.scss';
import def from 'ajv/dist/vocabularies/discriminator';

Fancybox.bind("[data-fancybox]", {
  // Your custom options
});
document.addEventListener("DOMContentLoaded", () => {
  document.querySelector('body').style.paddingTop = document.querySelector('.topblock').offsetHeight + 'px'
});

const setOnCloseHandler = () => {
  const jsClose = document.querySelectorAll('.js--close')
  if (jsClose) {
    jsClose.forEach(el => {
      el.addEventListener('click', () => {
        if (document.querySelector('.catdrop')) {
          document.querySelector('.catdrop').classList.remove('open')
        }
        document.querySelector('.backdrop').classList.remove('open')
        document.querySelector('html').classList.remove('locked')
        if (document.querySelector('.mobsort')) {
          document.querySelector('.mobsort').classList.remove('open')
        }
        document.querySelector('.modalcart').classList.remove('open')
        document.querySelector('.modalguide').classList.remove('open')
        document.querySelector('#changepass').classList.remove('open')
        document.querySelector('#changepass_ok').classList.remove('open')
        document.querySelector('#resetpass').classList.remove('open')
        document.querySelector('#resetpass_code').classList.remove('open')
        document.querySelector('#resetpass_new').classList.remove('open')
        document.querySelector('#resetpass_ok').classList.remove('open')
        document.querySelector('#newadress').classList.remove('open')
        document.querySelector('#newadress_ok').classList.remove('open')
        document.querySelector('#logout-modal').classList.remove('open')
        document.querySelector('.lkmodal').classList.remove('open')

        document.querySelector('#editadress').classList.remove('open')
        document.querySelector('#editadress_ok').classList.remove('open')
        document.querySelector('#deleteadress').classList.remove('open')
        document.querySelector('#deleteadress_ok').classList.remove('open')

        document.querySelector('#cancel').classList.remove('open')
        document.querySelector('#cancel_ok').classList.remove('open')
        document.querySelector('.cartaler').classList.remove('open')

      })
    })
  }
}


const passFields = document.querySelectorAll('.inputel_pas--ico')

if (passFields) {
  passFields.forEach(el => {
    el.addEventListener('click', () => {
      if (el.closest('div').querySelector('input').getAttribute('type') == 'password') {
        el.closest('div').querySelector('input').setAttribute('type', 'text')
      } else {
        el.closest('div').querySelector('input').setAttribute('type', 'password')
      }
    })
  })
}

customSelect('select');
var swiper = new Swiper(".main-banner__swiper", {
  spaceBetween: 0,
  autoplay: {
    delay: 3500,
    disableOnInteraction: false,
  },
});

var newproducts = new Swiper(".new-products__swiper", {
  spaceBetween: 2,
  slidesPerView: 2,
  loop: true,
  pagination: {
    el: ".new-products__pag",
    clickable: true,
  },
  navigation: {
    nextEl: ".new-products__nav-next",
    prevEl: ".new-products__nav-prev",
  },
  breakpoints: {
    768: {
      spaceBetween: 2,
      slidesPerView: 4,
    },
  },
});


var product = new Swiper(".product-card__img-slider", {
  spaceBetween: 0,
  pagination: {
    el: ".product-card__image-pag",
    clickable: true,
  },
});


const prodAcc = document.querySelectorAll('.pageprod-accords__open')
if (prodAcc) {
  prodAcc.forEach(el => {
    const defHei = el.nextElementSibling.offsetHeight
    el.nextElementSibling.style.height = 0
    el.addEventListener('click', () => {
      if (el.classList.contains('open')) {
        el.classList.remove('open')
        el.nextElementSibling.style.height = 0
      } else {
        el.classList.add('open')
        el.nextElementSibling.style.height = defHei + 'px'
      }
    })
  })
}


const guideAccord = document.querySelectorAll('.modalguide-how__header')

if (guideAccord) {
  guideAccord.forEach(el => {
    const degHei = el.nextElementSibling.offsetHeight
    el.nextElementSibling.style.height = 0

    el.addEventListener('click', () => {
      if (el.classList.contains('open')) {
        el.classList.remove('open')
        el.nextElementSibling.style.height = 0
      } else {
        el.classList.add('open')
        el.nextElementSibling.style.height = degHei + 'px'
      }
    })
  })
}


var blog = new Swiper(".blog__swiper", {
  spaceBetween: 2,
  slidesPerView: 1,
  loop: true,
  pagination: {
    el: ".blog__pag",
    clickable: true,
  },
  navigation: {
    nextEl: ".blog__nav-next",
    prevEl: ".blog__nav-prev",
  },
  breakpoints: {
    768: {
      spaceBetween: 2,
      slidesPerView: 3,
    },
  },
});


const alertClose = document.querySelector('#alert-close')

if (alertClose) {
  alertClose.addEventListener('click', () => {
    alertClose.parentElement.style.display = 'none'
    document.querySelector('body').style.paddingTop = document.querySelector('.topblock').offsetHeight + 'px'
  })
}


const inputs = document.querySelectorAll('input');

// Функция для обработки изменения в input
function handleInputChange(event) {
  if (event.target.value.trim() !== '') {
    // Добавляем класс, если поле не пустое
    event.target.classList.add('input--full');
  } else {
    // Убираем класс, если поле пустое
    event.target.classList.remove('input--full');
  }
}

if (inputs) {
  inputs.forEach(input => {
    input.addEventListener('input', handleInputChange);
  });
}

const updateFilters = () => {
  const accordsFilter = document.querySelectorAll('.catdrop-block__open');
  if (accordsFilter.length > 0) {
    accordsFilter.forEach(el => {
      const defHei = el.nextElementSibling.offsetHeight;
      el.nextElementSibling.style.height = 0;

      el.addEventListener('click', () => {
        console.log(defHei); // Проверка высоты
        if (el.classList.contains('open')) {
          el.classList.remove('open');
          el.nextElementSibling.style.height = 0;
        } else {
          el.classList.add('open');
          el.nextElementSibling.style.height = defHei + 'px';
        }
      });
    });
  }
}

const initProductCardsSlider = () => {
  const productCards = document.querySelectorAll('.product-card');

  productCards.forEach(card => {
    const sliderTrack = card.querySelector('.product-card__slider-track');
    const slides = card.querySelectorAll('.product-card__slide');
    const dots = card.querySelectorAll('.product-card__pagination-dot');

    const updateActiveSlide = (index) => {
      slides.forEach((slide, i) => {
        slide.style.opacity = i === index ? '1' : '0';
        slide.style.pointerEvents = i === index ? 'auto' : 'none';
      });

      dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === index);
      });
    };

    sliderTrack.addEventListener('mousemove', (e) => {
      const rect = sliderTrack.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const width = rect.width;
      const third = width / 3;

      if (x < third) {
        updateActiveSlide(0);
      } else if (x < third * 2) {
        updateActiveSlide(1);
      } else {
        updateActiveSlide(2);
      }
    });

    sliderTrack.addEventListener('mouseleave', () => {
      updateActiveSlide(0);
    });

    const radios = document.querySelectorAll('input[name="color"]');
    const clearButton = document.querySelector('.prodpar__block-clear');

    radios.forEach(radio => {
      radio.addEventListener('change', () => {
        clearButton.classList.add('active');
      });
    });

    if (clearButton) {
      clearButton.addEventListener('click', () => {
        radios.forEach(radio => {
          radio.checked = false;
        });
        clearButton.classList.remove('active');
      });
    }
  });
}

document.addEventListener('DOMContentLoaded', () => {

  var thProd = new Swiper(".pageprod__gallery-thumbs", {
    spaceBetween: 10,
    slidesPerView: 6,
    watchSlidesProgress: true,
    breakpoints: {
      768: {
        slidesPerView: 4,
        direction: "vertical",
      },
    },
  });
  var prod = new Swiper(".pageprod__gallery-main", {
    spaceBetween: 10,
    thumbs: {
      swiper: thProd,
    },
  });

  initProductCardsSlider();
});

const initFilters = () => {
  console.log('initFilters');
  updateFilters();
  initProductCardsSlider();
  setOnCloseHandler();
  customSelect('select');

  const catdropBlocks = document.querySelectorAll('.catdrop-block');
  const togfilterElement = document.querySelector('.catalogpage__togfilter');
  const selectedFiltersContainer = document.createElement('div');
  selectedFiltersContainer.className = 'selected-filters';
  const header = document.querySelector('.catdrop__header');
  if (header) header.insertAdjacentElement('afterend', selectedFiltersContainer);

  // Создаем второй контейнер для дублирования фильтров
  const duplicateFiltersContainer = document.createElement('div');
  duplicateFiltersContainer.className = 'duplicate-selected-filters';
  const catalogHeadingLeft = document.querySelector('.catalogpage__heading-left');
  catalogHeadingLeft.appendChild(duplicateFiltersContainer);

  catdropBlocks.forEach(block => {
    const radios = block.querySelectorAll('input[type="radio"]');
    const checks = block.querySelectorAll('input[type="checkbox"]');

    radios.forEach(radio => {
      // Вызов при инициализации, если отмечен
      if (radio.checked) {
        updateSelectedFilters(radio.value, true);
      }
      radio.addEventListener('change', () => {
        updateSelectedFilters(radio.value, true);
        toggleHasChecked(block);
      });
    });

    checks.forEach(check => {
      // Вызов при инициализации, если отмечен
      if (check.checked) {
        updateSelectedFilters(check.value, false);
      }
      check.addEventListener('change', () => {
        updateSelectedFilters(check.value, false);
        toggleHasChecked(block);
      });
    });
  });

// Кнопка сброса
  const resetButton = document.querySelector('.catdrop__reset');
  resetButton.addEventListener('click', () => {
    catdropBlocks.forEach(block => {
      block.querySelectorAll('input[type="radio"]:checked, input[type="checkbox"]:checked').forEach(input => {
        input.checked = false;
      });
      block.classList.remove('has_checked');
    });
    selectedFiltersContainer.innerHTML = '';
    duplicateFiltersContainer.innerHTML = '';
    toggleSelectedFiltersVisibility(); // Это вызовет обновление класса current_filtered
  });

// Обновление выбранных фильтров
  function updateSelectedFilters(value, isRadio) {
    const existingFilter = Array.from(selectedFiltersContainer.children).find(child => child.textContent.includes(value));
    const existingDuplicateFilter = Array.from(duplicateFiltersContainer.children).find(child => child.textContent.includes(value));

    if (isRadio) {
      // Удаляем все предыдущие радио-кнопки
      selectedFiltersContainer.innerHTML = '';
      duplicateFiltersContainer.innerHTML = ''; // Очищаем дублирующий контейнер

      // Создаем новый элемент для радио-кнопки
      const filterDiv = createFilterDiv(value);
      selectedFiltersContainer.appendChild(filterDiv);
      duplicateFiltersContainer.appendChild(filterDiv.cloneNode(true)); // Клонируем для второго контейнера
    } else {
      // Обработка чекбоксов
      if (!existingFilter) {
        const newFilterValue = createFilterDiv(value);
        selectedFiltersContainer.appendChild(newFilterValue);
        duplicateFiltersContainer.appendChild(newFilterValue.cloneNode(true)); // Клонируем для второго контейнера
      } else {
        // Если чекбокс уже существует, удаляем его из обоих контейнеров
        selectedFiltersContainer.removeChild(existingFilter);
        duplicateFiltersContainer.removeChild(existingDuplicateFilter);
      }
    }
    toggleSelectedFiltersVisibility();
  }

// Создание элемента фильтра
  function createFilterDiv(value) {
    const filterDiv = document.createElement('div');
    filterDiv.innerHTML = `<span>${value}</span> <button class="remove-filter"><svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12 13.4998L8 8.16649M4 2.83316L8 8.16649M8 8.16649L12 2.83316M8 8.16649L4 13.4998" stroke="#232229" stroke-width="1.5"/>
</svg>
</button>`;

    // Добавляем обработчик клика для удаления фильтра
    filterDiv.querySelector('.remove-filter').addEventListener('click', () => {
      removeFilter(filterDiv, value);
    });

    return filterDiv;
  }

// Функция для удаления фильтра
  function removeFilter(filterDiv, value) {
    // Удаляем из основного контейнера
    const mainFilter = Array.from(selectedFiltersContainer.children).find(child => child.textContent.includes(value));
    if (mainFilter) selectedFiltersContainer.removeChild(mainFilter);

    // Удаляем из дублирующего контейнера
    const duplicateFilter = Array.from(duplicateFiltersContainer.children).find(child => child.textContent.includes(value));
    if (duplicateFilter) duplicateFiltersContainer.removeChild(duplicateFilter);

    // Находим ВСЕ соответствующие input элементы (радио и чекбоксы)
    const inputs = document.querySelectorAll(`input[type="radio"][value="${value}"], input[type="checkbox"][value="${value}"]`);

    inputs.forEach(input => {
      input.checked = false; // Снимаем выделение
      const block = input.closest('.catdrop-block');
      if (block) toggleHasChecked(block); // Обновляем состояние блока
    });

    const search = window.getCatalogParams();
    window.updateCatalogAjax(search);

    toggleSelectedFiltersVisibility();
  }


  [selectedFiltersContainer, duplicateFiltersContainer].forEach(container => {
    container.addEventListener('click', (event) => {
      if (event.target.classList.contains('remove-filter')) {
        const filterDiv = event.target.closest('div');
        const value = filterDiv.querySelector('span').textContent.trim();
        removeFilter(filterDiv, value);
      }
    });
  });


// Управление видимостью контейнера выбранных фильтров
  function toggleSelectedFiltersVisibility() {
    const hasFilters = selectedFiltersContainer.children.length > 0;

    // Управляем видимостью контейнеров
    selectedFiltersContainer.style.display = hasFilters ? 'flex' : 'none';
    duplicateFiltersContainer.style.display = hasFilters ? 'flex' : 'none';

    // Управляем классом current_filtered
    if (hasFilters) {
      togfilterElement.classList.add('current_filtered');
    } else {
      togfilterElement.classList.remove('current_filtered');
    }
  }

// Проверка наличия выбранных элементов
  function toggleHasChecked(block) {
    const hasChecked = block.querySelector('input[type="radio"]:checked, input[type="checkbox"]:checked');
    if (hasChecked) {
      block.classList.add('has_checked');
    } else {
      block.classList.remove('has_checked');
    }
  }

// Изначально скрываем контейнеры
  toggleSelectedFiltersVisibility();

// Добавляем обработчики кликов для элементов в дублирующем контейнере
  duplicateFiltersContainer.addEventListener('click', (event) => {
    if (event.target.classList.contains('remove-filter')) {
      const filterDiv = event.target.closest('div');
      const value = filterDiv.querySelector('span').textContent;
      removeFilter(filterDiv, value);
    }
  });


  const togFilters = document.querySelector('.catalogpage__togfilter')
  if (togFilters) {
    togFilters.addEventListener('click', () => {
      document.querySelector('.catdrop').classList.add('open')
      document.querySelector('.backdrop').classList.add('open')
      document.querySelector('html').classList.add('locked')

    })
  }


  const mobSort = document.querySelector('.catalogpage__mobsort')
  if (mobSort) {
    mobSort.addEventListener('click', () => {
      document.querySelector('.mobsort').classList.add('open')
      document.querySelector('html').classList.add('locked')
    })
  }
}

document.addEventListener("DOMContentLoaded", function () {
  initFilters();
});

window.initFilters = initFilters;


document.addEventListener('scroll', function () {
  const catalogPage = document.querySelector('.catalogpage');
  const heading = document.querySelector('.catalogpage__heading');

  if (catalogPage && heading) {
    const catalogPageOffset = catalogPage.offsetTop;
    const scrollPosition = window.scrollY;

    if (scrollPosition > catalogPageOffset + 100) {
      heading.classList.add('pined');
    } else {
      heading.classList.remove('pined');
    }
  }
});


document.addEventListener('DOMContentLoaded', function () {
  // Инициализация слайдера
  const slider = new Swiper('.collectionsinfo__gallery-slider', {
    slidesPerView: 1,
    navigation: {
      nextEl: '.collectionsinfo__gallery-next',
      prevEl: '.collectionsinfo__gallery-prev',
    },
    on: {
      init: function () {
        updateSliderCounter(this);
      },
      slideChange: function () {
        updateSliderCounter(this);
      }
    }
  });

  // Функция обновления счетчика слайдов
  function updateSliderCounter(swiper) {
    const current = document.querySelector('.collectionsinfo__gallery-counter .current');
    const total = document.querySelector('.collectionsinfo__gallery-counter .total');

    // Получаем реальный индекс слайда с учетом loop
    const realIndex = swiper.realIndex + 1;

    // Форматируем номер в двузначный формат (01, 02 и т.д.)
    current.textContent = String(realIndex).padStart(2, '0');

    // Общее количество слайдов (без учета клонированных в loop)
    total.textContent = String(swiper.slides.length - (swiper.loop ? swiper.loopedSlides * 2 : 0)).padStart(2, '0');
  }
});


const counterMinus = document.querySelectorAll('.counter__prev')

if (counterMinus) {
  counterMinus.forEach(el => {
    el.addEventListener('click', () => {
      let valInp = Number(el.closest('div').querySelector('input').value)
      if (valInp > 1) {
        valInp -= 1
      }
      el.closest('div').querySelector('input').value = valInp
    })
  })
}


const counterPlus = document.querySelectorAll('.counter__next')

if (counterPlus) {
  counterPlus.forEach(el => {
    el.addEventListener('click', () => {
      let valInp = Number(el.closest('div').querySelector('input').value)
      valInp += 1
      el.closest('div').querySelector('input').value = valInp
    })
  })
}


const openModals = document.querySelectorAll('.js--modal')

if (openModals) {
  openModals.forEach(el => {
    const dataQuery = '#' + el.getAttribute('data-modal')
    el.addEventListener('click', () => {
      document.querySelector(dataQuery).classList.add('open')
      document.querySelector('.backdrop').classList.add('open')
      document.querySelector('html').classList.add('locked')
    })
  })
}


