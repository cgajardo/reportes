<html>
<head>
</head>
<body>

<form action="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>usuarios/guardar" name="usuarios" method="post">

<?php 
	//revisamos si se trata de un update
	if($update){
 		echo '<input type="hidden" name="id" value ="'.$usuario->id.'"/>';
	}
	
	//calculamos los valores para el combo
// 	$combo = '<option value="-1">Seleccione una Plataforma</option>';
// 	foreach ($plataformas as $plataforma){
// 		if($institucion->plataforma->id == $plataforma->id )
// 			$combo.='<option selected value="'.$plataforma->id.'">'.$plataforma->nombre.'</option>';
// 		else
// 			$combo.='<option value="'.$plataforma->id.'">'.$plataforma->nombre.'</option>';
		
// 	}
?>

Nombres <input type="text" name="nombres" value ="<?php echo $usuario->nombres;?>"/>

Apellidos <input type="text" name="apellidos" value ="<?php echo $usuario->apellidos;?>"/>

Email <input type="text" name="email" value ="<?php echo $usuario->email;?>"/>

<input type="submit" value="Guardar"/>
</form>
</body>
</html>