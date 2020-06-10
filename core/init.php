
<?php
session_start();

$cart_id  = '';
if(isset($_COOKIE[MY_COOKIE])){
    //this COOKIE is define in define.php page
     //id comes from databse but in this case this code goes to the add_cart.php
     $cart_id = (int)$_COOKIE[MY_COOKIE];
}
 
//session_destroy();

