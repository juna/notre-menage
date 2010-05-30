<h1>Artikelkategorie anlegen</h1>

<?php echo form_open('artikel/kategorie/anlegen'); ?>
	<div class="span-3 formlabel">Titel</div>
	<div class="span-5 formfield"><?php echo form_input('title', set_value('title')); ?></div>
	<div class="span-4 formerror last"><?php echo form_error('title'); ?></div>

	<div class="span-3 clear">&nbsp;</div>
	<div class="span-5 last"><?php echo form_submit('submit', 'Jetzt speichern!'); ?></div>
<?php echo form_close(); ?>