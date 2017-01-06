<?php 
	require_once 'D:\phpapachemsql\www\interface\interface.php';
	require_once 'D:\phpapachemsql\www\model\Model_take_data.php';
	require_once 'D:\phpapachemsql\www\model\Model_relocation.php';
	class Controller_relocation {
		private $Model_take_data;
		private $Model_relocation;
		function __construct(IModel_take_data $model_data,IModel_relocation $model_relocation)
		{
			$this->Model_take_data = $model_data;
			$this->Model_relocation = $model_relocation;
		}
		public function Action_relocation(){
			$this->Model_relocation->Action_relocation();
			$this->Model_take_data->Action_take_data();
		}
	}
	#Model_take_data.php
	$obj_browser_scr = new script_browser_version_platform;
	$obj_reg = new take_region;
	$obj_bvp = new take_browser_version_platform($obj_browser_scr);
	$obj_date = new take_date_and_time;
	$obj_ip = new take_ip;
	$obj_msq = new Mysql_model_take_data($mysql_connect_object);
	$obj_model_take_data = new Model_take_data($obj_ip,$obj_date,$obj_bvp,$obj_reg,$obj_msq);
	#Model_relocation.php
	$obj_msqi = new Mysql_model_relocation($mysql_connect_object);
	$obj_model_relocation = new Model_relocation($obj_msqi);
	#Controller_relocation.php
	$obj_controller = new Controller_relocation($obj_model_take_data,$obj_model_relocation);
	$obj_controller->Action_relocation();
 ?>