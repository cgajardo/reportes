<html>
<head>
    <link rel="stylesheet" type="text/css" href="../views/styles/galyleo.css" />
    <script>
        function info(nombre,link,logrado,noLogrado,padre){
            alert("hola mundo");
        }
    </script>
</head>
<body align="center">
    <img class="header" src="../views/images/logos/galyleo.jpg"/><br/><br/>
    <h2>Ingrese Informaci&oacute;n del Contenido</h2>
<form action="<?php echo($_SERVER['PHP_SELF']);?>?rt=contenidos/guardar" name="contenido" method="post">
    <table align="center">
<tr><td>Nombre</td><td><input type="text" name="nombre" value ="<?php echo $contenido->nombre;?>"/></td></tr>
<tr><td>Link Repaso</td><td><input type="text" name="linkRepaso" value ="<?php echo $contenido->linkRepaso;?>"/></td></tr>
<tr><td>Frase Logrado</td><td><input type="text" name="fraseLogrado" value ="<?php echo $contenido->fraseLogrado;?>"/></td></tr>
<tr><td>Frase No Logrado</td><td><input type="text" name="fraseNoLogrado" value ="<?php echo $contenido->fraseNoLogrado;?>"/></td></tr>
<tr><td>Contenido Padre</td><td><select name="padre"><option value="0">NO TIENE CONTENIDO PADRE</option>
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
</td></tr></table>
<input type="submit" value="Guardar"/>
</form>
    <div class="footer"></div>
</body>
</html>