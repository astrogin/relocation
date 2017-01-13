<?php
	abstract class Mysql {
		protected $mysql_result = true;
		protected $mysqli;
		function __construct(connect $connect){
			$this->mysqli = $connect->connecting();
		}
		public function lock_table_write(...$args){
			if (isset($args[2])) {
				return $this->mysqli->query("LOCK TABLES $args[0],$args[1],$args[2] WRITE");
			}else if (isset($args[1])){
				return $this->mysqli->query("LOCK TABLES $args[0],$args[1] WRITE");
			}else{
				return $this->mysqli->query("LOCK TABLES $args[0] WRITE");
			}
		}
		public function unlock_table(){
			return $this->mysqli->query("UNLOCK TABLES");
		}
		public function one_SELECT($table,$coll,$value){
			return $this->save_mode("SELECT * FROM $table WHERE $coll=?",["s",$value]);
		}
		/**
		 * @param $q - SQL
		 * @param $arr - 0(args = type) 1-n(var)
		 * @return mysqli_result
         */
		public function save_mode($q, $arr){
			$stmt = $this->mysqli->stmt_init();
			$refs = array();
		    foreach($arr as $key => $value) {
		        $arr[$key] = addslashes($value);
		        $refs[$key] = &$arr[$key]; 
		    }
		    if (
			   ($stmt->prepare("$q") === FALSE) 
			or (call_user_func_array(array($stmt,'bind_param'), $refs) === FALSE) 
			or ($stmt->execute() === FALSE)
			) {
		    	die();
			  }
			if (explode(" ",$q)[0] === "SELECT" && ($result = $stmt->get_result()) !== FALSE) return $result;
		}
	}
 ?>