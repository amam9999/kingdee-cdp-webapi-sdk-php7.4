<?php
namespace kingdee_cdp_webapi_sdk\util;
class StringUtil{
	
	public static function start_with ($string, $startString)
	{
			$len = strlen($startString);
			return (substr($string, 0, $len) === $startString);
	}

	public static function end_with($string, $endString)
	{
			$len = strlen($endString);
			if ($len == 0) {
					return true;
			}
			return (substr($string, -$len) === $endString);
	}
}
?>