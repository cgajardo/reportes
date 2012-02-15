<?php
   
    function es_profesor(){
        $notas_grupo = $_SESSION['notas_grupo'];
        $usuario = $_SESSION['usuario'];
        $resp=TRUE;
        if(@$notas_grupo[$usuario->id]!=NULL){
            $resp=FALSE;
        }
        return $resp;
    }

    function matriz_desempeño(){
        
        $matriz_desempeño = $_SESSION['matriz_desempeño'];
        foreach($matriz_desempeño as $quiz => $columna){
                echo "<td>";
                    $celdas = '';
                    $logro_quiz = 0;
                    $total_preguntas = 0;

                    foreach ($columna as $celda){
                            $celdas .= '<tr>';
                            //nos permite identificar si el control fue rendido o no
                            if($celda['logro'] == -1){
                                    $celdas .= '<td class="no_rendido">'.$celda['contenido']->nombre.'</td>';
                            }elseif($celda['logro'] <= 45){
                                    $celdas .= '<td class="insuficiente">'.$celda['contenido']->nombre.' ('.round($celda['logro']).'%)</td>';
                            }elseif($celda['logro'] > 45 && $celda['logro'] < 55 ){
                                    $celdas .= '<td class="suficiente">'.$celda['contenido']->nombre.' ('.round($celda['logro']).'%)</td>';
                            }elseif ($celda['logro'] >= 55){
                                    $celdas .= '<td class="destacado">'.$celda['contenido']->nombre.' ('.round($celda['logro']).'%)</td>';
                            }else{
                                    $celdas .= '<td class="no_rendido">'.$celda['contenido']->nombre.' ('.round($celda['logro']).'%)</td>';
                            }
                            $celdas .= '</tr>';
                            $logro_quiz += $celda['logro']*$celda['numero_preguntas'];
                            $total_preguntas += $celda['numero_preguntas'];
                    }

                    echo '<table class="matriz" border="1">';
                    echo '<tr><td class="header">';
                    echo $quiz.' ('.round($logro_quiz/$total_preguntas).'%)';
                    echo '</td></td>';
                    echo $celdas;
                    echo '</table></td>';

            }
    }
    
    function promedio(){
        
        $notas_grupo = $_SESSION['notas_grupo'];
        $promedio_grupo = $_SESSION['promedio_grupo'];
        $usuario = $_SESSION['usuario'];
        ?>
        <script type="text/javascript">
            google.load("visualization", "1", {packages:["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Caso');
                data.addColumn('number', 'Nota');
                data.addRows([
                    ['Promedio Curso', <?php echo($promedio_grupo); ?>]
                <?php if(!es_profesor()){
                        echo ",['Nota Alumno',".$notas_grupo[$usuario->id]->logro."]";
                    }
                ?>
                ]);

                var options = {
                    title:'Promedio Curso',
                    vAxis: {showTextEvery: 1,viewWindow: {min: 0}}
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('promedio_grupo'));
                chart.draw(data, options);
            }
            
        </script>  
        
        
        <?php
    }
    
    function porcentaje_logro(){
        
        $matriz_desempeño = $_SESSION['matriz_desempeño'];
        $nombre_actividad = $_SESSION['nombre_actividad'];
        
        ?>
        <script>
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Contenido');
        data.addColumn('number', 'Porcentaje de Logro');
        data.addRows([
        <?php
        $logros_actividad=$matriz_desempeño[$nombre_actividad];
        for($i=0;$i<count($logros_actividad);$i++){
            if($i<count($logros_actividad)-1){                
                echo '["'.$logros_actividad[$i]['contenido']->nombre.'",'.(round($logros_actividad[$i]['logro'])/100).'],';
            }else{
                echo '["'.$logros_actividad[$i]['contenido']->nombre.'",'.(round($logros_actividad[$i]['logro'])/100).']';
            }
        }
        ?>
          
        ]);

        var options = {
          title: '% Logro de Contenidos',
          hAxis:{minValue:0,format:'#%'}
        };

        var chart = new google.visualization.BarChart(document.getElementById('logro_por_contenido'));
        chart.draw(data, options);
      }
    </script>
    <?php        
        
    }
    
    function histograma(){
        
        $notas_grupo = $_SESSION['notas_grupo'];
        $nota_maxima = $_SESSION['nota_maxima'];
        ?>
        
        <script type="text/javascript">
            
            <?php
                $conj_notas=array(0,0,0,0,0);
                
                foreach($notas_grupo as $nota){
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
                    title:'Histograma de Notas',
                    vAxis: {title:'Frecuencia',showTextEvery: 1,viewWindow: {min: 0}},
                    hAxis:{title:'Notas'}
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('histograma'));
                chart.draw(data, options);
            }
        </script> 
        <?

    }
    
    function pie_rendimiento(){
        
        $notas_grupo = $_SESSION['notas_grupo'];
        ?>
        <script type="text/javascript">
            <?php
                $ausentes=0;
                $aprobados=0;
                $reprobados=0;
                foreach($notas_grupo as $nota){
                    if($nota->logro==NUll){
                        $ausentes++;
                    }elseif($nota->logro>45){
                        $aprobados++;
                    }else{
                        $reprobados++;
                    }
                }
                $_SESSION['aprobados'] = $aprobados;
                $_SESSION['reprobados'] = $reprobados;
                $_SESSION['ausentes'] = $ausentes;
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
        };

        var chart = new google.visualization.PieChart(document.getElementById('aprobados'));
        chart.draw(data, options);
      }
    </script>
    <?php    
    }
    
    function ranking_notas(){
        
        $notas_grupo = $_SESSION['notas_grupo'];
        ?>
        <script type="text/javascript">
            google.load("visualization", "1", {packages:["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'alumno');
                data.addColumn('number', 'Puntaje');
                data.addRows([
<?php
$i = 1;
$prof =  es_profesor();
foreach ($notas_grupo as $nota) {
    if($nota->logro!=NULL){
        if($prof){
            echo '[\'' . $nota->apellido . " " . $nota->nombre;
            $i++;
        }else{
            echo '[\'' . $i++;
        }
        echo '\', ' . $nota->logro/100 . ']';
        if ($i <= count($notas_grupo)) {
            echo ',';
        }
    }else{
        if($prof){
            echo '[\'' . $nota->apellido . " " . $nota->nombre;
            $i++;
        }else{
            echo '[\'' . $i++;
        }
        echo '\',0]';
        if ($i <= count($notas_grupo)) {
            echo ',';
        }
    }
}
?>
                      ]);

                      var options = {
                          title: 'Ranking del Curso',
                          hAxis: {showTextEvery: 1,gridlines:{count:10}, slantedText:'True', slantedTextAngle: 90,textStyle:{fontSize:10},viewWindowMode:'maximized'},
                          vAxis: {showTextEvery: 1,viewindow: {min: 0},format:'# %'},
                          pointSize:5
                      };

                      var chart = new google.visualization.LineChart(document.getElementById('ranking_curso'));
                      chart.draw(data, options);
                      
                  }
        </script>
        
        <?php
    }
    
    function ranking_tiempos(){

        $notas_grupo = $_SESSION['notas_grupo'];
        $tiempos = $_SESSION['tiempos'];
        ?>

        <script type="text/javascript">
            google.load("visualization", "1", {packages:["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Alumno');
                data.addColumn('number', 'Minutos en Plataforma');
                data.addRows([
<?php
foreach ($notas_grupo as $id => $nota) {
    if ($id == count($notas_grupo) - 1) {
        echo '[\'' . $nota->apellido . " " . $nota->nombre . '\', ' . (int)($tiempos[$nota->id]/60) . ']';
    } else {
        echo '[\'' . $nota->apellido . " " . $nota->nombre . '\', ' . (int)($tiempos[$nota->id]/60) . '],';
    }
}
?>
                      ]);

                      var options = {
                          title: 'Ranking del Curso',
                          hAxis: {showTextEvery: 1,gridlines:{count:10}, slantedText:'True', slantedTextAngle: 90,textStyle:{fontSize:10},viewWindowMode:'maximized'},
                          vAxis: {showTextEvery: 1,viewindow: {min: 0}},
                          pointSize:5
                      };

                      var chart = new google.visualization.ColumnChart(document.getElementById('ranking_curso_2'));
                      chart.draw(data, options);
                      
                  }
        </script>
        <?        
    }
    
    function matriz_resago(){
        
        $matriz_contenidos = $_SESSION['matriz_contenidos'];
        
        $s = '';
    	foreach($matriz_contenidos as $contenido=>$quiz){
                $aux='';
                foreach($quiz as $celda){
                    if($celda['logro']==NULL || $celda['logro']<45){
                        $aux.= '<tr><td>'.$celda['apellido'].', '.$celda['nombre'].'</td></tr>';
                    }
                }
    		
    		
    		
    		$s.= '<table class=\"matriz\" border=\"1\" style=\"width:25%;\">';
    		$s.= '<tr><th>';
    		$s.= $contenido;
    		$s.= '</th>';
    		$s.= $aux;
    		$s.= '</table>';
                

    	} 
        ?>
        <script>
            document.getElementById("matriz_resago").innerHTML = "<?php echo $s;?>";
        </script>
            
        <?php
        
    }
    
    function tabla_notas(){
                    
        $tiempos = $_SESSION['tiempos'];
        $nombre_actividad = $_SESSION['nombre_actividad'];
        $notas_grupo = $_SESSION['notas_grupo'];
        
        $s = '<table border=\"1\" class=\"center\"><tr><th><b>Nombre</b></th><th><b>Nota '.$nombre_actividad.'</b></th><th>Minutos en la Plataforma</th></tr>';
        foreach($tiempos as $id=>$tiempo){
            $s.= '<tr><td>'.$notas_grupo[$id]->apellido.', '.$notas_grupo[$id]->nombre.'</td><td>';
            if($notas_grupo[$id]->logro!=NULL){
                $s.= $notas_grupo[$id]->logro;
            }else{
                $s.= 'No Rinde';
            }
            $s.= '</td><td>'.(int)($tiempo/60).'</td></tr>';
            //$s=$s.'</td><td></td></tr>';
        }
        $s.= '</table>';
        ?>
        <script>
            document.getElementById("tabla_notas").innerHTML = "<?echo $s;?>";
        </script>
        <?php
    }
?>
