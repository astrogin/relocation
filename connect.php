<?php 
	class connect
	{
		private $host = 'localhost:3306';
		private $password = 'kira0810';
		private $user = "root";
		private $dbname = "my_db";
		public function new_user($h,$p,$u,$db){
			$this->host = $h;
			$this->password = $p;
			$this->user = $u;
			$this->dbname = $bd;
		}
		public function connecting(){
			$link = mysqli_connect($this->host,$this->user , $this->password, $this->dbname);
			$this->error();
			return $link;
		}
		private function error(){
			if (mysqli_connect_error()) {
				return exit;
			}
		}
	}
 ?>