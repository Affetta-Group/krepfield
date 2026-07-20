<?

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Localization\Loc;

$metaTags = getMetaTags();
if (!empty($metaTags)){
    $APPLICATION->SetTitle($metaTags['META_TITLE']);
    $APPLICATION->SetPageProperty('description', $metaTags['META_DESCRIPTION']);
} else {
    $APPLICATION->SetTitle('Личные данные');
    $APPLICATION->SetPageProperty('description', 'Личные данные');
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
			<h1>Личные данные</h1>
		</div>
	</div>
</div>
<div class="orders">
	<div class="container">
		<div class="orders__inner">
			<div class="orders__left tw">
				<div class="orders__lkp">
                    <? if (CModule::IncludeModule("affettapromo"))
                        $userPromo = Bitrix\Affettapromo\Utils::getUserPromoStatus();
//                        rdd($userPromo);
                        if($userPromo){
                            ?>
                            <div class="affetta-personal-status">
                                <div class="affetta-personal-status__item">
                                    <div class="affetta-personal-status__item-icon">
                                        <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/svg/sprite.svg#procent"></use></svg>
                                    </div>
                                    <div class="affetta-personal-status__item-label">Процент кэшбека</div>
                                    <div class="affetta-personal-status__item-value"><?=$userPromo['UF_PROMO_MULTI']?>%</div>
                                </div>
                                <div class="affetta-personal-status__item">
                                    <div class="affetta-personal-status__item-icon">
                                        <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/svg/sprite.svg#gift"></use></svg>
                                    </div>
                                    <div class="affetta-personal-status__item-label">Ваши баллы</div>
                                    <div class="affetta-personal-status__item-value"><?=$userPromo['UF_PROMO_CASH']?> баллов</div>
                                </div>
                                <div class="affetta-personal-status__item">
                                    <div class="affetta-personal-status__item-icon">
                                        <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/images/svg/sprite.svg#cubok"></use></svg>
                                    </div>
                                    <div class="affetta-personal-status__item-label">Ваш статус</div>
                                    <div class="affetta-personal-status__item-value"><?=$userPromo['UF_PROMO_TYPE']?></div>
                                </div>
                            </div>
                            <?
                        }
                    ?>
					<form method="post" name="form1" action="<?= POST_FORM_ACTION_URI ?>"
						  enctype="multipart/form-data" role="form">
						<?php ShowError($arResult["strProfileError"]); ?>
						<?= $arResult["BX_SESSION_CHECK"] ?>
						<input type="hidden" name="lang" value="<?= LANG ?>"/>
						<input type="hidden" name="ID" value="<?= $arResult["ID"] ?>"/>
						<input type="hidden" name="LOGIN" value="<?= $arResult["arUser"]["LOGIN"] ?>"/>
						<div class="orders__lkp-inner">
							<div class="orders__lkp-form">
								<div class="row">
									<div class="col-xl-6 col-lg-6 col-md-6">
										<div class="orders__lkp-cell">
											<label>Имя</label>
											<input placeholder="Имя" type="text" name="NAME" maxlength="50"
												   id="main-profile-name"
												   value="<?= $arResult["arUser"]["NAME"] ?>">
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6">
										<div class="orders__lkp-cell">
											<label>Отчество</label>
											<input placeholder="Отчество" type="text" name="SECOND_NAME" maxlength="50"
												   id="main-profile-second-name"
												   value="<?= $arResult["arUser"]["SECOND_NAME"] ?>">
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6">
										<div class="orders__lkp-cell">
											<label>Фамилия</label>
											<input placeholder="Фамилия" type="text" name="LAST_NAME" maxlength="50"
												   id="main-profile-last-name"
												   value="<?= $arResult["arUser"]["LAST_NAME"] ?>">
										</div>
									</div>
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="orders__lkp-cell">
                                            <label>Город</label>
                                            <input placeholder="Город" type="text" name="PERSONAL_CITY" maxlength="50"
                                                   id="city"
                                                   value="<?= $arResult["arUser"]["PERSONAL_CITY"] ?>">
                                        </div>
                                    </div>
                                </div>
							</div>
						</div>
						<div class="orders__lkp-inner">
							<div class="orders__lkp-form">
								<div class="row">
									<div class="col-xl-6 col-lg-6 col-md-6">
										<div class="orders__lkp-cell">
											<label>Телефон</label>
											<input class="phone-mask" placeholder="Телефон" type="tel"
												   name="PERSONAL_PHONE" maxlength="50"
												   id="main-profile-personal-phone"
												   value="<?= $arResult["arUser"]["PERSONAL_PHONE"] ?>">
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6">
										<div class="orders__lkp-cell">
											<label>Электронная почта</label>
											<input type="email" placeholder="Email" type="email" name="EMAIL"
												   maxlength="50"
												   id="main-profile-email"
												   value="<?= $arResult["arUser"]["EMAIL"] ?>">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="orders__lkp-btn">
							<input type="submit" class="button button-black" name="save"
								   value="Сохранить">
							<input type="submit" class="button button-link" name="reset"
								   value="Сбросить">
						</div>
					</form>
				</div>
			</div>
			<? $APPLICATION->IncludeComponent(
				"bitrix:menu",
				"personal",
				array(
					"ROOT_MENU_TYPE" => "personal",
					"MAX_LEVEL" => "1",
					"CHILD_MENU_TYPE" => "top",
					"USE_EXT" => "Y",
					"DELAY" => "N",
					"ALLOW_MULTI_SELECT" => "Y",
					"MENU_CACHE_TYPE" => "N",
					"MENU_CACHE_TIME" => "3600",
					"MENU_CACHE_USE_GROUPS" => "N",
					"MENU_CACHE_GET_VARS" => ""
				)
			); ?>
		</div>
	</div>
</div>