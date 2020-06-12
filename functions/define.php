
<?php 
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    define('MP_VERSION', '4.1.0');
    define('MP_ROOT_URL', dirname(__FILE__));
    
    define('ON_DEV', false);//ON_DEV, para indicar que estamos en ambiente de prueba.
    
 	define('BASE_URL', 'https://alexdavid2019-mp-ecommerce-php.herokuapp.com/');
 	//define('BASE_URL', 'http://localhost/mp-ecommerce/');

 	define('DIR_DATA', __DIR__ . "/../data/");
 	define('DIR_MP_LOG', __DIR__ . "/../logs/mercadopago/");
 	define('DIR_HOST_LOG', __DIR__ . "/../logs/host/");
 	
?>