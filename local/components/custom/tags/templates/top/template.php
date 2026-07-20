<?php
global $USER;
if ($arResult["AF_BANNER"] && $arResult["AF_BANNER_LINK"]):
    ?>
    <div class="banner-container banner-container__small">
        <a href="<?= $arResult["AF_BANNER_LINK"] ?>">
            <img src="<?= $arResult["AF_BANNER"] ?>" alt="">
        </a>
    </div>
<?php elseif ($arResult["AF_BANNER"]): ?>
    <div class="banner-container banner-container__small" style="position:relative;">
        <img src="<?= $arResult["AF_BANNER"] ?>" alt="">
    </div>
<?php endif; ?>
<?php if($arResult['AF_TAGS'][$arParams['DISPLAY_TYPE']]): ?>
<div class="affetta-tags affetta-tags__top">
    <div class="affetta-tags__wrapper">
        <div class="affetta-tags__list" style="display: block; overflow: unset;">
            <?= $arResult['AF_TAGS'][$arParams['DISPLAY_TYPE']] ?>
        </div>
        <div class="affetta-tags__show-more" style="display: block;">Еще
            <svg class="affetta_tags_arrow">
                <use xlink:href="#arrow"></use>
            </svg>
        </div>
    </div>
</div>
<?php endif; ?>