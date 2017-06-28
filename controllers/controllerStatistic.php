<?php
namespace controllers;

use singletons\answerSingleton;

class controllerStatistic extends abstractController
{
    protected function createAnswer()
    {
        $answer = answerSingleton::getInstance();
        $count = count($this->answerModel);
        $i = 0;
        $str = "";
        while ($i < $count){
            $str .= "<div>".
                    $this->answerModel[$i]["statistic"]."<br>".
                    $this->answerModel[$i]["date"]."<br>".
                    $this->answerModel[$i]["ip"]."<br>".
                    $this->answerModel[$i]["region"]."<br>".
                    $this->answerModel[$i]["browser"]."<br>".
                    $this->answerModel[$i]["version"]."<br>".
                    $this->answerModel[$i]["os"]."<br>".
                "</div><br>";
            $i++;
        }
        $answer->setParam($str);
    }
}