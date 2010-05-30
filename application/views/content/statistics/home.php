<?php
	$month_latest = '';
	$month_sum = 0;
	foreach($buyings->all as $buying)
	{
		if($month_latest != date("m", $buying->date))
		{
			if($month_sum != 0) echo '<span style="float: right; font-size: 2em;">'.$month_sum.' Euro</span><span class="clearfix"></span>';
		
			$month_latest = date("m", $buying->date);
			echo '<h2 style="margin: 15px 0 5px 0; border-bottom: 1px solid #eee;">'.$month_latest.'.'.date("Y", $buying->date).'</h2>';
			
			$month_sum = 0;
		}
	
		$productpurchase = new Productpurchase();
		$productpurchase->where_related_buying('id', $buying->id);
		$productpurchase->select_sum('offprice')->get();
		
		$month_sum += $productpurchase->offprice;
	}
?>