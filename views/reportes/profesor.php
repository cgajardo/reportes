<html>
    <head>
        <title><?php echo $titulo; ?></title>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <!-- javascript for ranking_curso -->
        <script type="text/javascript">
            google.load("visualization", "1", {packages:["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'alumno');
                data.addColumn('number', 'Puntaje');
                data.addRows([
<?php
foreach ($notas_grupo as $id => $nota) {
    if($nota->logro!=NULL){
        if ($id == count($notas_grupo) - 1) {
            echo '[\'' . $nota->apellido . " " . $nota->nombre . '\', ' . $nota->logro/100 . ']';
        } else {
            echo '[\'' . $nota->apellido . " " . $nota->nombre . '\', ' . $nota->logro/100 . '],';
        }
    }else{
        if ($id == count($notas_grupo) - 1) {
            echo '[\'' . $nota->apellido . " " . $nota->nombre . '\', 0]';
        } else {
            echo '[\'' . $nota->apellido . " " . $nota->nombre . '\', 0],';
        }
    }
};
/*for ($sinnotas = count($notas_grupo); $sinnotas < $total_estudiantes_grupo; $sinnotas++) {
    echo ',[\'' . $sinnotas . '\', 0]';
}*/
?>
                      ]);

                      var options = {
                          width: 1400, height: 240,
                          title: 'Ranking del Curso',
                          hAxis: {showTextEvery: 1, showTextEvery:1,gridlines:{count:10}, slantedText:'True', slantedTextAngle: 90,textStyle:{fontSize:10},viewWindowMode:'maximized'},
                          vAxis: {showTextEvery: 1,viewindow: {min: 0},format:'#%'},
                          pointSize:5
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
                    width: 400, height: 240,
                    vAxis: {showTextEvery: 1,viewWindow: {min: 0}}
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('comparacion_grupo'));
                chart.draw(data, options);
            }
        </script>  
        <script type="text/javascript">
            <?php
                $conj_notas[0]=0;
                $conj_notas[1]=0;
                $conj_notas[2]=0;
                $conj_notas[3]=0;
                $conj_notas[4]=0;
                for($j=0;$j<count($notas_grupo);$j++){
                    if(($nota->logro>=0 && $nota->logro<=$nota_maxima/5) || $nota->logro==NULL){
                        $conj_notas[0]++;
                    }elseif($nota->logro>$nota_maxima/5 && $nota->logro<=$nota_maxima*2/5){
                        $conj_notas[1]++;
                    }elseif($nota->logro>$nota_maxima*2/5 && $nota->logro<=$nota_maxima*3/5){
                        $conj_notas[2]++;
                    }elseif($nota->logro>$nota_maxima*3/5 && $nota->logro<=$nota_maxima*4/5){
                        $conj_notas[3]++;
                    }elseif($nota->logro>$nota_maxima*4/5 && $nota->logro<=$nota_maxima){
                        $conj_notas[4]++;
                    }
                }
            ?>
            google.load("visualization", "1", {packages:["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Caso');
                data.addColumn('number', 'Nota');
                data.addRows([
                    <?php echo '[\'0-'.($nota_maxima/5).'\','.$conj_notas[0].'],'; 
                    echo '[\''.($nota_maxima/5).'-'.($nota_maxima*2/5).'\','.$conj_notas[1].'],'; 
                    echo '[\''.($nota_maxima*2/5).'-'.($nota_maxima*3/5).'\','.$conj_notas[2].'],'; 
                    echo '[\''.($nota_maxima*3/5).'-'.($nota_maxima*4/5).'\','.$conj_notas[3].'],'; 
                    echo '[\''.($nota_maxima*4/5).'-'.($nota_maxima).'\','.$conj_notas[4].']'; 
                    ?>
                ]);

                var options = {
                    width: 400, height: 240,
                    vAxis: {showTextEvery: 1,viewWindow: {min: 0}}
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('histograma'));
                chart.draw(data, options);
            }
        </script> 
    </head>
    <body>
        <h1>Informe de Gestión para el Docente</h1>
        <!-- TODO: mostrar la fecha de hoy -->
        <b>Evaluación: <?php echo $nombre_actividad;?></b>
        <b>Curso: </b><?php echo $nombre_curso; ?></br>
        <b>Estudiante: </b><?php echo ucwords(strtolower($usuario->nombre)) . " " . ucwords(strtolower($usuario->apellido)); ?></br>
        <hr/>
        <!--Div that will hold the pie chart-->
        <b>Matriz de desempe&ntilde;o</b>
        </br>
        <style type="text/css" media="screen">
            table { border: 1px solid black;float:left;width:148px;}
            #matriz_desempeno{width:800px;margin:0;overflow:hidden;}
        </style>
        <div id="matriz_desempeno">
            <?php
            /*foreach($matriz_desempeno as $quiz => $columna) {
                $celdas = '';
                $logro_quiz = 0;
                $total_preguntas = 0;
                foreach ($columna as $celda) {
                    $celdas .= '<tr>';
                    if ($celda['logro'] < 60) {
                        $celdas .= '<td class="reprueba">' . $celda['contenido']->nombre . '(' . $celda['logro'] . '%)</td>';
                    } else {
                        $celdas .= '<td>' . $celda['contenido']->nombre . '(' . $celda['logro'] . '%)</td>';
                    }
                    $celdas .= '</td>';
                    $logro_quiz += $celda['logro'] * $celda['numero_preguntas'];
                    $total_preguntas += $celda['numero_preguntas'];
                }

                echo '<table>';
                echo '<tr><td><b>';
                echo $quiz . '(' . round($logro_quiz / $total_preguntas) . '%)';
                echo '</b></td></td>';
                echo $celdas;
                echo '</table>';
            }
            */?>
        </div>
        <hr/>
        <br/>
        <hr/>
        <div class="comparacion_grupo">
            <p>Según lo que respondiste en la actividad <?php echo $nombre_actividad; ?>, cerrada el día <?php echo $fecha_cierre; ?>, tus resultados son los siguientes:</p>
            <div id="ranking_curso"></div>
            <hr/>
            <div id="comparacion_grupo"></div>
            <hr/>
            <div id="histograma"></div>
        </div>
    </body>
</html>