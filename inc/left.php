
<?php
       $json = __DIR__ . "/data/categories.json";

		// Read the file contents into a string variable,  
		// and parse the string into a data structure
		$str_data = file_get_contents($json);
		$categories = json_decode($str_data,true);
?>

<materializer data-uid="as-accordion-id0" id="as-accordion-id0" data-show-height="computed" 
				data-hide-height="0" class="as-search-facet-materializer ase-materializer ase-materializer-show" 
				data-shown-init="true" style="">
<div class="as-accordion-content">
	<ul class="as-search-filter-items  as-filter-text-type    ">

<?php 
	foreach ($categories as $item_cat):
         $item_id = $item_cat['Id'];
?>
    
	<li class="as-filter-item       ">
		<a href="" class="as-filter-option  " 
				aria-disabled="false" tabindex="0" 
				role="checkbox" aria-checked="false">

			<span class="as-filter-name">
				<span class="as-search-filter-content">
					<span class="as-search-filter-text">
						<?= ucfirst($item_cat['Name'] )  ;?>
					</span>
				</span>
			</span>
		</a>
	</li>

<?php endforeach ?>
</materializer>
	</ul>
	<button class="as-searchmoreless-toggle as-searchfilter-morebutton  as-search-more" id="iPad Compatibility_more">
		<span class="as-search-morelessbutton-text">More</span>
	</button>
</div>
