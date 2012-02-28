<html>
<head>
<title>Listado de contenidos</title>
<style>
    .header {
        height: 150px;
        margin-top: -8px;
        margin-left: auto;
        margin-right: auto;
    }
</style>
</head>
<body align="center">
    <img class="header" src="views/images/logos/galyleo.jpg"><br/><br/>
    <div align="left">
    <a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>contenidos/agregar">Nuevo Contenido</a><br/>
    <a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>contenidos/asociar">Asociar Contenido a Preguntas</a>
    </div><br/>
    <table border="1">
    <tr>
    <th>Nombre</th>
    <th>Link Repaso</th>
    <th>Frase No Logrado</th>
    <th>Frase Logrado</th>
    <th>Contenido Padre</th>
    <th>opciones</th>    
    </tr>
    <?php 
    foreach ($contenidos as $contenido){
            echo '<tr>';
            echo '<td>'.$contenido->nombre.'</td>';
            echo '<td>'.$contenido->linkRepaso.'</td>';
            echo '<td>'.$contenido->fraseNoLogrado.'</td>';
            echo '<td>'.$contenido->fraseLogrado.'</td>';
            echo '<td>'.$contenido->padre.'</td>';
    ?>
            <td>
            <a href="<?php print($_SERVER['PHP_SELF']);?>?rt=contenidos/eliminar&id=<?php echo $contenido->id;?>">eliminar</a>
            <a href="contenidos/editar?id=<?php echo $contenido->id;?>">modificar</a>	
            </td>
    <?php
            echo '</tr>'; 
    }
    ?>

    </table>
    <br/>
</body>
</html>
