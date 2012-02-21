<html>
<head>

</head>
<body>
<h1>Lista de Instituciones</h1>
<<<<<<< HEAD
<<<<<<< HEAD
<p><?php echo $mensaje;?></p>
=======
<p><?php echo $mensaje_exito;?></p>
>>>>>>> Index de Instituciones
=======
<p><?php echo $mensaje;?></p>
>>>>>>> CRUD instituaciones: DONE
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
<<<<<<< HEAD
<<<<<<< HEAD
		<a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>instituciones/eliminar&id=<?php echo $institucion->id;?>">eliminar</a>
		<a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>instituciones/editar&id=<?php echo $institucion->id;?>">modificar</a>	
=======
	<form action="<?php print($_SERVER['PHP_SELF']);?>?rt=instituciones/eliminar" method="post">
		<input type="hidden" name="id" value="<?php echo $sede->id;?>"/>
		<a href="#" onclick="this.form.submit()">eliminarr</a>
	</form>
		<a href="<?php print($_SERVER['PHP_SELF']);?>?rt=instituciones/editar&id=<?php echo $sede->id;?>">modificar</a>	
>>>>>>> Index de Instituciones
=======
		<a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>instituciones/eliminar&id=<?php echo $institucion->id;?>">eliminar</a>
		<a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>instituciones/editar&id=<?php echo $institucion->id;?>">modificar</a>	
>>>>>>> CRUD instituaciones: DONE
	</td>
<?php 
		echo '</tr>';
	}
?>
</table>
<br/>
<<<<<<< HEAD
<<<<<<< HEAD
<a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>instituciones/agregar">Nueva Instituci&oacute;n</a>
=======
<a href="<?php print($_SERVER['PHP_SELF']);?>?rt=instituciones/agregar">Nueva Sede</a>
>>>>>>> Index de Instituciones
=======
<a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>instituciones/agregar">Nueva Instituci&oacute;n</a>
>>>>>>> CRUD instituaciones: DONE
</body>
</html>
