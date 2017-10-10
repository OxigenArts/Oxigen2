<?php 



namespace Core;

include_once "../config/app.php";


class Loader {
    function __construct() {
        
    }

    public function loadOxigen() {
        include_once($APP_DIRECTORIES['oxigen-class']);
        return $this;
    }

    public function loadObjects() {
        foreach(scandir($APP_DIRECTORIES['object-directory']) as $object) {
            include_once($APP_DIRECTORIES['object-directory'] . $object);
        }
        return $this;
    }

    public function loadConfig() {
        foreach(scandir($APP_DIRECTORIES['config-directory']) as $object) {
            include_once($APP_DIRECTORIES['config-directory'] . $object);
        }
        return $this;
    }

    public function loadModules() {
        foreach(scandir($APP_DIRECTORIES['module-directory']) as $module) {
            include_once($APP_DIRECTORIES['module-directory'] . $module);
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