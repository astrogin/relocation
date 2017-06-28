<?php
namespace command;

use request\RequestUrl;

class CommandRequest extends abstractCommand
{
    public function getCommand()
    {
        $request = RequestUrl::getInstance();
        if (substr_count($request->getParam(), "/")) {
            $answer = explode('/', $request->getParam())[1];
            if (substr_count($request->getParam(), "?")) {
                $answer = explode("?", $request->getParam())[0];
            }
        }
        return $answer;
    }
}