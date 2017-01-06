 <?php
 require_once 'D:\phpapachemsql\www\interface\interface.php';
 class script_browser_version_platform implements IScript_browser_version_platform{
 public function browser_and_version($user_agent)
  {
    if (strpos($user_agent, "Firefox") !== false){ 
    $browser = "Firefox";
    $version = explode('/', stristr($user_agent, 'Firefox'));
    }
    elseif (strpos($user_agent, "Opera") !== false){ 
      $browser = "Opera";
      $version = explode('/', stristr($user_agent, 'Opera'));
    }
    elseif (strpos($user_agent, "OPR") !== false){ 
      $browser = "Opera";
      $version = explode('/', stristr($user_agent, 'OPR'));
    }
    elseif (strpos($user_agent, "Edge") !== false){ 
      $browser = "Edge";
      $version = explode('/', stristr($user_agent, 'Edge'));
    }
    elseif (strpos($user_agent, "Chrome") !== false){ 
      $browser = "Chrome";
      $version = explode('/', stristr($user_agent, 'Chrome'));
      $version = explode(' ', $version[1]);
      $version = array_reverse($version);
    }
    elseif (strpos($user_agent, "MSIE") !== false){ 
      $browser = "Internet Explorer";
      $version = explode('/', stristr($user_agent, 'MSIE'));
    }
    elseif (strpos($user_agent, "Trident/7.0; rv:11.0") !== false){ 
      $browser = "Internet Explorer";
      $version = [0,"11"];
    }
    elseif (strpos($user_agent, "Safari") !== false){ 
      $browser = "Safari";
      $version = explode('/', stristr($user_agent, 'Safari'));
    }
    else {
      $browser = "Unknown";
      $version = array(' ','Unknown');
    }
    return array("browser"=>"$browser","version"=>"$version[1]");
  }
 public function platform($user_agent){
        if (stripos($user_agent, 'windows') !== false)
    		{
            $platform = 'windows';
        }
        else if (stripos($user_agent, 'linux') !== false)
        {
            $platform = "linux";
        }
        else if (stripos($user_agent, 'android') !== false)
        {
            $platform = "androird";
        }
        else if (stripos($user_agent, 'iPad') !== false)
        {
            $platform = "iPad";
        }
        else if (stripos($user_agent, 'iPod') !== false)
        {
            $platform = "iPod";
        }
        else if (stripos($user_agent, 'iPhone') !== false)
        {
            $platform = "iPhone";
        }
        else if (stripos($user_agent, 'mac') !== false)
        {
            $platform = "mac";
        }else
        {
        	$platform = "Unknown";
        }
        return $platform;
    }
}
?>