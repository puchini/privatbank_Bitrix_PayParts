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
    include(GetLangFileName(dirname(__FILE__).'/', '/payment.php'));

    $order_id = (strlen(CSalePaySystemAction::GetParamValue('ORDER_ID')) > 0)
        ? CSalePaySystemAction::GetParamValue('ORDER_ID')
        : $GLOBALS['SALE_INPUT_PARAMS']['ORDER']['ID'];
    $amount = (strlen(CSalePaySystemAction::GetParamValue('AMOUNT')) > 0)
        ? number_format((float)CSalePaySystemAction::GetParamValue('AMOUNT'), 2, '.', '')
        : $GLOBALS['SALE_INPUT_PARAMS']['ORDER']['SHOULD_PAY'];

    $currency = (strlen(CSalePaySystemAction::GetParamValue('CURRENCY')) > 0)
        ? CSalePaySystemAction::GetParamValue('CURRENCY')
        : $GLOBALS['SALE_INPUT_PARAMS']['ORDER']['CURRENCY'];

    $result_url      = CSalePaySystemAction::GetParamValue('RESULT_URL');
    $store_id        = CSalePaySystemAction::GetParamValue('STORE_ID');
    $store_passwd    = CSalePaySystemAction::GetParamValue('STORE_PASSWD');
    $parts_och       = CSalePaySystemAction::GetParamValue('PARTS_COUNT_OC');
    $parts_mr        = CSalePaySystemAction::GetParamValue('PARTS_COUNT_MP');
    $merchantType    = CSalePaySystemAction::GetParamValue('MERCHANT_TYPE');
    $get_token_url   = CSalePaySystemAction::GetParamValue('ACTION_CREATE');
    $send_url        = CSalePaySystemAction::GetParamValue('ACTION_SEND');
    $redirectUrl     = CSalePaySystemAction::GetParamValue('REDIRECT_URL');
    $type            = 'buy';
    $language        = LANGUAGE_ID;
    $order_id_unique = $order_id;
    $version         = '3';
    $partsCount      = '2';
    $action          = $APPLICATION->GetCurUri();
    $responseUrl     = "http://". $_SERVER["HTTP_HOST"] . $action;
    $signature       = '';
    $orders_sales    = array();
    $price_finder    = 0;

    $db_sales = CSaleBasket::GetList(array("ORDER_ID" => "ASC"), Array("USER_ID" => $USER->GetID(), "ORDER_ID" => $order_id));
    while ($ar_sales = $db_sales->Fetch())
    {
        $NAME_ORDER_FROM_DB = trim($ar_sales['NAME'], " ");
        if(LANG_CHARSET == 'windows-1251')
        {
            $NAME_ORDER_FROM_DB = iconv('cp1251', 'utf8', (string)$NAME_ORDER_FROM_DB);
        }
        $orders_sales[] = array(
            'name' => $NAME_ORDER_FROM_DB,
            'price' => (string)number_format((float)$ar_sales['PRICE'], 2, '.', ''),
            'count' => (int)$ar_sales['QUANTITY']
        );
        if($ar_sales['QUANTITY'] > 1)
        {
            $price_finder += (float)$ar_sales['PRICE'] * (int)$ar_sales['QUANTITY'];
        }
        else
        {
            $price_finder += (float)$ar_sales['PRICE'];
        }
    }
    $delivery_finely = (float)$amount - (float)$price_finder;
    if($delivery_finely > 0)
    {
        $delivery_name = GetMessage('DELIVERY_PAY_MESSAGE');
        if(LANG_CHARSET == 'windows-1251')
        {
             $delivery_name = iconv('cp1251', 'utf8', (string)$delivery_name);
        }
        $orders_sales[] = array(
            'name' => $delivery_name,
                'price' => (string)number_format((float)$delivery_finely, 2, '.', ''),
                'count' => 1
                );
    }
    if ($currency == 'RUR'){ $currency = 'RUB'; }
    if ($_POST['partsCount']){ $partsCount = $_POST['partsCount']; }
    if ($_POST['merchant']){ $merchantType = $_POST['merchant']; }

    $products_string = "";
    for ($i=0; $i<count($orders_sales);$i++)
    {
        $products_string .= $orders_sales[$i]['name']
            .(string)$orders_sales[$i]['count']
            .str_replace('.', '', $orders_sales[$i]['price']);
    }
    if (isset($store_id)){
        $signature = base64_encode(
            hex2bin(
                SHA1( $store_passwd
                    .$store_id
                    .$order_id_unique
                    .str_replace('.', '', $amount)
                    .$currency
                    .$partsCount
                    .$merchantType
                    .$responseUrl
                    .$redirectUrl
                    .$products_string
                    .$store_passwd
                )
            )
        );
    }
    $requestData = json_encode(
        array(
            "storeId"      => $store_id,
            "orderId"      => $order_id_unique,
            "amount"       => $amount,
            "currency"     => $currency,
            "partsCount"   => $partsCount,
            "merchantType" => $merchantType,
            "products"     => $orders_sales,
            "responseUrl"  => $responseUrl,
            "redirectUrl"  => $redirectUrl,
            "signature"    => $signature
        )
    );

    if ($_POST['submit'] == 'send') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $get_token_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Accept-Encoding: UTF-8',
            'Content-Type: application/json; charset=UTF-8'
        ));
        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        if ($response->state == 'FAIL')
        {
            echo '<span style="color: red;">'.$response->errorMessage."</span><br /><br />";
            echo '<span style="color: red;">'.$response->message."</span><br /><br />";
        }
        if ($response->state == 'SUCCESS'){
            header("Location: ".$send_url."?token=".$response->token);
        }
    }
?>
<?=GetMessage('PAYMENT_DESCRIPTION_PS')?> <b><?=GetMessage('PAYMENT_NAME')?></b>.<br /><br />
<?=GetMessage('PAYMENT_DESCRIPTION_SUM')?>: <b><?=CurrencyFormat($amount, $currency)?></b><br /><br />
<div id="selectServiceTypeContainer">
    <p><?=GetMessage('PAYMENT_TYPE')?></p>
    <input id="ochId" type="button" value="<?=GetMessage('PAYMENT_SUB_NAME_OPERATION_PP')?>"/>
    <input id="mrId" type="button" value="<?=GetMessage('PAYMENT_SUB_NAME_OPERATION_II')?>"/>
</div>
<div id="payPP" style="display: none;">
    <form method="POST" action="<?=$action?>" accept-charset="utf-8">
        <p><?=GetMessage('PAYMENT_SUB_NAME_OPERATION_PP').GetMessage('PP_OPERATION_CHECK_PERIOD')?>  
            <select id="month-sel" name="partsCount">
                <option disabled><?=GetMessage('CHECK_PERIOD_VALUE_IN_SELECT')?></option>
                <option selected value="2">2</option>
                <?for ($i=0;$i < $parts_och+1; $i++){
                    if($i > 2){
                        echo '<option value='.$i.'>'.$i.'</option>';
                    } else
                    {
                        continue;
                    }
                }?>
        </select></p>
        <input type="hidden" name="merchant" value="PP" />
        <input type="hidden" name="submit" value="send" />
        <input type="submit" value="<?=GetMessage('CHECK_PERIOD_FORM_PAY')?>" />
    </form>
</div>
<div id="payII" style="display: none;">
    <form method="POST" action="<?=$action?>" accept-charset="utf-8">
        <p><?=GetMessage('PAYMENT_SUB_NAME_OPERATION_II').GetMessage('PP_OPERATION_CHECK_PERIOD')?>  
            <select id="month-selII" name="partsCount">
                <option disabled><?=GetMessage('CHECK_PERIOD_VALUE_IN_SELECT')?></option>
                <option selected value="2">2</option>
                <?for ($i=0;$i < $parts_mr+1; $i++){
                    if($i > 2){
                        echo '<option value='.$i.'>'.$i.'</option>';
                    } else
                    {
                        continue;
                    }
                }?>
            </select></p>
        <input type="hidden" name="merchant" value="II" />
        <input type="hidden" name="submit" value="send" />
        <input type="submit" value="<?=GetMessage('CHECK_PERIOD_FORM_PAY')?>" />
    </form>
</div>
<script>
var merchant_type = '<?=$merchantType ?>';

    if(merchant_type == 'PP' || merchant_type == 'II'){
        document.getElementById('selectServiceTypeContainer').style.display = 'none';
        document.getElementById('pay'+merchant_type).style.display = 'block';
    }
    else {
        document.getElementById('ochId').onclick = callOch;
        document.getElementById('mrId').onclick = callMr;
    }
    function callOch() {
        if (document.getElementById("payPP").style.display == "none") {
            document.getElementById("mrId").style.color = "black";
            document.getElementById("ochId").style.color = "green";
            document.getElementById("payPP").style.display = "block";
            document.getElementById("payII").style.display = "none";
        } else {
            document.getElementById("ochId").style.color = "black";
            document.getElementById("payPP").style.display = "none";
        }
    };
    function callMr() {
        if (document.getElementById("payII").style.display == "none") {
            document.getElementById("ochId").style.color = "black";
            document.getElementById("mrId").style.color = "green";
            document.getElementById("payII").style.display = "block";
            document.getElementById("payPP").style.display = "none";
        } else {
            document.getElementById("mrId").style.color = "black";
            document.getElementById("payII").style.display = "none";
        }
    };
</script>
