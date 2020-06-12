<?php include 'inc/MPApi.php'; ?>
<?php 

//creamos una transaccion aleatorea para identificar el proceso.
$transaccionID = "TX-".generateRandomString();

$notification_url = BASE_URL. "/notify.php";

//inicializamos preferencias por defecto..
$preference = array(
    'external_reference' => $transaccionID,
    'notification_url' => $notification_url,
    'statement_descriptor' => strip_tags("Dispositivo movil de Tienda e-commerce"),
);


//no permitir pagos con American Express ( amex ) ni tampoco cajero automático ( atm ).
$excluded_payment_methods = array( array('id' => "amex") );
$excluded_payment_types = array( array('id' => "atm") ) ;
/*$excluded_payment_types = array(    *excluyo tipos de pago rapipago, transf bancaria, atm*
                            array("id"=>"ticket"),  
                            array("id"=>"bank_transfer"), 
                            array("id"=>"atm")	); */
//Creamos instancia de la Api..
$mercadopago = MPApi::getInstance();
//invocamos la lectura de todos los metodos disponibles en la Api..
/*
$payment_methods = $mercadopago->getPaymentMethods();

foreach ($payment_methods as $payment_method) {
    if ($payment_method['id'] == "amex") {
        $excluded_payment_methods[] = array(
            'id' => $payment_method['id'],
        );
    }
}
*/

//Indicamos que el max de cuotas es de 6 : getInstallmentsDefault()
$payment_options = array(
    'installments' => (integer) $mercadopago->getInstallmentsDefault(),
    //'default_payment_method_id' => "visa", // método de pago por default
    'excluded_payment_types' => $excluded_payment_types,
    'excluded_payment_methods' => $excluded_payment_methods,
    'default_payment_method_id' => null,
    'default_installments' => null
);

$urls_options = array(
    "success"=> BASE_URL.'/transaccion_exitosa.php',
    "pending" => BASE_URL.'/transaccion_pendiente.php',
    "failure"=> BASE_URL.'/transaccion_erronea.php'
);

$pathImage = $_POST['img'];

if ( (substr($pathImage, 0, 7) != "http://") && (substr($pathImage, 0, 8) != "https://"))
{
    $pathImage = rel2abs($_POST['img'],BASE_URL);
}

// Tipos de monedas: https://api.mercadopago.com/currencies
//Cargamos la info del producto en seleccion...
$cart_items = array(
        array(
            'id' => $_POST['productId'],
            "title" => strip_tags($_POST['title']),
            "quantity" => (double)$_POST['unit'],
            "currency_id" => "MXN",
            'picture_url' => $pathImage,
            'description' => strip_tags($_POST['title']),
            "unit_price" => (float) round($_POST['price'],2)
        )
);


$json = DIR_DATA . "pagador.json";
$str_data = file_get_contents($json);
$pagador = json_decode($str_data,true);
//Cargamos los datos del pagador


$payer_items = array(
    "name" => $pagador["FirstName"],
    "surname" => $pagador["LastName"],
    "email" => $pagador["Email"],   //EMAIL DEL USUARIO COMPRADOR GENERADO POR MP
    "date_created" => date('Y-m-d', strtotime( $pagador["date_created"] )) . "T" . date('H:i:s',strtotime( $pagador["date_created"] )),
    "phone" => array(
        "area_code" => $pagador["Area"],
        "number" => $pagador["Phone"]
    ),
    'identification' => array(
        'type' => '',
        'number' => '',
    ),
    "address" => array(
        "street_name" => $pagador["Address"],
        "street_number" => $pagador["Number"],
        "zip_code" => $pagador["cp"]
    )
);

$preference['client_id'] = "6718728269189792"; //VENDEDOR
$preference['collector_id'] = 491494389; //VENDEDOR
$preference['operation_type'] = "regular_payment";
                                //regular_payment:  Pago regular.
                                //money_transfer: Solicitud de dinero.

$nday = time() + ( 24 * 60 * 60);
$today = date('Y-m-d');
$nextday = date('Y-m-d',$nday);

$date_past = strtotime('-1 day', strtotime($today));
$date_past = date('Y-m-d', $date_past);

$preference['items'] = $cart_items;
$preference['payer'] = $payer_items;
//$preference['shipments'] = array('mode' => 'not_specified');
$preference['back_urls'] = $urls_options;
$preference['payment_methods'] = $payment_options;
$preference['auto_return'] = "all"; //"approved";
//$preference['binary_mode'] = false;
$preference['expires'] = false;                 //Preferencia que determina si una preferencia expira.
//$preference['expiration_date_from'] = $date_past;   //Fecha a partir de la cual la preferencia estará activa.
//$preference['expiration_date_to'] = $nextday;   //Fecha en la que la preferencia expirará.
$preference['metadata'] = array("checkout"=> "smart", "checkout_type" => "redirect");

//Enviar los datos al API de Mercado Pago para la generación del link
write_json_log($preference, DIR_MP_LOG . "input-".$transaccionID.".json");
$preference_saved = $mercadopago->createPreference($preference);
write_json_log($preference_saved, DIR_MP_LOG . "output-".$transaccionID.".json");

$preference_id = "";
$preference_point = "";

$preference_search = $mercadopago->searchPreferencies($preference['collector_id']);
write_json_log($preference_search, DIR_MP_LOG . "search-".$preference['collector_id']."-".date('Y-m-d').".json");

if (is_array($preference_saved) && array_key_exists('init_point', $preference_saved) && ON_DEV == false) {
    $preference_id = $preference_saved['id'];
    $preference_notify=$preference_saved['notification_url'];
    $preference_point=$preference_saved['init_point'];
    
    write_json_log(array('notification_url' => $preference_notify,'init_point' => $preference_point), DIR_MP_LOG . "input-".$preference_id.".json");
    $preference_saved = $mercadopago->getPreferenciesById($preference_id);
    write_json_log($preference_saved, DIR_MP_LOG . "output-".$preference_id.".json");

    $preference_id = $preference_saved['id'];
    $preference_notify=$preference_saved['notification_url'];
    $preference_point=$preference_saved['sandbox_init_point'];
}
else if (is_array($preference_saved) && array_key_exists('sandbox_init_point', $preference_saved)) {
    $preference_id = $preference_saved['id'];
    $preference_notify=$preference_saved['notification_url'];
    $preference_point=$preference_saved['sandbox_init_point'];
    
    write_json_log(array('notification_url' => $preference_notify,'init_point' => $preference_point), DIR_MP_LOG . "input-".$preference_id.".json");
    $preference_saved = $mercadopago->getPreferenciesById($preference_id);
    write_json_log($preference_saved, DIR_MP_LOG . "output-".$preference_id.".json");
    
    $preference_id = $preference_saved['id'];
    $preference_notify=$preference_saved['notification_url'];
    $preference_point=$preference_saved['sandbox_init_point'];
} 

?>
