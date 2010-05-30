<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		
		<title><?php echo $site_name . (isset($page_name) ? ' - '.$page_name : ''); ?></title>
		
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/blueprint/print.css" type="text/css" media="print" charset="utf-8">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/blueprint/screen.css" type="text/css" media="screen" charset="utf-8">
		
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/master.css" type="text/css" media="screen" charset="utf-8">
	</head>
	
	<body>
		<div class="container">
			<div id="header" class="span-22 last">
				<h1 class="title"><a href="<?php echo base_url(); ?>">notre menage deux</a></h1>
			</div>
			
			<div id="navigation" class="span-22 last">
				<?php echo $this->template->block('navigation', 'layouts/standard/_navigation') ?>
			</div>

			<div id="contentintro" class="span-22 last">
				<div class="innerpadding">
					<?php echo $this->template->block('contentintro', 'layouts/standard/_contentintro') ?>
				</div>
			</div>
			
			<div id="content" class="span-22 last">
				<div id="contentinner" class="span-15">
					<div class="innerpadding">
						<?php echo $this->template->yield() ?>
					</div>
				</div>
				<div id="sidebar" class="span-7 last">
					<div class="innerpadding">
						<?php echo $this->template->block('sidebar', 'layouts/standard/_sidebar') ?>
					</div>
				</div>
			</div>
			
			<div id="footer" class="span-22 last">
				<div class="innerpadding">
					<?php echo $this->template->block('footer', 'layouts/standard/_footer') ?>
				</div>
			</div>
		</div>
	</body>
</html>