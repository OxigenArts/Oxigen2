<?php



namespace Core;

require_once "config/app.php";

class Loader {
    function __construct($oxigenInstance) {
        $this->oxigen = $oxigenInstance;
    }

    public function valid_directory($f) {
        if (is_object($f) || is_array($f)) {
            return true;
        } else {
            return false;
        }
    }

    public function loadOxigen() {
        global $APP_DIRECTORIES;
        require_once($APP_DIRECTORIES['oxigen-class']);
        return $this;
    }

    public function loadObjects() {
        global $APP_DIRECTORIES;
        $toforeach = scandir($APP_DIRECTORIES['objects-directory']);
        if($this->valid_directory($toforeach)){
          foreach($toforeach as $object) {
              if(!is_dir($object))
                require_once($APP_DIRECTORIES['objects-directory']."/".$object);
          }
        }
        return $this;
    }

    public function loadConfig() {
        global $APP_DIRECTORIES;
        $toforeach = scandir($APP_DIRECTORIES['config-directory']);
        if($this->valid_directory($toforeach)){
          foreach($toforeach as $object) {
              if(!is_dir($object))
                require_once($APP_DIRECTORIES['config-directory']."/".$object);
          }
        }
        return $this;
    }

    public function loadModules() {
        global $APP_DIRECTORIES;
        $toforeach = scandir($APP_DIRECTORIES['module-directory']);
        if($this->valid_directory($toforeach)){
          foreach($toforeach as $object) {
             if (is_dir($APP_DIRECTORIES['module-directory'] . "/" . $object) && $object != "." && $object != "..") {
                 require_once($APP_DIRECTORIES['module-directory'] . "/" . $object . "/index.php");
                 //echo "loading module $object </br>";
                $this->oxigen->regModule(new $object($this->oxigen));
                 
             }
          }
        }
        return $this;
    }

    public function loadSubModules($moduleName, $subModules) {
        global $APP_DIRECTORIES;
        foreach($subModules as $subModule) {
            require_once($APP_DIRECTORIES['module-directory'] . "/" . $moduleName . "/" . "submodules" . "/" . $subModule . ".php");
            $sMod = new $subModule($this->oxigen);
            if ($sMod->isGlobal) {
                $this->oxigen->regModule($sMod);
            }

            $this->oxigen->{$moduleName}->regSubModule($sMod->name);
        }
        return $this;
    }

    function loadCore() {
        return $this
                    ->loadObjects()
                    ->loadConfig()
                    ->loadOxigen()
                    ->loadModules();
    }
}

?>
