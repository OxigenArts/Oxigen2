En el loader...

supermodulo = carpeta con modulos

ejemplo:

```
.blog <-supermodulo
|--.classes/
|  |-- user.php
|  |-- post.php
|  `-- images.php
|-- archivos extra...
|-- install.php (opcional)
`-- config.php
```
"blog" es un supermodulo.

"config.php" carga clases y dependencias y ademas realiza acciones iniciales como una especia de "install" que realizaria acciones iniciales como crear tablas de bases de datos y otras acciones del primer uso.

En el loader.php...
```php
<?php
function cargarModulos(){
  $supermodulos = scandir("modules/");
  foreach ($supermodulos as $supermodulo){
    is_dir(supermodulo)
      require_once(dirname($supermodulo)."/config.php");//incluye el config
  }
}
?>
```

ejemplo de config.php...
```php
<?php
if(primer uso)
  require_once(install.php);

require_once(directorio_actual."/classes/user.php");
require_once(directorio_actual."/classes/post.php");
require_once(directorio_actual."/classes/images.php");
$registro_de_usuarios_activado = false;
etc...
?>
```
