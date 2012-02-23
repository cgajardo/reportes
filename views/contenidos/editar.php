<html>
<head>
    <script>
        function info(nombre,link,logrado,noLogrado,padre){
            alert("hola mundo");
        }
    </script>
</head>
<body>
<form action="<?php print($_SERVER['PHP_SELF']);?>?rt=contenidos/guardar" name="contenido" method="post">
Nombre<input type="text" name="nombre" value ="<?php echo $contenido->nombre;?>"/>
Link Repaso<input type="text" name="linkRepaso" value ="<?php echo $contenido->linkRepaso;?>"/>
Frase Logrado<input type="text" name="fraseLogrado" value ="<?php echo $contenido->fraseLogrado;?>"/>
Frase No Logrado<input type="text" name="fraseNoLogrado" value ="<?php echo $contenido->fraseNoLogrado;?>"/>
Contenido Padre<select name="padre"><option value="0">NO TIENE CONTENIDO PADRE</option>
<?php 

    foreach($contenidos as $cont){
        if($contenido->id!=$cont->id){
            echo '<option value="'.$cont->id.'"';
            if($contenido->padre==$cont->id){
                echo ' selected';
            }
            echo '>'.$cont->nombre.'</option>';
        }
    }

?>
</select>
<div id="info"></div>
<?php
    if(isset($contenido)){
        echo '<input name="id" value="'.$_POST['id']=$contenido->id.'" hidden readonly/>';
    }
?>
<input type="submit" value="Guardar"/>
</form>
</body>
</html>