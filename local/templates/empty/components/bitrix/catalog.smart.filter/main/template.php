<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);
?>
<?
// Кастом фильтр для страницы поиска
if ($arParams['WHITE_LIST']) {
    $data = $arResult["ITEMS"];
    $order = array_flip($arParams['WHITE_LIST']);
    $data = array_intersect_key($data, $order);

    $arResult["ITEMS"] = $data;
}
?>
<form name="<?= $arResult["FILTER_NAME"] . "_form" ?>" action="<?= $arResult["FORM_ACTION"] ?>"
      method="get"
      class="filter">

    <?php foreach ($arResult["HIDDEN"] as $arItem): ?>
        <input type="hidden" name="<?= $arItem["CONTROL_NAME"] ?>" id="<?= $arItem["CONTROL_ID"] ?>"
               value="<?= $arItem["HTML_VALUE"] ?>"/>
    <?php endforeach; ?>

    <? //prices
    foreach ($arResult["ITEMS"] as $key => $arItem) {
        $key = $arItem["ENCODED_ID"];
        if (isset($arItem["PRICE"])):
            if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0) {
                continue;
            }
            ?>

            <div class="filter__item open bx-filter-parameters-box ">
                <span class="bx-filter-container-modef"></span>
                <div class="filter__title open">
                    Цена
                </div>
                <div class="filter__container">
                    <div class="filter__range polzunok-container-5">
                        <div class="filter__range-item">
                            <input placeholder="<?= round($arItem["VALUES"]["MIN"]["VALUE"]) ?>"
                                   class="polzunok-input-5-left"
                                   type="text"
                                   name="<?= $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                   id="<?= $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                   value="<?= $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                   size="5"
                                   onkeyup="smartFilter.keyup(this)"
                            />
                        </div>
                        <div class="filter__range-item">
                            <input placeholder="<?= round($arItem["VALUES"]["MAX"]["VALUE"]) ?>"
                                   class="polzunok-input-5-right"
                                   type="text"
                                   name="<?= $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                   id="<?= $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                   value="<?= $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                   size="5"
                                   onkeyup="smartFilter.keyup(this)"
                            />
                        </div>
                        <div class="bx-ui-slider-track-container">
                            <div class="bx-ui-slider-track" id="drag_track_<?= $key ?>">
                                <div class="bx-ui-slider-pricebar-vd" style="left: 0;right: 0;"
                                     id="colorUnavailableActive_<?= $key ?>"></div>
                                <div class="bx-ui-slider-pricebar-vn" style="left: 0;right: 0;"
                                     id="colorAvailableInactive_<?= $key ?>"></div>
                                <div class="bx-ui-slider-pricebar-v" style="left: 0;right: 0;"
                                     id="colorAvailableActive_<?= $key ?>"></div>
                                <div class="bx-ui-slider-range" id="drag_tracker_<?= $key ?>"
                                     style="left: 0;right: 0;">
                                    <a class="bx-ui-slider-handle left" style="left:0;" href="javascript:void(0)"
                                       id="left_slider_<?= $key ?>"></a>
                                    <a class="bx-ui-slider-handle right" style="right:0;" href="javascript:void(0)"
                                       id="right_slider_<?= $key ?>"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        $arJsParams = array(
            "leftSlider" => 'left_slider_' . $key,
            "rightSlider" => 'right_slider_' . $key,
            "tracker" => "drag_tracker_" . $key,
            "trackerWrap" => "drag_track_" . $key,
            "minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
            "maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
            "minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
            "maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
            "curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
            "curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
            "fltMinPrice" => (int)$arItem["VALUES"]["MIN"]["FILTERED_VALUE"] ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"],
            "fltMaxPrice" => (int)$arItem["VALUES"]["MAX"]["FILTERED_VALUE"] ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
            "colorUnavailableActive" => 'colorUnavailableActive_' . $key,
            "colorAvailableActive" => 'colorAvailableActive_' . $key,
            "colorAvailableInactive" => 'colorAvailableInactive_' . $key,
        );
        ?>
            <script type="text/javascript">
                BX.ready(() => {
                    window['trackBar<?= $key ?>'] = new BX.Iblock.SmartFilter(<?= CUtil::PhpToJSObject($arJsParams) ?>)
                })
            </script>
        <?php
        endif;
    } ?>
    <?
    //not prices
    foreach ($arResult["ITEMS"] as $key => $arItem) {
        $incorrect_values = empty($arItem["VALUES"]) || isset($arItem["PRICE"]);
        $incorrect_type = $arItem["DISPLAY_TYPE"] === "A" && ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0);

        if ($incorrect_values || $incorrect_type) {
            continue;
        }
        $flag = 0;
        ?>
        <?    

   $t=0;
        if(!empty($arParams["ID_DISABLED"])){
            if (in_array($arItem["ID"], $arParams["ID_DISABLED"])){
                $t=1;
            }
        }
             if ($t==0): ?>
            <div class="bx-filter-parameters-box filter__item open">
                <span class="bx-filter-container-modef"></span>
                <div class="filter__title open">
                    <?= str_replace('(КФ для сайта)', '', $arItem["NAME"]) ?>
                </div>
                <div class="filter__container">
                    <div class="<?= count($arItem["VALUES"]) > 5 ? 'filter__group-check ' : '' ?>">
                        <?php
                        $arCur = current($arItem["VALUES"]);
                        foreach ($arItem["VALUES"] as $val => $ar):
                            if ($ar["DISABLED"] && !$ar["CHECKED"]) {
                                continue;
                            }
                            switch ($arItem["DISPLAY_TYPE"]) {
                                case "A":
                                    if ($flag === 1) continue;
                                        $flag = 1;
                                        ?>
                                        <div class="filter__range polzunok-container-5">
                                            <div class="filter__range-item filter__range-item-prop">
                                                <input placeholder="<?= round($arItem["VALUES"]["MIN"]["VALUE"]) ?>"
                                                       class="polzunok-input-5-left"
                                                       type="text"
                                                       name="<?= $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                                       id="<?= $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                                       value="<?= $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                                       size="5"
                                                       onkeyup="smartFilter.keyup(this)"
                                                />
                                            </div>
                                            <div class="filter__range-item filter__range-item-prop">
                                                <input placeholder="<?= round($arItem["VALUES"]["MAX"]["VALUE"]) ?>"
                                                       class="polzunok-input-5-right"
                                                       type="text"
                                                       name="<?= $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                                       id="<?= $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                                       value="<?= $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                                       size="5"
                                                       onkeyup="smartFilter.keyup(this)"
                                                />
                                            </div>
                                            <div class="bx-ui-slider-track-container">
                                                <div class="bx-ui-slider-track" id="drag_track_<?= $key ?>">
                                                    <div class="bx-ui-slider-pricebar-vd" style="left: 0;right: 0;"
                                                         id="colorUnavailableActive_<?= $key ?>"></div>
                                                    <div class="bx-ui-slider-pricebar-vn" style="left: 0;right: 0;"
                                                         id="colorAvailableInactive_<?= $key ?>"></div>
                                                    <div class="bx-ui-slider-pricebar-v" style="left: 0;right: 0;"
                                                         id="colorAvailableActive_<?= $key ?>"></div>
                                                    <div class="bx-ui-slider-range" id="drag_tracker_<?= $key ?>"
                                                         style="left: 0;right: 0;">
                                                        <a class="bx-ui-slider-handle left" style="left:0;" href="javascript:void(0)"
                                                           id="left_slider_<?= $key ?>"></a>
                                                        <a class="bx-ui-slider-handle right" style="right:0;" href="javascript:void(0)"
                                                           id="right_slider_<?= $key ?>"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            <?
                            $arJsParams = array(
                                "leftSlider" => 'left_slider_'.$key,
                                "rightSlider" => 'right_slider_'.$key,
                                "tracker" => "drag_tracker_".$key,
                                "trackerWrap" => "drag_track_".$key,
                                "minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
                                "maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
                                "minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
                                "maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
                                "curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                                "curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                                "fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
                                "fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
                                "precision" => $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0,
                                "colorUnavailableActive" => 'colorUnavailableActive_'.$key,
                                "colorAvailableActive" => 'colorAvailableActive_'.$key,
                                "colorAvailableInactive" => 'colorAvailableInactive_'.$key,
                            );
                            ?>
                                <script type="text/javascript">
                                    BX.ready(function(){
                                        window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
                                    });
                                </script>
                                    <?
                                    break;
                                case "F":
                                        ?>
                                        <div class="filter__check">
                                            <input type="checkbox"
                                                   value="<?= $ar["HTML_VALUE"] ?>"
                                                   name="<?= $ar["CONTROL_NAME"] ?>"
                                                   id="<?= $ar["CONTROL_ID"] ?>"
                                                <?= $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                   onclick="smartFilter.click(this)"
                                                <?= ($ar["DISABLED"] && !$ar["CHECKED"]) ? 'disabled' : '' ?>>
                                            <label data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                   class="bx-filter-param-label <?= $ar["DISABLED"] ? 'disabled' : '' ?>"
                                                   for="<?= $ar["CONTROL_ID"] ?>"
                                                   style="font-weight: normal;">
                                                <?= $ar["VALUE"] ?>
                                            </label>
                                        </div>
                                        <?php
                                    break;
                            } endforeach;
                        foreach ($arItem["VALUES"] as $val => $ar):
                            if (!($ar["DISABLED"] && !$ar["CHECKED"]) || $arItem["DISPLAY_TYPE"] === "A" ) {
                                continue;
                            }
                            ?>
                            <div class="filter__check">
                                <input type="checkbox"
                                       value="<?= $ar["HTML_VALUE"] ?>"
                                       name="<?= $ar["CONTROL_NAME"] ?>"
                                       id="<?= $ar["CONTROL_ID"] ?>"
                                    <?= $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                       onclick="smartFilter.click(this)"
                                    <?= ($ar["DISABLED"] && !$ar["CHECKED"]) ? 'disabled' : '' ?>>
                                <label data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                       class="bx-filter-param-label <?= $ar["DISABLED"] ? 'disabled' : '' ?>"
                                       for="<?= $ar["CONTROL_ID"] ?>" style="font-weight: normal;">
                                    <?= $ar["VALUE"] ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <? endif; ?>
        <?php
    }
    ?>
    <div class="filter__btn">
        <input
                class="button button-black"
                type="submit"
                id="set_filter"
                name="set_filter"
                value="<?= GetMessage("CT_BCSF_SET_FILTER") ?>"
        />
        <input
                class="button button-link"
                type="submit"
                id="del_filter"
                name="del_filter"
                value="<?= GetMessage("CT_BCSF_DEL_FILTER") ?>"
        />
        <div id="modef" style="display: none;"><a href="#" style="display: none;"></a><div id="modef_num" style="display: none;"></div></div>
    </div>
</form>
<script type="text/javascript">
    var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>

<script type="text/javascript">
    (function(){
        // Патч: физическое запрещение пересечения ручек
        var MIN_GAP_PX = 12; // минимальный зазор между центрами ручек в пикселях (подгони при необходимости)

        // helper: центр ручки относительно левого края трека (в px)
        function getHandleCenterPx(handleEl, trackerWrapEl){
            var hRect = handleEl.getBoundingClientRect();
            var tRect = trackerWrapEl.getBoundingClientRect();
            return (hRect.left + hRect.right)/2 - tRect.left;
        }

        // helper: получить координату по событию относительно трека (в px)
        function getEventPosPx(e, trackerWrapEl){
            e = e || window.event;
            var pageX;
            if (e.touches && e.touches[0]) pageX = e.touches[0].pageX;
            else if (e.pageX != null) pageX = e.pageX;
            else pageX = e.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft || 0);

            var tRect = trackerWrapEl.getBoundingClientRect();
            return pageX - tRect.left;
        }

        // Нормализуем и перезапишем обработчики движения для SmartFilter
        if (window.BX && BX.Iblock && BX.Iblock.SmartFilter) {
            var SF = BX.Iblock.SmartFilter;

            // Переопределяем onMoveLeftSlider и onMoveRightSlider, чтобы считать в пикселях и не допускать пересечения
            SF.prototype.onMoveLeftSlider = function(e){
                if (!this.isTouch) {
                    this.leftSlider.ondragstart = function(){ return false; };
                }

                var trackerWrap = this.trackerWrap;
                var self = this;

                var moveFn = function(event){
                    var posPx = getEventPosPx(event, trackerWrap);
                    // центруем по handle (учитываем translateX(-50%))
                    // clamp page px
                    var maxPx = trackerWrap.offsetWidth;
                    if (posPx < 0) posPx = 0;
                    if (posPx > maxPx) posPx = maxPx;

                    // вычисляем текущий центр правой ручки
                    var rightCenter = getHandleCenterPx(self.rightSlider, trackerWrap);

                    // минимально допустимый центр левой ручки
                    var minAllowed = 0;
                    var maxAllowed = Math.max(0, rightCenter - MIN_GAP_PX);

                    // если правой ручки ещё нет (0) — разрешаем всю ширину
                    if (isNaN(rightCenter) || rightCenter === 0) {
                        maxAllowed = maxPx;
                    }

                    // clamp
                    var leftCenter = Math.min(Math.max(posPx, minAllowed), maxAllowed);

                    // превращаем центр в процент (от ширины трека)
                    self.leftPercent = (leftCenter * 100) / trackerWrap.offsetWidth;

                    // применяем отрисовку (и не пересекаемся)
                    self.makeLeftSliderMove();
                };

                var upFn = function(){
                    document.removeEventListener('mousemove', moveFn);
                    document.removeEventListener('touchmove', moveFn);
                    document.removeEventListener('mouseup', upFn);
                    document.removeEventListener('touchend', upFn);
                };

                if (!this.isTouch){
                    document.addEventListener('mousemove', moveFn, {passive:false});
                    document.addEventListener('mouseup', upFn);
                } else {
                    document.addEventListener('touchmove', moveFn, {passive:false});
                    document.addEventListener('touchend', upFn);
                }

                return false;
            };

            SF.prototype.onMoveRightSlider = function(e){
                if (!this.isTouch) {
                    this.rightSlider.ondragstart = function(){ return false; };
                }

                var trackerWrap = this.trackerWrap;
                var self = this;

                var moveFn = function(event){
                    var posPx = getEventPosPx(event, trackerWrap);
                    var maxPx = trackerWrap.offsetWidth;
                    if (posPx < 0) posPx = 0;
                    if (posPx > maxPx) posPx = maxPx;

                    // вычисляем текущий центр левой ручки
                    var leftCenter = getHandleCenterPx(self.leftSlider, trackerWrap);

                    // минимально допустимый центр правой ручки (в пикселях от левого края трека)
                    var minAllowed = Math.min(maxPx, (leftCenter + MIN_GAP_PX));
                    var maxAllowed = maxPx;

                    // Если левой ручки ещё нет — разрешаем всю ширину
                    if (isNaN(leftCenter) || leftCenter === 0) {
                        minAllowed = 0;
                    }

                    // clamp right center
                    var rightCenter = Math.min(Math.max(posPx, minAllowed), maxAllowed);

                    // переводим в процент (rightPercent считается как расстояние от правого края в процентах)
                    // но в нашей реализации мы храним rightPercent как в исходном SmartFilter: percent расстояния от правого края.
                    // проще: вычислим leftPercent из rightCenter и затем rightPercent = 100 - leftPercent при необходимости.
                    var rightPercentFromLeft = (rightCenter * 100) / trackerWrap.offsetWidth;
                    // rightPercent (как в исходном коде) — это процент от правого края, то есть:
                    self.rightPercent = 100 - rightPercentFromLeft;

                    // применяем отрисовку
                    self.makeRightSliderMove();
                };

                var upFn = function(){
                    document.removeEventListener('mousemove', moveFn);
                    document.removeEventListener('touchmove', moveFn);
                    document.removeEventListener('mouseup', upFn);
                    document.removeEventListener('touchend', upFn);
                };

                if (!this.isTouch){
                    document.addEventListener('mousemove', moveFn, {passive:false});
                    document.addEventListener('mouseup', upFn);
                } else {
                    document.addEventListener('touchmove', moveFn, {passive:false});
                    document.addEventListener('touchend', upFn);
                }

                return false;
            };

            // Чтобы отрисовка была более "жесткой", немного укрепляем makeLeft/Right (не трогаем логику fltMin/fltMax)
            var origMakeLeft = SF.prototype.makeLeftSliderMove;
            SF.prototype.makeLeftSliderMove = function(recountPrice){
                // Защита: leftPercent в [0,100]
                this.leftPercent = Math.max(0, Math.min(100, this.leftPercent));
                // Не даём сумме превышать 100
                if (this.leftPercent + this.rightPercent > 100){
                    this.rightPercent = Math.max(0, 100 - this.leftPercent);
                }
                // Вызов оригинальной логики
                origMakeLeft.apply(this, arguments);
            };

            var origMakeRight = SF.prototype.makeRightSliderMove;
            SF.prototype.makeRightSliderMove = function(recountPrice){
                this.rightPercent = Math.max(0, Math.min(100, this.rightPercent));
                if (this.leftPercent + this.rightPercent > 100){
                    this.leftPercent = Math.max(0, 100 - this.rightPercent);
                }
                origMakeRight.apply(this, arguments);
            };

        } // endif SF exists
    })();
</script>
