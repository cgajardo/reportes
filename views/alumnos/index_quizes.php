<!DOCTYPE h1 PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title><?php echo $titulo;?></title>
	<link rel="stylesheet" type="text/css" href="/reportes/views/styles/galyleo.css" />
  	<style type="text/css">
  	.header_institucion {
		background-image: url("/reportes/views/images/logos/<?php echo $institucion->nombreCorto;?>-header.png");
		background-position: center;
		background-repeat: no-repeat;
		height: 150px;
		margin-top: -8px;
	}
	</style>
</head>
<body>
	<div class="header_institucion"></div>
	<h1>Todas tus evaluaciones</h1>
	<p><?php $nombre=explode(" ",$usuario->nombre); echo ucwords(strtolower($nombre[0]));?> 
	selecciona una evaluaci&oacute;n para revisar tus notas</p>
	
	<?php
        //echo '<a href="'.str_replace("index.php","",$_SERVER['PHP_SELF']).'alumnos/nivelacion?params='.$encrypter->encode('&curso='.$id_curso).'">NIVELACION</a></br>';
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
</html>
