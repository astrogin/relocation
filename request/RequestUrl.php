<?php
namespace request;


class RequestUrl extends AbstractRequest
{
    private $filter;
    private static $instance;
    private $answer;

    private function __construct()
    {
        $this->filter = new filterMain();
        $this->main();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function main()
    {
        $this->answer = $this->filter->execute($_SERVER['REQUEST_URI']);
    }

    public function setFilter(abstractFilter $filter)
    {
        $this->filter = $filter;
        $this->main();
    }

    public function getParam()
    {
        if(isset($this->answer)) {
            return $this->answer;
        }
    }
}