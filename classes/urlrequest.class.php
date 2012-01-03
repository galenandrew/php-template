<?php
/**
 *	URL Request Utility
 *
 *	@description Functions to help with URL Requests
 */

class URLRequest extends Utility {

	//---> Parses Sub Page Requests
	public static function get_sub_request_array() 
	{
		//---> Multi Sub-Page Exists
		$sub_reqs_array = explode('/', REQ_PAGE_SUB);
		
		return $sub_reqs_array;
	}

	//---> Parses Sub Page Requests
	public static function get_last_sub_request() 
	{
		//---> Multi Sub-Page Exists
		$sub_reqs_array = $this->get_sub_request_array();
		
		return array_pop($sub_reqs_array);
	}

	//---> Parses Sub Page Requests
	public static function get_first_sub_request() 
	{
		//---> Multi Sub-Page Exists
		$sub_reqs_array = $this->get_sub_request_array();
		
		return array_shift($sub_reqs_array);
	}

	//---> Total # of Sub Page Requests
	public static function get_total_sub_request($array = FALSE) 
	{
		//---> Multi Sub-Page Exists
		$sub_reqs_array = !$array ? $this->get_sub_request_array() : $array;
		
		return count($sub_reqs_array);
	}
	
}
?>