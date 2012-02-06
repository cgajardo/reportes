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
}
?>
                      ]);

                      var options = {
                          width: 1400, height: 240,
                          title: 'Ranking del Curso',
                          hAxis: {showTextEvery: 1,gridlines:{count:10}, slantedText:'True', slantedTextAngle: 90,textStyle:{fontSize:10},viewWindowMode:'maximized'},
                          vAxis: {showTextEvery: 1,viewindow: {min: 0},format:'# %'},
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
                    title:'Promedio Curso',
                    width: 400, height: 240,
                    vAxis: {showTextEvery: 1,viewWindow: {min: 0}}
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('promedio_grupo'));
                chart.draw(data, options);
            }
            
        </script>  
        
        <script type="text/javascript">
            <?php
                $conj_notas=array(0,0,0,0,0);
                
                for($j=0;$j<count($notas_grupo);$j++){
                    if(($notas_grupo[$j]->logro>=0 && $notas_grupo[$j]->logro<=$nota_maxima/5) || $notas_grupo[$j]->logro==NULL){
                        $conj_notas[0]++;
                    }elseif($notas_grupo[$j]->logro>$nota_maxima/5 && $notas_grupo[$j]->logro<=$nota_maxima*2/5){
                        $conj_notas[1]++;
                    }elseif($notas_grupo[$j]->logro>$nota_maxima*2/5 && $notas_grupo[$j]->logro<=$nota_maxima*3/5){
                        $conj_notas[2]++;
                    }elseif($notas_grupo[$j]->logro>$nota_maxima*3/5 && $notas_grupo[$j]->logro<=$nota_maxima*4/5){
                        $conj_notas[3]++;
                    }elseif($notas_grupo[$j]->logro>$nota_maxima*4/5 && $notas_grupo[$j]->logro<=$nota_maxima){
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
                    title:'Histograma de Notas',
                    width: 400, height: 240,
                    vAxis: {title:'Frecuencia',showTextEvery: 1,viewWindow: {min: 0}},
                    hAxis:{title:'Notas'}
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('histograma'));
                chart.draw(data, options);
            }
        </script> 
        <script type="text/javascript">
            <?php
                $ausentes=0;
                $aprobados=0;
                $reprobados=0;
                for($i=0;$i<count($notas_grupo);$i++){
                    if($notas_grupo[$i]->logro==NUll){
                        $ausentes++;
                    }elseif($notas_grupo[$i]->logro>45){
                        $aprobados++;
                    }else{
                        $reprobados++;
                    }
                }
            ?>
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'situacion');
        data.addColumn('number', 'alumnos');
        data.addRows([
            <?php
            echo "['Aprobados',".$aprobados."],['Reprobados',".$reprobados."],['Ausentes',".$ausentes."]";
            ?>
        ]);

        var options = {
          width: 450, height: 300
        };

        var chart = new google.visualization.PieChart(document.getElementById('aprobados'));
        chart.draw(data, options);
      }
    </script>

    
    </head>
    <body>
        <div class="comparacion_grupo"></div>
        <p>El siguiente gr&aacutefico muestra el ranking general del curso, despu&eacutes de realizada la actividad <?php echo $nombre_actividad; ?>:</p>
        <div id="ranking_curso"></div>
        <hr/>
        <div id="promedio_grupo"></div>
        <p>El promedio del curso fue <?php echo $promedio_grupo; ?> considerando solo a los estudiantes que rindieron la actividad.</p>
        <hr/>
        <div id="histograma"></div>
        <p>El eje vertical representa la frecuencia, mientras que el eje horizontal intervalos de las notas.</p>
        <hr/>
        <div id="aprobados"></div>
        <p>Del total de estudiantes, el <?php echo intval(($aprobados/($aprobados+$reprobados+$ausentes))*100); ?>% aprob&oacute y el <?php echo intval(($reprobados/($aprobados+$reprobados+$ausentes))*100); ?>% reprob&oacute,
            mientras que un <?php echo intval(($ausentes/($aprobados+$reprobados+$ausentes))*100); ?>% no realiz&oacute la actividad y, por lo tanto,
            reprob&oacute.
        </p>
        <hr/>
        <div id="tabla_notas"></div>
    <script>
        <?php
            $s='<table border=\"1\"><tr><th><b>Nombre</b></th><th><b>Nota '.$nombre_actividad.'</b></th></tr>';
            foreach($notas_grupo as $nota){
                $s=$s.'<tr><td>'.$nota->apellido.', '.$nota->nombre.'</td><td>';
                if($nota->logro!=NULL){
                    $s=$s.$nota->logro;
                }else{
                    $s=$s.'No Rinde';
                }
                $s=$s.'</td></tr>';
            }
            $s=$s.'</table>';
        ?>  
        document.getElementById("tabla_notas").innerHTML= "<?php echo $s; ?>";
        
    </script>
    </body>
