<?php
namespace models;

use request\RequestUrl, Pdo\PdoHandler;

class modelHandler extends abstractModel
{
    private $url;

    function __construct()
    {
        $this->url = explode("=", RequestUrl::getInstance()->getParam())[1];
    }

    public function actionModel()
    {
        $answer = new StrategyHandlerDefault();
        return $answer->execute($this->url);
    }
}

class generateAbridgedUrl
{
    public function generate()
    {
        $key = '';
        $array = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $c = count($array);
        for ($i = 0; $i <= 6; $i++) {
            @$key .= $array[rand(0, $c)];
        };
        return $key;
    }
}

abstract class StrategyHandler
{
    abstract function execute($url);
}

class StrategyHandlerDefault extends StrategyHandler
{
    private $generator;
    private $pdo;

    function __construct()
    {
        $this->generator = new generateAbridgedUrl();
        $this->pdo = new PdoHandler();
    }

    public function execute($url)
    {
        $arr = $this->createArrForPdo($url);
        $this->pdo->insert($arr);
        return $arr;
    }

    private function createArrForPdo($url)
    {
        $vertualUrl = $this->generator->generate();
        $statisticUrl = $vertualUrl . "+";
        if ($this->pdo->select(Array($vertualUrl))) {
            $this->createArrForPdo($url);
        } else {
            return Array($url, $vertualUrl, $statisticUrl);
        }
    }
}
