<?php
	foreach($productcategories->all as $productcatgory)
	{
		echo '<hr/>';
		echo '<h2>'.$productcatgory->title.'</h2>';
		
		foreach($productcatgory->products->get()->all as $product)
		{
			echo $product->title.'<br/>';
		}
	}
?>