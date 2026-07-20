//custom select
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.dropdown').forEach(function (dropdownWrapper) {
        console.log(dropdownWrapper)

        const dropdownBtn = dropdownWrapper.querySelector('.dropdown__button');
        const dropdownList = dropdownWrapper.querySelector('.dropdown__list');
        const dropdownItems = dropdownList.querySelectorAll('.dropdown__list-item');
        const dropdownInput = dropdownWrapper.querySelector('.dropdown__input_hidden')

        dropdownBtn.addEventListener('click', function () {
            dropdownList.classList.toggle('dropdown__list_visible');
            this.classList.toggle('dropdown__button_active');
        });

        dropdownItems.forEach(function (listItem) {
            listItem.addEventListener('click', function (e) {
                dropdownItems.forEach(function (el) {
                    el.classList.remove('dropdown__list-item_active');
                })
                e.target.classList.add('dropdown__list-item_active');
                dropdownBtn.innerText = this.innerText;
                dropdownInput.value = this.dataset.value;
                dropdownList.classList.remove('dropdown__list_visible');
            })
        })

        document.addEventListener('click', function (e) {
            if (e.target !== dropdownBtn) {
                dropdownBtn.classList.remove('dropdown__button_active');
                dropdownList.classList.remove('dropdown__list_visible');
            }
        })

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Tab' || e.key === 'Escape') {
                dropdownBtn.classList.remove('dropdown__button_active');
                dropdownList.classList.remove('dropdown__list_visible');
            }
        })
    })
    document.querySelectorAll('.dropdown_with-chk').forEach(function (dropdownWrapper) {
        const dropdownBtn = dropdownWrapper.querySelector('.dropdown_with-chk__button');
        const dropdownList = dropdownWrapper.querySelector('.dropdown_with-chk__list');
        const dropdownItems = dropdownList.querySelectorAll('.dropdown_with-chk__list-item');

        dropdownBtn.addEventListener('click', function () {
            dropdownList.classList.toggle('dropdown_with-chk__list_visible');
            this.classList.toggle('dropdown_with-chk__button_active');
        });

        dropdownItems.forEach(function (listItem) {
            listItem.addEventListener('click', function (e) {
                e.target.classList.toggle('dropdown_with-chk__list-item_active');
            })
        })

        document.addEventListener('click', function (e) {
            if (e.target !== dropdownBtn && e.target !== dropdownItems && !e.target.classList.contains('dropdown_with-chk__list-item') && !e.target.classList.contains('dropdown_with-chk__list-item_label')) {
                dropdownBtn.classList.remove('dropdown_with-chk__button_active');
                dropdownList.classList.remove('dropdown_with-chk__list_visible');
            }
        })

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Tab' || e.key === 'Escape') {
                dropdownBtn.classList.remove('dropdown_with-chk__button_active');
                dropdownList.classList.remove('dropdown_with-chk__list_visible');
            }
        })
    })

    function moreText() {
        const mains = document.querySelectorAll('[data-more-text="main"]')

        if (!mains.length) return

        mains.forEach(main => {
            const elems = main.children
            const paragraphs = Object.values(elems)
            console.log(paragraphs)
            console.log(typeof paragraphs)
            const btn = main.querySelector('[data-more-text="btn"]')
            const btnName = main.querySelector('[data-more-text="btn-name"]')

            if (paragraphs.length) {
                paragraphs.forEach((paragraph, index) => {
                    if (index > 1 && index < (paragraphs.length - 1)) paragraph.style.display = 'none'
                })
            }

            btn.addEventListener('click', () => {
                main.classList.toggle('active')

                if (main.classList.contains('active')) {
                    btnName.textContent = 'Скрыть'
                    btn.classList.add('active')
                    paragraphs.forEach((paragraph, index) => {
                        if (index > 1 && index < paragraphs.length - 1) paragraph.style.display = 'block'
                    })
                } else {
                    btnName.textContent = 'Показать еще'
                    btn.classList.remove('active')
                    paragraphs.forEach((paragraph, index) => {
                        if (index > 1 && index < paragraphs.length - 1) paragraph.style.display = 'none'
                    })
                }
            })
        })
    }

    moreText()
})

// Функция обработки упаковки в корзине
function processBasketItems() {
    const container = document.querySelector('#basket-item-table');
    if (!container) return;
    const items = Array.from(container.querySelectorAll('[data-entity="basket-item"]'));
    if (!items.length) return;

    let specialItem = null;

    items.forEach(item => {
        const link = item.querySelector('a[href="/product/_upakovka_i_podbor_usluga/"]');
        if (!link) return;

        // Обработка упаковки
        const name = link.textContent || 'Услуга упаковки';
        const priceBlockElement = item.querySelector('.catalog__item-price');
        const priceBlock = priceBlockElement ? priceBlockElement.outerHTML : '';
        const imgSrc = link.querySelector('img')?.src || '';
        const quantity = item.querySelector('[data-entity="basket-item-quantity-field"]')?.value ||
            item.querySelector('.catalog__item-amount input')?.value || '1';

        item.classList.add('catalog__item--special');
        item.innerHTML = `
            <div class="catalog__item-img"><img src="${imgSrc}" alt=""></div>
            <span class="catalog__item-title catalog__item-title--special">${name}</span>
            <div class="catalog__item-amount special">${quantity}</div>
            ${priceBlock}
            <div class="catalog__item-close"></div>
        `;

        specialItem = item;
    });

    // Переместим элемент с услугой в конец
    if (specialItem && container.contains(specialItem)) {
        container.appendChild(specialItem);
    }
}
document.addEventListener('DOMContentLoaded', function() {
    processBasketItems();
});
BX.addCustomEvent('OnBasketChange', function() {
    processBasketItems();
});

document.addEventListener('DOMContentLoaded', () => {
    // Создаем MutationObserver для отслеживания изменений в DOM
    const observer = new MutationObserver(() => {
        // Проверяем наличие элементов с классом catalog__item
        const catalogItems = document.querySelectorAll('.catalog__item:not(.catalog__item--special)');

        // Если элементов с классом catalog__item нет
        if (catalogItems.length === 0) {
            // Находим все элементы с классом catalog__item--special
            const specialItems = document.querySelectorAll('.catalog__item--special');
            // Удаляем каждый найденный элемент
            specialItems.forEach(item => item.remove());
        }
    });

    // Настраиваем и запускаем наблюдатель
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});