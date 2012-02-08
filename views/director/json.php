<?php
$cadena = '[';
foreach ($arbol['detalle'] as $nombre => $nodo){
	$cadena .= '["'.$nombre.'",'.$nodo['tiempo'].'],';
	
	foreach ($nodo['detalle'] as $nombre => $nodo){
		$cadena .= '["'.$nombre.'",'.$nodo['tiempo'].'],';
	}	
}
echo substr($cadena, 0, -1).']';
?>