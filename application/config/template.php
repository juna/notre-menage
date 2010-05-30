<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

///---------------------------------------------------------------
// OCULAR TEMPLATE LIBRARY
// by Lonnie Ezell (http://igniteyourcode.com/ocular)
//
// version: 2.0 Beta 2
//---------------------------------------------------------------

// ------------------------------------------------------------------------

/*
|--------------------------------------------------------------------
| OCULAR LAYOUT LIBRARY SETTINGS
|--------------------------------------------------------------------
| This file contains the settings necessary for the Ocular Layout
| library to function properly.
|
| Unless you want to store your views in a different location, or
| use a different default naming convention, you shouldn't need
| to edit this file.
|
*/

/*
|--------------------------------------------------------------------
| CREATE BENCHMARKS?
|--------------------------------------------------------------------
| When set to true, Ocular will set benchmark points for most of
| methods. Setting it to false can be useful when you are profiling
| your application, but you don't want to see the Ocular points. 
|
| For each method, you can pass a second argument of TRUE in and 
| it will override the setting for that one mark only.
|
*/
$config['OCU_profile'] = FALSE;


/*
|--------------------------------------------------------------------
| SITE NAME
|--------------------------------------------------------------------
| The name of the site. This is data is automatically passed into 
| the views as the $site_name variable for use in layouts and views.
|
*/
$config['OCU_site_name'] = "notre menage";

/*
|--------------------------------------------------------------------
| TEMPLATE DIRECTORY
|--------------------------------------------------------------------
| The location of the application's templates. Leave blank for:
|   /system/application/views/templates/
| 
| When Ocular goes to render a template, it first checks to see
| if a template exists for the controller being called. If it doesn't,
| it renders the system default template (Defined below). So, for
| an application with a URL of http://mysite.com/friends/1 the 
| controller being called is 'friends'. Ocular would look for a 
| view in the following location (assuming default settings):
|
| /views/templates/friends.php
|
*/
$config['OCU_layout_folder'] = "layouts/";

/*
|--------------------------------------------------------------------
| DEFAULT LAYOUT
|--------------------------------------------------------------------
| This is the name of the default layout used if no others are
| specified.
|
| NOTE: do not include an ending ".php" extension.
|
*/
$config['OCU_default_layout'] = "standard";

	
/*
|--------------------------------------------------------------------
| USE THEMES?
|--------------------------------------------------------------------
| When set to TRUE, Ocular will check the user agent during the 
| render process, and check the UA against the OCU_themes (below),
| allowing you to create mobile versions of your site, and version
| targetted specifically at a single type of phone (ie, Blackberry or
| iPhone).
|
| Note, that, when rendering, if the file doesn't exist in the 
| targetted theme, Ocular then checks the default site for the same file.
|
*/
$config['OCU_use_themes'] = FALSE;


/*
|--------------------------------------------------------------------
| DEFAULT THEME
|--------------------------------------------------------------------
| This is the folder name that contains the default theme to use
| when 'OCU_use_themes' is set to TRUE.
|
*/
$config['OCU_default_theme'] = 'default';

/*
|--------------------------------------------------------------------
| THEME COLLECTIONS
|--------------------------------------------------------------------
| This is a collection of themes, and their associated user agents.
| When 'OCU_use_themes' is TRUE, Ocular will grab the user agent, 
| see if it exists within the 'OCU_themes' settings, and then look
| for files within the 'views/theme_name' directory.
|
| For example, if you are making an iPhone specific site alongside
| your traditional desktop site, the iPhone theme should reside in
| the 'views/iphone' folder, while the desktop site should live in
| the 'views/default' folder.
|
| In the default setting, there is just an iphone listing: 
|
|  'iphone' => array('iPhone', 'iPod')
|
| The key of the array (iphone) must match the folder name in the
| 'views' folder.
|
| Any views that are not within the targeted folder, will be searched
| for in the 'default' folder.
|
| NOTE: when checking the themes, it happens in a first-come, first-serve
| basis. That means if you have both a 'mobile' site and an 'iPhone'
| site, the iPhone array must be earlier in the 'OCU_themes' array
| than the 'mobile' array.
|
*/
$config['OCU_themes'] = array(
	'iphone' => array('Apple iPhone', 'Apple iPod Touch')
);

/*
|--------------------------------------------------------------------
| MESSAGE TEMPLATE
|--------------------------------------------------------------------
| This is the template that Ocular will use when displaying messages
| through the message() function. 
|
| To set the class for the type of message (error, success, etc),
| the {type} placeholder will be replaced. The message will replace 
| the {message} placeholder.
|
*/
$config['OCU_message_template'] = '
	<div class="notification {type}">
		<div>{message}</div>
	</div>
';

/*
|--------------------------------------------------------------------
| EXTENSION HANDLERS
|--------------------------------------------------------------------
| Extension handlers allow Ocular to render multiple types of 
| files, not just html (with a .php extension) as would the standard
| $this->load->view() function.
|
| The OCU_handlers config setting is an array of file extensions,
| followed by the name of the handler. In this case, the handler name
| MUST match the name of a helper (named: handler_helper.php) and
| the function to be called to parse the script.
|
| For example, using the Markdown helper that ships with Ocular,
| the syntax is: 
|
| $config['OCU_handlers'] = array(
|		'md'	=> 'Markdown',
|	);
|
| which loads the Markdown_helper.php file and processes it by calling
| Markdown($content);
|
| NOTE: do not include an ending ".php" extension.
|
*/
$config['OCU_handlers'] = array(
		'md'	=> 'Markdown',
	);

?>
