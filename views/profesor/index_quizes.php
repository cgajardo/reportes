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
	selecciona una evaluaci&oacute;n para revisar las notas de tu curso</p>
	  
	<?php
	foreach($quizes as $quiz){
		
		if($quiz->fechaCierre > date("Y-m-f H:m:s")){
			echo $quiz->nombre.' (no finalizada)</br>';
		} else {
			echo '<a href="'. str_replace("index.php","",$_SERVER['PHP_SELF']).'profesores/reporte?params='.$encrypter->encode($origen.'&grupo='.$id_grupo.'&quiz='.$quiz->id).'">'.$quiz->nombre.'</a></br>';
		}
	} 
	echo '</br>';
	echo '<a href="'.$_SERVER['PHP_SELF'].'?rt=profesor/index&params='.$retorno.'">&lt;-Todos tus cursos</a>';
	
	?>
	<div class="footer"></div>
</body>
</html>
