<?php
$cadena = '[';
foreach (array_reverse($tiempos_semanas) AS $fecha => $tiempo){
	$cadena .= '["'.$fecha.'",'.round($tiempo/60,1).'],';
}
echo substr($cadena, 0, -1).']';
?>