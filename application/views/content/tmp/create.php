<h1>Artikel schreiben</h1>

<?php echo form_open('artikel/schreiben'); ?>
	<div class="span-3 formlabel">Titel</div>
	<div class="span-5 formfield"><?php echo form_input('title', set_value('title')); ?></div>
	<div class="span-4 formerror last"><?php echo form_error('title'); ?></div>
	
	<div class="span-3 formlabel clear">
		Einführungstext<br/>
		<div class="formerror"><?php echo form_error('intro'); ?></div>
	</div>
	<div class="span-11 formfield last">
		<?php echo form_textarea('intro', set_value('intro')); ?>
	</div>
	
	<div class="span-3 formlabel clear">
		Text<br/>
		<div class="formerror"><?php echo form_error('body'); ?></div>
	</div>
	<div class="span-11 formfield last">
		<?php echo form_textarea(array('name' => 'body', 'style' => 'height: 600px;'), set_value('body')); ?>
	</div>

	<div class="span-3 clear">&nbsp;</div>
	<div class="span-5 last"><?php echo form_submit('submit', 'Jetzt speichern!'); ?></div>