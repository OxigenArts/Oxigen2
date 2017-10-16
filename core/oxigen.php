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



  public function regModule($module){
      if (!$module->enabled) {
        return;
      }
      $name = $module->name;
      $this->{$name} = $module;
      $this->{$name}->initSubModules();
      $this->loadedModules[$name] = "loaded";
  }
  
}

?>
