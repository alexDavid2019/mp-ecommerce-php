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

function generateRandomString($length = 8) {
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
};

function write_json_log($content, $file){
    	
	try {
		file_fix_directory(dirname($file));

		if (gettype($content) == 'string') {
			$json = json_encode(array('data' => json_decode($content, true)), JSON_PRETTY_PRINT);
			if (file_put_contents($file, $json)) {
				return true;
			}
		} else {
			$json = json_encode(array('data' => $content), JSON_PRETTY_PRINT);
			if (file_put_contents($file, $json)) {
				return true;
			}
		}
		return false;
	} catch (Exception $e) {
		write_general_log($content, $file);
	}
}


function write_general_log($content, $file){
    	
	try {
		$general = dirname($file) . "general.log";

		file_fix_directory(dirname($general));

		if (gettype($content) == 'string') {
			$json = json_encode(array('file' => $file, 'data' => json_decode($content, true)), JSON_PRETTY_PRINT);
			error_log($json);

			if (file_put_contents($general, $json)) {
				return true;
			}
		} else {
			$json = json_encode(array('file' => $file, 'data' => $content), JSON_PRETTY_PRINT);
			error_log($json);
			
			if (file_put_contents($general, $json)) {
				return true;
			}
		}
		return false;
	} catch (Exception $e) {
		echo($e->getMessage);
	}
}

function file_fix_directory($dir, $nomask = array('.', '..')) {
  if (is_dir($dir)) {
     // Try to make each directory world writable.
     if (@chmod($dir, 0777)) {
       //echo "<p>Made writable: " . $dir . "</p>";
     }
  }
  if (is_dir($dir) && $handle = opendir($dir)) {
    while (false !== ($file = readdir($handle))) {
      if (!in_array($file, $nomask) && $file[0] != '.') {
        if (is_dir("$dir/$file")) {
          // Recurse into subdirectories
          file_fix_directory("$dir/$file", $nomask);
        }
        else {
          $filename = "$dir/$file";
            // Try to make each file world writable.
            if (@chmod($filename, 0666)) {
              //echo "<p>Made writable: " . $filename . "</p>";
            }
        }
      }
    }
    closedir($handle);
  }
}

function rel2abs($rel, $base)
{
    if(strpos($rel,"//")===0)
    {
        return "http:".$rel;
    }
    /* return if  already absolute URL */
    if  (parse_url($rel, PHP_URL_SCHEME) != '') return $rel;
    /* queries and  anchors */
    if ($rel[0]=='#'  || $rel[0]=='?') return $base.$rel;
    /* parse base URL  and convert to local variables:
     $scheme, $host,  $path */
    extract(parse_url($base));
    /* remove  non-directory element from path */
    $path = preg_replace('#/[^/]*$#',  '', $path);
    /* destroy path if  relative url points to root */
    if ($rel[0] ==  '/') $path = '';
    /* dirty absolute  URL */
    $abs =  "$host$path/$rel";
    /* replace '//' or  '/./' or '/foo/../' with '/' */
    $re =  array('#(/.?/)#', '#/(?!..)[^/]+/../#');
    for($n=1; $n>0;  $abs=preg_replace($re, '/', $abs, -1, $n)) {}
    /* absolute URL is  ready! */
    return  $scheme.'://'.$abs;
}

?>
