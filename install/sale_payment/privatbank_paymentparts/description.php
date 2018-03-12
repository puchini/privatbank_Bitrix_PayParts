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
 
 if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); }

 include(GetLangFileName(dirname(__FILE__).'/', '/.description.php'));

$psTitle = GetMessage('PP_MODULE_NAME');
$psDescription = GetMessage('PP_MODULE_DESC');

$arPSCorrespondence = array(
	'MERCHANT_TYPE' => array(
		'NAME'  => GetMessage('PP_MERCHANT_TYPE'),
		'DESCR' => GetMessage('PP_MERCHANT_TYPE_DESC'),
		'VALUE' => '',
		'TYPE'  => ''
	),
	'PARTS_COUNT_OC' => array(
		'NAME'  => GetMessage('PP_PARTS_COUNT_OC'),
		'DESCR' => GetMessage('PP_PARTS_COUNT_OC_DESC'),
		'VALUE' => '24',
		'TYPE'  => ''
	),
	'PARTS_COUNT_MP' => array(
		'NAME'  => GetMessage('PP_PARTS_COUNT_MP'),
		'DESCR' => GetMessage('PP_PARTS_COUNT_MP_DESC'),
		'VALUE' => '24',
		'TYPE'  => ''
	),
	'STORE_ID' => array(
		'NAME'  => GetMessage('PP_STORE_ID'),
		'DESCR' => GetMessage('PP_STORE_ID_DESC'),
		'VALUE' => '',
		'TYPE'  => ''
	),
	'STORE_PASSWD' => array(
		'NAME' 	=> GetMessage('PP_PASSWD_NAME'),
		'DESCR' => GetMessage('PP_PASSWD_DESCR'),
		'VALUE' => '',
		'TYPE' => ''
	),
	'AMOUNT' => array(
		'NAME'  => GetMessage('PP_AMOUNT'),
		'DESCR' => '',
		'VALUE' => 'SHOULD_PAY',
		'TYPE'  => 'ORDER'
	),
	'CURRENCY' => array(
		'NAME'  => GetMessage('PP_CURRENCY'),
		'DESCR' => '',
		'VALUE' => 'CURRENCY',
		'TYPE'  => 'ORDER'
	),
	'ORDER_ID' => array(
		'NAME'  => GetMessage('PP_ORDER_ID'),
		'DESCR' => '',
		'VALUE' => 'ID',
		'TYPE'  => 'ORDER'
	),
	'DELIVERY_ID' => array(
		'NAME'  => GetMessage('PP_DELIVERY_ID'),
		'DESCR' => '',
		'VALUE' => 'DELIVERY_ID',
		'TYPE'  => 'ORDER'
	),
	'RESULT_URL' => array(
		'NAME'  => GetMessage('PP_RESULT_URL'),
		'DESCR' => GetMessage('PP_RESULT_URL_DESC'),
		'VALUE' => 'http://'.$_SERVER['HTTP_HOST'].'/personal/order/',
		'TYPE'  => ''
	),
	'REDIRECT_URL' => array(
		'NAME'  => GetMessage('PP_REDIRECT_URL'),
		'DESCR' => GetMessage('PP_REDIRECT_URL_DESC'),
		'VALUE' => 'http://'.$_SERVER['HTTP_HOST'],
		'TYPE'  => ''
	),
	'ACTION_CREATE' => array(
		'NAME'  => GetMessage('PP_ACTION_SEND'),
		'DESCR' => GetMessage('PP_ACTION_SEND_DESC'),
		'VALUE' => 'https://payparts2.privatbank.ua/ipp/v2/payment/create',
		'TYPE'  => ''
	),
	'ACTION_SEND' => array(
		'NAME'  => GetMessage('PP_ACTION'),
		'DESCR' => GetMessage('PP_ACTION_DESC'),
		'VALUE' => 'https://payparts2.privatbank.ua/ipp/v2/payment',
		'TYPE'  => ''
	)
);

