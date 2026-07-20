<? if ($arParams['BASKET_POSITION'] === 'after'): ?>
    <!--	BASKET ITEMS BLOCK	-->
    <div id="bx-soa-basket" data-visited="false" class="bx-soa-section bx-active">
        <div class="bx-soa-section-title-container d-flex justify-content-between align-items-center flex-nowrap">
            <div class="bx-soa-section-title" data-entity="section-title">
                <span class="bx-soa-section-title-count"></span><?= $arParams['MESS_BASKET_BLOCK_NAME'] ?>
            </div>
            <div><a href="javascript:void(0)"
                    class="bx-soa-editstep"><?= $arParams['MESS_EDIT'] ?></a></div>
        </div>
        <div class="bx-soa-section-content"></div>
    </div>
<? endif ?>