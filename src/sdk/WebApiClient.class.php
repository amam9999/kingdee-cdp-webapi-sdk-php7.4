<?php

namespace kingdee_cdp_webapi_sdk\sdk;

require_once 'ApiRequester.class.php';
require_once dirname(__FILE__) . '\..\entity\IdentifyInfo.class.php';
require_once dirname(__FILE__) . '\..\util\encode_util.class.php';
require_once dirname(__FILE__) . '\..\util\string_util.class.php';

use kingdee_cdp_webapi_sdk\sdk\ApiRequester;
use kingdee_cdp_webapi_sdk\entity\IdentifyInfo;
use kingdee_cdp_webapi_sdk\util\EncodeUtil;
use kingdee_cdp_webapi_sdk\util\StringUtil;
use Exception;

class WebApiClient
{
	protected $api_request;
	/** 
	 * @api: 构造函数
	 * @param mixed $config 可以传入配置文件路径，也可以直接传入IdentifyInfo实例 string|IdentifyInfo
	 * @return mixed 调用接口返回结果 string
	 */
	public function __construct($config = 'conf.ini')
	{
		//config可以传入配置文件路径，也可以直接传入IdentifyInfo实例
		if (gettype($config) == 'string') {
			$config = new IdentifyInfo($config);
		}
		$this->api_request = new ApiRequester($config);
	}
	/** 
	 * @api: 通用执行请求方法
	 * @param mixed $service_name 请求地址 string
	 * @param mixed $parameters 请求参数 array|string
	 * @return mixed 调用接口返回结果 string
	 */
	public function execute($service_name, $parameters)
	{
		$parameters = $this->process_parameters($parameters);
		$output = $this->api_request->post($service_name, $parameters);
		// echo '<br>请求返回结果：<br>';
		// var_dump($output);
		if (StringUtil::start_with($output, "response_error:")) {
			$msg = $this->process_error_msg($output);
			throw new Exception($msg);
		}
		return $output;
	}
	protected function process_parameters($parameters)
	{
		if (is_array($parameters)) {
			$parameters = EncodeUtil::utf8_encode($parameters);
		}
		if (!StringUtil::start_with($parameters, "[")) {
			$parameters = "[" . $parameters . "]";
		}
		$parameters = '{"parameters":' . $parameters . '}';
		return $parameters;
	}
	//处理错误信息，提取Message
	protected function process_error_msg($error)
	{
		$error = substr($error, strpos($error, '{'));
		$json = json_decode($error);
		return $json->Message;
	}
	//允许用户修改第三方系统登陆授权配置
	public function set_identify($identify)
	{
		$this->api_request->set_identify($identify);
	}
}
