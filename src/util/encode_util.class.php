<?php
namespace kingdee_cdp_webapi_sdk\util;
use Exception;
class EncodeUtil{
	
	public static function HmacSHA256($data,$seckey){
		$signature = hash_hmac('sha256', $data, $seckey, false);
		if($signature==false){
			throw new Exception("HmacSHA256加密失败");
		}
		return self::base64_encode($signature);
	}

	public static function base64_encode($data){
		$signature = base64_encode($data);
		if($signature==false){
			throw new Exception("base64加密失败");
		}
		return $signature;
	}

	public static function base64_decode($data){
		$str = base64_decode($data);
		if($str==false||$str==$data){
			throw new Exception("base64解密失败");
		}
		return $str;
	}

	public static function xor_encode($buffer,$seckey){
		$len=strlen($buffer);
		if($len>strlen($seckey)){
			throw new Exception("按位异或加密失败：原文".$buffer."长度".$len."不符");
		}
		for($i=0;$i<$len;$i++){
			$buffer[$i]=$buffer[$i]^$seckey[$i];
		}
		return $buffer;
	}

	public static function base64_xor_encode($data,$seckey){
		$buffer=self::base64_decode($data);
		$signature=self::xor_encode($buffer,$seckey);
		return self::base64_encode($signature);
	}

	public static function utf8_encode($data){
		//需要php5.4版本或以上
		$json=json_encode($data,JSON_UNESCAPED_UNICODE);
		return $json;
	}
}
?>