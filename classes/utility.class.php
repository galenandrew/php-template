<?php
/**
 *	General Utility
 *
 *	@description General utility functions
 */

class Utility {

	//---> Parse URL String to Words
	public static function to_words($string, $delimiter = '-') 
	{
		return ucwords(str_replace($delimiter, ' ', $string));
	}

	//---> Validates form data by data type
	public static function validate_data_by_type($data, $data_type='text') 
	{
		switch(strtolower($data_type)) {
			default:
			case 'text':
				return strlen(stripslashes($data)) <= 2 ? FALSE:TRUE; 
			break;
			case 'name':
				return (preg_match('/^[a-zA-Z \.,-]+$/', $data)
						&& strlen(stripslashes($data)) >= 2)
						? TRUE : FALSE; 
			break;
			case 'email':
				$isValid = true;
				$atIndex = strrpos($data, "@");
	
				if (is_bool($atIndex) && !$atIndex) {
					$isValid = false;
				} else {
					$domain 	= substr($data, $atIndex+1);
					$local 		= substr($data, 0, $atIndex);
					$localLen 	= strlen($local);
					$domainLen 	= strlen($domain);
	
					// local part length exceeded
					if($localLen < 1 || $localLen > 64) 					{ $isValid = false; } 
	
					// domain part length exceeded
					else if($domainLen < 1 || $domainLen > 255) 			{ $isValid = false; } 
	
					// local part starts or ends with '.'
					else if($local[0] == '.' || $local[$localLen-1] == '.') { $isValid = false; } 
	
					// local part has two consecutive dots
					else if(preg_match('/\\.\\./', $local)) 				{ $isValid = false; } 
	
					// character not valid in domain part
					else if(!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) { $isValid = false; } 
	
					// domain part has two consecutive dots
					else if (preg_match('/\\.\\./', $domain)) 				{ $isValid = false; }
	
					// character not valid in local part unless local part is quoted
					else if(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))) {
						if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))) { $isValid = false; }
					}
						// domain not found in DNS
						if($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))) { $isValid = false; }
				}
				return $isValid;
			break;
			case 'url':
				return (preg_match('/^(https?:\/\/)?((www\.)|([a-z0-9]+\.))?([a-zA-Z0-9_%\-]*)\b(\.[a-z]{2,4})(\.[a-z]{2})?([\/a-zA-Z0-9_%\?=\.&\-#!]+)?$/', $data))
					   ? TRUE : FALSE;
			break;
			case 'phone':
				return (strlen(preg_replace("[\D]",'',$data)) == 10) ? TRUE : FALSE;
			break;
			case 'zip':
				return (strlen(preg_replace("[\D]",'',$data)) == 5) || (strlen(preg_replace("[\D]",'',$data)) == 10) ? TRUE : FALSE;
			break;
		}
	}

}
?>