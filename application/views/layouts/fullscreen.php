<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		
		<title><?php echo $site_name . (isset($page_name) ? ' - '.$page_name : ''); ?></title>
		
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/blueprint/print.css" type="text/css" media="print" charset="utf-8">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/blueprint/screen.css" type="text/css" media="screen" charset="utf-8">
		
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fullscreen.css" type="text/css" media="screen" charset="utf-8">
		
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.autocomplete.min.js"></script>
	</head>
	
	<body>
		<div id="header">
			<h1 class="title"><a href="<?php echo base_url(); ?>">notre menage deux</a></h1>
		</div>
		
		<div id="navigation">
			<?php echo $this->template->block('navigation', 'layouts/fullscreen/_navigation') ?>
		</div>
		<span class="clearfix"></span>
		<div id="contentintro" class="span-22 last">
			<div class="innerpadding">
				<?php echo $this->template->block('contentintro', 'layouts/fullscreen/_contentintro') ?>
			</div>
		</div>
		
		<div id="content">
			<table id="buying_edit">
				<tr>
					<td style="width: 400px;">
						<div class="innerpadding">
							<?php echo $this->template->yield() ?>
						</div>
					</td>
					<td>
						<div class="innerpadding">
							<?php echo $this->template->block('sidebar', 'layouts/fullscreen/_sidebar') ?>
						</div>
					</td>
				</tr>
			</table>
			<span class="clearfix"></span>
		</div>
		
		<div id="footer">
			<div class="innerpadding">
				<?php echo $this->template->block('footer', 'layouts/fullscreen/_footer') ?>
			</div>
		</div>
	</body>
</html>