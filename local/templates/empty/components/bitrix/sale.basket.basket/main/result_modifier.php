<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (isset($_POST["BasketClear"]) && CModule::IncludeModule("sale"))
{
    CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
    header("Location: ".$_SERVER['REQUEST_URI']);
}