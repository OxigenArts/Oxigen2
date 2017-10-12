<?php 



namespace Core;

include_once "config/app.php";

class Loader {
    function __construct() {
        
    }

    public function loadOxigen() {
        echo "Loading Oxigen....";
        global $APP_DIRECTORIES;
        include_once($APP_DIRECTORIES['oxigen-class']);
        return $this;
    }

    public function loadObjects() {
        echo "Loading Objects...";
        global $APP_DIRECTORIES;
        echo "test1";
        print_r(scandir($APP_DIRECTORIES['objects-directory']));
        echo "test1";
        foreach(scandir($APP_DIRECTORIES['objects-directory']) as $object) {
            include_once($APP_DIRECTORIES['objects-directory'] . $object);
        }
        return $this;
    }

    public function loadConfig() {
        echo "Loading Config File...";
        global $APP_DIRECTORIES;
        foreach(scandir($APP_DIRECTORIES['config-directory']) as $object) {
            include_once($APP_DIRECTORIES['config-directory'] . $object);
        }
        return $this;
    }

    public function loadModules() {
        echo "Loading Modules...";
        global $APP_DIRECTORIES;
        foreach(scandir($APP_DIRECTORIES['module-directory']) as $module) {
            include_once($APP_DIRECTORIES['module-directory'] . $module);
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