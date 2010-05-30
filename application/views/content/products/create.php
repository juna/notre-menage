<h2>Neues Produkt erstellen</h2>

<div class="bigger">
<?php
	$productcategory_array = array();
	foreach($productcategories->all as $productcategories)
	{
		$productcategory_array[$productcategories->id] = $productcategories->title;
	}

	echo form_open('products/create');
		echo '<strong>Name:</strong> '.form_input('title', set_value('title'));
		
		echo '<br/><br/><strong>Kategorie:</strong><br/>';
		echo form_dropdown('productcategory', $productcategory_array, null, 'size="5"');
		
		echo '<br/><br/><br/>';
		echo form_submit('submit', 'speichern');
	echo form_close();
?>
</div>