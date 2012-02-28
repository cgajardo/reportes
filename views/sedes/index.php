<html>
<head>
<link rel="stylesheet" type="text/css" href="./views/styles/galyleo.css" />
</head>
<body align="center">
    <img class="header" src="views/images/logos/galyleo.jpg">
<h1>Lista de Sedes</h1>
<?php  echo @$mensaje_exito;?>
<table border="1" align="center">
<tr>
<th>Nombre</th>
<th>Pa&iacute;s</th>
<th>Regi&oacute;n</th>
<th>Ciudad</th>
<th>Instituci&oacute;n</th>
<th>opciones</th>
</tr>
<?php   
    foreach($instituciones as $institucion=>$sedes){
	foreach ($sedes as $sede){
		echo '<tr>';
		echo '<td>'.$sede->nombre.'</td>';
		echo '<td>'.$sede->pais.'</td>';
		echo '<td>'.$sede->region.'</td>';
		echo '<td>'.$sede->ciudad.'</td>';
		echo '<td>'.$institucion.'</td>';
?>
	<td>
                <a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>sedes/eliminar&id=<?php echo $sede->id;?>">eliminar</a>
		<a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>sedes/editar&id=<?php echo $sede->id;?>">modificar</a>
	</td>
<?php 
		echo '</tr>';
	}
    }
?>
</table>
<br/>
<a href="sedes/agregar"><button>Nueva Sede</button></a>
<div class="footer"></div>
</body>
</html>
