<?php
/**
 * Base Config Url
*/

/**
 * Base Third API Activate Path
 *
 * @access public
 * @return string
 */
if( !function_exists("base_thirdapi_activate") ) {
	function base_thirdapi_activate() {
		$CI	=& get_instance();
		return $CI->config->item('base_thirdapi_activate');
	}
}

/**
 * Base Third API Forget Path
 *
 * @access public
 * @return string
 */
if( !function_exists("base_thirdapi_forget") ) {
	function base_thirdapi_forget() {
		$CI	=& get_instance();
		return $CI->config->item('base_thirdapi_forget');
	}
}

/**
 * Base Third API sms Path
 *
 * @access public
 * @return string
 */
if( !function_exists("base_thirdapi_sms") ) {
	function base_thirdapi_sms() {
		$CI	=& get_instance();
		return $CI->config->item('base_thirdapi_sms');
	}
}

?>