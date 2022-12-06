<?php
//测试demo
//第一种引用方式：源码引用
require_once 'src/index.php';
//第二种引用方式：phar伪协议引用
// require_once 'phar://../build/kingdee-webapi-sdk-php7.4-v8.0.4.phar/index.php';

use kingdee_cdp_webapi_sdk\sdk\K3CloudApi;
use kingdee_cdp_webapi_sdk\entity\IdentifyInfo;
use FFI\Exception;

try {
	//使用绝对位置查找对应的配置文件
	// $config = new IdentifyInfo(dirname(__FILE__) . "/build/conf.ini");
	//使用相对位置查找对应的配置文件
	$config = new IdentifyInfo("config/conf.ini");
	//如果请求参数为为空则默认在同一级目录下寻找conf.ini文件
	$k3api = new K3CloudApi($config);
	//请求参数可以为数组
	$post_data = array(
		"Model" => array(
			"FName" => "kh20221027001",
			"FNumber" => "A_20221125164202014_1",
		)
	);
	//也可以使用字符串
	// $post_data = json_encode($post_data);
	//调用保存接口
	$output = $k3api->save("BD_Customer", $post_data);
	echo '<br/>执行保存接口结果：' . $output . '<br/>';
	//请求参数的数组形式
	$post_data = array(
		"FormId" => "BD_MATERIAL",
		"FieldKeys" => "FMATERIALID,FNumber,FName",
		"FilterString" => "FNumber='MFGWL600001'",
		"OrderString" => "",
		"TopRowCount" => 0,
		"StartRow" => 0,
		"Limit" => 2000,
		"SubSystemId" => ""
	);
	//也可以使用字符串
	// $post_data = json_encode($post_data, JSON_UNESCAPED_SLASHES);
	//调用单据查询接口
	$output = $k3api->execute_bill_query($post_data);
	echo '<br/>执行查询单据接口结果：' . $output . '<br/>';
	//调用自定义接口
	$uri = "Kingdee.K3.SCM.WebApi.ServicesStub.SaveXSaleOrderWebApi.SaveXSaleOrder";
	//请求参数可以为字符串
	$post_data_str = '{"saveXSaleOrderArgs":{"SaleOrderBillNo":"XSDD000688","SaleOrderBillId":100827,"SOEntryIds":[102803,102804]}}';
	//使用execute通用方法调用自定义接口
	$output = $k3api->execute($uri, $post_data_str);
	echo '<br/>执行自定义接口结果：' . $output . '<br/>';
	//请求参数可以为数组
	$post_data = array(
		"saveXSaleOrderArgs" => array(
			"SaleOrderBillNo" => "XSDD000688",
			"SaleOrderBillId" => "100827",
		)
	);
	//使用execute通用方法调用自定义接口
	$output = $k3api->execute($uri, $post_data_str);
	echo '<br/>执行自定义接口结果：' . $output . '<br/>';
} catch (Exception $e) {
	echo '<br>';
	echo $e->getMessage();
}
