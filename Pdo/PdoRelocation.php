<?php
namespace Pdo;

class PdoRelocation extends abstractPdo{
    public function insert($param){
        $this->query("INSERT INTO statistic VALUES (?,?,?,?,?,?,?)", $param);
    }
}