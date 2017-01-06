<?php 
	require_once 'D:\phpapachemsql\www\interface\interface.php';
	require_once 'D:/phpapachemsql/www/model/Model_main.php';
	class Controller_main 
	{
		private $Model_obj;
		function __construct(IModel_main $model){
			$this->Model_obj = $model;
		}
		public function Action_index()
		{
			$this->chek_answer_model($this->Model_obj->Action_index());
		}		
		private function chek_answer_model($array){
			require_once "D:/phpapachemsql/www/View/View_main.php";
			if ($array != null) {
				showInfo($array);
			}else{
				ShowEmptyUrls();
			}
		}
	}
	#Model_cookie.php
	$take_cookie = new Take_cookies;
	$mysql_commands_cookie = new Mysql_for_cookie($mysql_connect_object);
	$set_cookie = new Set_cookies($take_cookie,$mysql_commands_cookie);
	$set_cookie->setting_cookies();
	#Model_main.php
	$Mysql_for_answer = new Mysql_for_answer($mysql_connect_object);
	$form_answer_urls = new form_answer_urls($take_cookie,$Mysql_for_answer,$set_cookie);
	$model_main_object = new Model_main($form_answer_urls,$Mysql_for_answer,$set_cookie);


	#controller_main.php
	$controller_obj = new Controller_main($model_main_object);
	$controller_obj->Action_index();
 ?>