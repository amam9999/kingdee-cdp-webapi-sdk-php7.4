<?php

namespace kingdee_cdp_webapi_sdk\sdk;

require_once 'WebApiClient.class.php';

use kingdee_cdp_webapi_sdk\sdk\WebApiClient;

class K3CloudApi extends WebApiClient
{
	private static $pre_str = 'Kingdee.BOS.WebApi.ServicesStub.DynamicFormService.';

	/** 
	 * @api: 保存
	 * @param mixed $form_id 业务对象标识 string
	 * @param mixed $data 请求参数 array
	 * @return mixed 调用接口返回结果 string
	 */
	public function save($form_id, $data)
	{
		$arr = array($form_id, $data);
		return $this->execute(self::$pre_str . "Save", $arr);
	}
	/** 
	 * @api: 批量保存
	 * @param mixed $form_id 业务对象标识 string
	 * @param mixed $data 请求参数 array
	 * @return mixed 调用接口返回结果 string
	 */
	public function batch_save($form_id, $data)
	{
		$arr = array($form_id, $data);
		return $this->execute(self::$pre_str . "BatchSave", $arr);
	}
	/** 
	 * @api: 审核
	 * @param mixed $form_id 业务对象标识 string
	 * @param mixed $data 请求参数 array
	 * @return mixed 调用接口返回结果 string
	 */
	public function audit($form_id, $data)
	{
		$arr = array($form_id, $data);
		return $this->execute(self::$pre_str . "Audit", $arr);
	}
	/** 
	 * @api: 删除
	 * @param mixed $form_id 业务对象标识 string
	 * @param mixed $data 请求参数 array
	 * @return mixed 调用接口返回结果 string
	 */
	public function delete($form_id, $data)
	{
		$arr = array($form_id, $data);
		return $this->execute(self::$pre_str . "Delete", $arr);
	}
	/** 
	 * @api: 反审核
	 * @param mixed $form_id 业务对象标识 string
	 * @param mixed $data 请求参数 array
	 * @return mixed 调用接口返回结果 string
	 */
	public function unaudit($form_id, $data)
	{
		$arr = array($form_id, $data);
		return $this->execute(self::$pre_str . "UnAudit", $arr);
	}
	/** 
	 * @api: 提交
	 * @param mixed $form_id 业务对象标识 string
	 * @param mixed $data 请求参数 array
	 * @return mixed 调用接口返回结果 string
	 */
	public function submit($form_id, $data)
	{
		$arr = array($form_id, $data);
		return $this->execute(self::$pre_str . "Submit", $arr);
	}
	/** 
	 * @api: 查看
	 * @param mixed $form_id 业务对象标识 string
	 * @param mixed $data 请求参数 array
	 * @return mixed 调用接口返回结果 string
	 */
	public function view($form_id, $data)
	{
		$arr = array($form_id, $data);
		return $this->execute(self::$pre_str . "View", $arr);
	}
	/** 
	 * @api: 单据查询
	 * @param mixed $data 请求参数 array|string
	 * @return mixed 调用接口返回结果 string
	 */
	public function execute_bill_query($data)
	{
		return $this->execute(self::$pre_str . "ExecuteBillQuery", $data);
	}
	/** 
	 * @api: 暂存
	 * @param mixed $form_id 业务对象标识 string
	 * @param mixed $data 请求参数 array
	 * @return mixed 调用接口返回结果 string
	 */
	public function draft($form_id, $data)
	{
		$arr = array($form_id, $data);
		return $this->execute(self::$pre_str . "Draft", $arr);
	}
	/** 
	 * @api: 分配
	 * @param mixed $form_id 业务对象标识 string
	 * @param mixed $data 请求参数 array
	 * @return mixed 调用接口返回结果 string
	 */
	public function allocate($form_id, $data)
	{
		$arr = array($form_id, $data);
		return $this->execute(self::$pre_str . "Allocate", $arr);
	}
	/** 
	 * @api: 执行操作
	 * @param mixed $form_id 业务对象标识 string
	 * @param mixed $op_number 操作编码 string
	 * @param mixed $data 请求参数 array
	 * @return mixed 调用接口返回结果 string
	 */
	public function excute_operation($form_id, $op_number, $data)
	{
		$arr = array($form_id, $op_number, $data);
		return $this->execute(self::$pre_str . "ExcuteOperation", $arr);
	}
	/** 
	 * @api: 弹性域保存
	 * @param mixed $form_id 业务对象标识 string
	 * @param mixed $data 请求参数 array
	 * @return mixed 调用接口返回结果 string
	 */
	public function flex_save($form_id, $data)
	{
		$arr = array($form_id, $data);
		return $this->execute(self::$pre_str . "FlexSave", $arr);
	}
	/** 
	 * @api: 发送消息
	 * @param mixed $data 请求参数 array|string
	 * @return mixed 调用接口返回结果 string
	 */
	public function send_msg($data)
	{
		return $this->execute(self::$pre_str . "SendMsg", $data);
	}
	/** 
	 * @api: 下推
	 * @param mixed $form_id 业务对象标识 string
	 * @param mixed $data 请求参数 array
	 * @return mixed 调用接口返回结果 string
	 */
	public function push($form_id, $data)
	{
		$arr = array($form_id, $data);
		return $this->execute(self::$pre_str . "Push", $arr);
	}
	/** 
	 * @api: 分组保存
	 * @param mixed $form_id 业务对象标识 string
	 * @param mixed $data 请求参数 array
	 * @return mixed 调用接口返回结果 string
	 */
	public function group_save($form_id, $data)
	{
		$arr = array($form_id, $data);
		return $this->execute(self::$pre_str . "GroupSave", $arr);
	}
	/** 
	 * @api: 拆单
	 * @param mixed $form_id 业务对象标识 string
	 * @param mixed $data 请求参数 array
	 * @return mixed 调用接口返回结果 string
	 */
	public function disassembly($form_id, $data)
	{
		$arr = array($form_id, $data);
		return $this->execute(self::$pre_str . "Disassembly", $arr);
	}
	/** 
	 * @api: 查询单据信息
	 * @param mixed $data 请求参数 array|string
	 * @return mixed 调用接口返回结果 string
	 */
	public function query_business_info($data)
	{
		return $this->execute(self::$pre_str . "QueryBusinessInfo", $data);
	}
	/** 
	 * @api: 查询分组信息
	 * @param mixed $data 请求参数 array|string
	 * @return mixed 调用接口返回结果 string
	 */
	public function query_group_info($data)
	{
		return $this->execute(self::$pre_str . "QueryGroupInfo", $data);
	}
	/** 
	 * @api: 工作流审批
	 * @param mixed $data 请求参数 array|string
	 * @return mixed 调用接口返回结果 string
	 */
	public function work_flow_audit($data)
	{
		return $this->execute(self::$pre_str . "WorkflowAudit", $data);
	}
	/** 
	 * @api: 分组删除
	 * @param mixed $data 请求参数 array|string
	 * @return mixed 调用接口返回结果 string
	 */
	public function group_delete($data)
	{
		return $this->execute(self::$pre_str . "GroupDelete", $data);
	}
	/** 
	 * @api: 切换组织
	 * @param mixed $data 请求参数 array|string
	 * @return mixed 调用接口返回结果 string
	 */
	public function switch_org($data)
	{
		return $this->execute(self::$pre_str . "SwitchOrg", $data);
	}
	/** 
	 * @api: 取消分配
	 * @param mixed $form_id 业务对象标识 string
	 * @param mixed $data 请求参数 array
	 * @return mixed 调用接口返回结果 string
	 */
	public function cancel_allocate($form_id, $data)
	{
		$arr = array($form_id, $data);
		return $this->execute(self::$pre_str . "CancelAllocate", $arr);
	}
	/** 
	 * @api: 撤销服务
	 * @param mixed $form_id 业务对象标识 string
	 * @param mixed $data 请求参数 array
	 * @return mixed 调用接口返回结果 string
	 */
	public function cancel_assign($form_id, $data)
	{
		$arr = array($form_id, $data);
		return $this->execute(self::$pre_str . "CancelAssign", $arr);
	}
	/** 
	 * @api: 获取报表数据
	 * @param mixed $form_id 业务对象标识 string
	 * @param mixed $data 请求参数 array
	 * @return mixed 调用接口返回结果 string
	 */
	public function get_sys_report_data($form_id, $data)
	{
		$arr = array($form_id, $data);
		return $this->execute(self::$pre_str . "GetSysReportData", $arr);
	}
	/** 
	 * @api: 上传附件
	 * @param mixed $data 请求参数 array|string
	 * @return mixed 调用接口返回结果 string
	 */
	public function attachment_upload($data)
	{
		return $this->execute(self::$pre_str . "AttachmentUpload", $data);
	}
	/** 
	 * @api: 下载附件
	 * @param mixed $data 请求参数 array|string
	 * @return mixed 调用接口返回结果 string
	 */
	public function attachment_downLoad($data)
	{
		return $this->execute(self::$pre_str . "AttachmentDownLoad", $data);
	}
}
