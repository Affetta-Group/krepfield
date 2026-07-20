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


$INPUT_ID = trim($arParams["~INPUT_ID"]);
if ($INPUT_ID === '') {
    $INPUT_ID = "title-search-input";
}

$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if ($CONTAINER_ID === '') {
    $CONTAINER_ID = "title-search";
}

$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);

if ($arParams["SHOW_INPUT"] !== "N"): ?>
<div class="header__search" id="<?= $CONTAINER_ID ?>" itemscope itemtype="//schema.org/WebSite">
    <meta itemprop="url" content="//krepfield.ru"/>
    <div id="search_root" style="display: none"></div>
    <form action="<?= $arResult["FORM_ACTION"] ?>" itemprop="potentialAction" itemscope itemtype="//schema.org/SearchAction">
    <meta itemprop="target" content="//krepfield.ru/search/?q={query}"/>
    <input type="text" id="<?= $INPUT_ID ?>" name="q" placeholder="Поиск" itemprop="query-input" maxlength="255">
    <button class="button header__search-btn" type="submit">
        <svg>
            <use xlink:href="#search"></use>
        </svg>
    </button>
    </form>
</div>
<?php endif; ?>
<script>
    BX.ready(function () {
        new JCTitleSearch({
            'AJAX_PAGE': '<?= CUtil::JSEscape(POST_FORM_ACTION_URI)?>',
            'CONTAINER_ID': '<?= $CONTAINER_ID?>',
            'INPUT_ID': '<?= $INPUT_ID?>',
            'MIN_QUERY_LEN': 2
        });
    });
</script>