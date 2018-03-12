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
 
IncludeModuleLangFile(__FILE__);
CModule::IncludeModule('sale');

class privatbank_paymentparts extends CModule
{
    var $MODULE_ID = 'privatbank.paymentparts';
    var $MODULE_GROUP_RIGHTS = 'N';

    var $PARTNER_NAME;
    var $PARTNER_URI;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;

    public function __construct()
    {
    	require(dirname(__FILE__).'/version.php');

        $this->PARTNER_NAME = 'PrivatBank';
        $this->PARTNER_URI = 'https://payparts2.privatbank.ua/';
        $this->MODULE_ID;
    	$this->MODULE_NAME = GetMessage('PP_MODULE_NAME');
        $this->MODULE_DESCRIPTION = GetMessage('PP_MODULE_DESC');
        $this->MODULE_VERSION = PAY_PARTS_VERSION;
        $this->MODULE_VERSION_DATE = PAY_PARTS_VERSION_DATE;
    }

    public function privatbank_paymentparts()
    {
    	$this->PARTNER_URI;
        $this->MODULE_ID;
    	$this->MODULE_VERSION = PAY_PARTS_VERSION; 
    	$this->MODULE_VERSION_DATE = PAY_PARTS_VERSION_DATE; 
    	$this->MODULE_NAME = GetMessage("PP_MODULE_NAME"); 
    	$this->MODULE_DESCRIPTION = GetMessage("PP_MODULE_DESC");

    }
    public function DoInstall()
    {
    	if (IsModuleInstalled('sale')) {
            global $APPLICATION;
            $this->InstallFiles();
            RegisterModule($this->MODULE_ID);
            return true;
        }
        $TAG = 'VWS';
        $MESSAGE = GetMessage('PP_ERR_MODULE_NOT_FOUND', array('#MODULE#'=>'sale'));
        $intID = CAdminNotify::Add(compact('MODULE_ID', 'TAG', 'MESSAGE'));

        return false;
    }

    public function DoUninstall()
    {
        global $APPLICATION;
        COption::RemoveOption($this->MODULE_ID);
        UnRegisterModule($this->MODULE_ID);
        $this->UnInstallFiles();
    }

    public function InstallFiles()
    {
        CopyDirFiles(
            $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.$this->MODULE_ID.'/install/sale_payment',
            $_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/include/sale_payment',
            true, true
        );
    }

    public function UnInstallFiles()
    {
        return DeleteDirFilesEx($_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/include/sale_payment/'.$this->MODULE_ID);
    }
}
