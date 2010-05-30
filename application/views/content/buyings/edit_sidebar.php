<script type="text/javascript">                                         
	$(document).ready(function()
	{
		$("a.addproduct").click(function(e)
		{
			e.preventDefault();
			
			//$.post("<?php echo base_url(); ?>buyings/addproduct/<?php echo $buying->id; ?>/"+$(this).attr("id"));
			//alert("<?php echo base_url(); ?>buyings/addproduct/<?php echo $buying->id; ?>/"+$(this).attr("id"));
			
			$("#buying_edit_list").load("<?php echo base_url(); ?>buyings/addproduct/<?php echo $buying->id; ?>/"+$(this).attr("id"));
		});
	});
</script>

<div id="buyings_edit_list_products_outer">
<table id="buyings_edit_list_products">
	<tr>
		<?php
			echo '<td><div class="inner">';
			$num_products = 0;
			$firstchar = '';
			foreach($productcategories->all as $productcatgory)
			{
				if($num_products != 0)
				{
					echo '<div class="divider"></div>';
					$num_products += 2;
				}
				echo '<strong style="font-size: 2em;">'.$productcatgory->title.'</strong><br/>';
				
				foreach($productcatgory->products->get()->all as $product)
				{
					if($firstchar != substr(strtolower(str_replace(array(utf8_encode('Ä'), utf8_encode('Ö'), utf8_encode('Ü')), array('A', 'O', 'U'), $product->title)), 0, 1))
					{
						$firstchar = substr(strtolower(str_replace(array(utf8_encode('Ä'), utf8_encode('Ö'), utf8_encode('Ü')), array('A', 'O', 'U'), $product->title)), 0, 1);
						//echo '<br/><span style="font-size: 1.9em;">'.$firstchar.'</span><br/>';
						
						echo '<span style="line-height: 1.1em; color: darkblue; font-weight: bold; font-size: 2em;">'.strtoupper($firstchar).'</span>';
						$title = substr($product->title, 1, strlen($product->title));
						echo anchor('', $title, 'class="addproduct" id="p_'.$product->id.'"');
					}
					else
					{
						echo anchor('', $product->title, 'class="addproduct" id="p_'.$product->id.'"');
					}
					
					echo '<br/>';
					$num_products++;
					if($num_products >= 50)
					{
						echo '</div></td><td><div class="inner">';
						$num_products = 0;
					}
				}
			}
			echo '</td><td>';
		?>
	</tr>
</table>
</div>