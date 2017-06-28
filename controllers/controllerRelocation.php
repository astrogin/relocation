<?php
namespace controllers;

class controllerRelocation extends abstractController
{
    public function action()
    {
        $this->replacement();
        $this->createModel();
    }
}
