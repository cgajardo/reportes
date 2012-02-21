<html>
<head>
</head>
<body>

<form action="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>instituciones/guardar" name="institucion" method="post">

<?php 
	if($update){
 		echo '<input type="hidden" name="id" value ="'.$institucion->id.'"/>';
	}
?>

Nombre <input type="text" name="nombre" value ="<?php echo $institucion->nombre;?>"/>

Nombre Corto <input type="text" name="nombreCorto" value ="<?php echo $institucion->nombreCorto;?>"/>

Prefijo Evaluaciones <input type="text" name="prefijo" value ="<?php echo $institucion->prefijoEvaluacion;?>"/>

Nota Aprobado <input type="text" name="notaAprobado" value ="<?php echo $institucion->notaAprobado;?>"/>
		
<input type="submit" value="Guardar"/>
</form>
</body>
</html>