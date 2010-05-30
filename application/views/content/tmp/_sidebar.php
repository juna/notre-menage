<h3>Kategorien</h3>
<?php
	foreach ($res_articlecategories->all as $obj_articlecategory)
	{
		echo $obj_articlecategory->title . '<br/>';
	}
?>

<div class="divider"></div>

<a href="<?php echo base_url(); ?>artikel/schreiben">Einen neuen Artikel schreiben</a><br/>
<a href="<?php echo base_url(); ?>artikel/kategorie/anlegen">Eine neue Artikelkategorie anlegen</a>