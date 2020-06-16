
<?php include 'functions/define.php'; ?>
<?php include 'core/init.php'; ?>
<?php include 'helpers/helper.php'; ?>

<?php include 'inc/MPApi.php'; ?>

<?php 

//Creamos instancia de la Api..
$mercadopago = MPApi::getInstance();

// Check mandatory parameters
if (!isset($_GET["id"], $_GET["topic"]) || !ctype_digit($_GET["id"])) {
    http_response_code(400);
    return;
}

write_json_log(array('id' => $_GET["id"], 'topic' => $_GET["topic"]), DIR_MP_LOG . "notifications-".date('Y-m-d').".json");

if($_GET["topic"] == 'payment')
{
    $payment_info = $mercadopago->getPaymentStandard($_GET["id"]);
    write_json_log($payment_info, DIR_MP_LOG . "PaymentStandard-".$_GET["id"]."-out-".date('Y-m-d').".json");
    
    if (is_array($payment_info) && array_key_exists('order', $payment_info) ) 
    {
        $merchant_order_info = $mercadopago->getMerchantOrder($payment_info["order"]["id"]);
        write_json_log($merchant_order_info, DIR_MP_LOG . "MerchantOrder-".$payment_info["order"]["id"]."-out-".date('Y-m-d').".json");
    }
}
else if($_GET["topic"] == 'merchant_order')
{
    $merchant_order_info = $mercadopago->getMerchantOrder($_GET["id"]);
    write_json_log($merchant_order_info, DIR_MP_LOG . "MerchantOrder-".$_GET["id"]."-out-".date('Y-m-d').".json");
}

if ($merchant_order_info["status"] == 200) {
    $transaction_amount_payments= 0;
    $transaction_amount_order = $merchant_order_info["response"]["total_amount"];
    $payments=$merchant_order_info["response"]["payments"];
    foreach ($payments as  $payment) {
        if($payment['status'] == 'approved'){
            $transaction_amount_payments += $payment['transaction_amount'];
        }
    }
    
    if($transaction_amount_payments >= $transaction_amount_order){
        echo "--------- Todos los Producto/s transaccionados -----------------------";
    }
    else{
        echo "---------- Aun quedan Producto/s sin transaccionar ------------------";
    }
}

?>
