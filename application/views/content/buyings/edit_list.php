<script type="text/javascript">                                         
	$(document).ready(function()
	{
		$("a.productdelete").click(function(e)
		{
			e.preventDefault();
			
			//$.post("<?php echo base_url(); ?>buyings/addproduct/<?php echo $buying->id; ?>/"+$(this).attr("id"));
			//alert("<?php echo base_url(); ?>buyings/addproduct/<?php echo $buying->id; ?>/"+$(this).attr("id"));
			
			$("#buying_edit_list").load("<?php echo base_url(); ?>buyings/deleteproduct/<?php echo $buying->id; ?>/"+$(this).attr("id"));
		});
		
		$(".purchase_price").focus(function(e)
		{
			$(this).parent().parent().addClass('active');
		});
		
		$(".purchase_price").keydown(function(e)
		{
			//$(this).parent().parent().addClass('edited');
		});
		
		$(".purchase_price").blur(function(e)
		{
			$.post(
				"<?php echo base_url(); ?>buyings/saveproduct/<?php echo $buying->id; ?>/"+$(this).attr("id"),
				{ price: $(this).attr("value") },
				function(data)
				{
					$("#price_sum").html(data);
				}
			);
			
			$(this).parent().parent().removeClass('active');
		});
	});
</script>

<?php
	$num = 1;
	$price_sum = 0;
	foreach($buying->productpurchase->get()->all as $productpurchase)
	{
		echo '<li>';
			echo anchor('', 'X', 'class="productdelete" id="purchase_'.$productpurchase->id.'"').' ';
			echo '<strong>'.$productpurchase->product->get()->title.'</strong>';
			echo '<div class="price"><input tabindex="'.$num.'" class="purchase_price" id="purchasefield_'.$productpurchase->id.'" type="text" value="'.$productpurchase->offprice.'" /> Euro</div>';
		echo '<span class="clearfix"></span></li>';
		
		$num++;
		
		$price_sum += $productpurchase->offprice;
	}
	
	echo '<hr style="margin: 0;" />';
	echo '<div style="font-size: 2em; float: right; font-weight: bold;"><span id="price_sum">'.$price_sum.'</span> Euro</div>';
?>