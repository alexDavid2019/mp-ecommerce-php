<?php include 'inc/MPApi.php'; ?>
<?php 

//Creamos instancia de la Api..
$mercadopago = MPApi::getInstance();

//creamos una transaccion aleatorea para identificar el proceso.
$externalReference = "TX-".generateRandomString();
//$externalReference =  $mercadopago->getExternalReferenceDefault();

$notification_url = BASE_URL. "/ipnTest.php";

//inicializamos preferencias por defecto..
 $preference = array(
    'external_reference' => $externalReference,
    'notification_url' => $notification_url,
    'statement_descriptor' => strip_tags("Dispositivo movil de Tienda e-commerce")
);

//no permitir pagos con American Express ( amex ) ni tampoco cajero automático ( atm ).
$excluded_payment_methods = array( array('id' => "amex") );
$excluded_payment_types = array( array('id' => "atm") ) ;
/* *excluyo tipos de pago rapipago, transf bancaria, atm*
$excluded_payment_types = array(    
                            array("id"=>"ticket"),  
                            array("id"=>"bank_transfer"), 
                            array("id"=>"atm")	); */

//invocamos la lectura de todos los metodos disponibles en la Api..
//$payment_methods = $mercadopago->getPaymentMethods();

//Indicamos que el max de cuotas es de 6 : getInstallmentsDefault()
$payment_options = array(
    'installments' => 1,/*(integer) $mercadopago->getInstallmentsDefault(),*/
    'excluded_payment_types' => $excluded_payment_types,
    'excluded_payment_methods' => $excluded_payment_methods
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
            "currency_id" =>  $mercadopago->getCurrentCurrency(),
            'picture_url' => $pathImage,
            'description' => strip_tags($_POST['title']),
            "unit_price" => (float) round($_POST['price'],2)
     )
);

$jsonFile = DIR_DATA . "pagador-ARS.json";
if ($mercadopago->getCurrentCurrency() != "ARS"){
    $jsonFile = DIR_DATA . "pagador-MEX.json";
}

$str_data = file_get_contents($jsonFile);
$pagador = json_decode($str_data,true);

//Cargamos los datos del pagador

$payer_items = array(
    "email" => $pagador["Email"],   //EMAIL DEL USUARIO COMPRADOR GENERADO POR MP
    "name" => $pagador["FirstName"],
    "surname" => $pagador["LastName"],
    "date_created" => date('Y-m-d', strtotime( $pagador["date_created"] ) ) ,
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

$preference['operation_type'] = "regular_payment";
                                //regular_payment:  Pago regular.
                                //money_transfer: Solicitud de dinero.

$today = date('Y-m-d');

$date_next = strtotime('+1 day', strtotime($today));
$date_next = date('Y-m-d', $date_next);

$date_past = strtotime('-1 day', strtotime($today));
$date_past = date('Y-m-d', $date_past);

$preference['items'] = $cart_items;
//$preference['payer'] = $payer_items;
$preference['back_urls'] = $urls_options;
$preference['payment_methods'] = $payment_options;
$preference['auto_return'] = "approved";
//$preference['expires'] = true;                      //Preferencia que determina si una preferencia expira.
//$preference['expiration_date_from'] = $date_past;   //Fecha a partir de la cual la preferencia estará activa.
//$preference['expiration_date_to'] = $date_next;     //Fecha en la que la preferencia expirará.

//Enviar los datos al API de Mercado Pago para la generación del link
write_json_log($preference, DIR_MP_LOG . "createPreference-".$externalReference."-input.json");
$preference_saved = $mercadopago->createPreference($preference);
write_json_log($preference_saved, DIR_MP_LOG . "createPreference-".$externalReference."-output.json");

$preference_id = "";
$preference_point = "";


if (is_array($preference_saved) && array_key_exists('init_point', $preference_saved) ) {
    $preference_id = $preference_saved['id'];
    $preference_notify=$preference_saved['notification_url'];
    $preference_point=$preference_saved['init_point'];
    /*
    $preference_saved = $mercadopago->getPreferenciesById($preference_id);
    write_json_log($preference_saved, DIR_MP_LOG . "SearchPreferenceById-".$preference_id."-out-".date('Y-m-d').".json");
        
    $preference_search = $mercadopago->searchPreferencies($preference_saved['collector_id']);
    write_json_log($preference_search, DIR_MP_LOG . "SearchAllPreferencesBy-".$preference_saved['collector_id']."-out-".date('Y-m-d').".json");
    */
}
else if (is_array($preference_saved) && array_key_exists('sandbox_init_point', $preference_saved)) {
    $preference_id = $preference_saved['id'];
    $preference_notify=$preference_saved['notification_url'];
    $preference_point=$preference_saved['sandbox_init_point'];
    /*
    $preference_saved = $mercadopago->getPreferenciesById($preference_id);
    write_json_log($preference_saved, DIR_MP_LOG . "SearchPreferenceById-".$preference_id."-out-".date('Y-m-d').".json");
    
    $preference_search = $mercadopago->searchPreferencies($preference_saved['collector_id']);
    write_json_log($preference_search, DIR_MP_LOG . "SearchAllPreferencesBy-".$preference_saved['collector_id']."-out-".date('Y-m-d').".json");
    */
} 

?>
