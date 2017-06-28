<?php
namespace singletons;

class configSingleton
{
    private static $instance;
    private $config;

    private function __construct()
    {
        if (file_exists(CONFIG_PATH)) {
            $this->config = parse_ini_file(CONFIG_PATH);
        } else {
            throw new \Exception("config doesn't exists");
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConfig()
    {
        return $this->config;
    }
}