<html>
<head>

</head>
<body>
<h1>Lista de Instituciones</h1>
<p><?php echo $mensaje;?></p>
<table>
<tr>
<th>Nombre</th>
<th>Nombre Corto</th>
<th>Prefijo evaluaciones</th>
<th>Nota aprobado</th>
</tr>
<?php
	foreach ($instituciones as $institucion){
		echo '<tr>';
		echo '<td>'.$institucion->nombre.'</td>';
		echo '<td>'.$institucion->nombreCorto.'</td>';
		echo '<td>'.$institucion->prefijoEvaluacion.'</td>';
		echo '<td>'.$institucion->notaAprobado.'</td>';
?>
	<td>
		<a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>instituciones/eliminar&id=<?php echo $institucion->id;?>">eliminar</a>
		<a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>instituciones/editar&id=<?php echo $institucion->id;?>">modificar</a>	
	</td>
<?php 
		echo '</tr>';
	}
?>
</table>
<br/>
<a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>instituciones/agregar">Nueva Instituci&oacute;n</a>
</body>
</html>
