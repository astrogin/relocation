<?php
	use library_function\config;
	class Model_handler implements IModel_handler{
		private $executor_handler;
		private $array_answer_of_model_handler = array();
		function __construct(IExecutor_handler $exec){
			$this->executor_handler = $exec;
		}
		public function Action_handler($array)
		{
			/*print_r($this->executor_handler->logic_executer($array));
			$collect = $this->executor_handler->executer($array,$this->executor_handler->logic_executer);
			foreach ($collect as $val) print_r($val);*/
			$this->executor_handler->logic_executer($array);
			$this->array_answer_of_model_handler = $this->executor_handler->array_answer;
			return $this->array_answer_of_model_handler;
		}
	}
	#update 08.01.2017 to version 1.1
	class executor_handler implements IExecutor_handler{
		private $arr_for_mysql = [];
		private $arr_for_arr_answer = [];
		private $Mysql_comands_handler;
		private $Executor_supporting_function;
		public $array_answer = array();
		function __construct(IMysql_comands_handler $msq_comand,IExecutor_supporting_function $sup){
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
				$real_url_result = $this->Mysql_comands_handler->same_real_url_SELECT('realurl','Reality',$e);
				$id = config::clean($_COOKIE['ID'] ?? 'Anon');
				if ($real_url_result === false) {
					$vertual_url = $this->Executor_supporting_function->addInTableRealurlNewUrl($e);
				}
				else {
					$vertual_url = mysqli_fetch_assoc($real_url_result)['Vertuality'];
					$statistic_url_result = $this->Mysql_comands_handler->same_vertual_url_SELECT('statisticurl','cookie_ID','vertual_url',$id,$vertual_url);
					if ($statistic_url_result !== false) {
						$statistic_url = mysqli_fetch_assoc($statistic_url_result)['statistic_url'];
						$this->array_answer[] = $this->Executor_supporting_function->create_array_new_links($vertual_url, $statistic_url, $e);
						return;
					}
				}
				$statistic_url = $this->Executor_supporting_function->chekRandomVirtualityNameInMysqlForStatistic();
				$this->Mysql_comands_handler->addInTablesStatisticurlAndStatisticNewUrl("statisticurl","statistic","statistic_url",$id,$statistic_url,$vertual_url);
				$this->array_answer[] = $this->Executor_supporting_function->create_array_new_links($vertual_url,$statistic_url,$e);
			});
			foreach ($collect as $val);
		}
	}
	class executor_supporting_function implements IExecutor_supporting_function{
		private $Mysql_comands_handler;
		function __construct(IMysql_comands_handler $msq_comand){
			$this->Mysql_comands_handler = $msq_comand;
		}
		public function create_array_new_links($vert_url,$statistic_url,$real_url){
			$finalLinkTransition = "localhost/".$vert_url."Q".$statistic_url;
			$finalLinkStatistics = "localhost/".$vert_url."Q".$statistic_url."+";
			$array_answer = array($finalLinkTransition,$finalLinkStatistics,$real_url);
			return $array_answer;
		}
		public function chekRandomVirtualityNameInMysqlForStatistic() {
			$endVNForStatistic = config::randomVirtualityName();
			$result_query = $this->Mysql_comands_handler->same_real_url_SELECT('statisticurl','statistic_url',$endVNForStatistic);
			if ($result_query !== false) {
				$this->chekRandomVirtualityNameInMysqlForStatistic();
			}else{
				return $endVNForStatistic;
			};
		}
		public function addInTableRealurlNewUrl($real_url){
			$random_vertul_url = config::randomVirtualityName();
			$this->Mysql_comands_handler->lock_table_write('realurl');
			if ($this->Mysql_comands_handler->same_real_url_SELECT('realurl','Vertuality',$random_vertul_url) !== false) {
				$this->addInTableRealurlNewUrl($real_url);
			}else{
				$this->Mysql_comands_handler->INSERT_one_table('realurl',$real_url,$random_vertul_url);
				$this->Mysql_comands_handler->unlock_table();
				return $random_vertul_url;
			}
		}
	}
	class Mysql_comands_handler extends Mysql implements IMysql_comands_handler{
		public function same_real_url_SELECT($table,$col,$val){
			return $this->logic_sql("SELECT * FROM $table WHERE $col = '$val'");
		}
		public function same_vertual_url_SELECT($table,$col_first,$col_second,$val_first,$val_second){
			return $this->logic_sql("SELECT * FROM $table WHERE `$col_first` = '$val_first' AND `$col_second` = '$val_second'");
		}
		public function INSERT_one_table(...$args){
			if (isset($args[3])) {
				mysqli_query($this->link,"INSERT INTO $args[0] VALUES ('$args[1]','$args[2]','$args[3]')");
			}else if (isset($args[2])){
				mysqli_query($this->link,"INSERT INTO $args[0] VALUES ('$args[1]','$args[2]')");
			}
		}
		public function addInTablesStatisticurlAndStatisticNewUrl($table_1,$table_2,$col,$val_1,$val_2,$val_3){
			mysqli_query($this->link, "LOCK TABLES $table_1,$table_2 WRITE");
			mysqli_query($this->link, "INSERT INTO $table_1 VALUES ('$val_1','$val_2','$val_3')");
			mysqli_query($this->link, "INSERT INTO $table_2 ($col) VALUES ('$val_2')");
			mysqli_query($this->link, "UNLOCK TABLES");
		}
		public function statistic_url_UPDATE($table,$col_first,$col_second,$col_third,$val_first,$val_second,$val_third){
			mysqli_query($this->link,"UPDATE $table SET $col_first = '$val_first',$col_second = '$val_second' WHERE $col_third = '$val_third'");
		}
		protected function logic_sql($q){
			$result = mysqli_query($this->link,"$q");
			if (isset($result->num_rows) && $result->num_rows >= 1) {
				return $result;
			}
			$this->mysql_result = false;
			return $this->mysql_result;
		}
	}
 ?>