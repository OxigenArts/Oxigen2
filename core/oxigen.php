<?php 
/**
 * Oxigen Class
 * Core class
 */
namespace App;

use Core\Loader;

class Oxigen
{
  private $appName,$appVersion;
  public $loader, $loadedModules;
  function __construct($appName,$appVersion = null)
  {
    $this->loader = new Loader($this);
    $this->appName = $appName;
    $this->appVersion = $appVersion;
    $this->loadedModules = [];
  }

  function __destruct(){

  }

  public function init() {
    $this->loader->loadCore();
    $this->handle("Router");
  }

  public function handle($moduleName) {
    $this->{$moduleName}->start();
  }



  public function regModule($module, $routePath = null){
      if (!$module->enabled) {
        return;
      }

      if ($routePath) {
        $module->moduleRoute = $routePath;
      }

      $name = $module->name;
      $this->{$name} = $module;
      $this->{$name}->initSubModules();
      $this->{$name}->migrateTables();
      $this->loadedModules[$name] = "loaded";
  }
  
}

?>
