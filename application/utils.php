<?php

include_once 'encrypter.php';


/**
 * devuelve la fecha de hoy en formato "Lunes 30 de Enero de 2012" 
 * @author cgajardo
 * @return string
 */
function fecha_hoy(){
	
	$dia_semana = date("w");
	$dia = date("j");
	$mes = date("n");
	$año = date("Y");
	
	switch ($dia_semana){
		case 0: $dia_semana = "Domingo"; break;
		case 1: $dia_semana = "Lunes"; break;
		case 2: $dia_semana = "Martes"; break;
		case 3: $dia_semana = "Miercoles"; break;
		case 4: $dia_semana = "Jueves"; break;
		case 5: $dia_semana = "Viernes"; break;
		case 6: $dia_semana = "Sabado"; break;
		default: $dia_semana = "Error";
	}
	
	switch($mes){
		case 1: $mes = "enero"; break;
		case 2: $mes = "febrero"; break;
		case 3: $mes = "marzo"; break;
		case 4: $mes = "abril"; break;
		case 5: $mes = "mayo"; break;
		case 6: $mes = "junio"; break;
		case 7: $mes = "julio"; break;
		case 8: $mes = "agosto"; break;
		case 9: $mes = "septiembre"; break;
		case 10: $mes = "octubre"; break;
		case 11: $mes = "noviembre"; break;
		case 12: $mes = "diciembre"; break;
		default: $mes = "Error";
	}
	
	return $dia_semana.' '.$dia.' de '.$mes.' de '.$año;
}

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