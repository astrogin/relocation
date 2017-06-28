<?php
namespace models;

use Pdo\PdoStatistic,request\RequestUrl;

class modelStatistic extends abstractModel
{
    private $url;
    private $pdo;
    function __construct()
    {
        $this->url = substr(RequestUrl::getInstance()->getParam(),1);
        $this->pdo = new PdoStatistic();
    }
    public function actionModel()
    {
        return $this->pdo->select(Array($this->url));
    }
}