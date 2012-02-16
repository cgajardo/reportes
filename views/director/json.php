<?php
$cadena = '[';
foreach ($arbol['detalle'] as $nombre => $nodo){
	$cadena .= '["'.utf8_encode($nombre).'",'.round($nodo['tiempo']/60/$nodo['alumnos']).'],';	
}
echo substr($cadena, 0, -1).']';
?>
