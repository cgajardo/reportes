@autor: Carlos Gajardo

Este set de scripts tiene por objetivo sincronizar las bases de datos de cada instancia de moodle con el sistema de resportes de Galyleo.
Para poder ejecutar el script es necesario contar con el modelo de base de datos incluido en modelo.mwb (Mysql Workbench) y actualizar los par‡¡metros de conexi—n a la base de datos del sistema de resportes galyleo, en sync.php lineas 37 y 40.

Para cada instancia a sincronizar es necesario:
 * agregar el registro correpondiente en la tabla 'plataformas'. Donde nombre corresponde al de la plataforma y prefijo_bd al prefijo que se utiliza en la base de datos de tal plataforma.
 * agregar el caso correspondiente en sync.php funci—n getConection, en donde se definen los par‡mtros de conexi—n a cada instancia (utilizar el caso 'local' como ejemplo)
 
 Finalmente se debe ejecutar el script usando php (en l’nea de comando: php sync.php)

 

Changelog:

1.4
- [modelo] una instituaci—n puede tener varias plataformas (instancias de moodle)
- [fix] tiempo de duraci—n de un quiz

1.3
- se modific— el modelo para incluir la fecha de inicio de un quiz
- se actualiz— el script de sincronizaci—n

1.2
- recupera correctamente las notas sin importar el estado del quiz (Mayor Fix)
- recupera correctamente el ultimo id insertado en la conexi—n local

1.1
- incluye el soporte para registrar el log de actividades de cada usuario
 