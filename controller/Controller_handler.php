<?php 
	require_once 'D:\phpapachemsql\www\interface\interface.php';
	require_once 'D:\phpapachemsql\www\model\Model_handler.php';
	class Controller_handler{
		private $array_urls_in_model = array();
		protected $Model_handler;
		function __construct(IModel_handler $obj){
			$this->Model_handler = $obj;
		}
		public function Action_handler()
		{
				$this->array_urls_in_model = $_POST;
				$this->add_view($this->Model_handler->Action_handler($this->array_urls_in_model));
		}
		protected function add_view($arr){
			require_once "D:/phpapachemsql/www/view/View_handler.php";
			result_new_urls($arr);
		}
	}
	#Model_handler.php
	$msq_command = new Mysql_comands_handler($mysql_connect_object);
	$sup_func = new executor_supporting_function($msq_command);
	$executor_obj = new executor_handler(new Mysql_comands_handler($mysql_connect_object),$sup_func);
	$model_obj = new Model_handler($executor_obj);
	#Controller_handler.php
	$controller_handler = new Controller_handler($model_obj);
	$controller_handler->Action_handler();
 ?>