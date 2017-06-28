<?php
namespace controllers;
use singletons\answerSingleton;

class controllerHandler extends abstractController
{
    protected function createAnswer()
    {
        $answer = answerSingleton::getInstance();
        $count = count($this->answerModel);
        $arr = ["Реальная ссылка: ", "Сыллка для переходов: ", "Ссылка для статистики: "];
        $i = 0;
        $str = "";
        while ($i < $count){
            $str .= $arr[$i].DOMAIN."/".$this->answerModel[$i]."<br>";
            $i++;
        }
        $answer->setParam($str);
    }
}