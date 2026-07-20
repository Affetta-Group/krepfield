<form action="" class="questionnaire__form" novalidate data-validate-form data-questionnaire="form" id="form_<?= $arParams["TOKEN"] ?>">
    <div class="questionnaire__form-wrap-inputs">
        <div class="input" data-input="main">
            <span class="input__name" data-input="name">Имя</span>
            <div class="input__block-input">
                <input value="<?=$arParams['USER_NAME']?>" name="name" type="text" placeholder="Иванов Иван Иванович" class="input__input" data-input="input" data-input-type="name" minlength="2" required>
            </div>
            <span class="input__message" data-input="message"></span>
        </div>
        <div class="input" data-input="main">
            <span class="input__name" data-input="name">Телефон</span>
            <div class="input__block-input">
                <input value="<?=$arParams['USER_PERSONAL_PHONE']?>" name="phone" type="text" placeholder="+7 (999) 999-99-99" class="input__input" data-input="input" data-input-type="tel" data-phone-mask required>
            </div>
            <span class="input__message" data-input="message"></span>
        </div>
        <div class="input" data-input="main">
            <span class="input__name" data-input="name">Email</span>
            <div class="input__block-input">
                <input value="<?=$arParams['USER_EMAIL']?>" name="email" type="text" placeholder="ivan@mail.ru" class="input__input" data-input="input" data-input-type="email" required>
            </div>
            <span class="input__message" data-input="message"></span>
        </div>
    </div>
    <div class="questionnaire__form-wrap-variants">
        <div class="questionnaire__form-variant" data-questionnaire="form-variant">
            <span class="questionnaire__form-title">Как вы попали на эту страницу?</span>
            <div class="questionnaire__form-inner-variants" data-questionnaire="form-inner-variants">
                <div class="radio" data-questionnaire="block-radio">
                    <label data-role="" class="radio__label">
                        <input type="radio" class="radio__input" name="WAY" value="YA" data-questionnaire="radio">
                        <span class="radio__text">Яндекс Маркет</span>
                        <span class="radio__decore"></span>
                    </label>
                </div>
                <div class="radio" data-questionnaire="block-radio">
                    <label data-role="" class="radio__label">
                        <input type="radio" class="radio__input" name="WAY" value="OZON" data-questionnaire="radio">
                        <span class="radio__text">Ozon</span>
                        <span class="radio__decore"></span>
                    </label>
                </div>
                <span class="questionnaire__form-message" data-questionnaire="form-message">Выберите вариант ответа</span>
            </div>
        </div>
        <div class="questionnaire__form-variant" data-questionnaire="form-variant" data-questionnaire-special="form-variant">
            <span class="questionnaire__form-title">К какой категории вы себя относите?</span>
            <div class="questionnaire__form-inner-variants" data-questionnaire="form-inner-variants">
                <div class="radio" data-questionnaire="block-radio" data-questionnaire-variant="professional">
                    <label data-role="" class="radio__label">
                        <input type="radio" class="radio__input" name="SKILL" value="PROFI" data-questionnaire="radio">
                        <span class="radio__text">Профессионал</span>
                        <span class="radio__decore"></span>
                    </label>
                </div>
                <div class="radio" data-questionnaire="block-radio">
                    <label data-role="" class="radio__label">
                        <input type="radio" class="radio__input" name="SKILL" value="AMATEUR" data-questionnaire="radio">
                        <span class="radio__text">Любитель</span>
                        <span class="radio__decore"></span>
                    </label>
                </div>
                <span class="questionnaire__form-message" data-questionnaire="form-message">Выберите вариант ответа</span>
            </div>
        </div>
        <div class="questionnaire__form-variant" data-questionnaire="form-variant" data-questionnaire-additional="specialties">
            <span class="questionnaire__form-title">Укажите вашу специальность</span>
            <div class="questionnaire__form-inner-variants" data-questionnaire="form-inner-variants">
                <div class="radio" data-questionnaire="block-radio">
                    <label data-role="" class="radio__label">
                        <input type="radio" class="radio__input" name="POSITION" value="MONTAGE" data-questionnaire="radio">
                        <span class="radio__text">Монтажник</span>
                        <span class="radio__decore"></span>
                    </label>
                </div>
                <div class="radio" data-questionnaire="block-radio">
                    <label data-role="" class="radio__label">
                        <input type="radio" class="radio__input" name="POSITION" value="ELECTR" data-questionnaire="radio">
                        <span class="radio__text">Электрик</span>
                        <span class="radio__decore"></span>
                    </label>
                </div>
                <div class="radio" data-questionnaire="block-radio">
                    <label data-role="" class="radio__label">
                        <input type="radio" class="radio__input" name="POSITION" value="SLES" data-questionnaire="radio">
                        <span class="radio__text">Слесарь</span>
                        <span class="radio__decore"></span>
                    </label>
                </div>
                <div class="radio" data-questionnaire="block-radio">
                    <label data-role="" class="radio__label">
                        <input type="radio" class="radio__input" name="POSITION" value="MECH" data-questionnaire="radio">
                        <span class="radio__text">Механик</span>
                        <span class="radio__decore"></span>
                    </label>
                </div>
                <span class="questionnaire__form-message" data-questionnaire="form-message">Выберите вариант ответа или заполните поле</span>
            </div>
            <div class="questionnaire__form-other" data-questionnaire="form-other">
                <span class="questionnaire__form-other-title">Другое:</span>
                <div class="questionnaire__form-other-block-input">
                    <input type="text" class="questionnaire__form-other-input" data-questionnaire="form-other-input">
                </div>
            </div>
        </div>
    </div>
    <div class="questionnaire__form-wrap-btn">
        <button type="submit" class="button button-primary">Отправить</button>
        <div class="questionnaire__form-privacy-policy">
            Нажимая “Отправить”, вы соглашаетесь с условиями нашей
            <a href="/policy/" target="_blank">политики конфиденциальности</a>
        </div>
    </div>
</form>


<script type="application/javascript">
    "use strict";

    const formSubmit = (objD) => {
        postData(window.location.origin + window.location.pathname, objD)
            .then((data) => {
                console.log(data); // JSON data parsed by `data.json()` call
            });
    }

    async function postData(url = '', data = {}) {
        // Default options are marked with *
        const response = await fetch(url, {
            method: 'POST', // *GET, POST, PUT, DELETE, etc.
            mode: 'cors', // no-cors, *cors, same-origin
            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
            credentials: 'same-origin', // include, *same-origin, omit
            headers: {
                'Content-Type': 'application/json'
                // 'Content-Type': 'application/x-www-form-urlencoded',
            },
            redirect: 'follow', // manual, *follow, error
            referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
            body: JSON.stringify(data) // body data type must match "Content-Type" header
        });
        return response.json(); // parses JSON response into native JavaScript objects
    }

    function validateForm(first) {
        const forms = document.querySelectorAll('[data-validate-form]')

        if (!forms.length) return

        const validate = (el) => {
            const form = el.closest('[data-validate-form]')
            const inputs = form.querySelectorAll('.input')
            const textarea = form.querySelectorAll('.textarea')

            const regExpName = /^[A-ZА-ЯЁ]+$/i

            let numberСorrectАields = 0

            const data = {
                name: '',
                phone: '',
                email: '',
            }

            const addHeightMessage = () => {
                setTimeout(() => {
                    inputs.forEach(elInput => {
                        if (elInput.classList.contains('input--error')) {
                            const message = elInput.querySelector('[data-input="message"]')
                            const heightMessage = message.offsetHeight
                            elInput.style.paddingBottom = `${heightMessage}px`
                        } else {
                            elInput.style.paddingBottom = '0'
                        }
                    })
                }, 0)
            }

            if (inputs.length) {
                inputs.forEach(elInput => {
                    const input = elInput.querySelector('input')

                    if (input.hasAttribute('required')) {
                        const type = input.getAttribute('data-input-type')
                        const message = elInput.querySelector('[data-input="message"]')

                        if (input.value) {
                            const value = input.value

                            if (type === 'tel') {
                                if (value.length < 16) {
                                    elInput.classList.add('input--error')
                                    message.innerText = 'Введите полный номер'
                                } else {
                                    elInput.classList.remove('input--error')
                                    data.phone = value
                                }
                            }

                            if (type === 'name') {
                                const minlength = +input.getAttribute('minlength')

                                if (!value.match(regExpName) || value.length < minlength) {
                                    elInput.classList.add('input--error')
                                    message.innerText = 'Введите имя верно'
                                } else {
                                    elInput.classList.remove('input--error')
                                    data.name = value
                                }
                            }

                            if (type === 'surname') {
                                const minlength = +input.getAttribute('minlength')

                                if (!value.match(regExpName)) {
                                    elInput.classList.add('input--error')
                                    message.innerText = 'Введите фамилию верно'
                                } else {
                                    elInput.classList.remove('input--error')
                                }
                            }

                            if (type === 'patronymic') {
                                const minlength = +input.getAttribute('minlength')

                                if (!value.match(regExpName)) {
                                    elInput.classList.add('input--error')
                                    message.innerText = 'Введите отчество верно'
                                } else {
                                    elInput.classList.remove('input--error')
                                }
                            }

                            if (type === 'address') {
                                const minlength = +input.getAttribute('minlength')

                                if (!value.match(regExpName)) {
                                    elInput.classList.add('input--error')
                                    message.innerText = 'Введите адрес верно'
                                } else {
                                    elInput.classList.remove('input--error')
                                }
                            }

                            if (type === 'email') {
                                if (!validator.isEmail(value)) {
                                    elInput.classList.add('input--error')
                                    message.innerText = 'Введите корректный email'
                                } else {
                                    elInput.classList.remove('input--error')
                                    data.email = value
                                }
                            }

                            addHeightMessage()

                        } else {
                            elInput.classList.add('input--error')
                            addHeightMessage()
                            message.innerText = 'Это поле обязательно для заполнения'
                        }
                    }
                })

                inputs.forEach(elInput => {
                    if (!elInput.classList.contains('input--error')) {
                        numberСorrectАields++
                    } else {
                        elInput.classList.add('input--error-effect')
                        setTimeout(() => {
                            elInput.classList.remove('input--error-effect')
                        }, 500)
                    }
                })

                if (numberСorrectАields === inputs.length) {

                    // if (form.hasAttribute('action')) {
                    //     form.submit()
                    // }

                    return data
                } else return undefined
            }

        }

        if (first) {
            document.addEventListener('click', (event) => {
                const el = event.target

                if (el.closest('[data-validate-form]')) {
                    if (el.closest('button[type="submit"]')) {
                        event.preventDefault()
                        validate(el)
                    }

                    if (el.closest('.input')) {
                        validate(el)
                    }
                }
            })
        } else {

            validate(document.querySelector('[data-validate-form]'))

            let numberСorrectАields = 0;
            const form = document.querySelector('[data-validate-form] .questionnaire__form-wrap-inputs')
            const inputs = form.querySelectorAll('.input')
            inputs.forEach(elInput => {
                if (!elInput.classList.contains('input--error')) {
                    numberСorrectАields++
                }
            })
            if (numberСorrectАields === inputs.length) {
                // console.log(numberСorrectАields)
                return false
            }
        }
    }
    function questionnaire(first) {
        const main = document.querySelector('[data-questionnaire="main"]')

        if (!main) return

        const form = main.querySelector('[data-questionnaire="form"]')

        if (form) {
            const formVariants = form.querySelectorAll('[data-questionnaire="form-variant"]')
            const specialties = form.querySelector('[data-questionnaire-additional="specialties"]')

            const data = {
                howDidYouGetToThisPage: '',
                whatCategoryDoYouBelongTo: '',
                specifyYourSpecialty: '',
            }

            formVariants.forEach(formVariant => {
                if (formVariant.hasAttribute('data-questionnaire-special')) {
                    const blockRadios = formVariant.querySelectorAll('[data-questionnaire="block-radio"]')

                    blockRadios.forEach(blockRadio => {
                        if (first) {
                            blockRadio.addEventListener('click', (event) => {
                                event.preventDefault()

                                const radio = blockRadio.querySelector('[data-questionnaire="radio"]')

                                if (!blockRadio.classList.contains('active')) {

                                    blockRadios.forEach(blockRadio2 => {
                                        const radio2 = blockRadio2.querySelector('[data-questionnaire="radio"]')
                                        blockRadio2.classList.remove('active')
                                        radio2.checked = false
                                    })

                                    blockRadio.classList.add('active')
                                    radio.checked = true

                                    if (blockRadio.hasAttribute('data-questionnaire-variant')) {

                                        specialties.classList.add('active')
                                    } else {
                                        specialties.classList.remove('active')
                                    }
                                }
                            })
                        }
                    })
                }
            })

            const logicSentBtn = (formVariant) => {
                let sendAccess = '';
                if (!formVariant.hasAttribute('data-questionnaire-additional')) {
                    const blocksRadio = formVariant.querySelectorAll('[data-questionnaire="block-radio"]')
                    const innerVariants = formVariant.querySelector('[data-questionnaire="form-inner-variants"]')
                    let isMessage = true

                    blocksRadio.forEach(blockRadio => {
                        const radio = blockRadio.querySelector('[data-questionnaire="radio"]')

                        if (radio.checked) {
                            isMessage = false
                        }
                    })

                    if (isMessage) {
                        innerVariants.classList.add('questionnaire__form-inner-variants--message')
                        sendAccess = 'e';
                    } else {
                        innerVariants.classList.remove('questionnaire__form-inner-variants--message')
                    }
                } else {
                    const blocksRadio = formVariant.querySelectorAll('[data-questionnaire="block-radio"]')
                    const innerVariants = formVariant.querySelector('[data-questionnaire="form-inner-variants"]')
                    const input = formVariant.querySelector('[data-questionnaire="form-other-input"]')
                    let isMessage = true

                    blocksRadio.forEach(blockRadio => {
                        const radio = blockRadio.querySelector('[data-questionnaire="radio"]')

                        if (radio.checked) {
                            isMessage = false
                        }
                    })

                    if (isMessage) {
                        if (input.value.length > 5) {
                            isMessage = false
                        }
                    }

                    if (isMessage) {
                        innerVariants.classList.add('questionnaire__form-inner-variants--message')
                        sendAccess = 'e';
                    } else {
                        innerVariants.classList.remove('questionnaire__form-inner-variants--message')
                    }
                }

                return sendAccess;
            }

            if (!first) {
                let sendAccess = '';

                formVariants.forEach(formVariant => {
                    if (!formVariant.hasAttribute('data-questionnaire-additional')) {
                        sendAccess += logicSentBtn(formVariant)
                    } else if (formVariant.classList.contains('active')) {
                        sendAccess += logicSentBtn(formVariant)
                    }
                })

                if(sendAccess.length === 0) return false;
            }




            const innerVariants = form.querySelectorAll('[data-questionnaire="form-inner-variants"]')
            let numberСorrectАields = 0

            innerVariants.forEach(innerVariant => {
                if (!innerVariant.classList.contains('questionnaire__form-inner-variants--message')) {
                    numberСorrectАields++
                }
            })

            // console.log(innerVariants.length + ' / ' + numberСorrectАields)

            if (numberСorrectАields === innerVariants.length) {

                // if (form.hasAttribute('action')) {
                //     form.submit()
                // }



                innerVariants.forEach((innerVariant, index) => {
                    // console.log(data.howDidYouGetToThisPage)
                    const blocksRadio = innerVariant.querySelectorAll('[data-questionnaire="block-radio"]')

                    blocksRadio.forEach(blockRadio => {
                        const radioInput = blockRadio.querySelector('[data-questionnaire="radio"]')
                        const radioValue = blockRadio.querySelector('.radio__text')
                        const formOtherInput = form.querySelector('[data-questionnaire="form-other-input"]')

                        if (radioInput.checked) {
                            for (var i in data) {
                                if (data.hasOwnProperty(i)) {
                                    if (i === index) {
                                        data[i] = radioValue.textContent
                                    }
                                }
                            }
                        } else {
                            if (formOtherInput) {
                                for (var i in data) {
                                    if (data.hasOwnProperty(i)) {
                                        if (i === index) {
                                            data[i] = formOtherInput.value
                                        }
                                    }
                                }
                            }
                        }
                    })
                })

                return data
            } else return undefined
        }
    }

    validateForm(true)
    questionnaire(true)

    $(() => {

        $("#form_<?= $arParams["TOKEN"] ?> button[type=submit]").click(e => {
            e.preventDefault();

            let errors = [];

            errors.push(validateForm())
            errors.push(questionnaire())

            for (let error of errors) {
                if (error !== false) return;
            }

            //formSubmit({
            //    TOKEN:'<?php //= $arParams['TOKEN'] ?>//',
            //    URL: window.location.origin + window.location.pathname,
            //    PHONE: $('#form_<?php //= $arParams['TOKEN'] ?>// input[name=name]').val(),
            //    NAME: $('#form_<?php //= $arParams['TOKEN'] ?>// input[name=phone]').val(),
            //    MAIL: $('#form_<?php //= $arParams['TOKEN'] ?>// input[name=email]').val(),
            //    POSITION1: $('#form_<?php //= $arParams['TOKEN'] ?>// input[name=position1]:checked').val(),
            //    POSITION2: $('#form_<?php //= $arParams['TOKEN'] ?>// input[name=position2]:checked').val(),
            //});

            let data = new FormData;
            data.append("TOKEN", '<?= $arParams['TOKEN'] ?>');
            data.append("URL",  window.location.origin + window.location.pathname);
            data.append("PHONE",  $('#form_<?= $arParams['TOKEN'] ?> input[name=phone]').val());
            data.append("NAME",  $('#form_<?= $arParams['TOKEN'] ?> input[name=name]').val());
            data.append("MAIL",  $('#form_<?= $arParams['TOKEN'] ?> input[name=email]').val());
            data.append("SKILL",  $('#form_<?= $arParams['TOKEN'] ?> input[name=SKILL]:checked').val());

            if($('#form_<?= $arParams['TOKEN'] ?> input[name=POSITION]:checked').val() !== undefined) {
                data.append("POSITION", $('#form_<?= $arParams['TOKEN'] ?> input[name=POSITION]:checked').val());
            }

            data.append("WAY",  $('#form_<?= $arParams['TOKEN'] ?> input[name=WAY]:checked').val());

            $.ajax({
                method: "post",
                url: window.location.origin + window.location.pathname,
                data: data,
                contentType: false,
                processData: false,
                success: (data) => {
                    data = JSON.parse(data);
                    if (data.status === true) {
                        $('#modalCall').modal('hide');
                        $('#modalZv').modal('show').on('hidden.bs.modal', () => {
                            location.reload();
                        });
                    }
                }
            });
        });
    });
</script>