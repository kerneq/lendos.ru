<?php
/**
 * Created by PhpStorm.
 * User: maha
 * Date: 26.08.17
 * Time: 10:32
 */
// 1.
// Оплата заданной суммы с выбором валюты на сайте мерчанта
// Payment of the set sum with a choice of currency on merchant site

// регистрационная информация (логин, пароль #1)
// registration info (login, password #1)
$mrh_login = "lendosme";
$mrh_pass1 = "a1EH0K5FXTUfOfK5asP3";

// номер заказа
// number of order
$inv_id = 0;

// описание заказа
// order description
$inv_desc = "Вы успешно оплатили свой заказ, во вкладке заказ вы его увидите";

// сумма заказа
// sum of order
$out_summ = "350";

// тип товара
// code of goods
$shp_item = 1;

// предлагаемая валюта платежа
// default payment e-currency
$in_curr = "";

// язык
// language
$culture = "ru";

// кодировка
// encoding
$encoding = "utf-8";

// формирование подписи
// generate signature
$crc  = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item");

// HTML-страница с кассой
// ROBOKASSA HTML-page
/*print "<html><script language=JavaScript ".
    "src='https://auth.robokassa.ru/Merchant/PaymentForm/FormFLS.js?".
    "MrchLogin=$mrh_login&OutSum=$out_summ&InvId=$inv_id&IncCurrLabel=$in_curr".
    "&Desc=$inv_desc&SignatureValue=$crc&Shp_item=$shp_item".
    "&Culture=$culture&Encoding=$encoding&IsTest=1'></script></html>";
*/

?>