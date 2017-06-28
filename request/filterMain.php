<?php
namespace request;
class filterMain extends abstractFilter
{
    public function execute(string $str)
    {
        if ($str === $this->clean($str)) {
            return $str;
        }
       throw new \Exception('bad request');
    }

    private function clean($value)
    {
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        return $value;
    }
}