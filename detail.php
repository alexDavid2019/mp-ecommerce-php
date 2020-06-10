
<?php include 'functions/define.php'; ?>
<?php include 'core/init.php'; ?>

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

                        <div class="as-accessories-results  as-search-desktop">
                            <div class="width:60%">
                                <div class="as-producttile-tilehero with-paddlenav " style="float:left;">
                                    <div class="as-dummy-container as-dummy-img">
                                        <img src="<?php echo $_POST['img'] ?>" class="ir ir item-image as-producttile-image  " 
										style="max-width: 70%;max-height: 70%;"alt="" width="445" height="445">
                                    </div>
                                    <div class="images mini-gallery gal5 ">
                                        <div class="as-isdesktop with-paddlenav with-paddlenav-onhover">
                                            <div class="clearfix image-list xs-no-js as-util-relatedlink relatedlink">
                                                <div class="as-tilegallery-element as-image-selected">
                                                    <div class=""></div>
                                                    <img src="<?php echo $_POST['img'] ?>" class="ir ir item-image as-producttile-image" 
													alt="" width="445" height="445" 
													style="content:-webkit-image-set(url(<?php echo $_POST['img'] ?>) 2x);">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="as-producttile-info" style="float:left;min-height: 168px;">
                                    <div class="as-producttile-titlepricewraper" style="min-height: 128px;">
                                        <div class="as-producttile-title">
                                            <h3 class="as-producttile-name">
                                                <p class="as-producttile-tilelink">
                                                    <span data-ase-truncate="2"><?php echo $_POST['title'] ?></span>
                                                </p>
                                            </h3>
                                        </div>
                                        <h3 >
                                            <?php echo $_POST['price'] ?>
                                        </h3>
                                        <h3 >
                                            <?php echo $_POST['unit'] ?>
                                        </h3>
                                    </div>
                                    <button type="submit" class="mercadopago-button" formmethod="post">Pagar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
        <div role="alert" class="as-loader-text ally" aria-live="assertive"></div>
</div>


<!-- =============footer.php========== -->
	<?php include('inc/footer.php') ?>
<!-- =============./footer.php========== -->
