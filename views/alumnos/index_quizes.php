<!DOCTYPE h1 PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!--
Pagina que muestra las evaluaciones de un determinado curso.
Al seleccionar una evaluacion, direcciona al alumno a la reporte seleccionado (reporte.php).
-->
<html>
<head>
	<title><?php echo $titulo;?></title>
	<link rel="stylesheet" type="text/css" href="../views/styles/galyleo.css" />
  	<style type="text/css">
  	.header_institucion {
		background-image: url("../views/images/logos/<?php echo $institucion->nombreCorto;?>-header.png");
		background-position: center;
		background-repeat: no-repeat;
		height: 150px;
		margin-top: -8px;
	}
	</style>
</head>
<body>
	<div class="header_institucion"></div>
        <!--<h1>Revisa tu calendario de actividades para este curso</h1>
        <table border="1" align="center"><tr><th>Eje</th><th>Tema</th><th>Fecha Inicio</th><th>Fecha Cierre</th></tr>-->
        <?php
//            foreach($calendario as $actividad){
//                echo '<tr><td>'.$actividad->idContenido.'</td>';
//                echo '<td><a href="'.$actividad->link.'">'.$actividad->frase."</a></td>";
//                echo '<td>'.$actividad->fechaInicio."</td>";
//                echo '<td>'.$actividad->fechaCierre."</td></tr>";
//            }
            
//            foreach($actividades_actual as $actividad_actual){
//                echo '<tr><td>'.$actividad_actual->idContenido.'</td>';
//                echo '<td><a href="'.$actividad_actual->link.'" style="text-decoration:blink">'.$actividad_actual->frase."</a></td>";
//                echo '<td>'.$actividad_actual->fechaInicio."</td>";
//                echo '<td>'.$actividad_actual->fechaCierre."</td></tr>";
//            }
        ?>
        <!--</table>-->
	<h1>Todas tus evaluaciones</h1>
	<p><?php $nombre=explode(" ",$usuario->nombre); echo ucwords(strtolower($nombre[0]));?> 
	selecciona una evaluaci&oacute;n para revisar tus notas</p>
	
	<?php
        if(!is_null($diagnostico)){
            echo '<a href="'.str_replace("index.php","",$_SERVER['PHP_SELF']).'alumnos/nivelacion?params='.$encrypter->encode('curso='.$id_curso.'&quiz='.$diagnostico->id).'">NIVELACION</a></br>';
        }
	foreach($quizes as $quiz){
		
		if($quiz->fechaCierre > date("Y-m-f H:m:s")){
			echo $quiz->nombre.' (no finalizada)</br>';
		} else {
			echo '<a href="'.str_replace("index.php","",$_SERVER['PHP_SELF']).'alumnos/reporte?params='.$encrypter->encode('&curso='.$id_curso.'&quiz='.$quiz->id).'">'.$quiz->nombre.'</a></br>';
		}
	} 
	echo '</br>';
	echo '<a href="'.str_replace("index.php","",$_SERVER['PHP_SELF']).'alumnos/index">&lt;-Todos tus cursos</a>';
	
	?>
	<div class="footer"></div>
</body>
<!-- Piwik Image Tracker -->
<img src="http://analytics.litmon.com/piwik.php?idsite=6&rec=1" style="border:0" alt="" />
<!-- End Piwik -->
</html>
