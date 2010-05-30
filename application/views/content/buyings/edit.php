<script type="text/javascript">                                         
	$(document).ready(function()
	{
		var data =
		"<?php
			foreach($productcategories->all as $productcatgory)
			{
				foreach($productcatgory->products->get()->all as $product)
				{
					echo $product->title.'_'.$product->id.'xxxxxxx';
				}
			}
		?>".split("xxxxxxx");
		$("#autocomplete").autocomplete(data);
		
		$("#autocomplete").keydown(function(e)
		{
			if(e.keyCode == 13)
			{
				$.post(
				"<?php echo base_url(); ?>buyings/addproductac/<?php echo $buying->id; ?>/",
				{ product: $("#autocomplete").val() },
				function(data)
				{
					$("#autocomplete").val('');
					$("#buying_edit_list").html(data);
				}
			);
			}
		});
	});
</script>

<?php
	echo 'Einkauf vom <strong>'.date("d.m.Y", $buying->date).'</strong> im <strong>'.$buying->store->get()->title.'</strong>';
?>

<input id="autocomplete" style="width: 280px; font-size: 1.3em; padding: 5px;" type="text" value="" />

<ul id="buying_edit_list">
	<?php
		$data['buying'] = $buying;
		$this->load->view('content/buyings/edit_list', $data);
	?>
</ul>