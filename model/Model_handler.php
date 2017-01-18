<?php
	use library_function\config;
	class Model_handler implements IModel_handler{
		private $executor_handler;
		private $array_answer_of_model_handler = array();
		function __construct($exec){
			$this->executor_handler = $exec;
		}
		public function Action_handler($array)
		{
			$this->executor_handler->logic_executer($array);
			$this->array_answer_of_model_handler = $this->executor_handler->array_answer;
			return $this->array_answer_of_model_handler;
		}
	}
	#update 08.01.2017 to version 1.1
	class executor_handler{
		private $Mysql_comands_handler;
		private $Executor_supporting_function;
		public $array_answer = array();
		function __construct($msq_comand,$sup){
			$this->Mysql_comands_handler = $msq_comand;
			$this->Executor_supporting_function = $sup;
		}
		public function executer ($array,$callback)
		{
			foreach ($array as $item)
			{
				yield $callback($item);
			}
		}
		public function logic_executer($item){
				$collect = $this->executer($item,function ($e){
				$real_url_result = $this->Mysql_comands_handler->find('realurl','Reality = ?',['s',$e]);
				$id = config::clean($_COOKIE['ID'] ?? 'Anon');
				if ($real_url_result->num_rows === 0) {
					$vertual_url = $this->Executor_supporting_function->addInTableRealurlNewUrl($e);
				}
				else {
					$vertual_url = $real_url_result->fetch_assoc()['Vertuality'];
					$statistic_url_result = $this->Mysql_comands_handler->find('statisticurl','cookie_ID = ? AND vertual_url = ?',['ss',$id,$vertual_url]);
					if ($statistic_url_result->num_rows !== 0) {
						$statistic_url = $statistic_url_result->fetch_assoc()['statistic_url'];
						$this->array_answer[] = $this->Executor_supporting_function->create_array_new_links($vertual_url, $statistic_url, $e);
						return;
					}
				}
				$statistic_url = $this->Executor_supporting_function->chekRandomVirtualityNameInMysqlForStatistic();
				$tables = ["statisticurl","statistic"];
				$this->Mysql_comands_handler->lock_table($tables,'WRITE');
				$this->Mysql_comands_handler->insert($tables[0],['sss',$id,$statistic_url,$vertual_url]);
				$this->Mysql_comands_handler->insert($tables[1],['s','statistic_url'=>"$statistic_url"]);
				$this->Mysql_comands_handler->unlock_table();
				$this->array_answer[] = $this->Executor_supporting_function->create_array_new_links($vertual_url,$statistic_url,$e);
			});
			foreach ($collect as $val);
		}
	}
	class executor_supporting_function{
		private $Mysql_comands_handler;
		function __construct($msq_comand){
			$this->Mysql_comands_handler = $msq_comand;
		}
		public function create_array_new_links($vert_url,$statistic_url,$real_url){
			$finalLinkTransition = $_SERVER['HTTP_HOST']."/".$vert_url."Q".$statistic_url;
			$finalLinkStatistics = $_SERVER['HTTP_HOST']."/".$vert_url."Q".$statistic_url."+";
			$array_answer = array($finalLinkTransition,$finalLinkStatistics,$real_url);
			return $array_answer;
		}
		public function chekRandomVirtualityNameInMysqlForStatistic() {
			$endVNForStatistic = config::randomVirtualityName();
			$result_query = $this->Mysql_comands_handler->find('statisticurl','statistic_url = ?',['s',$endVNForStatistic]);
			if ($result_query->num_rows !== 0) {
				$this->chekRandomVirtualityNameInMysqlForStatistic();
			}else{
				return $endVNForStatistic;
			};
		}
		public function addInTableRealurlNewUrl($real_url){
			$random_vertul_url = config::randomVirtualityName();
			$this->Mysql_comands_handler->lock_table(['realurl'],'WRITE');
			$result = $this->Mysql_comands_handler->find('realurl','Vertuality = ?',['s',$random_vertul_url]);
			if ($result->num_rows !== 0) {
				$this->addInTableRealurlNewUrl($real_url);
			}else{
				$this->Mysql_comands_handler->insert('realurl',['ss',$real_url,$random_vertul_url]);
				$this->Mysql_comands_handler->unlock_table();
				return $random_vertul_url;
			}
		}
	}
 ?>