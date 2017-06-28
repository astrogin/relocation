<?php
namespace request;

abstract class AbstractRequest
{

    abstract function setFilter(abstractFilter $filter);

    abstract function getParam();
}