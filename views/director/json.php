<?php
$cadena = '[';
foreach ($arbol['detalle'] as $nombre => $nodo){
	$cadena .= '["'.$nombre.'",'.$nodo['tiempo'].'],';	
}
echo substr($cadena, 0, -1).']';
?>