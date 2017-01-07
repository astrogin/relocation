<?php
	abstract class Mysql {
		protected $mysql_result = true;
		protected $link;
		function __construct(connect $connect){
			$this->link = $connect->connecting();
		}
		public function lock_table_write(...$args){
			if (isset($args[2])) {
				return mysqli_query($this->link,"LOCK TABLES $args[0],$args[1],$args[2] WRITE");
			}else if (isset($args[1])){
				return mysqli_query($this->link,"LOCK TABLES $args[0],$args[1] WRITE");
			}else{
				return mysqli_query($this->link,"LOCK TABLES $args[0] WRITE");
			}
		}
		public function unlock_table(){
			return mysqli_query($this->link,"UNLOCK TABLES");
		}
	}
 ?>