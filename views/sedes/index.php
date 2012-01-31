<html>
<head>

</head>
<body>
<h1>Lista de Sedes</h1>
<p><?php echo $mensaje_exito;?></p>
<table>
<tr>
<th>Nombre</th>
<th>Pa&iacute;s</th>
<th>Regi&oacute;n</th>
<th>Ciudad</th>
<th>Instituci&oacute;n</th>
<th>opciones</th>
</tr>
<?php
	foreach ($sedes as $sede){
		echo '<tr>';
		echo '<td>'.$sede->nombre.'</td>';
		echo '<td>'.$sede->pais.'</td>';
		echo '<td>'.$sede->region.'</td>';
		echo '<td>'.$sede->ciudad.'</td>';
		echo '<td>'.$sede->institucion.'</td>';
?>
	<td>
	<form action="<?php print($_SERVER['PHP_SELF']);?>?rt=sedes/eliminar" method="post">
		<input type="hidden" name="id" value="<?php echo $sede->id;?>"/>
		<a href="#" onclick="this.form.submit()">eliminarr</a>
	</form>
		<a href="<?php print($_SERVER['PHP_SELF']);?>?rt=sedes/editar&id=<?php echo $sede->id;?>">modificar</a>	
	</td>
<?php 
		echo '</tr>';
	}
?>
</table>
<br/>
<a href="<?php print($_SERVER['PHP_SELF']);?>?rt=sedes/agregar">Nueva Sede</a>
</body>
</html>
