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
        this.userId = 0;

        this.formData = {};

        BX.ready(BX.delegate(this.init,this));
    };

    window.promoReg.prototype = {
        init: function () {
            this.bindEvents()
        },
        sendCodeByMail: function (userId) {
            this.formData.EVENT = 'mailCode';
            this.formData.USER_ID = userId;
            this.userId = userId;
            this.sendForm();
        },
        bindEvents: function () {
            BX.bind(this.submitBtn, 'click', BX.proxy(this.sendCheck, this));
            BX.bind(this.signInBtn, 'click', BX.proxy(this.signIn, this));
        },
        signIn: function () {
            this.formData = {}
            this.formData.EVENT = "SEND_CODE"
            this.formData.USER_ID = this.userId
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

            for (let field of this.fields) {
                    this.getFieldValue(field);

                    switch (field.type) {
                        case 'text':
                            if (field.required == 'Y') {
                                if (this.promoform.querySelector('#' + field.name).value.length == 0) {
                                    error_code = 1;
                                    this.promoform.querySelector('#' + field.name).style.border = 'red 1px solid';
                                    errors.push("Поле \"" + field.placeholder + "\" обязательное для заполнения")
                                } else {
                                    this.promoform.querySelector('#' + field.name).style.border = 'none';
                                }
                            }
                            break;

                        case 'checkbox':
                            if (field.required == 'Y') {
                                if (!this.promoform.querySelector('#' + field.name).checked) {
                                    error_code = 1;
                                    errors.push("Необходимо отметить \"" + field.placeholder + "\"")
                                    this.promoform.querySelector('#' + field.name).parentNode.style.border = 'red 1px solid'
                                } else {
                                    this.promoform.querySelector('#' + field.name).parentNode.style.border = 'none'
                                }
                            }
                            break;

                        case 'multiselect_ext':
                            let opt_cnt = 0;
                            if (field.required == 'Y') {
                                for (let subfield of field.ext) {
                                    if (this.promoform.querySelector('#' + subfield.name).checked) {
                                        opt_cnt++;
                                    }
                                }
                                if (opt_cnt == 0) {
                                    error_code = 1;
                                    errors.push(field.placeholder)
                                    this.promoform.querySelector('#' + field.name).style.border = 'red 1px solid'
                                } else {
                                    this.promoform.querySelector('#' + field.name).style.border = 'none'
                                }
                            }
                            break;
                    }
                }

            console.log(this.formData)
            if (error_code == 0) {
                this.formData.EVENT = this.action;
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
            console.log(231)
            if(arResult.status){
                if (this.userPhone.length == 0) {
                    this.userPhone = this.promoform.querySelector('#PHONE').value
                } else {
                    if(arResult.authorized) {
                        console.log('authorized')
                        location.href = '/personal/';
                    }
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