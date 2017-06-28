<?php
namespace controllers;

use singletons\answerSingleton;

abstract class abstractController
{
    protected $answerModel;
    protected $modelClass;
    protected $modelPath;
    protected $viewPath;

    public function action()
    {
        $this->replacement();
        $this->createModel();
        $this->createAnswer();
        $this->includeView();
    }

    protected function replacement()
    {
        $this->modelClass = str_replace('controllers\controller', 'models\model', get_class($this));
        $this->modelPath = "../" . $this->modelClass . ".php";
        $view = str_replace('controllers\controller', 'view', get_class($this));
        $this->viewPath = VIEW_PATH . $view . ".php";
    }

    protected function createModel()
    {
        if (file_exists($this->modelPath)){
            require_once $this->modelPath;
        }else{
            throw new \Exception("file doesn't exists");
        }
        if (class_exists($this->modelClass)){
            $modelObject = new $this->modelClass;
        }else{
            throw new \Exception("Class doesn't exists");
        }
        if (method_exists($modelObject,"actionModel")){
            $method = "actionModel";
            $this->answerModel = $modelObject->$method();
        }else{
            throw new \Exception("method doesn't exists");
        }
    }

    protected function createAnswer()
    {
        $answer = answerSingleton::getInstance();
        $answer->setParam($this->answerModel);
    }

    protected function includeView()
    {
        require_once VIEW_HEADER_PATH;
        if (file_exists($this->viewPath)){
            require_once $this->viewPath;
        }else{
            throw new \Exception("file doesn't exists");
        }
        require_once VIEW_FOOTER_PATH;
    }
}