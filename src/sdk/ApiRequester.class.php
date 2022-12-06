<?php

namespace kingdee_cdp_webapi_sdk\sdk;

require_once 'HttpRequester.class.php';
require_once dirname(__FILE__) . '\..\entity\IdentifyInfo.class.php';
require_once dirname(__FILE__) . '\..\util\encode_util.class.php';
require_once dirname(__FILE__) . '\..\util\string_util.class.php';

use kingdee_cdp_webapi_sdk\sdk\HttpRequester;
use kingdee_cdp_webapi_sdk\entity\IdentifyInfo;
use kingdee_cdp_webapi_sdk\util\EncodeUtil;
use kingdee_cdp_webapi_sdk\util\StringUtil;
use Exception;

class ApiRequester
{
	protected $cookie = array();
	protected $header = array();
	protected $identify;
	static $request_timeout_default = 120;
	static $connect_timeout_default = 120;

	public function __construct($identify)
	{
		$this->init_header();
		$this->set_identify($identify);
	}
	//验证并赋值
	public function set_identify($identify)
	{
		if (gettype($identify) != 'object' || get_class($identify) != IdentifyInfo::class) {
			throw new Exception("identify参数不正确");
		}
		if (empty($identify->get_acct_id())) {
			throw new Exception("Please check whether your [acct_id] has set value");
		}
		if (empty($identify->get_user_name())) {
			throw new Exception("Please check whether your [user_name] has set value");
		}
		if (empty($identify->get_app_id())) {
			throw new Exception("Please check whether your [app_id] has set value");
		}
		if (empty($identify->get_app_sec())) {
			throw new Exception("Please check whether your [app_sec] has set value");
		}
		//如果为公有云则取默认网关
		if (empty($identify->get_server_url())) {
			$identify->set_server_url("https://api.kingdee.com/galaxyapi/");
		}
		//如果超时时间为0则取默认值
		if (empty($identify->get_connect_timeout())) {
			$identify->set_connect_timeout($this->connect_timeout_default);
		}
		if (empty($identify->get_request_timeout())) {
			$identify->set_connect_timeout($this->request_timeout_default);
		}
		//如果语言为空默认取中文
		if (empty($identify->get_lcid())) {
			$identify->set_lcid('2052');
		}
		$this->identify = $identify;
		// var_dump($this->identify);
		// echo "<br>";
	}
	//初始化请求头信息
	private function init_header()
	{
		//能有效提高POST大于1M数据时的请求速度
		$this->header['Expect'] = '';
		//设置浏览器信息
		$this->header['User-Agent'] = 'Kingdee/PHP WebApi SDK 8.0.4 (compatible; MSIE 6.0; Windows NT 5.1;SV1)';
		$this->header['Connection'] = 'keep-alive';
		$this->header['Content-Type'] = 'application/json; charset=UTF-8';
		//固定字符串
		$this->header['x-api-signheaders'] = 'X-Api-TimeStamp,X-Api-Nonce';
		$this->header['X-Api-Auth-Version'] = '2.0';
	}
	//建立请求头信息
	private function build_header($url)
	{
		//私有云使用kd
		$app_id = $this->identify->get_app_id();
		//APPID
		$this->header['X-Kd-Appkey'] = $app_id;
		//编码前的app_data，格式：'{AcctID},{UserName},{LCID},{OrgNum}'
		$app_data = $this->identify->get_acct_id() . ',' . $this->identify->get_user_name() . ',' . $this->identify->get_lcid() . ',' . $this->identify->get_org_num();
		//经过base64编码（基于utf-8）得到字符串
		$this->header['X-Kd-Appdata'] = EncodeUtil::base64_encode($app_data);
		//使用HmacSHA256加密算法，HmacSHA256(原文'{AppID}{app_data}',密钥AppSec)，得到signature结果
		$this->header['X-Kd-Signature'] = EncodeUtil::HmacSHA256($app_id . $app_data, $this->identify->get_app_sec());
		//公有云使用api
		//AppID字符串中下划线“_”的前面部分，如'204399'
		$app_id_arr = explode('_', $app_id);
		if (count($app_id_arr) != 2) {
			throw new Exception("[app_id]格式不正确");
		}
		$this->header['X-Api-ClientID'] = $app_id_arr[0];
		//当前时间戳
		$timestamp = time();
		$this->header['x-api-timestamp'] = $timestamp;
		$this->header['x-api-nonce'] = $timestamp;
		//加密前原文
		$path_url = $this->get_path_utl($url);
		$data = "POST\n" . $path_url . "\n\nx-api-nonce:" . $timestamp . "\nx-api-timestamp:" . $timestamp . "\n";
		//密钥
		$seckey = EncodeUtil::base64_xor_encode($app_id_arr[1], '0054f397c6234378b09ca7d3e5debce7');
		$this->header['X-Api-Signature'] = EncodeUtil::HmacSHA256($data, $seckey);
	}
	public function post($url, $post_data_str = '')
	{
		$requester = new HttpRequester();
		//设置请求头
		$this->build_header($url);
		// echo '<br>请求头信息：<br>';
		// var_dump($this->header);
		foreach ($this->header as $key => $value) {
			$requester->set_header($key, $value);
		}
		//设置cookie
		$requester->set_cookie($this->cookie);
		//设置超时时间
		if (!empty($this->identify->get_connect_timeout())) {
			$requester->set_connect_timeout($this->identify->get_connect_timeout());
		}
		if (!empty($this->identify->get_request_timeout())) {
			$requester->set_request_timeout($this->identify->get_request_timeout());
		}
		//请求地址
		$url = $this->get_url($url);
		// echo '<br>请求url：<br>';
		// var_dump($url);
		// echo '<br>请求参数：<br>';
		// var_dump($post_data_str);
		//发送请求
		$output = $requester->request($url, $post_data_str);
		// echo '<br>请求用时：<br>';
		// var_dump($requester->get_response_info('total_time_us'));
		//将返回结果header的Set-Cookie信息放到cookie中用于下一次请求
		$cookies = $requester->get_response_header('Set-Cookie');
		$this->process_cookie($cookies);
		return $requester->get_response_data();
	}
	//处理返回的cookie
	private function process_cookie($cookies)
	{
		if (!is_array($cookies)) {
			return false;
		}
		$this->cookie["Theme"] = "standard";
		foreach ($cookies as $item) {
			//只处理分割后的第一部分
			$kv_str = explode(';', $item)[0];
			//分为key和value存储起来
			$kv_arr = explode('=', trim($kv_str));
			//新增或者修改cookie
			if (count($kv_arr) == 2) {
				$this->cookie[$kv_arr[0]] = $kv_arr[1];
			}
		}
		// echo '<br>返回处理过的cookie：<br>';
		// var_dump($this->cookie);
	}
	//根据接口名补充完整请求url
	protected function get_url($service_name)
	{
		//如果不为http开头则补充完整
		if (StringUtil::start_with($service_name, 'http')) {
			return $service_name;
		}
		$server_url = $this->identify->get_server_url();
		//如果不以/结尾则添加/
		if (!StringUtil::end_with($server_url, '/')) {
			$server_url .= '/';
		}
		$url = $server_url . $service_name . '.common.kdsvc';
		return $url;
	}
	//截取完整url中除域名外的部分
	protected function get_path_utl($url)
	{
		$url = $this->get_url($url);
		//去掉http协议
		$url = substr($url, strpos($url, '://') + 3);
		//域名的结束位置
		$index = strpos($url, '/');
		$path_url = substr($url, $index);
		return urlencode($path_url);
	}
}
