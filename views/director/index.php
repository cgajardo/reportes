<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Inicio Director</title>
     <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
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
<body style="font-family: Arial;border: 0 none;">
   	<div class="header_institucion"></div>
    <div class="contenido">
    	<h1>Bienvenido <?php echo $usuario->nombre;?>:</h1>
    	<h4>Selecciona a continuación alguna de las herramientas que tenemos disponibles:</h4>
		<ul>
		  <li><a href="./tiempo?id=<?php echo $usuario->id?>"><b>Comparaci&oacute;n tiempos de uso</b></a>
		 	 <br/> permite visualizar los tiempos de uso agrupados por sede, curso e instituci&oacute;n</li>
		  <li><a href="./logro?id=<?php echo $usuario->id?>"><b>Comparaci&oacute;n logro promedio</b></a>
		  	<br/> permite visualizar el nivel de logro promedio agrupado por sede, curso e instituaci&oacute;n</li>
		</ul>
    </div>
    <div class="footer"></div>
 </body>
 </html>
