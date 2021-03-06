
<?php include 'functions/define.php'; ?>
<?php include 'core/init.php'; ?>
<?php include 'helpers/helper.php'; ?>

<?php include 'inc/MPApi.php'; ?>

<?php 

//Creamos instancia de la Api..
$mercadopago = MPApi::getInstance();

$id = '';
$type = '';

foreach($_GET as $key=>$value){
    if (strpos($key, 'id') !== false) {
        $id = $value;
    }
    if (strpos($key, 'type') !== false) {
        $type = $value;
    }    
}

// Check mandatory parameters
if ( empty($id) || empty($type) ) {
    echo "---------- Argumentos no validos ------------------<br/>";
    http_response_code(400);
    return;
}

write_json_log(array('id' => $id, 'type' => $type), DIR_MP_LOG . "ipnTest-".date('Y-m-d').".json");

if($type == 'payment')
{
    $payment_info = $mercadopago->getPaymentStandard($id);
    write_json_log($payment_info, DIR_MP_LOG . "ipnTest-PaymentStandard-".$id."-out-".date('Y-m-d').".json");
    
    if (is_array($payment_info) && array_key_exists('order', $payment_info) ) 
    {
        $merchant_order_info = $mercadopago->getMerchantOrder($payment_info["order"]["id"]);
        write_json_log($merchant_order_info, DIR_MP_LOG . "ipnTest-MerchantOrder-".$payment_info["order"]["id"]."-out-".date('Y-m-d').".json");
    
        echo "---------- Orden de pago recibido correctamente ------------------";
    }
    else {
        echo "--------- Notificado del pago no valida -----------------------";
    }
}
else if($type == 'merchant_order')
{
    $merchant_order_info = $mercadopago->getMerchantOrder($id);
    write_json_log($merchant_order_info, DIR_MP_LOG . "ipnTest-MerchantOrder-".$id."-out-".date('Y-m-d').".json");

    echo "---------- Orden de pago recibido correctamente ------------------";
}
else {
    echo "---------- Notificacion no valida ------------------";
}

?>
