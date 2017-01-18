<?php
	require_once 'interface\interface.php';
	require_once 'connect.php';
	require_once 'model\Model_class_mysql.php';
	require_once 'library\library_function.php';
	require_once 'model\Model_statistic.php';
	require_once 'view\View_statistic.php';
	class Controller_statistic {
		private $model_statistic;
		private $array_answer;
		function __construct(IModel_statistic $mdl)
		{
			$this->model_statistic = $mdl;
		}
		public function Action_statistic(){
			$this->array_answer = $this->model_statistic->Action_statistic();
			$this->logic_view($this->array_answer);
		}
		private function logic_view($array){
			if ($this->array_answer['date'] == null || $this->array_answer['date'][0]['date'] == null) {
				sortNolinks($array);
			}else{
				sortInformationByDate($array);
			}
		}
	}
	#connect.php
	$mysql_connect_object = new connect;
	#Model_statistic.php
	$mysql_statistic = new Mysql($mysql_connect_object);
	$model_statistic = new Model_statistic($mysql_statistic);
	#Controller_statistic.php
	$Controller_statistic = new Controller_statistic($model_statistic);
	$Controller_statistic->Action_statistic();
  ?>