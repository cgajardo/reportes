<html>
<head>
</head>
<body>
<form action="<?php print($_SERVER['PHP_SELF']);?>?rt=contenidos/guardar" name="contenido" method="post">
Nombre<input type="text" name="nombre" value ="<?php echo $contenido->nombre;?>"/>
Link Repaso<input type="text" name="linkRepaso" value ="<?php echo $contenido->linkRepaso;?>"/>
Frase Logrado<input type="text" name="fraseLogrado" value ="<?php echo $contenido->fraseLogrado;?>"/>
Frase No Logrado<input type="text" name="fraseNoLogrado" value ="<?php echo $contenido->fraseNoLogrado;?>"/>
Contenido Padre<select><option value="0">NO TIENE CONTENIDO PADRE</option>
<?php 

    foreach($contenidos as $cont){
        if($contenido->id!=$cont->id){
            if($contenido->padre==$cont->id){
                echo '<option value="'.$cont->id.'" selected>'.$cont->nombre.'</option>';
            }else{
                echo '<option value="'.$cont->id.'">'.$cont->nombre.'</option>';
            }
        }
    }
?>
</select>
<input type="submit" value="Guardar"/>
</form>
</body>
</html>