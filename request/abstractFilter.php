<?php
namespace request;
abstract class abstractFilter
{
    abstract public function execute(string $str);
}