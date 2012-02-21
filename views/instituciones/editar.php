<html>
<head>
</head>
<body>

<form action="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>instituciones/guardar" name="institucion" method="post">

<?php 
	//revisamos si se trata de un update
	if($update){
 		echo '<input type="hidden" name="id" value ="'.$institucion->id.'"/>';
	}
	
	//calculamos los valores para el combo
	$combo = '<option value="-1">Seleccione una Plataforma</option>';
	foreach ($plataformas as $plataforma){
		if($institucion->plataforma->id == $plataforma->id )
			$combo.='<option selected value="'.$plataforma->id.'">'.$plataforma->nombre.'</option>';
		else
			$combo.='<option value="'.$plataforma->id.'">'.$plataforma->nombre.'</option>';
		
	}
?>

Nombre <input type="text" name="nombre" value ="<?php echo $institucion->nombre;?>"/>

Nombre Corto <input type="text" name="nombreCorto" value ="<?php echo $institucion->nombreCorto;?>"/>

Prefijo Evaluaciones <input type="text" name="prefijo" value ="<?php echo $institucion->prefijoEvaluacion;?>"/>

Nota Aprobado <input type="text" name="notaAprobado" value ="<?php echo $institucion->notaAprobado;?>"/>

Plataforma <select name="plataforma" >.<?php echo $combo;?>.</select>		
<input type="submit" value="Guardar"/>
</form>
</body>
</html>