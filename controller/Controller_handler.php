<?php
	require_once '../interface/Interface.php';
	require_once '../library/library_function.php';
    require_once "../model/Model_class_mysql.php";
    require_once '../connect.php';
	require_once '../model/Model_handler.php';
	class Controller_handler{
		private $array_urls_in_model = array();
		protected $Model_handler;
		function __construct(IModel_handler $obj){
			$this->Model_handler = $obj;
		}
		public function Action_handler()
		{
				$this->array_urls_in_model = $_REQUEST;
				$this->add_view($this->Model_handler->Action_handler($this->array_urls_in_model));
		}
		protected function add_view($arr){
			require_once "../View/View_handler.php";
			result_new_urls($arr);
		}
	}
    #connect.php
    $mysql_connect_object = new connect;
	#Model_handler.php
	$msq_command = new Mysql($mysql_connect_object);
	$sup_func = new executor_supporting_function($msq_command);
	$executor_obj = new executor_handler(new Mysql($mysql_connect_object),$sup_func);
	$model_obj = new Model_handler($executor_obj);
	#Controller_handler.php
	$controller_handler = new Controller_handler($model_obj);
    $controller_handler->Action_handler();
 ?>