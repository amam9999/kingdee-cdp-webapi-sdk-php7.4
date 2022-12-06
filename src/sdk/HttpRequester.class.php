<?php

namespace kingdee_cdp_webapi_sdk\sdk;

use Exception;

class HttpRequester
{
	private $cookie;
	private $header = array();
	private $request_timeout = 120;
	private $connect_timeout = 120;
	private $response;
	private $response_httpcode;
	private $response_data;
	private $response_header;
	private $response_info;
	public function __construct()
	{
	}
	//设置curl允许执行的最长秒数
	public function set_request_timeout($rt)
	{
		$this->request_timeout = $rt;
	}
	//设置在发起链接前等待的最长秒数，为0则无限等待
	public function set_connect_timeout($ct)
	{
		$this->connect_timeout = $ct;
	}
	//获取curl允许执行的最长秒数
	public function get_request_timeout()
	{
		return $this->request_timeout;
	}
	//获取在发起链接前等待的最长秒数，为0则无限等待
	public function get_connect_timeout()
	{
		return $this->connect_timeout;
	}
	//添加cookie
	public function set_cookie($cookie = '')
	{
		if (is_array($cookie)) {
			$arr = array();
			foreach ($cookie as $key => $value) {
				$arr[] = $key . "=" . $value;
			}
			$this->cookie .= join(";", $arr);
		} else {
			$this->cookie .= $cookie;
		}
	}
	//添加头
	public function set_header($key, $value = '')
	{
		if (!empty($key)) {
			$this->header[] = $key . ':' . $value;
		}
	}
	//发送http请求并获取返回结果
	public function request($url, $post_data = '')
	{
		if (empty($url)) {
			throw new Exception("url不能为空");
		}
		//等价于$ch = curl_init();curl_setopt($ch, CURLOPT_URL, $url);//要访问的地址
		$ch = curl_init($url);
		if (!$ch) {
			throw new Exception("curl初始化失败");
		}
		//执行结果是否被返回，0是返回，1是不返回
		//为0时结果将被直接打印出来，但$output没有值
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//将返报文的头文件的信息作为数据流输出； 1 为输出 ；0 不输出 
		//为0时将会只返回content   
		curl_setopt($ch, CURLOPT_HEADER, 1);
		//判断是否为post请求
		if (!empty($post_data)) {
			curl_setopt($ch, CURLOPT_POST, 1); // 发送一个常规的POST请求
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		}
		// http请求 不验证证书和 hosts 请求数据时使用，跳过验证； 例如参数 返回数据
		// CURLOPT_SSL_VERIFYPEER 禁用后cURL将终止从服务端进行验证  默认为true
		// 如果CURLOPT_SSL_VERIFYPEER(默认值为2)被启用，CURLOPT_SSL_VERIFYHOST需要被设置成TRUE否则设置为FALSE。
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		//设置请求超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->request_timeout);
		//设置链接前等待超时
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connect_timeout);
		// 如果传递 HTTP请求中 的 Cookie
		if (!empty($this->cookie)) {
			curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
		}
		//设置请求头
		if (!empty($this->header)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
		}
		//执行并获取数据
		$this->response = curl_exec($ch);
		if ($this->response === false) {
			throw new Exception(curl_error($ch));
		}
		$this->process_response($ch);
		curl_close($ch);
		return true;
	}
	//处理http请求返回结果
	private function process_response($ch)
	{
		//获取http状态
		$this->response_httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		//获取响应信息
		$this->response_info = curl_getinfo($ch);
		//获取返回结果
		$content_size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
		if ($content_size > 0) {
			$this->response_header = substr($this->response, 0, -$content_size);
			$this->response_data = substr($this->response, -$content_size);
		} else {
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$this->response_header = substr($this->response, 0, $header_size);
			$this->response_data = substr($this->response, $header_size);
		}
		//进一步分解header
		$this->response_header = explode("\r\n", trim($this->response_header));
		$header_assoc = array();
		foreach ($this->response_header as $header) {
			$kv = explode(':', $header);
			if (count($kv) < 2) {
				continue;
			}
			if ($kv[0] == 'Set-Cookie') {
				$header_assoc['Set-Cookie'][] = $kv[1];
			} else {
				$header_assoc[$kv[0]] = $kv[1];
			}
		}
		$this->response_header = $header_assoc;
		return true;
	}
	//获取返回内容
	public function get_response_data()
	{
		return $this->response_data;
	}
	//获取返回http状态码
	public function get_response_httpcode()
	{
		return $this->response_httpcode;
	}
	//获取返回结果header
	public function get_response_header($key = '')
	{
		if (!empty($key) && isset($this->response_header[$key])) {
			return $this->response_header[$key];
		}
		return $this->response_header;
	}
	//获取返回结果header
	public function get_response_info($key = '')
	{
		if (!empty($key)) {
			return $this->response_info[$key];
		}
		return $this->response_info;
	}
}
