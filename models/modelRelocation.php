<?php
namespace models;

use lib\Browser,Pdo\PdoRelocation,request\RequestUrl,lib\SxGeo;

class modelRelocation extends abstractModel
{
    private $url;
    function __construct()
    {
        $this->url = substr(RequestUrl::getInstance()->getParam(),1);
    }
    public function actionModel()
    {
        $strategy = new StrategyRelocationDefault();
        $strategy->execute($this->url);
    }
}
abstract class StrategyRelocation
{
    abstract function execute($url);
}

class StrategyRelocationDefault extends StrategyRelocation
{
    private $pdo;
    private $browserAndOs;

    function __construct()
    {
        $this->pdo = new PdoRelocation();
        $this->browserAndOs = new Browser();
    }

    public function execute($url)
    {
        if($answerSql = $this->pdo->select(Array($url))){
            $real = $answerSql["reality"];
            header("Location: http://$real",true,301);
            $this->saveData($url);
        }else{
            header("Location: 404.php",true,301);
        }
    }
    private function getDate(){
        return date("Y-m-d");
    }
    private function saveData($url){
        $url = $url."+";
        $date = $this->getDate();
        $ip = $_SERVER['REMOTE_ADDR'];
        $region = $this->getRegion();
        $browser = $this->browserAndOs->getBrowser();
        $version = $this->browserAndOs->getVersion();
        $os = $this->browserAndOs->getPlatform();
        $arr = [$url,$date,$ip,$region,$browser,$version,$os];
        $this->pdo->insert($arr);
    }
    private function getRegion(){
        $SxGeo = new SxGeo('..\lib\SxGeoCity.dat', SXGEO_BATCH | SXGEO_MEMORY);
        $region = $SxGeo->getCityFull($_SERVER["REMOTE_ADDR"])['region']['name_ru'];
        if ($region == '') {
            $region = 'Неизвестный регион';
        };
        return $region;
    }
}