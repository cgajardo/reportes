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
	<h1>Todos tus cursos</h1>
	<p> Bienvenido <?php echo ucwords(strtolower($usuario->nombre));?> 
	a continuaci&oacute;n podr&aacute;s revisar tu historial de evaluaciones y notas. </br>
	Por favor selecciona el curso que deseas revisar </p>
	  
	<?php
	foreach($cursos as $curso){
		echo '<a href="'.$_SERVER['PHP_SELF'].'?rt=profesor/index&params='.$encrypter->encode($origen.'&curso='.$curso->id).'">'.$curso->nombre.'</a></br>';	
	} 
	echo '</br>';
	?>

    <div class="footer"></div>
</body>
</html>