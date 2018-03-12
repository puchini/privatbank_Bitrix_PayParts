<?php
/**
 * PayParts Payment Module
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category        PayParts
 * @package         pay.parts
 * @version         0.0.1
 * @author          PayParts
 * @copyright       Copyright (c) 2015 PayParts
 * @license         http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 * EXTENSION INFORMATION
 *
 * 1C-Bitrix        15.0
 * PAYPARTS API       https://payparts2.privatbank.ua/ipp/
 *
 */
 
global $MESS;
$MESS['PP_MERCHANT_TYPE'] = 'Тип кредита';
$MESS['PP_MERCHANT_TYPE_DESC'] = 'PP - Оплата частями<br />II - Мгновенная рассрочка<br />Если хотите использовать обе системы оставьте поле пустым.';
$MESS['PP_PARTS_COUNT_OC'] = 'Максимальное количество платежей по Оплате частями';
$MESS['PP_PARTS_COUNT_OC_DESC'] = '(Для заключения кредитного договора)<br />Должно быть > 2.';
$MESS['PP_PARTS_COUNT_MP'] = 'Максимальное количество платежей по Мгновенной рассрочке';
$MESS['PP_PARTS_COUNT_MP_DESC'] = '(Для заключения кредитного договора)<br />Должно быть > 2.';
$MESS['SCOM_INSTALL_NAME'] = 'Платежная система Оплата частями';
$MESS['PP_MODULE_NAME'] = 'Платежная система "Оплата частями"';
$MESS['PP_MODULE_DESC'] = 'Обработчик для платежной системы "Оплата частями"';
$MESS['PP_PUBLIC_KEY'] = 'Количество частей платежа';
$MESS['PP_PUBLIC_KEY_DESC'] = 'Введите поддерживаемое количество частей платежа.';
$MESS['PP_AMOUNT'] = 'Сумма для списания при оплате в магазине';
$MESS['PP_CURRENCY'] = 'Валюта платежа';
$MESS['PP_ORDER_ID'] = 'Уникальный ID покупки в Вашем магазине';
$MESS['PP_DELIVERY_ID'] = 'Уникальный ID службы доставки в Вашем магазине';
$MESS['PP_RESULT_URL'] = 'URL на который будет переадресация после покупки';
$MESS['PP_RESULT_URL_DESC'] = '(этот параметр можно указать единоразово в настройках магазина)';
$MESS['PP_SERVER_URL'] = 'URL API для уведомлений о статусе покупки';
$MESS['PP_SERVER_URL_DESC'] = '(этот параметр можно указать единоразово в настройках магазина)';
$MESS['PP_TYPE'] = 'Тип оплаты';
$MESS['PP_TYPE_DESC'] = '(<b>buy</b> - покупка, <b>donate</b> - пожертвование)';
$MESS['PP_STORE_ID'] = 'Идентификатор магазина';
$MESS['PP_STORE_ID_DESC'] = '(<a target="_blank" href="https://payparts2.privatbank.ua/ipp/">получить идентификатор магазина</a>)';
$MESS['PP_PASSWD_NAME'] = 'Пароль магазина';
$MESS['PP_PASSWD_DESC'] = '(<a target="_blank" href="https://payparts2.privatbank.ua/ipp/">получить пароль магазина</a>)';
$MESS['PP_ACTION_SEND'] = 'URL для получения токена';
$MESS['PP_ACTION_SEND_DESC'] = '(атрибут action для отправки запроса)';
$MESS['PP_ACTION'] = 'URL для отправки формы';
$MESS['PP_ACTION_DESC'] = '(атрибут action формы для приёма платежей)';
$MESS['PP_REDIRECT_URL'] = 'URL для редиректа';
$MESS['PP_REDIRECT_URL_DESC'] = '(URL для редиректа с страницы платежной системы)';