<?php
namespace Pdo;

class PdoHandler extends abstractPdo
{

    public function insert($param)
    {
        $this->query("INSERT INTO urls(`reality`,`vertual`,`statistic`) VALUES (?,?,?)", $param);
    }
}