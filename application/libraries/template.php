<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//---------------------------------------------------------------
// OCULAR TEMPLATE LIBRARY
// by Lonnie Ezell (http://igniteyourcode.com/ocular)
//
// version: 2.0 Beta 2
//---------------------------------------------------------------

/*
2.0b2 changes

Additions: 
	- now adds $active_controller, $active_view and $active_function to the data array for use in views.

Bugs: 
	- _check_layout now works with custom layout names.
	- render() no longer resets the view name if a custom one has been set.
	- fixed block() to actually use the $this->blocks value.
*/

class Template {

	/**
	 * An instance of the CI super object.
	 * 
	 * @var mixed
	 * @access private
	 */
	private $ci;
	
	/**
	 * The view to load. Normally not set unless
	 * you need to bypass the automagic.
	 * 
	 * @var mixed
	 * @access public
	 */
	public $current_view;
	
	/**
	 * The data to be passed into the views.
	 * The keys are the names of the variables
	 * and the values are the values.
	 * 
	 * @var mixed
	 * @access protected
	 */
	protected $data;
	
	/**
	 * The layout to render the views into.
	 * 
	 * @var mixed
	 * @access protected
	 */
	public $layout;
	
	/**
	 * An array of blocks. The key is the name
	 * to reference it by, and the value is the file.
	 * The class will loop through these, parse them,
	 * and push them into the layout.
	 * 
	 * (default value: array())
	 * 
	 * @var array
	 * @access protected
	 */
	protected $blocks = array();
	
	
	/**
	 * If themes are turned on in the config file, this
	 * value stores the name of the active theme (folder)
	 * with a trailing slash. 
	 *
	 * If 'OCU_use_themes' is FALSE, you can still use
	 * this value to create your own themeing system
	 * through the set_theme() and theme() functions.
	 * 
	 * (default value: '')
	 * 
	 * @var string
	 * @access protected
	 */
	protected $active_theme = '';
	
	/**
	 * Holds a simple array to store the status Message
	 * that gest displayed using the message() function.
	 *
	 * @var array
	 * @access protected
	 */
	protected $messages = array();
	
	//---------------------------------------------------------------
	
	/**
	 * __construct function.
	 *
	 * Grabs an instance of the CI superobject, loads the Ocular config
	 * file, and sets our default layout.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() 
	{	
		$this->ci =& get_instance();
		
		$this->_mark('Template_constructor_start');
		
		$this->ci->config->load('template');
		
		$this->ci->lang->load('template');
		
		$this->ci->load->helper('language');
		
		// Store some of our defaults
		$this->layout = $this->ci->config->item('OCU_layout_folder') . $this->ci->config->item('OCU_default_layout');
		
		log_message('debug', lang('OCU_loaded'));
		
		$this->_mark('Template_constructor_end');
	}
	
	//---------------------------------------------------------------
	
	/**
	 * render function.
	 *
	 * Renders out the specified layout, which starts the process
	 * of rendering the page content. Also determines the correct
	 * view to use based on the current controller/method.
	 * 
	 * @access public
	 * @param string $layout. (default: '')
	 * @return void
	 */
	public function render($layout='') 
	{
		$this->_mark('Template_Render_start');
		
		$this->set('site_name', $this->ci->config->item('OCU_site_name'));

		$this->set('active_controller', $this->ci->router->class);
		$this->set('active_method', $this->ci->router->method);
		$this->set('active_view', $this->current_view);
		
		$this->_set_layout();
	
		// Grab out current view name, based on controller/method
		// which routes to views/controller/method. Ignore extension
		// for now.
		if (empty($this->current_view))
		{
			$this->current_view = $this->ci->router->class . '/' . $this->ci->router->method;
		}
	
		// Make sure we're using the correct layout.
		// If none is specified, use the default. 
		// Set in constructor.
		$layout = empty($layout) ? $this->layout : $layout;
				
		//
		// Time to render the layout
		//
		
		// Start by checking if there's a theme available
		if (!empty($this->active_theme))
		{
			// A theme has been specified. First try to locate the file under
			// the active theme. If that doesn't work, fall back to the default theme.
			if ($this->ci->load->view($this->_check_layout($layout), $this->data) === FALSE)
			{
				// Oops. Not found in active theme. Try the default.
				if ($this->ci->load->view($this->_check_layout($layout, true), $this->data) === FALSE)
				{
					// Layout not found, so spit out an error.
					show_error(lang('OCU_404_error') . $layout);
				}
			}
		} else 
		{
			// We're not using themes, so default to the 'views' folder
			if ($this->ci->load->view($layout, $this->data) === FALSE)
			{
				// Show an error here, since we're overriding CI's loader.
				show_error(lang('OCU_404_error') . $layout);
			}
		}
				
		$this->_mark('Template_Render_end');
	}
	
	//---------------------------------------------------------------
	
	/**
	 * Renders the current page. 
	 *
	 * Uses a view based on the controller/function being run. (See __constructor).
	 * The view file does not have to be a standard html or php file. Instead, any
	 * type of file can be used, and processed with helpers. These are dealth
	 * with via helpers, and set in the OCU_handlers config setting. (See the
	 * Template.php config file for more details.)
	 * 
	 * @access public
	 * @return void
	 */
	public function yield() 
	{
		$this->_mark('Template_Yield_start');
		
		$file = '';				// Stores the view name we're attempting to find in the filesystem.
		$theme_folder = '';		// Stores the theme folder to look in (or blank if none)
	
		//
		// See if a file exists matching the $current_view variable (any extension).
		//
		
		// Start by checking if there's a theme available.
		if (!empty($this->active_theme))
		{
			// A theme has been specified. First try to locate the file under
			// the active theme. If that doesn't work, fall back to the default theme.
			$file = APPPATH . 'views/' . $this->active_theme . $this->current_view;
			$file = glob($file . '.*');
			$theme_folder = $this->active_theme;
			
			if (count($file) == 0)
			{
				// Pull it from the default theme.
				$file = APPPATH . 'views/' . $this->ci->config->item('OCU_default_theme') .'/'. $this->current_view;
				$file = glob($file . '.*');
				$theme_folder = $this->ci->config->item('OCU_default_theme') .'/';
			}
		} else {
			// We're not using themes, so default to the views folder
			$file = APPPATH . 'views/' . $this->current_view;
			$file = glob($file . '.*');
		}
		
		
		if (count($file) == 0)
		{
			// No usable view found. Log the error,
			log_message('debug', lang('OCU_no_view') . $this->current_view);
			// Flush the output buffer
			ob_clean();
			// and show the page not found error.
			show_404();
		} else 
		{
			// Note, if more than one file matches, we just use the first.
			$ext = substr($file[0], strrpos($file[0], '.') + 1);
			
			// Grab the content of our view file
			$content = $this->ci->load->view($theme_folder . $this->current_view . '.' . $ext, $this->data, true);
			
			// Use our handler config array to see if we need to do anything
			// with this file.
			$handlers = $this->ci->config->item('OCU_handlers');
			
			if (isset($handlers[$ext]) && !empty($handlers[$ext]))
			{
				// Load the associated helper
				$this->ci->load->helper($handlers[$ext]);
				$content = @$handlers[$ext]($content);
			}
			
			echo $content;
		}
		
		$this->_mark('Template_Yield_end');
	}
	
	//---------------------------------------------------------------
	
	/**
	 * Renders a "block" to the view.
	 *
	 * A block is a partial view contained in a view file in the 
	 * application/views folder. It can be used for sidebars,
	 * headers, footers, or any other recurring element within
	 * a site. It is recommended to set a default when calling
	 * this function within a layout. The default will be rendered
	 * if no methods override the view (using the set_block() method).
	 * 
	 * @access public
	 * @param string $name. (default: '')
	 * @param string $default_view. (default: '')
	 * @return void
	 */
	public function block($block_name='', $default_view='') 
	{
		$this->_mark('Template_Block_start');
		
		if (empty($block_name)) 
		{
			log_message('debug', lang('OCU_no_block'));
			return;
		}

		if (array_key_exists($block_name, $this->blocks))
		{
			$block_name = $this->blocks[$block_name];
		} else {
			$block_name = $default_view;
		}
		

		if (empty($block_name)) 
		{
			log_message('debug', lang('OCU_no_default_block') . $default_view);
			return;
		}
	
		//
		// Time to actually render the block.
		//
		
		// Start by checking if there's a theme available
		if (!empty($this->active_theme))
		{
			// A theme has been specified. First, try to locate the file under
			// the active_theme. If that doesn't work, fall back to the default.
			$block_content = $this->ci->load->view($this->_check_view($block_name), $this->data, true);
			if (empty($block_content))
			{
				// Oops. Not found in the active_theme. Try the default.
				$block_content = $this->ci->load->view($this->_check_view($block_name, true), $this->data, true);
			}
		} else 
		{
			$block_content = $this->ci->load->view($block_name, $this->data, true);
		}
		
		echo $block_content;
		
		$this->_mark('Template_Block_end');
	}
	
	//---------------------------------------------------------------
	
	/**
	 * Stores the block named $name in the blocks array for later rendering.
	 * The $current_view variable is the name of an existing view. If it is empty,
	 * your script should still function as normal.
	 * 
	 * @access public
	 * @param string $name. (default: '')
	 * @param string $view. (default: '')
	 * @return void
	 */
	public function set_block($block_name='', $view_name='') 
	{
		$this->_mark('Template_Set_Block_start');
		
		if (!empty($block_name))
		{
			$this->blocks[$block_name] = $view_name;
		} 
		
		$this->_mark('Template_Set_Block_end');
	}
	
	//---------------------------------------------------------------
	
	/**
	 * Makes it easy to save information to be rendered within the views.
	 * 
	 * @access public
	 * @param string $name. (default: '')
	 * @param string $value. (default: '')
	 * @return void
	 */
	public function set($var_name='', $value='') 
	{
		$this->_mark('Template_Set_start');
		
		if (!empty($var_name))
		{
			$this->data[$var_name] = $value;
		}
		
		$this->_mark('Template_Set_end');
	}
	
	//---------------------------------------------------------------
	
	/**
	 * Sets the active_theme property and adds a trailing slash.
	 * 
	 * @access public
	 * @param string $name. (default: '')
	 * @return void
	 */
	public function set_theme($theme_name='') 
	{
		$this->active_theme = $theme_name . '/';
	}
	
	//---------------------------------------------------------------
	
	/**
	 * Returns the name of the active theme.
	 * 
	 * @access public
	 * @return void
	 */
	public function theme() 
	{
		return $this->active_theme();
	}
	
	//---------------------------------------------------------------
	
	/**
	 * is_ajax function.
	 *
	 * Checks if a request has been made through AJAX or not.
	 * Thanks to Jamie Rumbelow (http://jamierumbelow.net) for this one.
	 * 
	 * @access public
	 * @return void
	 */
	public function is_ajax() 
	{
		return ($this->ci->input->server('HTTP_X_REQUESTED_WITH') == 'XMLHttpRequest') ? TRUE : FALSE;
	}
	
	//---------------------------------------------------------------
	
	/**
	 * Sets a status message (for displaying small success/error messages).
	 * This function is used in place of the session->flashdata function,
	 * because you don't always want to have to refresh the page to get the
	 * message to show up. 
	 * 
	 * @access public
	 * @param string $message. (default: '')
	 * @param string $type. (default: 'info')
	 * @return void
	 */
	public function set_message($message='', $type='info') 
	{
		if (!empty($message))
		{
			if (class_exists('session'))
			{
				$this->ci->session->set_flashdata('message', $type.'::'.$message);
			}
			
			$this->message = array('type'=>$type, 'message'=>$message);
		}
	}
	
	//---------------------------------------------------------------
	
	/**
	 * Displays a status message (small success/error messages).
	 * If data exists in 'message' session flashdata, that will 
	 * override any other messages. The renders the message based
	 * on the template provided in the config file ('OCU_message_template').
	 * 
	 * @access public
	 * @return void
	 */
	public function message() 
	{
		$message = '';		// The message body.
		$type	 = '';		// The message type (used for class)
	
		// Does session data exist? 
		if (class_exists('session'))
		{
			$message = $this->ci->session->flashdata('message');
		}
		
		if (!empty($message))
		{
			// Split out our message parts
			$temp_message = explode('::', $message);
			$type = $temp_message[0];
			$message = $temp_message[1];
			
			unset($temp_message);
		} 
		
		// If message is empty, we need to check our own storage.
		if (empty($message))
		{
			if (empty($this->message['message']))
			{
				return '';
			}
			
			$message = $this->message['message'];
			$type = $this->message['type'];
		}
		
		// Grab out message template and replace the placeholders
		$template = str_replace('{type}', $type, $this->ci->config->item('OCU_message_template'));
		$template = str_replace('{message}', $message, $template);
		
		return $template;
	}
	
	//---------------------------------------------------------------
	
	//---------------------------------------------------------------
	// PRIVATE FUNCTIONS
	//---------------------------------------------------------------
	
	/**
	 * Sets a benchmark mark if 'OCU_profile' is set to true
	 * in the config file, or if TRUE was passed as a second
	 * parameter (allowing you to benchmark just one function.)
	 * 
	 * @access private
	 * @param string $name. (default: '')
	 * @param mixed $override. (default: FALSE)
	 * @return void
	 */
	private function _mark($name='', $override=FALSE) 
	{
		// Is Template supposed to provide benchmarks? 
		if ($this->ci->config->item('OCU_profile') === TRUE || ($override === TRUE))
		{
			if (!empty($name))
			{
				$this->ci->benchmark->mark($name);
			}
		} 
	}
	
	//---------------------------------------------------------------
	
	/**
	 * Sets the current layout, based on user_agents.
	 * 
	 * @access private
	 * @return void
	 */
	private function _set_layout() 
	{
		if ($this->ci->config->item('OCU_use_themes') === TRUE)
		{
			// Load our user_agent library
			$this->ci->load->library('user_agent');
			
			$agent ='';
			
			// Grab our agent
			if ($this->ci->agent->is_mobile())
			{
			    $agent = $this->ci->agent->mobile();
			}
			else if ($this->ci->agent->is_browser())
			{
			    $agent = $this->ci->agent->browser().' '.$this->ci->agent->version();
			}
			else if ($this->ci->agent->is_robot())
			{
			    $agent = $this->ci->agent->robot();
			}
			
			// Check our themes array to see if we can find a match.
			if (!empty($agent))
			{
				$themes = $this->ci->config->item('OCU_themes');
				
				foreach ($themes as $theme => $values)
				{
					// If the agent is found anywhere inside the values,
					// Then we've found our theme to use.
					if (in_array($agent, $values) === TRUE)
					{
						$this->active_theme = $theme . '/';						
						// Get out of here.
						break;
					}
				}
			}
			
			// If we still don't have a theme, set it to the default.
			if (empty($this->active_theme))
			{
				$this->active_theme = $this->ci->config->item('OCU_default_theme') . '/';
			}
		}
	}
	
	//---------------------------------------------------------------
	
	/**
	 * Adjusts the name passed based on the current theme (if any)
	 * 
	 * @access private
	 * @return void
	 */
	private function _check_view($name='', $use_default=FALSE) 
	{
		if (!empty($name))
		{
			// Is there a theme assigned? If we're using themes, 
			// it should already be set by the time we get here.
			if (!empty($this->active_theme))
			{
				return ($use_default === TRUE) ? $this->ci->config->item('OCU_default_theme') . '/' . $name : $this->active_theme . $name;
			}
		}
		
		return $name;
	}
	
	//---------------------------------------------------------------
	
	private function _check_layout($name='', $use_default=FALSE) 
	{	
		if (!empty($name))
		{
			// see if it includes the 'layout' folder
			if (strpos($name, 'layouts') === FALSE)
			{
				$name = 'layouts/' . $name;
			}
		
			// Is there a theme assigned? If we're using themes,
			// if should already be set by the time we're here.
			if (!empty($this->active_theme))
			{
				return ($use_default === TRUE) ? $this->ci->config->item('OCU_default_theme') . '/' . $name : $this->active_theme . $name;
			}
		}
	}
	
	//---------------------------------------------------------------
	

}

/* End of file Template.php */
/* Location: ./application/libraries/Template.php */