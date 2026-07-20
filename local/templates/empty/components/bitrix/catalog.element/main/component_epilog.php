<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

/**
 * @var array $templateData
 * @var array $arParams
 * @var string $templateFolder
 * @global CMain $APPLICATION
 * @global array $arResult
 */

global $APPLICATION;

if (isset($templateData['TEMPLATE_THEME']))
{
	$APPLICATION->SetAdditionalCSS($templateFolder.'/themes/'.$templateData['TEMPLATE_THEME'].'/style.css');
	$APPLICATION->SetAdditionalCSS('/bitrix/css/main/themes/'.$templateData['TEMPLATE_THEME'].'/style.css', true);
}

if (!empty($templateData['TEMPLATE_LIBRARY']))
{
	$loadCurrency = false;

	if (!empty($templateData['CURRENCIES']))
	{
		$loadCurrency = Loader::includeModule('currency');
	}

	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);
	if ($loadCurrency)
	{
		?>
		<script>
			BX.Currency.setCurrencies(<?=$templateData['CURRENCIES']?>);
		</script>
		<?
	}
}

if (isset($templateData['JS_OBJ']))
{
	?>
	<script>
		BX.ready(BX.defer(function(){
			if (!!window.<?=$templateData['JS_OBJ']?>)
			{
				window.<?=$templateData['JS_OBJ']?>.allowViewedCount(true);
			}
		}));
	</script>

	<?
	// check compared state
	if ($arParams['DISPLAY_COMPARE'])
	{
		$compared = false;
		$comparedIds = array();
		$item = $templateData['ITEM'];

		if (!empty($_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']]))
		{
			if (!empty($item['JS_OFFERS']))
			{
				foreach ($item['JS_OFFERS'] as $key => $offer)
				{
					if (array_key_exists($offer['ID'], $_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']]['ITEMS']))
					{
						if ($key == $item['OFFERS_SELECTED'])
						{
							$compared = true;
						}

						$comparedIds[] = $offer['ID'];
					}
				}
			}
			elseif (array_key_exists($item['ID'], $_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']]['ITEMS']))
			{
				$compared = true;
			}
		}

		if ($templateData['JS_OBJ'])
		{
			?>
			<script>
				BX.ready(BX.defer(function(){
					if (!!window.<?=$templateData['JS_OBJ']?>)
					{
						window.<?=$templateData['JS_OBJ']?>.setCompared('<?=$compared?>');

						<? if (!empty($comparedIds)): ?>
						window.<?=$templateData['JS_OBJ']?>.setCompareInfo(<?=CUtil::PhpToJSObject($comparedIds, false, true)?>);
						<? endif ?>
					}
				}));
			</script>
			<?
		}
	}

	// select target offer
	$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();
	$offerNum = false;
	$offerId = (int)$this->request->get('OFFER_ID');
	$offerCode = $this->request->get('OFFER_CODE');

	if ($offerId > 0 && !empty($templateData['OFFER_IDS']) && is_array($templateData['OFFER_IDS']))
	{
		$offerNum = array_search($offerId, $templateData['OFFER_IDS']);
	}
	elseif (!empty($offerCode) && !empty($templateData['OFFER_CODES']) && is_array($templateData['OFFER_CODES']))
	{
		$offerNum = array_search($offerCode, $templateData['OFFER_CODES']);
	}

	if (!empty($offerNum))
	{
		?>
		<script>
			BX.ready(function(){
				if (!!window.<?=$templateData['JS_OBJ']?>)
				{
					window.<?=$templateData['JS_OBJ']?>.setOffer(<?=$offerNum?>);
				}
			});
		</script>
		<?
	}
}

for ($i = 2; $i < count($arResult['SECTION']['PATH']); $i++) {
    $chainSection = $arResult['SECTION']['PATH'][$i];
    $APPLICATION->AddChainItem($chainSection['NAME'], $chainSection['SECTION_PAGE_URL']);
}
$APPLICATION->AddChainItem($arResult['NAME']);

$metaTags = $arResult['META_TAGS'];
if (!empty($metaTags['BROWSER_TITLE'])) {
    $APPLICATION->SetTitle($metaTags['BROWSER_TITLE']);
} else {
    $APPLICATION->SetTitle($arResult['NAME']);
}

$APPLICATION->SetPageProperty("h1",$arResult['NAME']);
if (!empty($metaTags['DESCRIPTION'])) {
    $APPLICATION->SetPageProperty('description', $metaTags['DESCRIPTION']);
}

$arSelect = array("ID", "NAME", "PROPERTY_KF_DLYA_SAYTA_NAIMENOVANIE");
$arFilter = array("ID" => $arResult['ID']);
$res = CIBlockElement::GetList(array("SORT"=>"ASC"), $arFilter, false, array("nPageSize" => 1, 'iNumPage' => 1), $arSelect);
if ($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();
	if(!empty($arFields['PROPERTY_KF_DLYA_SAYTA_NAIMENOVANIE_VALUE']))
		$APPLICATION->SetPageProperty('h1',$arFields['PROPERTY_KF_DLYA_SAYTA_NAIMENOVANIE_VALUE']);
}

$arFavorites = json_decode($_COOKIE["favorites"]);

foreach ($arFavorites as $k => $favoriteItem):?>
    <script>
        if ($('.cart-product__about-inf-fav[data-id="<?=$favoriteItem?>"]'))
            $('.cart-product__about-inf-fav[data-id="<?=$favoriteItem?>"]').addClass('active');
            $('.cart-product__about-inf-fav[data-id="<?=$favoriteItem?>"] span').html('В избранном');
    </script>
<?
endforeach; ?>