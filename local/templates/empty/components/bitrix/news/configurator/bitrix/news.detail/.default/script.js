function quizInitialize() {
    $('.slick-quiz').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        vertical: true,
        verticalSwiping: true,
        infinite: false,
        prevArrow: $('.quiz__result-prev'),
        nextArrow: $('.quiz__result-next'),
        responsive: [{
            breakpoint: 1199,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1,
            }
        }, {
            breakpoint: 768,
            settings: {
                vertical: false,
                verticalSwiping: false,
                slidesToShow: 2,
                slidesToScroll: 1,
            }
        },{
            breakpoint: 401,
            settings: {
                vertical: false,
                verticalSwiping: false,
                slidesToShow: 1,
                slidesToScroll: 1,
            }
        }]
    })
}

let dataId = [];
document.select_reply = function (ids) {
    // let label = event.currentTarget;
    // let labelList = label.querySelector('.quiz__question-label-list');
    // labelList.innerHTML = '';

    for (var items in ids) break;
    let dependQuests = document.querySelectorAll('.quiz__question-fields.rule'+items);
    dependQuests.forEach((dependQuest, index) => {
        dependQuest.classList.remove('noactive');
        var inputs = dependQuest.getElementsByTagName('input');
        for(var i = 0; i < inputs.length; i++) {
            inputs[i].checked = false;
            inputs[i].disabled = false;
        }
        delete dataId[dependQuest.parentNode.dataset.question];
    });


    if (ids[items]['quanRule'] > 0 && ids[items]['quanRule'] < items) {
        ids[items]['goods'].forEach(function(item, i, arr) {
            item['id'] = dataId[ids[items]['quanRule']]['goods'][ids[items]['quanRuleReply']]['id']
        });
    }
    BX.ajax({
        url: '/local/ajax/conf_goods.php',
        method: 'POST',
        data: {'ids': ids},
        dataType: 'json',
        onsuccess: function(data) {
            if (data) {
                $('.slick-quiz').slick('unslick');
                let resultList = document.querySelector('.quiz__result-wrapper .slick-quiz');
                resultList.innerHTML = '';

                for (var items in data) break;
                // data[items]['goods'].forEach(function(item, i, arr) {
                //     if (item['id']) {
                //         let a = document.createElement('a');
                //         a.className = 'quiz__question-card';
                //         a.href = '/product/'+item['code'];
                //         a.target = '_blank';
                //         let span1 = document.createElement('span');
                //         span1.className = 'quiz__question-card-image';
                //         let img = document.createElement('img');
                //         img.src = item['picture'];
                //         img.alt =  item['code'];
                //         span1.append(img);
                //         a.append(span1);
                //         let span2 = document.createElement('span');
                //         span2.className = 'quiz__question-card-text';
                //         span2.innerHTML = item['name'];
                //         a.append(span2);
                //         labelList.append(a);
                //     }
                // });

                data[items]['goods'].forEach((item, index) =>{
                    if (data[items]['quanRule'] > 0 && data[items]['quanRule'] < items) {
                        dataId.forEach((array) => {
                            array['goods'].forEach((aritem) => {
                                if (aritem['id'] == item['id']) {
                                    aritem['quantity'] = item['quantity'];
                                }
                            });
                        });
                        data[items]['goods'].splice(index, 1);
                    }
                });

                dataId[items] = data[items];

                const questions = document.querySelectorAll('.quiz__question.subquestion');
                questions.forEach((question, index) => {
                    question.classList.add('hide');
                });

                var replyrule = [];
                for (var key in dataId) {
                    if (dataId[key]['replyrule']) {
                        replyrule.push(dataId[key]['replyrule']);
                    } else {
                        replyrule.push(0);
                    }
                }

                if (replyrule.length > 0) {
                    questions.forEach((question, index) => {
                        if (replyrule.includes(question.dataset.question)) {
                            question.classList.remove('hide')
                        } else if (question.classList.contains('hide')) {
                            if (dataId[question.dataset.question]) delete dataId[question.dataset.question];
                            var inputs = question.getElementsByTagName('input');

                            for(var i = 0; i < inputs.length; i++) {
                                inputs[i].checked = false;
                            }
                        }
                    });
                }

                dataId.forEach((array) => {
                    array['goods'].forEach((item) => {
                        if (item['id']) {
                            let div = document.createElement('div');
                            div.className = 'catalog__item';
                            div.dataset.id = item['id'];
                            let a2 = document.createElement('a');
                            a2.className = 'catalog__item-img';
                            a2.href = '/product/'+item['code'];
                            a2.target = '_blank';
                            div.append(a2);
                            let img2 = document.createElement('img');
                            img2.src = item['picture'];
                            img2.alt =  item['code'];
                            a2.append(img2);
                            let a3 = document.createElement('a');
                            a3.className = 'catalog__item-title';
                            a3.title = item['name'];
                            a3.href = '/product/'+item['code'];
                            let span3 = document.createElement('span');
                            span3.innerHTML = item['name'];
                            a3.append(span3);
                            div.append(a3);
                            resultList.append(div);
                        }
                    });
                });
                quizInitialize();

                const allQuestions = document.querySelectorAll('.quiz__question-fields');
                let answered = false;
                for (const question of allQuestions) {
                    if (question.offsetParent !== null) {
                        const inputs = question.querySelectorAll('input');
                        for (const input of inputs) {
                            if (input.checked) {
                                answered = true;
                                break;
                            }
                            answered = false;
                        }
                        if (!answered) {
                            break;
                        }
                    }
                }
                if (!document.querySelector('.quiz__result-wrapper a.button')) {
                    let a = document.createElement('a');
                    a.className = 'button button-black off';
                    a.setAttribute("onclick", "basket_add()");
                    a.innerHTML = 'Добавить в корзину';
                    document.querySelector('.quiz__result-wrapper').append(a);
                    let div = document.createElement('div');
                    div.className = 'form-cell-tx';
                    div.innerHTML = 'Ответьте на все вопросы для продолжения оформления комплекта';
                    document.querySelector('.quiz__result-wrapper').append(div);
                } else if (answered) {
                    document.querySelector('.quiz__result-wrapper a.button').classList.remove('off');
                    document.querySelector('.quiz__result-wrapper .form-cell-tx').classList.add('hide');
                } else if (!answered && !document.querySelector('.quiz__result-wrapper a.button').classList.contains('off')) {
                    document.querySelector('.quiz__result-wrapper a.button').classList.add('off');
                    document.querySelector('.quiz__result-wrapper .form-cell-tx').classList.remove('hide');
                }

            }
        }
    });
};
let lock = false
document.basket_add = function (ids) {
    if (lock) {
        return;
    }
    lock = true
    event.currentTarget.classList.add('hide')
    document.querySelector('.loader').classList.remove('hide')
    const promises = []
    dataId.forEach((array) => {
        array['goods'].forEach((item) => {
            promises.push(new Promise(resolve => {
                if (!item['id']) {
                    resolve()
                    return;
                }

                const body = new FormData()
                body.append('PRODUCT_ID', item['id'])
                body.append('QUANTITY', item['quantity'] ? item['quantity'] : '1')
                fetch("/local/ajax/add2basket_ajax.php", {
                    method: 'post',
                    body
                })
                    .then(response => response.json())
                    .then(json => {
                        if (!json.status) {$('#exampleModalCartError').modal('show')};
                    })
                    .then(function () {
                        BX.onCustomEvent('OnBasketChange');
                        resolve()
                    })

            }))
        });
    });

    Promise.all(promises).then(() => {
        window.location.href = "/personal/cart/";
    })
}