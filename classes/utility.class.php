<?php
/**
 *	General Utility
 *
 *	@description General utility functions
 */

class Utility {
	//---> Changes a singular word to a plural.
    public static function singular_to_plural($word) {
    	// These are just some common plural regex bits.
        $plural = array(
        '/(quiz)$/i' => '1zes',
        '/^(ox)$/i' => '1en',
        '/([m|l])ouse$/i' => '1ice',
        '/(matr|vert|ind)ix|ex$/i' => '1ices',
        '/(x|ch|ss|sh)$/i' => '1es',
        '/([^aeiouy]|qu)ies$/i' => '1y',
        '/([^aeiouy]|qu)y$/i' => '1ies',
        '/(hive)$/i' => '1s',
        '/(?:([^f])fe|([lr])f)$/i' => '12ves',
        '/sis$/i' => 'ses',
        '/([ti])um$/i' => '1a',
        '/(buffal|tomat)o$/i' => '1oes',
        '/(bu)s$/i' => '1ses',
        '/(alias|status)/i'=> '1es',
        '/(octop|vir)us$/i'=> '1i',
        '/(ax|test)is$/i'=> '1es',
        '/s$/i'=> 's',
        '/$/'=> 's');

        $uncountable = array('information', 'series', 'coils');

        $irregular = array(
        'person' => 'people',
        'man' => 'men',
        'child' => 'children',
        'move' => 'moves',
        'ductless' => 'ductless');

        $lowercased_word = strtolower($word);

        foreach ($uncountable as $_uncountable) {
            if(substr($lowercased_word,(-1*strlen($_uncountable))) == $_uncountable){
                return $word;
            }
        }

        foreach ($irregular as $_plural=> $_singular) {
            if (preg_match('/('.$_plural.')$/i', $word, $arr)) {
                return preg_replace('/('.$_plural.')$/i', substr($arr[0],0,1).substr($_singular,1), $word);
            }
        }

        foreach ($plural as $rule => $replacement) {
            if (preg_match($rule, $word)) {
                return preg_replace($rule, $replacement, $word);
            }
        }

        return false;
    }

	//---> Changes a plural word to a singular one.
    public static function plural_to_singular($word)
    {
        $singular = array (
        '/(quiz)zes$/i' => '\1',
        '/(matr)ices$/i' => '\1ix',
        '/(vert|ind)ices$/i' => '\1ex',
        '/^(ox)en/i' => '\1',
        '/(alias|status)es$/i' => '\1',
        '/([octop|vir])i$/i' => '\1us',
        '/(cris|ax|test)es$/i' => '\1is',
        '/(shoe)s$/i' => '\1',
        '/(o)es$/i' => '\1',
        '/(bus)es$/i' => '\1',
        '/([m|l])ice$/i' => '\1ouse',
        '/(x|ch|ss|sh)es$/i' => '\1',
        '/(m)ovies$/i' => '\1ovie',
        '/(s)eries$/i' => '\1eries',
        '/([^aeiouy]|qu)ies$/i' => '\1y',
        '/([lr])ves$/i' => '\1f',
        '/(tive)s$/i' => '\1',
        '/(hive)s$/i' => '\1',
        '/([^f])ves$/i' => '\1fe',
        '/(^analy)ses$/i' => '\1sis',
        '/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i' => '\1\2sis',
        '/([ti])a$/i' => '\1um',
        '/(n)ews$/i' => '\1ews',
        '/s$/i' => '',
        );

        $uncountable = array('information', 'series', 'coils');

        $irregular = array(
        'person' => 'people',
        'man' => 'men',
        'child' => 'children',
        'move' => 'moves',
        'ductless' => 'ductless');

        $lowercased_word = strtolower($word);
        foreach ($uncountable as $_uncountable) {
            if(substr($lowercased_word,(-1*strlen($_uncountable))) == $_uncountable){
                return $word;
            }
        }

        foreach ($irregular as $_plural=> $_singular) {
            if (preg_match('/('.$_singular.')$/i', $word, $arr)) {
                return preg_replace('/('.$_singular.')$/i', substr($arr[0],0,1).substr($_plural,1), $word);
            }
        }

        foreach ($singular as $rule => $replacement) {
            if (preg_match($rule, $word)) {
                return preg_replace($rule, $replacement, $word);
            }
        }

        return $word;
    }

	//---> Parse URL String to Words
	public static function to_words($string, $delimiter = '-') 
	{
		return ucwords(str_replace($delimiter, ' ', $string));
	}

	//---> Validates form data by data type
	public static function validate_data_by_type($data, $data_type='text', $data_format=FALSE)
	{
		switch(strtolower($data_type)) {
			default:
			case 'text':
				return strlen(stripslashes($data)) <= 2 ? FALSE:TRUE; 
			break;
			case 'name':
				return (preg_match( $data_format ? $data_format : '/^[a-zA-Z \.,-]+$/', $data)
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
				return (preg_match($data_format ? $data_format : '/^(https?:\/\/)?((www\.)|([a-z0-9]+\.))?([a-zA-Z0-9_%\-]*)\b(\.[a-z]{2,4})(\.[a-z]{2})?([\/a-zA-Z0-9_%\?=\.&\-#!]+)?$/', $data))
					   ? TRUE : FALSE;
			break;
			case 'phone':
				$phone = preg_replace("[\D]",'',$data);
				return (strlen($phone) == 7 | strlen($phone) == 10 | strlen($phone) == 11) ? TRUE : FALSE;
			break;
			case 'zip':
				return (strlen(preg_replace("[\D]",'',$data)) == 5) || (strlen(preg_replace("[\D]",'',$data)) == 10) ? TRUE : FALSE;
			break;
			case 'date':
				if(preg_match($data_format ? $data_format : "/^([0-9]{1,2})(-|\/|\.)?([0-9]{1,2})(-|\/|\.)?([0-9]{4}|[0-9]{2})$/", $data, $parts)) {
					return (checkdate($parts[1], $parts[3], $parts[5])) ? TRUE : FALSE;
				} else { return FALSE; }
			break;
			case 'date2':
				return (preg_match($data_format ? $data_format : "/^([0-9]{1,2})(-|\/|\.)([0-9]{1,2})$/", $data))
					   ? TRUE : FALSE;
			break;
		}
	}

	//---> Format Phone Numbers
	public static function format_phone($phone) {
		$phone = preg_replace("[\D]",'',$phone);

		switch(strlen($phone)) {
			case 7:
				$format = '/([0-9]{3})([0-9]{4})/';
				$output = '$2-$3';
			break;
			case 10:
				$format = '/([0-9]{3})([0-9]{3})([0-9]{4})/';
				$output = '($1) $2-$3';
			break;
			case 11:
				$format = '/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/';
				$output = '$1 ($2) $3-$4';
			break;
			default:
				return FALSE;
			break;
		}
		return preg_replace($format, $output, $phone);
	}
}
?>