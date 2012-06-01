<?php
/** includes **/
include('funciones.php');

/** Global vars **/
$DEBUG = 1;
$CURRENT = 0;
$PREFIX = 0;
$IDPLATAFORM = 0;

/** Main **/
$connectionLocal = getConection('local');
$plataformas = getPlataformas($connectionLocal);

/** se procesa cada plataforma registrada en la base de datos **/
foreach($plataformas as $plataforma){
	$IDPLATAFORM = $plataforma['id'];
	$CURRENT = $plataforma['nombre'];
	$PREFIX = $plataforma['prefijo_bd'];
	$conectionMoodle = getConection($CURRENT);
	procesarPersonas($conectionMoodle, $connectionLocal);
	procesarGrupos($conectionMoodle, $connectionLocal);
	procesarPreguntas($conectionMoodle, $connectionLocal);
	procesarIntentos($conectionMoodle, $connectionLocal);
	procesarLog($conectionMoodle, $connectionLocal);
	mysqli_close($conectionMoodle);
}

mysqli_close($connectionLocal);



function getConection($instancia){
	$link = null;
	switch($instancia){ 
		case 'local': 
			//conectarnos de manera segura con la base de datos de prueba en desarrollo
			//TODO: definir un tiempo de vida para el socket
			//shell_exec("ssh -f -L 3307:127.0.0.1:3306 root@209.20.92.248 sleep 3600 >> logfile");
		  	//$link = mysqli_connect('127.0.0.1', 'root', 'dAmjAXtf', 'test_ssh', 3307);
			$link = mysqli_connect('127.0.0.1', 'root', 'root', 'galyleo_new_model_v2', 3306);
  			if (!$link)
		    	die('Could not connect: ' . mysqli_error());
			debug('Connected successfully to local');
  			return $link;
  			break; 
  		case 'universidad':
  				//conectarnos de manera segura con la base de datos de prueba en desarrollo
  				//TODO: definir un tiempo de vida para el socket
			$link = mysqli_connect('127.0.0.1', 'root', 'root', 'dump_universidad', 3306);
  			if (!$link)
  				die('Could not connect: ' . mysqli_error());
  			debug('Connected successfully to institutos');
  			return $link;
  			break;
	} 
	
}

?>