<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!--
Esta pagina es la encargada de crear los reportes de nivelacion de cada alumno.
-->
<html>
    <head>
        <title><?php echo $titulo; ?></title>
        <link rel="stylesheet" type="text/css" href="../views/styles/galyleo.css" />
        <style type="text/css">
            .header_institucion {
                background-image: url("../views/images/logos/<?php echo $institucion->nombreCorto; ?>-header.png");
                background-position: center;
                background-repeat: no-repeat;
                height: 150px;
                margin-top: -8px;
            }
        </style>
        <script type="text/javascript" src="../views/js/googlecharts.js"></script>
    </head>
        <body class="center">
        <div class="header_institucion"></div>
        <div class="title"><h1>Informe de Resultados del Diagn&oacute;stico</h1></div>
        <div class="fecha_reporte"><?php echo fecha_hoy(); ?></div>
        <div class="hr"></div>
        <div class="datos_alumno">
            <b>Curso: </b><?php echo $nombre_curso ?></br>
            <b>Estudiante: </b><?php echo ucwords(strtolower($usuario->nombre)) . " " . ucwords(strtolower($usuario->apellido)); ?><br>
            <b>Usuario: </b><?php echo $usuario->usuario; ?><br>
        </div>
        <div class="hr"></div>
        <div style="{textalign:justify;}">
        Estimado Estudiante:<br>
        A continuaci&oacute;n podr&aacute; ver su Matriz de Desempe&ntilde;o en el diagn&oacute;stico, en la cual se presentan los 
        contenidos medidos en esta evaluaci&oacute;n con sus respectivos porcentajes de logro. El objetivo es que
        <b>!!!!!!!!!!!!!FECHA¡¡¡¡¡¡¡¡¡¡ </b>pueda transformar la matriz completa a verde. Para esto se le
        indicar&aacute;n semanalmente qu&eacute; actividades debe realizar.
        </div>
        
        <h1></h1>
    </body>
</html>