<?php
namespace router;

use command\{
    abstractCommand, CommandRequest
};
use singletons\configSingleton;

class FacedRouter
{
    public function run()
    {
        $router = new Router(new CommandRequest(), new defaultStrategyRouter());
        $router->run();
    }
}

class Router
{
    private $Command;
    private $ControllerReserved;
    private $ControllerFilePath;
    private $ControllerAction;
    private $ControllerClass;
    private $strategy;

    function __construct(abstractCommand $Command, StrategyRouter $strategy)
    {
        $this->Command = $Command->getCommand();
        $this->strategy = $strategy;
        $this->ControllerReserved = configSingleton::getInstance()->getConfig();
    }

    public function run()
    {
        $this->takeInConfigPathClassAction($this->strategy->SettingControllerPathClassAction($this->Command));
        if (file_exists($this->ControllerFilePath)){
            require_once $this->ControllerFilePath;
        }else{
            throw new \Exception("file doesn't exists");
        }
        if (class_exists($this->ControllerClass)){
            $objectController = new $this->ControllerClass;
        }else{
            throw new \Exception("class doesn't exists");
        }
        if (method_exists($objectController,$this->ControllerAction)){
            $method = $this->ControllerAction;
            $objectController->$method();
        }
    }

    private function takeInConfigPathClassAction($type)
    {
        if (!array_key_exists($type, $this->ControllerReserved)) {
            throw new \Exception("key in config doesn't reserved");
        }
        $this->ControllerFilePath = $this->ControllerReserved[$type]['file'];
        $this->ControllerAction = $this->ControllerReserved[$type]['action'];
        $this->ControllerClass = $this->ControllerReserved[$type]['class'];
    }
}

abstract class StrategyRouter
{
    abstract public function SettingControllerPathClassAction($str);
}

class defaultStrategyRouter extends StrategyRouter
{
    public function SettingControllerPathClassAction($str)
    {
        switch ($str) {
            case ($str === 0):
                return "index";
            case (substr_count($str, '+') > 0):
                return "statistic";
            case ($str === "/handler"):
                return "handler";
            case (strlen($str) >= 6 && strlen($str) <= 9):
                return "relocation";
            default:
                return $str;
        }
    }
}