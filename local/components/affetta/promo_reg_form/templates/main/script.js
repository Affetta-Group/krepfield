(function (window) {
    'use strict';

    if (window.promoReg)
        return;

    window.promoReg = function (arParams) {
        this.fields = arParams.params.FIELDS;
        this.promoform = BX('promoform');
        this.inputsCont = BX('promoform-inputs');
        this.submitBtn = this.promoform.querySelector('[type=submit]');
        this.signInBtn = BX('sign_in');
        this.userPhone = '';
        this.action = arParams.params.ACTION;
        this.formData = {};
        this.customSelects = this.promoform.querySelectorAll('[js-role=af-custom-select]');
        this.customMultiSelects = this.promoform.querySelectorAll('[js-role=af-custom-multiselect]');

        BX.ready(BX.delegate(this.init,this));
    };

    window.promoReg.prototype = {
        init: function () {
            this.initSelects()
            this.initMultiSelects()
            this.bindEvents()
        },
        initMultiSelects: function () {
            for (let select of this.customMultiSelects) {
                // select.addEventListener('click',function (e){
                //     select.querySelector('.af-custom-select__variants').classList.toggle('active')
                // })


            }
        },
        initSelects: function () {
            for (let select of this.customSelects) {
                let variants = '';
                let origSelect = this.promoform.querySelector('#'+select.attributes['data-entity'].value)

                // select.addEventListener('click',function (e){
                //     select.querySelector('.af-custom-select__variants').classList.toggle('active')
                // })


                select.querySelector('.af-custom-select__label-text').innerHTML = origSelect.children[0].text;

                for (let opt of origSelect.children) {
                    variants += `<div class="af-custom-select__variant" val="${opt.value}"><span>${opt.text}</span></div>`;
                }
                select.querySelector('.af-custom-select__variants').innerHTML = variants;
            }

            for (let select of this.customSelects) {
                let origSelect = this.promoform.querySelector('#'+select.attributes['data-entity'].value)
                let btns = select.querySelectorAll('.af-custom-select__variant');
                for (let btn of btns) {
                    btn.addEventListener('click',function (){
                        origSelect.value = btn.attributes.val.value;
                        select.querySelector('.af-custom-select__label-text').innerHTML = btn.querySelector('span').innerHTML;
                    })
                }
            }
        },
        bindEvents: function () {
            window.addEventListener("click", (e) => {
                if (e.target.closest(".af-custom-select")) {
                    e.target.closest(".af-custom-select").classList.toggle("active");
                } else {
                    document.querySelectorAll('.af-custom-select').forEach(el => el.classList.remove('active'))
                }
            });

            BX.bind(this.submitBtn, 'click', BX.proxy(this.sendCheck, this));
            BX.bind(this.signInBtn, 'click', BX.proxy(this.signIn, this));
        },
        signIn: function () {
            this.formData = {}
            this.formData.EVENT = "SEND_CODE"
            this.formData.PHONE = this.userPhone;
            this.formData.CODE = BX('user_code').value;
            BX.ajax({
                method: 'POST',
                data: this.formData,
                dataType: 'json',
                url: "/local/ajax/check_code.php",
                onsuccess: BX.proxy(this.ajaxResult, this)
            });
        },
        refrechCode: function () {
            this.formData = {}
            this.formData.EVENT = "SEND_CODE"
            this.formData.PHONE = this.userPhone;
            BX.ajax({
                method: 'POST',
                data: this.formData,
                dataType: 'json',
                url: "/local/ajax/send_code.php",
                onsuccess: BX.proxy(this.ajaxResult, this)
            });
        },
        getFieldValue: function (field){
            switch (field.type) {
                case 'text':
                    this.formData[field.name] = this.promoform.querySelector('#'+field.name).value;
                    break;

                case 'checkbox':
                    this.formData[field.name] = this.promoform.querySelector('#'+field.name).checked;
                    break;

                case 'select':
                    this.formData[field.name] = this.promoform.querySelector('#'+field.name).value;
                    break;

                case 'multiselect_ext':
                    for(let subfield of field.ext){
                        if(!this.formData[field.name]) this.formData[field.name] = [];
                        this.formData[field.name][subfield.name] = this.promoform.querySelector('#'+subfield.name).checked
                    }
                    break;
            }
        },
        sendCheck: function () {
            if(this.userPhone.length > 0) {
                this.refrechCode();
                return;
            }

            let error_code = 0;
            let errors = [];
            this.formData = {};

            for(let field of this.fields) {
                this.getFieldValue(field);

                switch (field.type) {
                    case 'text':
                        if (field.required == 'Y') {
                            if (this.promoform.querySelector('#'+field.name).value.length == 0) {
                                error_code = 1;
                                this.promoform.querySelector('#'+field.name).parentNode.classList.add('error')
                                errors.push("Поле \""+ field.placeholder +"\" обязательное для заполнения")
                            } else {
                                this.promoform.querySelector('#'+field.name).parentNode.classList.remove('error')
                            }
                        }
                        break;

                    case 'checkbox':
                        if (field.required == 'Y') {
                            if (!this.promoform.querySelector('#'+field.name).checked) {
                                error_code = 1;
                                errors.push("Необходимо отметить \""+ field.placeholder +"\"")
                                this.promoform.querySelector('#'+field.name).parentNode.parentNode.classList.add('error')
                            } else {
                                this.promoform.querySelector('#'+field.name).parentNode.parentNode.classList.remove('error')
                            }
                        }
                        break;

                    case 'select':
                        if (field.required == 'Y') {
                            if (this.promoform.querySelector('#'+field.name).value.length == 0) {
                                error_code = 1;
                                this.promoform.querySelector('#'+field.name).parentNode.classList.add('error')
                                errors.push("Поле \""+ field.placeholder +"\" обязательное для заполнения")
                            } else {
                                this.promoform.querySelector('#'+field.name).parentNode.classList.remove('error')
                            }
                        }
                        break;

                    case 'multiselect_ext':
                        let opt_cnt = 0;
                        if (field.required == 'Y') {
                            for(let subfield of field.ext){
                                if (this.promoform.querySelector('#'+subfield.name).checked) {
                                    opt_cnt++;
                                }
                            }
                            if(opt_cnt == 0) {
                                error_code = 1;
                                errors.push(field.placeholder)
                                this.promoform.querySelector('#'+field.name).classList.add('error');
                            } else {
                                this.promoform.querySelector('#'+field.name).classList.remove('error')
                            }
                        }
                        break;
                }
            }

            console.log(this.formData)
            if (error_code == 0) {
                this.sendForm();
            } else {
                let mess = '';
                for(let err of errors){
                    mess += err+"\n";
                }
                console.log(mess);
            }
        },
        sendForm: function () {
            this.formData.EVENT = this.action;

            this.formData.utm_source = this.promoform.querySelector('[name="utm_source"]').value;
            this.formData.utm_campaign = this.promoform.querySelector('[name="utm_campaign"]').value;

            BX.ajax({
                method: 'POST',
                data: this.formData,
                dataType: 'json',
                url: "/local/ajax/send_code.php",
                onsuccess: BX.proxy(this.ajaxResult, this)
            });
        },
        ajaxResult: function (arResult) {
            console.log(arResult)
            if(arResult.status){
                if(arResult.authorized) {
                    console.log('authorized')
                    location.href = '/personal/';
                    return;
                }

                if (this.userPhone.length == 0) {
                    this.userPhone = this.promoform.querySelector('#PHONE').value
                }

                BX.cleanNode(this.inputsCont);
                var num = 60
                this.inputsCont.innerHTML = `<div class="enter__item-tx">На номер `+this.userPhone+` был отправлен одноразовый код</div>
<input id="user_code" class="enter__item-field" type="text" placeholder="Введите код">
<div class="enter__item-time">Отправить код ещё раз через <span class="seconds">`+num+`</span> сек.</div>`

                const secB = this.promoform.querySelector('#promoform .seconds');
                const subB = this.submitBtn;
                this.signInBtn.style.display = 'block';

                let timerId = setInterval(function () {
                    secB.innerHTML =--num;
                }, 1000);
                setTimeout(function () {
                    clearInterval(timerId);
                    subB.style.display = 'block';
                }, num * 1000);

                this.submitBtn.innerHTML = 'Получить код повторно';
                this.submitBtn.style.display = 'none';

                this.promoform.querySelector('.enter__error-text').style.display = 'none';
            } else {

                this.promoform.querySelector('.enter__error-text').style.display = 'block';
                this.promoform.querySelector('.enter__error-text').innerHTML = arResult.errors;

            }
        }
    }
})(window);