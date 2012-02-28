<html>
<head>
<link rel="stylesheet" type="text/css" href="./views/styles/galyleo.css" />
</head>
<body align="center">
    <img class="header" src="views/images/logos/galyleo.jpg">
<h1>Lista de Usuarios</h1>
<h3>Direcores de Sedes e Instituciones</h3>
<h6>Estos usuarios tendr&aacute;n su propio Login al sistema pues no tienen cuenta en Moodle</h6>
<?php echo @$mensaje;?>
<table align="center" border="1">
<tr>
<th>Nombres</th>
<th>Apellidos</th>
<th>Email</th>
</tr>
<?php
	foreach ($usuarios as $usuario){
		echo '<tr>';
		echo '<td>'.$usuario->nombres.'</td>';
		echo '<td>'.$usuario->apellidos.'</td>';
		echo '<td>'.$usuario->email.'</td>';
?>
	<td>
		<a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>usuarios/eliminar&id=<?php echo $usuario->id.'&email='.$usuario->email;?>">eliminar</a>
		<a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>usuarios/editar&id=<?php echo $usuario->id;?>">modificar</a>
	</td>
<?php 
		echo '</tr>';
	}
?>
</table>
<br/>
<a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>usuarios/agregar"><button>Nuevo Usuario</button></a>
<div class="footer"></div>
</body>
</html>
