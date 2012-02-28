<html>
<head>
    <link rel="stylesheet" type="text/css" href="../views/styles/galyleo.css" />
</head>
<body align="center">
    <img class="header" src="../views/images/logos/galyleo.jpg"><br/><br/>
    <h1>Ingrese Datos del Usuario</h1>
<form action="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>usuarios/guardar" name="usuarios" method="post">

<?php 
	//revisamos si se trata de un update
	if(isset($update)){
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
<table align="center">
<tr><td>Nombres </td><td><input type="text" name="nombres" value ="<?php echo @$usuario->nombres;?>"/></td></tr>

<tr><td>Apellidos </td><td><input type="text" name="apellidos" value ="<?php echo @$usuario->apellidos;?>"/></td></tr>

<tr><td>Email </td><td><input type="text" name="email" value ="<?php echo @$usuario->email;?>"/></td></tr>
</table>
<input type="submit" value="Guardar"/>
</form>
    <div class="footer"></div>
</body>
</html>