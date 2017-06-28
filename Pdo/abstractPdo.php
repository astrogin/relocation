<?php
namespace Pdo;

use singletons\configSingleton;

abstract class abstractPdo
{
    protected $pdo;

    function __construct()
    {
        $config = configSingleton::getInstance()->getConfig();
        $dsn = "mysql:host=" . $config['host'] . ";dbname=" . $config['db'] . ";charset=" . $config["charset"];
        $user = $config['user'];
        $pass = $config['password'];
        $opt = $config['opt'];
        $this->pdo = new \PDO($dsn, $user, $pass, $opt);
    }

    protected function query($str, $param)
    {
        $stmt = $this->pdo->prepare($str);
        $stmt->execute($param);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function select($param)
    {
        return $this->query("SELECT * FROM Urls WHERE vertual = ?", $param);
    }
}