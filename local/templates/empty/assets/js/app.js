'use strict';

$(document).ready(function () {
    $(".catalog-page__list-btn").on('click', function (event) {
        $(this).parent().toggleClass('open');
    });

    $(".catalog-page__content-col-nb").on('click', function (event) {
        $(this).parent().toggleClass('open');
    });

    $(".phone-mask").mask("+7 (999) 999 99 99", {"clearIncomplete": false});

    $(".filter__group-check, .catalog-page__list-item ul").mCustomScrollbar();

    $('.filter__title').on('click', function (event) {
        $(this).toggleClass('open').parent('.filter__item').toggleClass('open');
    });

    $('.cart-product__description-tx-btn').on('click', function (event) {
        $(this).prev().toggleClass('open');
    });

    if ($('.cart-product__text-container').height() > 365) {
        $('.cart-product__description-tx-btn').css("display", "inline-block");
    };

    $('.menu__list-title-mob').on('click', function (event) {
        $(this).toggleClass('open').next().toggleClass('open');
    });
    $('.menu__list-item-arrow').on('click', function (event) {
        $(this).parent().toggleClass('op').next();
    });
    $('.menu__tabs-mob').on('click', function (event) {
        $(this).parent().toggleClass('on');
    });

    $('.menu__list-item-all').on('click', function (event) {
        $(this).toggleClass('op').parent().toggleClass('op2');
    });

    $(".header__catalog").on("click", function (event) {
        if ($(this).hasClass("op")) {
            $(this).removeClass("op");
            $(".menu").removeClass("open");
            $('.overlay').removeClass('active');
        } else {
            $(this).addClass("op");
            $(".menu").addClass("open");
            $('.overlay').addClass('active');
        }
    });
    $(document).click(function (e) {
        if (!$(".header__catalog").is(e.target) && $(".header__catalog").has(e.target).length === 0 && !$(".menu").is(e.target) && $(".menu").has(e.target).length === 0) {
            $(".menu").removeClass("open");
            $(".header__catalog").removeClass("op");
            $('.overlay').removeClass('active');
        };
    });

    $('.menu__close').on('click', function (event) {
        $('.menu').removeClass('open');
        $('.overlay').removeClass('active');
    });

    $('.filter__title-t').on('click', function (event) {
        $(this).toggleClass('open').parent().toggleClass('open');
    });

    $('.filter__title-t-btn').on('click', function (event) {
        $(this).toggleClass('open').parent().toggleClass('on');
    });

    $(".filter__group-check").mCustomScrollbar();
    $(".cart-product__content-contact-map .cart-product__content-contact-table").mCustomScrollbar();

    $('.js-filter-mob').on('click', function (event) {
        $('.filter').addClass('op');
        $('body').addClass('overfl');
    });
    $('.js-filter-close').on('click', function (event) {
        $('.filter').removeClass('op');
        $('body').removeClass('overfl');
    });

    $('.js-select').selectric();

    $('.js-banner-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        arrows: false
    });

    $('.js-catalog-slider').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        dots: false,
        arrows: true,
        responsive: [{
            breakpoint: 1400,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1
            }
        }, {
            breakpoint: 1200,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1
            }
        }, {
            breakpoint: 991,
            settings: {
                variableWidth: true,
                dots: false,
                arrows: false
            }
        }]
    });

    $('.js-catalog-slider2').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        dots: false,
        arrows: true,
        responsive: [{
            breakpoint: 1400,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1
            }
        }, {
            breakpoint: 1200,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1
            }
        }, {
            breakpoint: 991,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                dots: false,
                arrows: true
            }
        }, {
            breakpoint: 500,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                arrows: true
            }
        }]
    });

    $('.js-blog-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: false,
        arrows: true,
        responsive: [{
            breakpoint: 1200,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        }, {
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true,
                arrows: arrow
            }
        }]
    });

    $('.js-propr-slider').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        dots: false,
        arrows: true,
        responsive: [{
            breakpoint: 1200,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1
            }
        }, {
            breakpoint: 991,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true,
                arrows: true
            }
        }]
    });

    $('.js-material-slider').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        dots: false,
        arrows: true,
        responsive: [{
            breakpoint: 1200,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1
            }
        }, {
            breakpoint: 991,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                arrows: false,
                variableWidth: true
            }
        }]
    });

    $('.js-propr-sl').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        dots: false,
        arrows: true,
        responsive: [{
            breakpoint: 1200,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1
            }
        }, {
            breakpoint: 991,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                arrows: false,
                variableWidth: true
            }
        }]
    });

    $('.js-masters-categor-slider').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        dots: false,
        arrows: true,
        responsive: [{
            breakpoint: 1200,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        }, {
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true,
                arrows: arrow
            }
        }]
    });

    $('.cart-product__about-slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        dots: false,
        fade: true,
        asNavFor: '.cart-product__about-slider-nav',
        responsive: [{
            breakpoint: 991,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true,
                vertical: false,
                verticalSwiping: false,
                asNavFor: false,
                arrows: false
            }
        }]
    });
    $('.cart-product__about-slider-nav').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        asNavFor: '.cart-product__about-slider-for',
        dots: false,
        arrows: true,
        focusOnSelect: true,
        responsive: [{
            breakpoint: 991,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
                arrows: true,
                vertical: false,
                verticalSwiping: false
            }
        }]
    });

    $('.slick-quiz').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        prevArrow: $('.quiz__result-prev'),
        nextArrow: $('.quiz__result-next'),
        responsive: [{
            breakpoint: 1199,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1,
            }
        }, {
            breakpoint: 767,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
            }
        }, {
            breakpoint: 575,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
            }
        }]
    })

});

;(function ($, window, document, undefined) {
    $('.form__input_type_file').each(function () {
        var $input = $(this),
            $label = $input.next('label'),
            labelVal = $label.html();

        $input.on('change', function (e) {
            var fileName = '';

            if (this.files && this.files.length > 1) fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length); else if (e.target.value) fileName = e.target.value.split('\\').pop();

            if (fileName) {
                // $('.js-file-remove').remove();
                $label.find('span').html(fileName);
                if ($remove.empty()) {
                    $label.next('span').append('<svg><use xlink:href="#remove" class="icon"></use></svg>');
                } else {
                    $remove.html('');
                }
            } else {
                $remove.html('');
                $label.html(labelVal);
            }
        });

        // Firefox bug fix
        $input.on('focus', function () {
            $input.addClass('has-focus');
        }).on('blur', function () {
            $input.removeClass('has-focus');
        });
    });
})(jQuery, window, document);
//# sourceMappingURL=app.js.map
