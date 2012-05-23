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
        <!-- javascript for ranking_curso -->
        <script type="text/javascript">
            google.load("visualization", "1", {packages:["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = new google.visualization.DataTable();
                data.addColumn('number', 'Alumno');
                data.addColumn('number', 'Porcentaje de logro');
                data.addRows([
<?php
$i=0;
foreach ($notas_grupo as $id => $nota) {
    if ($i == count($notas_grupo) - 1) {
        echo '[' . ($id + 1) . ', ' . ($nota->logro / 100) . ']';
    } else {
        echo '[' . ($id + 1) . ', ' . ($nota->logro / 100) . '],';
    }
    $i++;
};
for ($sinnotas = count($notas_grupo); $sinnotas < $total_estudiantes_grupo; $sinnotas++) {
    echo ',[' . ($sinnotas + 1) . ', 0]';
}
?>
                      ]);

                      var options = {
                          width: 800, height: 300,
                          title: 'Ranking del Curso',
                          hAxis: {showTextEvery: 1, showTextEvery:1,gridlines:{count:10}},
                          vAxis: {showTextEvery: 1,viewWindow: {min: 0},format:'#%'},
                          pointSize: 5
              
          };

                      var chart = new google.visualization.LineChart(document.getElementById('ranking_curso'));
                      chart.draw(data, options);
                  }
        </script>
        <!-- javascript for comparacion promedio -->
        <script type="text/javascript">
            google.load("visualization", "1", {packages:["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Caso');
                data.addColumn('number', 'Nota');
                data.addRows([
                    ['Promedio Curso', <?php echo($promedio_grupo); ?>]
                    
                ]);

                var options = {
                    width: 500, height: 340,
                    vAxis: {showTextEvery: 1,viewWindow: {min: 0}}
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('comparacion_grupo'));
                chart.draw(data, options);
            }
        </script>  
        
    </head>
        <body class="center">
        <div class="header_institucion"></div>
        <div class="title"><h1>Informe de Resultados del Diagn&oacute;stico</h1></div>
        <div class="fecha_reporte"><?php echo fecha_hoy(); ?></div>
        <div class="hr"></div>
        <div class="datos_grupo">
            <b>Curso: </b><?php echo $nombre_curso ?></br>
            <b>Usuario: </b><?php echo $usuario->usuario; ?><br>
        </div>
        <div class="hr"></div>
        <div style="{textalign:justify;}">
        Estimado Estudiante:<br>
        A continuaci&oacute;n podr&aacute; ver la Matriz de Desempe&ntilde;o del curso en el diagn&oacute;stico, en la cual se presentan los 
        contenidos medidos en esta evaluaci&oacute;n con sus respectivos porcentajes de logro. El objetivo es que 
        <b>antes del <?php echo $cierre;?> </b>se pueda transformar la matriz completa a verde. 
        </div>
         <div id="matriz_desempeno">
            <table id="tabla_desempeno">
                <tr id="fila_desempeno">
                <?php
                foreach ($matriz_diag as $unidad => $contenidos) {
                    $celdas = '';
                    $logro_quiz = 0;

                    foreach ($contenidos as $contenido=>$logro) {
                        $celdas .= '<tr>';
                        //nos permite identificar si el control fue rendido o no
                        if ($logro == -1) {
                            $celdas .= '<td class="no_rendido">' . $contenido . '(-)</td>';
                        } elseif ($logro <= $institucion->notaSuficiente) {
                            $celdas .= '<td class="insuficiente">' . $contenido . ' (' . round($logro) . '%)</td>';
                        } elseif ($logro > $institucion->notaSuficiente && $logro < $institucion->notaAprobado) {
                            $celdas .= '<td class="suficiente">' . $contenido . ' (' . round($logro) . '%)</td>';
                        } elseif ($logro >= $institucion->notaAprobado) {
                            $celdas .= '<td class="destacado">' . $contenido . ' (' . round($logro) . '%)</td>';
                        } else {
                            $celdas .= '<td class="no_rendido">' . $contenido . ' (' . round($logro) . '%)</td>';
                        }
                        $celdas .= '</td>';
                    }

                    echo '<td><table class="matriz">';
                    echo '<tr><td class="no_rendido">'.$unidad.'</td></td>';
                    echo $celdas;
                    echo '</table></td>';
                }
                ?>
                </tr>
            </table>
        </div>
        <?php if(!is_null($matriz_av)){
        echo '<div id="matriz_desempeno2">
            <br>A continuaci&oacute;n podras ver la matriz con tus nuevos logros
            considerando los avances del curso<br><br>
            <table id="tabla_desempeno2">
                <tr id="fila_desempeno2">';
        foreach ($matriz_av as $unidad => $contenidos) {
            $celdas = '';
            $logro_quiz = 0;

            foreach ($contenidos as $contenido=>$logro) {
                $celdas .= '<tr>';
                //nos permite identificar si el control fue rendido o no
                if ($logro == -1) {
                    $celdas .= '<td class="no_rendido">' . $contenido . '(-)</td>';
                } elseif ($logro <= $institucion->notaSuficiente) {
                    $celdas .= '<td class="insuficiente">' . $contenido . ' (' . round($logro) . '%)</td>';
                } elseif ($logro > $institucion->notaSuficiente && $logro < $institucion->notaAprobado) {
                    $celdas .= '<td class="suficiente">' . $contenido . ' (' . round($logro) . '%)</td>';
                } elseif ($logro >= $institucion->notaAprobado) {
                    $celdas .= '<td class="destacado">' . $contenido . ' (' . round($logro) . '%)</td>';
                } else {
                    $celdas .= '<td class="no_rendido">' . $contenido . ' (' . round($logro) . '%)</td>';
                }
                $celdas .= '</td>';
            }

            echo '<td><table class="matriz">';
            echo '<tr><td class="no_rendido">'.$unidad.'</td></td>';
            echo $celdas;
            echo '</table></td>';
        }
        echo '</tr></table></div>';
        }
        ?>
        <div>
            <table class="leyenda">
                <tr>
                    <td class="destacado">Logro &gt;= <?php echo $porcentaje_aprobado; ?>%</td>
                    <td class="suficiente"><?php echo $porcentaje_suficiente; ?>% &lt; Logro &lt;<?php echo $porcentaje_aprobado; ?>%</td>
                    <td class="insuficiente">Logro &lt;= <?php echo $porcentaje_suficiente; ?>%</td>
                    <td class="no_rendido">A&uacute;n no rendido</td>
                </tr>
            </table>
        </div>
        <div align="center">
        <div id="ranking_curso"></div>
        <div class="hr"></div>
            <div id="comparacion_grupo"></div>
        </div>
        <div class="hr"></div>

        </div>
    </body>
</html>