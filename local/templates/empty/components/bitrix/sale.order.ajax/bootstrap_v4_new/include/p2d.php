<? if ($arParams['DELIVERY_TO_PAYSYSTEM'] === 'p2d'): ?>
    <!--	PAY SYSTEMS BLOCK	-->
    <div id="bx-soa-paysystem" data-visited="false" class="bx-soa-section bx-active">
        <div class="bx-soa-section-title-container d-flex justify-content-between align-items-center flex-nowrap">
            <div class="bx-soa-section-title" data-entity="section-title">
                <span class="bx-soa-section-title-count"></span><?= $arParams['MESS_PAYMENT_BLOCK_NAME'] ?>
            </div>
            <div><a href="" class="bx-soa-editstep change"><?= $arParams['MESS_EDIT'] ?></a></div>
        </div>
        <div class="bx-soa-section-content"></div>
    </div>
    <!--	DELIVERY BLOCK	-->
    <div id="bx-soa-delivery" data-visited="false"
         class="bx-soa-section bx-active" <?= ($hideDelivery ? 'style="display:none"' : '') ?>>
        <div class="bx-soa-section-title-container d-flex justify-content-between align-items-center flex-nowrap">
            <div class="bx-soa-section-title" data-entity="section-title">
                <span class="bx-soa-section-title-count"></span><?= $arParams['MESS_DELIVERY_BLOCK_NAME'] ?>
            </div>
            <div><a href="" class="bx-soa-editstep change"><?= $arParams['MESS_EDIT'] ?></a></div>
        </div>
        <div class="bx-soa-section-content"></div>
    </div>
    <!--	PICKUP BLOCK	-->
    <div id="bx-soa-pickup" data-visited="false" class="bx-soa-section" style="display:none">
        <div class="bx-soa-section-title-container d-flex justify-content-between align-items-center flex-nowrap">
            <div class="bx-soa-section-title" data-entity="section-title">
                <span class="bx-soa-section-title-count"></span>
            </div>
            <div><a href="" class="bx-soa-editstep"><?= $arParams['MESS_EDIT'] ?></a></div>
        </div>
        <div class="bx-soa-section-content"></div>
    </div>
<? else: ?>
    <!--	DELIVERY BLOCK	-->
    <div id="bx-soa-delivery" data-visited="false"
         class="bx-soa-section bx-active" <?= ($hideDelivery ? 'style="display:none"' : '') ?>>
        <div class="bx-soa-section-title-container d-flex justify-content-between align-items-center flex-nowrap">
            <div class="bx-soa-section-title" data-entity="section-title">
                <span class="bx-soa-section-title-count"></span><?= $arParams['MESS_DELIVERY_BLOCK_NAME'] ?>
            </div>
            <div><a href="" class="bx-soa-editstep"><?= $arParams['MESS_EDIT'] ?></a></div>
        </div>
        <div class="bx-soa-section-content"></div>
    </div>
    <!--	PICKUP BLOCK	-->
    <div id="bx-soa-pickup" data-visited="false" class="bx-soa-section" style="display:none">
        <div class="bx-soa-section-title-container d-flex justify-content-between align-items-center flex-nowrap">
            <div class="bx-soa-section-title" data-entity="section-title">
                <span class="bx-soa-section-title-count"></span>
            </div>
            <div><a href="" class="bx-soa-editstep"><?= $arParams['MESS_EDIT'] ?></a></div>
        </div>
        <div class="bx-soa-section-content"></div>
    </div>
    <!--	PAY SYSTEMS BLOCK	-->
    <div id="bx-soa-paysystem" data-visited="false" class="bx-soa-section bx-active">
        <div class="bx-soa-section-title-container d-flex justify-content-between align-items-center flex-nowrap">
            <div class="bx-soa-section-title" data-entity="section-title">
                <span class="bx-soa-section-title-count"></span><?= $arParams['MESS_PAYMENT_BLOCK_NAME'] ?>
            </div>
            <div><a href="" class="bx-soa-editstep"><?= $arParams['MESS_EDIT'] ?></a></div>
        </div>
        <div class="bx-soa-section-content"></div>
    </div>
<? endif ?>