<?php
$base_price = CCatalogGroup::GetBaseGroup();
$selectedSort = $_COOKIE['catalog-sort'];
if (empty($selectedSort)) {
    $selectedSort = 'popular-desc';
}
switch ($selectedSort) {
    case "popular-asc":
        {
            $sort = array(
                "ELEMENT_SORT_FIELD" => "show_counter",
                "ELEMENT_SORT_ORDER" => "ASC"
            );
        }
        break;
    case "popular-desc":
        {
            $sort = array(
                "ELEMENT_SORT_FIELD" => "show_counter",
                "ELEMENT_SORT_ORDER" => "DESC"
            );
        }
        break;
    case "price-asc":
        {
            $sort = array(
                "ELEMENT_SORT_FIELD" => "catalog_price_" . $base_price["ID"],
                "ELEMENT_SORT_ORDER" => "ASC"
            );
        }
        break;
    case "price-desc":
        {
            $sort = array(
                "ELEMENT_SORT_FIELD" => "catalog_price_" . $base_price["ID"],
                "ELEMENT_SORT_ORDER" => "DESC"
            );
        }
        break;
}
?>
<?php
//foreach ($_COOKIE["countProducts"] as $count){
//    echo $count;
//}

?>
<div class="catalog-page__content-top">
    <div class="catalog-page__content-sorting">
        <div class="catalog-page__content-sorting-title">Сортировать по:</div>
        <ul class="ul-sort">
            <li class="<?= $sort["ELEMENT_SORT_FIELD"] === "show_counter" ? "active " : "" ?>">
                <a href="javascript:void(0);" data-sort="popular-asc">Популярности</a>
                <?= $sort["ELEMENT_SORT_FIELD"] === "show_counter" ? "<img src='/local/templates/empty/assets/images/svg/sort-img.svg'>" : "" ?>
            </li>
            <li class="<?= $sort["ELEMENT_SORT_FIELD"] === "catalog_price_" . $base_price["ID"] ? "active " : "" ?>">
                <a href="javascript:void(0);" data-sort="price-asc">Цене</a>
                <?= $sort["ELEMENT_SORT_FIELD"] === "catalog_price_" . $base_price["ID"] ? "<img src='/local/templates/empty/assets/images/svg/sort-img.svg'>" : "" ?>
            </li>
        </ul>
    </div>

    <div class="catalog-page__content-col">
        <div class="catalog-page__content-col-title">Показывать по:</div>
        <?php
        //        foreach ($_COOKIE["countProducts"] as $count){
        //            echo "<pre>"; var_dump($count); echo "</pre>";
        //        }
        ?>
        <div class="catalog-page__content-col-nb"><?= !empty($_COOKIE["countProducts"]) ? $_COOKIE["countProducts"] : '20' ?>
            <svg>
                <use xlink:href="#arrow2"></use>
            </svg>
        </div>
        <? if (!empty($_COOKIE["countProducts"])): ?>
            <!--            <div class="catalog-page__content-col-row">-->
            <!--                --><? //foreach (explode(' ,',$_COOKIE["othercountProducts"]) as $count):?>
            <!--                    <div class="catalog-page__content-col-row-it">--><?php //=$count?><!--</div>-->
            <!--                --><? //endforeach;?>
            <!--            </div>-->
            <div class="catalog-page__content-col-row">
                <?php if ($_COOKIE["countProducts"] != 20): ?>
                    <div class="catalog-page__content-col-row-it">20</div>
                <?php endif; ?>
                <?php if ($_COOKIE["countProducts"] != 30): ?>
                    <div class="catalog-page__content-col-row-it">30</div>
                <?php endif; ?>
                <?php if ($_COOKIE["countProducts"] != 50): ?>
                    <div class="catalog-page__content-col-row-it">50</div>
                <?php endif; ?>
            </div>
        <? else: ?>
            <div class="catalog-page__content-col-row">
                <div class="catalog-page__content-col-row-it">30</div>
                <div class="catalog-page__content-col-row-it">50</div>
            </div>
        <? endif; ?>
    </div>
</div>

<script type="application/javascript">
    'use strict'
    $(() => {
        $('a[data-sort]').click((e) => {
            console.log(BX.getCookie('catalog-sort'));
            if (BX.getCookie('catalog-sort') === 'price-asc') {
                BX.setCookie('catalog-sort', 'price-desc', {
                    expires: 3600 * 24,
                    path: '/'
                });
            } else if (BX.getCookie('catalog-sort') === 'popular-asc') {
                BX.setCookie('catalog-sort', 'popular-desc', {
                    expires: 3600 * 24,
                    path: '/'
                });
            } else {
                BX.setCookie('catalog-sort', e.currentTarget.dataset.sort, {
                    expires: 3600 * 24,
                    path: '/'
                });
            }
            location.reload();
        });
    })
</script>