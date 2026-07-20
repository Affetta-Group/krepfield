$(document).ready(function(){
    function affetta_init_tags() {

        const affetta_tags = document.getElementsByClassName("affetta-tags");
        if (affetta_tags) {
            for (const affetta_tag of affetta_tags) {
                if(window.innerWidth > 767) {
                    let affetta_tmp_width = 0;
                    let affetta_error_scale = 200;

                    let affetta_container_width = affetta_tag.getElementsByClassName("affetta-tags__wrapper")[0].offsetWidth;
                    let affetta_tags_items = affetta_tag.getElementsByTagName('a');
                    affetta_container_width -= affetta_error_scale;

                    for (const element of affetta_tags_items) {
                        let affetta_tag_width = element.offsetWidth;

                        affetta_tmp_width += affetta_tag_width;
                        if (affetta_tmp_width >= affetta_container_width) {
                            element.classList.add('hidable');
                            element.classList.add('hide');
                        }
                    }

                    const affetta_btn_show_more = affetta_tag.getElementsByClassName("affetta-tags__show-more")[0];
                    affetta_btn_show_more.style.display = 'block';

                    const listener = function () {
                        for (const element of affetta_tags_items) {
                            if (element.classList.contains('hidable')) {
                                element.classList.toggle('hide');
                            }
                        }
                        affetta_btn_show_more.getElementsByClassName("affetta_tags_arrow")[0].classList.toggle("active");
                    }

                    affetta_btn_show_more.removeEventListener('click', listener)
                    affetta_btn_show_more.addEventListener("click", listener)

                    let affetta_tags__list = affetta_tag.getElementsByClassName("affetta-tags__list")[0];
                    affetta_tags__list.style.display = 'block';
                    affetta_tags__list.style.overflow = 'unset';
                } else {
                    let affetta_btn_show_more = affetta_tag.getElementsByClassName("affetta-tags__show-more");
                    affetta_btn_show_more[0].style.display = 'none';

                    let affetta_tags__list = affetta_tag.getElementsByClassName("affetta-tags__list");
                    affetta_tags__list[0].style.display = 'flex';
                    affetta_tags__list[0].style.gap = '5px';
                    affetta_tags__list[0].style.overflow = 'scroll';
                    let affetta_tags_items = affetta_tag.getElementsByTagName('a');
                    for (const element of affetta_tags_items) {
                        element.classList.remove('hide');
                    }
                }
            }
        }
    }
    affetta_init_tags();
    window.onresize = affetta_init_tags;
});