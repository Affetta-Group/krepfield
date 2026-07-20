$(document).ready(function () {

    $(document).on('click', '.load-more-items', function () {

        let targetContainer = $('.items-list'),
            url = $('.load-more-items').attr('data-url'),
            targetContainer2 = $('.catalog-page__content-tb-bottom');

        if (url !== undefined) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'html',
                success: function (data) {
                    $('.load-more-items').remove();
                    $('.pagination-bl').remove();
                    let elements = $(data).find('.item-content'),
                        pagination = $(data).find('.load-more-items'),
                        pagination2 = $(data).find('.pagination-bl');
                    targetContainer.append(elements);
                    targetContainer2.append(pagination);
                    targetContainer2.append(pagination2);

                }
            });
        }

    });

});