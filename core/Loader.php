<?php



namespace Core;

require_once "config/app.php";

class Loader {
    function __construct() {

    }

    public function loadOxigen() {
        echo "Loading Oxigen....";
        global $APP_DIRECTORIES;
        require_once($APP_DIRECTORIES['oxigen-class']);
        return $this;
    }

    public function loadObjects() {
        echo "Loading Objects...";
        global $APP_DIRECTORIES;
        echo "test1";
        print_r(scandir($APP_DIRECTORIES['objects-directory']));
        echo "test1";
        $toforeach = scandir($APP_DIRECTORIES['objects-directory']);
        if(is_array($toforeach) || is_object($toforeach)){
          foreach($toforeach as $object) {
              if(!is_dir($object))
                require_once($APP_DIRECTORIES['objects-directory']."/".$object);
          }
        }
        return $this;
    }

    public function loadConfig() {
        echo "Loading Config File...";
        global $APP_DIRECTORIES;
        $toforeach = scandir($APP_DIRECTORIES['config-directory']);
        if(is_array($toforeach) || is_object($toforeach)){
          foreach($toforeach as $object) {
              if(!is_dir($object))
                require_once($APP_DIRECTORIES['config-directory']."/".$object);
          }
        }
        return $this;
    }

    public function loadModules() {
        echo "Loading Modules...";
        global $APP_DIRECTORIES;
        $toforeach = scandir($APP_DIRECTORIES['module-directory']);
        if(is_array($toforeach) || is_object($toforeach)){
          foreach($toforeach as $object) {
              if(!is_dir($object))
                require_once($APP_DIRECTORIES['module-directory']."/".$object);
          }
        }
        return $this;
    }

    function loadCore() {
        echo "Starting...";
        return $this
                    ->loadObjects()
                    ->loadConfig()
                    ->loadOxigen()
                    ->loadModules();
    }
}

?>
