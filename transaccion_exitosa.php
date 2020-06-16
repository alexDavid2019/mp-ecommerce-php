<?php include 'functions/define.php'; ?>
<?php include 'core/init.php'; ?>
<?php include 'helpers/helper.php'; ?>

<!-- =============header.php========== -->
     <?php include_once ('inc/header.php'); ?>
<!-- =============./header.php========== -->

    <div class="stack">
	
        <div class="as-search-wrapper" role="main">
			<!-- =============title.php========== -->
				 <?php include_once ('inc/title.php'); ?>
			<!-- =============./title.php========== -->

            <div class="as-search-results as-filter-open as-category-landing as-desktop" id="as-search-results">

                <div id="accessories-tab" class="as-accessories-details">
                    <div class="as-accessories" id="as-accessories">
                        <div class="as-accessories-header">
                            <div class="as-search-results-count">
                                <span class="as-search-results-value"></span>
                            </div>
                        </div>
                        <div class="as-searchnav-placeholder" style="height: 77px;">
                            <div class="row as-search-navbar" id="as-search-navbar" style="width: auto;">
                                <div class="as-accessories-filter-tile column large-6 small-3">
                                    <button class="as-filter-button" aria-expanded="true" aria-controls="as-search-filters" type="button">
                                        <h2 class=" as-filter-button-text">
                                            Smartphones
                                        </h2>
                                    </button>
                                </div>
                            </div>
                        </div>

<?php include 'inc/MPApi.php'; ?>
<?php 
//Creamos instancia de la Api..
$mercadopago = MPApi::getInstance();

write_json_log(array('collection_id' => $_GET["collection_id"], 
                        'collection_status' => $_GET["collection_status"],
                        'external_reference' => $_GET["external_reference"],
                        'payment_type' => $_GET["payment_type"],
                        'merchant_order_id' => $_GET["merchant_order_id"],
                        'preference_id' => $_GET["preference_id"],
                        'site_id' => $_GET["site_id"],
                        'processing_mode' => $_GET["processing_mode"]), DIR_MP_LOG . "transac-exitosas-".date('Y-m-d').".json");

$payment_info = $mercadopago->getPaymentStandard($_GET["collection_id"]);
write_json_log($payment_info, DIR_MP_LOG . "PaymentStandard-".$_GET["collection_id"]."-out-".date('Y-m-d').".json");

$merchant_order_info = $mercadopago->getMerchantOrder($_GET["merchant_order_id"]);
write_json_log($merchant_order_info, DIR_MP_LOG . "MerchantOrder-".$_GET["merchant_order_id"]."-out-".date('Y-m-d').".json");

$preference_saved = $mercadopago->getPreferenciesById($_GET["preference_id"]);
write_json_log($preference_saved, DIR_MP_LOG . "SearchPreferenceById-".$_GET["preference_id"]."-out-".date('Y-m-d').".json");

foreach ($merchant_order_info["items"] as $item_prod):
?>
                        <div class="as-accessories-results  as-search-desktop">
                            <div class="width:60%;max-width: 60%;">
                                <div class="as-producttile-tilehero with-paddlenav " 
                                		style="float:left;max-width: 60%;">
                                    <div class="as-dummy-container as-dummy-img">
                                        <img src="<?php echo $item_prod['picture_url'] ?>" 
                                        	class="ir ir item-image as-producttile-image  " 
										style="max-width: 70%;max-height: 70%;"alt="" 
											width="445" height="445">
                                    </div>
                                    <div class="images mini-gallery gal5 ">
                                        <div class="as-isdesktop with-paddlenav with-paddlenav-onhover">
                                            <div class="clearfix image-list xs-no-js as-util-relatedlink relatedlink">
                                                <div class="as-tilegallery-element as-image-selected">
                                                    <div class=""></div>
                                                    <img src="<?php echo $item_prod['picture_url'] ?>" 
                                                    		class="ir ir item-image as-producttile-image" 
													alt="" width="445" height="445" 
													style="content:-webkit-image-set(url(<?php echo $item_prod['picture_url'] ?>) 2x);">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="as-producttile-info" style="float:left;min-height: 168px;">
                                        <div class="as-producttile-titlepricewraper">
                                            <h4>
                                                <span>Descripcion: </span><?php echo $item_prod['title'] ?>
                                            </h4>
                                            <h4>
                                                <span>Precio final: </span><?php echo formatDollars($item_prod['unit_price']) ?>
                                            </h4>
                                            <h4>
                                                <span>Cantidad: </span><?php echo $item_prod['quantity'] ?>
                                            </h4>
                                        </div>
                                </div>
                                <div class="as-producttile-info" style="float:left;min-height: 168px;">
                                        <div class="as-producttile-titlepricewraper">
                    						<h3 style="color:green;">Transaccion Exitosa</h3>
                    						<hr/>
                                            <h4>
                                                <span>Status: </span><?php echo $payment_info['status'] ?>
                                            </h4>
                                            <h4>
                                                <span>Status detail: </span><?php echo $payment_info['status_detail'] ?>
                                            </h4>
                                            <h4>
                                                <span>Total: </span><?php echo formatDollars( $payment_info['transaction_amount']) ?>
                                            </h4>
                                        </div>
                                </div>
                                <div class="as-producttile-info" style="float:left;">
                                        <div class="as-producttile-titlepricewraper">
                                        	<h4>
                                        		<span>Informacion recibida.</span>
                                        	</h4>
                                            <h4>
                                                <span>payment_id: </span><?php echo $_GET["collection_id"] ?>
                                            </h4>
                                            <h4>
                                                <span>external_reference : </span><?php echo $_GET["external_reference"]  ?>
                                            </h4>
                                            <h4>
                                                <span>payment_type: </span><?php echo $_GET['payment_type'] ?>
                                            </h4>
                                        </div>
                                </div>
                            </div>
                        </div>
<?php endforeach ?>
                        
                    </div>
                </div>
            </div>
        </div>
		
        <div role="alert" class="as-loader-text ally" aria-live="assertive"></div>
        
</div>

<!-- =============footer.php========== -->
	<?php include('inc/footer.php') ?>
<!-- =============./footer.php========== -->
