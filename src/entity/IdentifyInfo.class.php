<?php

namespace kingdee_cdp_webapi_sdk\entity;

use Exception;

class IdentifyInfo
{
	private $acct_id;
	private $user_name;
	private $app_id;
	private $app_sec;
	private $server_url;
	private $lcid;
	private $org_num;
	private $connect_timeout;
	private $request_timeout;
	private $proxy;
	/** 
	 * @api: 构造函数
	 * @param mixed $config_path 配置文件路径 string
	 */
	public function __construct($config_path = 'conf.ini')
	{
		$this->init_config_file($config_path);
	}
	/** 
	 * @api: 根据配置文件路径初始化配置信息
	 * @param mixed $config_path 配置文件路径 string
	 */
	public function init_config_file($config_path = 'conf.ini')
	{
		if (empty($config_path)) {
			throw new Exception('Init config failed: Lack of config path!');
		}
		if (!file_exists($config_path)) {
			throw new Exception('Init config failed: Config file[' . $config_path . '] not found!');
		}
		$info = parse_ini_file($config_path);
		$this->acct_id = isset($info['X-KDApi-AcctID']) ? $info['X-KDApi-AcctID'] : '';
		$this->user_name = isset($info['X-KDApi-UserName']) ? $info['X-KDApi-UserName'] : '';
		$this->app_id = isset($info['X-KDApi-AppID']) ? $info['X-KDApi-AppID'] : '';
		$this->app_sec = isset($info['X-KDApi-AppSec']) ? $info['X-KDApi-AppSec'] : '';
		$this->server_url = isset($info['X-KDApi-ServerUrl']) ? $info['X-KDApi-ServerUrl'] : '';
		$this->lcid = isset($info['X-KDApi-LCID']) ? $info['X-KDApi-LCID'] : 2052;
		$this->org_num = isset($info['X-KDApi-OrgNum']) ? $info['X-KDApi-OrgNum'] : 0;
		$this->connect_timeout = isset($info['X-KDApi-ConnectTimeout']) ? $info['X-KDApi-ConnectTimeout'] : 120;
		$this->request_timeout = isset($info['X-KDApi-RequestTimeout']) ? $info['X-KDApi-RequestTimeout'] : 120;
		$this->proxy = isset($info['X-KDApi-Proxy']) ? $info['X-KDApi-Proxy'] : '';
		// var_dump(get_object_vars($this));
	}
	/** 
	 * @api: 配置信息初始化
	 * @param mixed $acct_id 账套ID string
	 * @param mixed $user_name 用户名称 string
	 * @param mixed $app_id 应用ID string
	 * @param mixed $app_sec 应用密钥 string
	 * @param mixed $server_url 产品环境地址 string
	 * @param mixed $lcid 账套语系，默认2052 int
	 * @param mixed $org_num 组织编码 int
	 * @param mixed $connect_timeout 在发起链接前等待的最长秒数 int
	 * @param mixed $request_timeout curl允许执行的最长秒数 int
	 * @param mixed $proxy 代理，暂时不起作用 string
	 */
	public function init_config_param(
		$acct_id,
		$user_name,
		$app_id,
		$app_sec,
		$server_url = '',
		$lcid = 2052,
		$org_num = 0,
		$connect_timeout = 120,
		$request_timeout = 120,
		$proxy = ''
	) {
		$this->acct_id = $acct_id;
		$this->user_name = $user_name;
		$this->app_id = $app_id;
		$this->app_sec = $app_sec;
		$this->server_url = $server_url;
		$this->lcid = $lcid;
		$this->org_num = $org_num;
		$this->connect_timeout = $connect_timeout;
		$this->request_timeout = $request_timeout;
		$this->proxy = $proxy;
	}
	/** 
	 * @api: 设置账套ID
	 */
	public function set_acct_id($acct_id)
	{
		$this->acct_id = $acct_id;
	}
	/** 
	 * @api: 获取账套ID
	 */
	public function get_acct_id()
	{
		return $this->acct_id;
	}
	/** 
	 * @api: 设置用户名称
	 */
	public function set_user_name($user_name)
	{
		$this->user_name = $user_name;
	}
	/** 
	 * @api: 获取用户名称
	 */
	public function get_user_name()
	{
		return $this->user_name;
	}
	/** 
	 * @api: 设置应用ID
	 */
	public function set_app_id($app_id)
	{
		$this->app_id = $app_id;
	}
	/** 
	 * @api: 获取应用ID
	 */
	public function get_app_id()
	{
		return $this->app_id;
	}
	/** 
	 * @api: 设置应用密钥
	 */
	public function set_app_sec($app_sec)
	{
		$this->app_sec = $app_sec;
	}
	/** 
	 * @api: 获取应用密钥
	 */
	public function get_app_sec()
	{
		return $this->app_sec;
	}
	/** 
	 * @api: 设置产品环境地址
	 */
	public function set_server_url($server_url)
	{
		$this->server_url = $server_url;
	}
	/** 
	 * @api: 获取产品环境地址
	 */
	public function get_server_url()
	{
		return $this->server_url;
	}
	/** 
	 * @api: 设置账套语系
	 */
	public function set_lcid($lcid)
	{
		$this->lcid = $lcid;
	}
	/** 
	 * @api: 获取账套语系
	 */
	public function get_lcid()
	{
		return $this->lcid;
	}
	/** 
	 * @api: 设置组织编码
	 */
	public function set_org_num($org_num)
	{
		$this->org_num = $org_num;
	}
	/** 
	 * @api: 获取组织编码
	 */
	public function get_org_num()
	{
		return $this->org_num;
	}
	/** 
	 * @api: 设置在发起链接前等待的最长秒数
	 */
	public function set_connect_timeout($connect_timeout)
	{
		$this->connect_timeout = $connect_timeout;
	}
	/** 
	 * @api: 获取在发起链接前等待的最长秒数
	 */
	public function get_connect_timeout()
	{
		return $this->connect_timeout;
	}
	/** 
	 * @api: 设置curl允许执行的最长秒数
	 */
	public function set_request_timeout($request_timeout)
	{
		$this->request_timeout = $request_timeout;
	}
	/** 
	 * @api: 获取curl允许执行的最长秒数
	 */
	public function get_request_timeout()
	{
		return $this->request_timeout;
	}
	/** 
	 * @api: 设置代理
	 */
	public function set_proxy($proxy)
	{
		$this->proxy = $proxy;
	}
	/** 
	 * @api: 获取代理
	 */
	public function get_proxy()
	{
		return $this->proxy;
	}
}
