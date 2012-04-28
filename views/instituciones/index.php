<html>
<head>
<link rel="stylesheet" type="text/css" href="../views/styles/galyleo.css" />
</head>
<body align="center">
    <img class="header" src="views/images/logos/galyleo.jpg">
<h1>Lista de Instituciones</h1>
<?php if(isset($mensaje)){
    echo $mensaje;
}
?>
<table border="1" align="center">
<tr>
<th>Nombre</th>
<th>Nombre Corto</th>
<th>Prefijo evaluaciones</th>
<th>Nota aprobado</th>
<th>Nota suficiente</th>
<th>Plataforma</th>
</tr>
<?php
	foreach ($instituciones as $institucion){
		echo '<tr>';
		echo '<td>'.$institucion->nombre.'</td>';
		echo '<td>'.$institucion->nombreCorto.'</td>';
		echo '<td>'.$institucion->prefijoEvaluacion.'</td>';
		echo '<td>'.$institucion->notaAprobado.'</td>';
		echo '<td>'.$institucion->notaSuficiente.'</td>';
		echo '<td>'.@$institucion->plataforma->nombre.'</td>';
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
<a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>instituciones/agregar"><button>Nueva Instituci&oacute;n</button></a>
<div class="footer"></div>
</body>
</html>
