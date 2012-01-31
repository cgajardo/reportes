<?php

include_once 'encrypter.php';

/**
 * cgajardo: recibe un arreglo de notas y devuelve el promedio de estas
 * @param array $notas
 */
function promedio_grupo($notas, $total_estudiantes){
	$i=0;
	$suma = 0;
	foreach ($notas as $nota){
		$i++;
		$suma+=$nota->nota;
	}
	return round($suma/$total_estudiantes);
	//return round($suma/$i);
} 

function posicion($notas_grupo, $nota_alumno){
	$i=0;
	foreach ($notas_grupo as $nota){
		$i++;
		if($nota->nota == $nota_alumno->nota){
			return $i;
		}
	}
}
?>