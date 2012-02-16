<?php

$cadena = '[';
foreach ($arbol['detalle'] as $nombre => $nodo){
	$cadena .= '["'.utf8_encode($nombre).'",'.round($nodo['promedio'], 1).'],';	
}
echo substr($cadena, 0, -1).']';

?>
