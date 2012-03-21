<html>
<head>
    <link rel="stylesheet" type="text/css" href="/reportes/views/styles/galyleo.css" />
</head>
<body align="center">
    <img class="header" src="../views/images/logos/galyleo.jpg"><br/><br/>
    <h2>Ingrese Informaci&oacute;n de la Instituci&oacute;n</h2>

<form action="guardar" name="institucion" method="post">

<?php 
	//revisamos si se trata de un update
	if(isset($update)){
 		echo '<input type="hidden" name="id" value ="'.$institucion->id.'"/>';
	}
	
	//calculamos los valores para el combo
	$combo = '<option value="-1">Seleccione una Plataforma</option>';
	foreach ($plataformas as $plataforma){
		if(isset($institucion->plataforma->id) && $institucion->plataforma->id == $plataforma->id )
			$combo.='<option selected value="'.$plataforma->id.'">'.$plataforma->nombre.'</option>';
		else
			$combo.='<option value="'.$plataforma->id.'">'.$plataforma->nombre.'</option>';
		
	}
?>
<table align="center">
<tr><td>Nombre </td><td><input type="text" name="nombre" value ="<?php echo $institucion->nombre;?>"/></td></tr>

<tr><td>Nombre Corto </td><td><input type="text" name="nombreCorto" value ="<?php echo $institucion->nombreCorto;?>"/></td></tr>

<tr><td>Prefijo Evaluaciones </td><td><input type="text" name="prefijo" value ="<?php echo $institucion->prefijoEvaluacion;?>"/></td></tr>

<tr><td>Nota Aprobado </td><td><input type="text" name="notaAprobado" value ="<?php echo $institucion->notaAprobado;?>"/></td></tr>
 
<tr><td>Nota Suficiente </td><td><input type="text" name="notaSuficiente" value ="<?php echo $institucion->notaSuficiente;?>"/></td></tr>

<tr><td>Plataforma </td><td><select name="plataforma" >.<?php echo $combo;?>.</select></td></tr>		
</table>
<input type="submit" value="Guardar"/>
</form>
    <div class="footer"></div>
</body>
</html>