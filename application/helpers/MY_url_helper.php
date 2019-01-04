<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CSS URL
 * 
 * Return a local CSS URL.
 * CSS path can be found in ./assets/css/
 *
 * @access	public
 * @param string
 * @return	string
 */
if ( ! function_exists('css_url'))
{
	function css_url($uri = '')
	{
		return base_url('public/css/'.$uri);
	}
}

// ------------------------------------------------------------------------

/**
 * JS URL
 * 
 * Return a local JS URL.
 * JS path can be found in ./assets/js/
 *
 * @access	public
 * @param string
 * @return	string
 */
if ( ! function_exists('js_url'))
{
	function js_url($uri = '')
	{
		return base_url('public/js/'.$uri);
	}
}

// ------------------------------------------------------------------------

/**
 * Image URL
 * 
 * Return a local Image URL.
 * Image path can be found in ./assets/img/
 *
 * @access	public
 * @param string
 * @return	string
 */
if ( ! function_exists('img_url'))
{
	function img_url($uri = '')
	{
		return base_url('public/uploads/'.$uri);
	}
}

// ------------------------------------------------------------------------

/**
 * Image URL
 * 
 * Return a local Image URL.
 * Image path can be found in ./assets/img/
 *
 * @access	public
 * @param string
 * @return	string
 */
if ( ! function_exists('lib_url'))
{
	function lib_url($uri = '')
	{
		return base_url('application/libraries/'.$uri);
	}
}

/* End of file MY_url_helper.php */
/* Location: ./application/helpers/MY_url_helper.php */