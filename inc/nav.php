<?php include 'helpers/helper.php'; ?>

<?php


$json = DIR_DATA . "products.json";
$str_data = file_get_contents($json);
$productsBase = json_decode($str_data,true);

//by default-- show all products
$products = $productsBase;
if (setGet('search') && !empty(get('search'))) {
	$categoryName = get('search');
	$arrFiltred = array(); 
	foreach ($productsBase as $item_prod){
         if ($item_prod['Category'] == $categoryName){
			 	array_push($arrFiltred, $item_prod);
		 }
	}	
	if (!empty($arrFiltred)){
		$products = $arrFiltred;
	}
}

	foreach ($products as $item_prod):
         $item_id = $item_prod['Id'];
?>
<div class="as-producttile large-4 small-6 group-1">
		<div class="as-producttile-tilehero with-paddlenav with-paddlenav-onhover">
			<div class="as-dummy-container as-dummy-img">
				<img src="<?= ucfirst($item_prod['Image'] )  ;?>" 
					class="ir ir item-image as-producttile-image  " alt="" width="445" height="445">
			</div>
			<div class="images mini-gallery gal1 ">
				<ul class="clearfix as-producttile-nojs">
					<li class="as-searchtile-nojs">
						<img src="<?= ucfirst($item_prod['Image'] )  ;?>" 
							class="ir relatedlink item-image as-producttile-image" alt="" width="445" height="445" 
							data-scale-params-2="wid=890&amp;hei=890&amp;fmt=jpeg&amp;qlt=95&amp;op_usm=0.5,0.5&amp;.v=1502831144597">
					</li>
				</ul>
				<div class="as-isdesktop with-paddlenav with-paddlenav-onhover">
					<div class="clearfix image-list xs-no-js as-util-relatedlink relatedlink">
						<div class="as-tilegallery-element as-image-selected">
							<div class=""></div>
							<img src="<?= ucfirst($item_prod['Image'] )  ;?>" 
								class="ir ir item-image as-producttile-image" alt="" 
								data-desc="<?= ucfirst($item_prod['Description'] )  ;?>" 
								style="content:-webkit-image-set(url(<?= ucfirst($item_prod['Image'] )  ;?>">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="as-producttile-info" style="min-height: 168px;">
			<div class="as-producttile-titlepricewraper" style="min-height: 128px;">
				<div class="as-producttile-title">
					<h3 class="as-producttile-name">
						<p class="as-producttile-tilelink">
							<span data-ase-truncate="2"><?= ucfirst($item_prod['Description'] )  ;?></span>
						</p>

					</h3>
				</div>
				<div class="as-price-currentprice as-producttile-currentprice">
					<?= formatDollars($item_prod['Price'] ) ;?>
				</div>
			</div>
			<form action="<?= BASE_URL  ;?>/detail.php" method="get">
				<input type="hidden" name="productId" value="<?= ucfirst($item_prod['Id'] )  ;?>">
				<input type="hidden" name="img" value="<?= ucfirst($item_prod['Image'] )  ;?>">
				<input type="hidden" name="title" value="<?= ucfirst($item_prod['Description'] )  ;?>">
				<input type="hidden" name="price" value="<?= ucfirst($item_prod['Price'] )  ;?>">
				<input type="hidden" name="unit" value="<?= ucfirst($item_prod['UnitDefault'] )  ;?>">
				<button type="submit" class="mercadopago-button" formmethod="post">Comprar</button>
			</form>
		</div>
</div>
<?php endforeach ?>
