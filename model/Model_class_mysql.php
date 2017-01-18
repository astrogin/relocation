<?php
class Mysql {
	protected $mysql_result = true;
	protected $mysqli;
	function __construct(connect $connect){
		$this->mysqli = $connect->connecting();
	}
	/**
	 * @param $arr tables for lock
	 * @param $type type lock
	 */
	public function lock_table($arr,$type){
		$str = '';
		foreach ($arr as $value) {
			$str .= $value.',';
		}
		$this->mysqli->query("LOCK TABLES $str $type");
	}
	public function unlock_table(){
		return $this->mysqli->query("UNLOCK TABLES");
	}
	/**
	 * @param str example-> id = ?
	 * @param value example->$arr['s',"somestring"] or $arr['i',"4"]
	 */
	public function find($table,$str,$value){
		return $this->save_mode("SELECT * FROM $table WHERE $str",$value);
	}
	/**
	 * @param $args - array(keys = colls,values = data)
	 */
	public function insert($table,$value){
		$arr_count = count($value) - 2;
		$str = '';
		if ($arr_count) {
			for ($i = 0; $i < $arr_count; $i++) {
				$str .= "?,";
			}
		}
		$str .= "?";
		if (array_keys($value)[1] !== 1){
			$type = array_shift($value);
			$str_keys = implode(',',array_keys($value));
			$arr_val = [$type];
			$arr_val = array_merge($arr_val,array_values($value));
			$this->save_mode("INSERT INTO $table ($str_keys) VALUES ($str)", $arr_val);
		}else {
			$this->save_mode("INSERT INTO $table VALUES ($str)", $value);
		}
	}
	/**
	 * @param $str - condition (WHERE $str)
	 * @param $args - array(0 = type data,keys = colls,values = data,last value = args in condition)
	 */
	public function update($table,$str,$args){
		$type = array_shift($args);
		$where = array_shift($args);
		$args_keys = array_keys($args);
		$args_last_key = array_pop($args_keys);
		$str_keys = '';
		$str_val = '';
		foreach ($args_keys as $values) $str_keys .= $values.'= ?,';
		$str_keys .= $args_last_key."=?";
		$args_value = [$type];
		$args_value = array_merge($args_value,array_values($args));
		$args_value[] = $where;
		$this->save_mode("UPDATE $table SET $str_keys WHERE $str",$args_value);
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