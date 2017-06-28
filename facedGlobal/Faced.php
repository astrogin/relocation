<?php
use router\FacedRouter;

define("VIEW_PATH", "../views/");
define("VIEW_FOOTER_PATH", "../views/viewFooter.php");
define("VIEW_HEADER_PATH", "../views/viewHeader.php");
define("CONFIG_PATH", "../config/config.ini");
define("TOOLS_PATH", "../tools/");
define("MODEL_PATH", "../models/");
define("DOMAIN", "localhost");

spl_autoload_register(function ($class_name) {
    $Path = "../" . $class_name . '.php';
    if (file_exists($Path)) {
        include $Path;
    } else {
        throw new \Exception("file doesn't exists" . $Path);
    }
});

class Faced
{
    public function run()
    {
        try {
            $router = new FacedRouter();
            $router->run();
        } catch (Exception $e) {
            echo $e->getMessage() . "<br>" . $e->getFile() . "<br>" . $e->getLine();
        }
    }
}