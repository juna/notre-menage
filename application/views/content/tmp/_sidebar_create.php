<a href="<?php echo base_url(); ?>artikel">zurück zur Übersicht</a><br/>

<div class="divider"></div>

<?php
	foreach ($res_articlecategories->all as $obj_articlecategory)
	{
		echo '<input type="checkbox" value="' .  $obj_articlecategory->id . '" name="category[]" ' . set_checkbox('category[]', $obj_articlecategory->id) . ' />' . $obj_articlecategory->title . '<br/>';
	}
?>

<div class="formerror"><?php echo form_error('category[]'); ?></div>

<?php form_close(); ?>