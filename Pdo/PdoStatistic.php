<?php
namespace Pdo;
class PdoStatistic extends abstractPdo{
    public function select($param)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM statistic WHERE statistic = ?");
        $stmt->execute($param);
        $arr = [];
        while($answer = $stmt->fetch(\PDO::FETCH_ASSOC)){
            $arr[] = $answer;
        }
        return $arr;
    }
}