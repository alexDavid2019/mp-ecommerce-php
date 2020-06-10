<?php

function pretty_date($date){
    return date("M d, Y h:i A",  strtotime($date));
    //A is for am pm
}

function sanitize($dirty){
    return htmlspecialchars($dirty,ENT_QUOTES,"utf-8");
}

function post($posted_value){
    $posted_check  = sanitize($posted_value);
    $check_post = $_POST[$posted_check];
    return $check_post;
}

function get($get_value){
    $posted_value  = sanitize($get_value);
    $check_get = $_GET[$posted_value];
    return $check_get;

}

function setPost($posted_value){
    $posted_check = sanitize( $posted_value);
    $check_post = isset($_POST[$posted_check]);
    return $check_post ;

}

function setGet($get_value){
    $posted_value = sanitize($get_value);
    $check_get = isset($_GET[$posted_value]);
    return  $check_get;

}

function setGetEqual($get_value,$check_value){
    //if(isset($_GET['get_value']) && ($_GET['get_value']=='check_value'))
      $get =  sanitize($get_value);
      $check =  sanitize($check_value);
      $value =(isset($_GET[$get]) && ($_GET[$get]==$check));
      return $value;


}

function setPostEqual($post_value,$check_value){
    //if(isset($_POST['post_value']) && ($_POST['post_value']=='check_value'))
      $post =  sanitize($post_value);
      $check =  sanitize($check_value);
      $value =(isset($_POST[$post]) && ($_POST[$post]==$check));
      return $value;
}

function formatDollars($dollars)
{
    $formatted = "$" . number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $dollars)), 2);
    return $dollars < 0 ? "({$formatted})" : "{$formatted}";
}

?>
