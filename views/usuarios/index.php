<html>
<head>

</head>
<body>
<h1>Lista de Usuarios</h1>
<h3>Direcores de Sedes e Instituciones</h3>
<h6>Estos usuarios tendr&aacute;n su propio Login al sistema pues no tienen cuenta en Moodle</h6>
<p><?php echo $mensaje;?></p>
<table>
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
		<a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>usuarios/eliminar&id=<?php echo $usuario->id;?>">eliminar</a>
		<a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>usuarios/editar&id=<?php echo $usuario->id;?>">modificar</a>
	</td>
<?php 
		echo '</tr>';
	}
?>
</table>
<br/>
<a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>usuarios/agregar">Nuevo Usuario</a>
</body>
</html>
