<h2>Neuen Einkauf erstellen</h2>

<div class="bigger">
	<?php
		$day_array = array(); for($i=1; $i<=31; $i++) { $day_array[$i] = $i; }
		$month_array = array(); for($i=1; $i<=12; $i++) { $month_array[$i] = $i; }
		$year_array = array(); for($i=2009; $i<=2012; $i++) { $year_array[$i] = $i; }
	
		$stores_array = array();
		foreach($stores->all as $store)
		{
			$stores_array[$store->id] = $store->title;
		}

		echo form_open('buyings/create');
			echo form_submit('submit', 'speichern');
			echo '<br/>';
			echo form_dropdown('day', $day_array, array(date('d', time()))).'.';
			echo form_dropdown('month', $month_array, array(date('m', time()))).'.';
			echo form_dropdown('year', $year_array, array(date('Y', time())));
			
			//echo '<strong>Tag:</strong> '.form_input('day', set_value('day', date('d', time())));
			//echo '<br/><strong>Monat:</strong> '.form_input('month', set_value('month', date('m', time())));
			//echo '<br/><strong>Jahr:</strong> '.form_input('year', set_value('year', date('Y', time())));
			echo '<br/>';
			
			echo form_dropdown('store', $stores_array, null, 'size="20"');
		echo form_close();
	?>
</div>