<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/* @var array $metaTags
 * @global CMain $APPLICATION
 */
if (empty($metaTags)) {
    $APPLICATION->SetTitle("Политика конфиденциальности");
    $APPLICATION->SetPageProperty('description', 'Политика конфиденциальности');
}
?>
    <div class="page-top">
        <div class="container">
            <div class="page-top__inner">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:breadcrumb",
                    "main",
                    array(
                        "START_FROM" => "0",
                        "PATH" => "",
                        "SITE_ID" => "s1"
                    )
                );
                ?>
                <h1>
                    <?= !empty($metaTags['TITLE']) ? $metaTags['TILTE'] : 'Политика в отношении обработки и защиты персональных данных Общества с ограниченной ответственностью «КРЕПФИЛД»' ?>
                </h1>
            </div>
        </div>
    </div>
    <div class="policy">
        <div class="container">
            <div class="policy__inner">
                <?= htmlspecialcharsback($GLOBALS["POLICY"]) ?>
            </div>
        </div>
    </div>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");