<html>
<head>

</head>
<body>
<h1>Lista de Instituciones</h1>
<p><?php echo $mensaje_exito;?></p>
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
	<form action="<?php print($_SERVER['PHP_SELF']);?>?rt=instituciones/eliminar" method="post">
		<input type="hidden" name="id" value="<?php echo $sede->id;?>"/>
		<a href="#" onclick="this.form.submit()">eliminarr</a>
	</form>
		<a href="<?php print($_SERVER['PHP_SELF']);?>?rt=instituciones/editar&id=<?php echo $sede->id;?>">modificar</a>	
	</td>
<?php 
		echo '</tr>';
	}
?>
</table>
<br/>
<a href="<?php print($_SERVER['PHP_SELF']);?>?rt=instituciones/agregar">Nueva Sede</a>
</body>
</html>
