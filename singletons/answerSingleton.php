<?php
namespace singletons;

class answerSingleton
{
    private static $instance;
    private $answer;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function setParam($str)
    {
        $this->answer = $str;
    }

    public function getParam()
    {
        if (isset($this->answer)) {
            return $this->answer;
        }else{
            throw new \Exception("answer not defined");
        }
    }
}