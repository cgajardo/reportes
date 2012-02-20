<?php 
    
    $matriz_desempeño = $_SESSION['matriz_desempeño'];
    $tiempos = $_SESSION['tiempos'];
    $notas_grupo = $_SESSION['notas_grupo'];
    $matriz_contenidos = $_SESSION['matriz_contenidos'];
    
    function es_profesor(){
        $resp=TRUE;
        if(@$notas_grupo[$usuario->id]!=NULL){
            $resp=FALSE;
        }
        return $resp;
    }
    /*foreach($_SESSION as $n=>$x){
        echo $n.'=>';
        var_dump($x);
        echo '<hr/>';
    }*/
    

?>
<html>
    <head>
        <title><?php echo $titulo; ?></title>
        <link rel="stylesheet" type="text/css" href="/reportes/views/styles/galyleo.css" />
  	<style type="text/css">
            .border{
                border:1px solid;
                background-image: url("../views/images/loading.gif");
            }
            .grafico{
                width: 48%;
                position:relative;
                margin:1%;
                float:left;
            }
            .header_institucion {
		background-image: url("../views/images/logos/<?php echo $institucion->nombreCorto;?>-header.png");
		background-position: center;
		background-repeat: no-repeat;
		height: 150px;
		margin-top: -8px;
	}
	</style>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script>
                
        </script>

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
$i = 1;
$prof =  es_profesor();
foreach ($notas_grupo as $nota) {
    if($nota->logro!=NULL){
        if($prof){
            echo '[\'' . $nota->apellido . ", " . $nota->nombre;
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
            echo '[\'' . $nota->apellido . ", " . $nota->nombre;
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
                      google.visualization.events.addListener(chart, 'select', loadAlumno);
                      
                      function loadAlumno(){


                        //document.getElementById("chart_div").innerHTML='<img class="loading-gif" border="0" src="/reportes/views/images/loading.gif" alt="cargando"/>';
                        //recuperamos la id del director
                        var xmlhttp;
                        var selection = chart.getSelection();
                        for (var i = 0; i < selection.length; i++) {
                                var item = selection[i];
                            if (item.row != null) {
                                alumno = data['G'][item.row]['c'][0]['v'];
                            } else {
                                alert("error");
                            }
                        }
                        
                        if (window.XMLHttpRequest){
                                // code for IE7+, Firefox, Chrome, Opera, Safari
                                xmlhttp=new XMLHttpRequest();
                        }
                        else{
                                // code for IE6, IE5
                                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        xmlhttp.onreadystatechange=function() { 
                                if (xmlhttp.readyState==4 && xmlhttp.status==200){
                                        //document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
                                        //alert(xmlhttp.responseText);
                                        location.href='../alumnos/reporte?params='+xmlhttp.responseText;
                        }
                        }
                        xmlhttp.open("GET","data?plataforma=<?php echo $platform;?>&alumno="+alumno+"&curso=<?php echo $curso->id;?>&grupo=<?php echo $grupo->id;?>&quiz=<?php echo $quiz->id;?>",true);
                        xmlhttp.send();
                    }      
                }

        </script>
        <!-- javascript for ranking_curso2 -->
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
                            echo '[\'' . $nota->apellido . ", " . $nota->nombre . '\', ' . (int)($tiempos[$nota->id]/60) . ']';
                        } else {
                            echo '[\'' . $nota->apellido . ", " . $nota->nombre . '\', ' . (int)($tiempos[$nota->id]/60) . '],';
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
                      google.visualization.events.addListener(chart, 'select', loadAlumno);
                  
                  
                  function loadAlumno(){


                        //document.getElementById("chart_div").innerHTML='<img class="loading-gif" border="0" src="/reportes/views/images/loading.gif" alt="cargando"/>';
                        //recuperamos la id del director
                        var xmlhttp;
                        var selection = chart.getSelection();
                        for (var i = 0; i < selection.length; i++) {
                                var item = selection[i];
                            if (item.row != null) {
                                alumno = data['G'][item.row]['c'][0]['v'];
                            } else {
                                alert("error");
                            }
                        }
                        
                        if (window.XMLHttpRequest){
                                // code for IE7+, Firefox, Chrome, Opera, Safari
                                xmlhttp=new XMLHttpRequest();
                        }
                        else{
                                // code for IE6, IE5
                                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        xmlhttp.onreadystatechange=function() { 
                                if (xmlhttp.readyState==4 && xmlhttp.status==200){
                                        //document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
                                        //alert(xmlhttp.responseText);
                                        location.href='../alumnos/reporte?params='+xmlhttp.responseText;
                        }
                        }

                        xmlhttp.open("GET","data?plataforma=<?php echo $platform;?>&alumno="+alumno+"&curso=<?php echo $curso->id;?>&grupo=<?php echo $grupo->id;?>&quiz=<?php echo $quiz->id;?>",true);
                        xmlhttp.send();
                    }      
                }
        </script>
        <!-- javascript for comparacion_promedio -->
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
        <!-- javascript for histograma -->
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
        <!-- javascript for aprobados -->
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
        <!-- javascript for logro_por_contenido -->
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
    </head>
    <body class="center">
        <div class="header_institucion"></div>
        <h1>Informe de Gesti&oacuten para el Docente</h1>
        <div class="fecha_reporte">
        <?php 
            echo fecha_hoy();
            //var_dump($matriz_desempeño);
        ?>
        </div>
        <br/>
        <b>EVALUACI&Oacute;N </b> <?php echo $nombre_actividad; ?><br/>
        <b>CURSO </b> <?php echo $nombre_curso." - ".$nombre_grupo; ?><br/>
        <?php 
            if(isset($usuario)){
                echo "<b>DOCENTE </b>".$usuario->nombre." ".$usuario->apellido."<br/>"; 
            }
        ?>
        <hr/>
        <div class="center">
            Estimado Docente:<br/>
            A continuaci&oacute;n podr&aacute; ver la Matriz de Desempe&ntilde;o de las evaluaciones
            rendidas a la fecha y en las p&aacute;ginas siguientes encontrar&aacute;
            los resultados de la &uacute;ltima actividad rendida.
        <div id="matriz_desempeno">           
    <?php
        //hola mundo
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
        
    ?>

    </div>

            <div>
                <table class="leyenda" border="1">
                <tr>
                        <td class="destacado">Logro &gt;= 55%</td>
                        <td class="suficiente">45% &lt; Logro &lt;55%</td>
                        <td class="insuficiente">Logro &lt;= 45%</td>
                        <td class="no_rendido">A&uacute;n no rendido</td>
                </tr>
                </table>
            </div>
        </div>
        <hr/>
        <div id="reporte">
        Seg&uacute;n lo que sus alumnos respondieron en la actividad '<?php echo $nombre_actividad ?>',
        sus resultados son los siguientes:<br/>
        <div style="overflow:hidden;">
            <div class="grafico">
                <div class="border" id="logro_por_contenido"></div>
                El gr&aacute;fico representa el promedio de logro por contenido 
                respecto al total de estudiantes que rindieron la actividad '<?php echo $nombre_actividad;?>'.
            </div>
            <div class="grafico">
                <div class="border" id="promedio_grupo"></div>
                El promedio del curso fue <?php echo $promedio_grupo; ?> considerando solo a los estudiantes que rindieron la actividad.
            </div>
            <div class="grafico">
                <div class="border" id="histograma"></div>
                El eje vertical representa la frecuencia, mientras que el eje horizontal intervalos de las notas.
            </div>
            <div class="grafico">
                <div class="border" id="aprobados"></div>
                Del total de estudiantes, el <?php echo intval(($aprobados/($aprobados+$reprobados+$ausentes))*100); ?>% aprob&oacute y el <?php echo intval(($reprobados/($aprobados+$reprobados+$ausentes))*100); ?>% reprob&oacute,
                mientras que un <?php echo intval(($ausentes/($aprobados+$reprobados+$ausentes))*100); ?>% no realiz&oacute la actividad y, por lo tanto,
                reprob&oacute.
            </div>
        </div>
        <hr/>
        <div>
        <div>
            El siguiente gr&aacutefico muestra el ranking general del curso, despu&eacutes de realizada la actividad <?php echo $nombre_actividad; ?>:
            <div class="border" id="ranking_curso"></div>
        </div>
        <br/>
        <div>
            El siguiente gr&aacutefico muestra el tiempo que cada alumno estuvo en la plataforma desde un mes antes que terminara la actividad '<?php echo $nombre_actividad; ?>' del curso:
             <div class="border" id="ranking_curso_2"></div>        
        </div>
        </div>
        <hr/>
        <div>
        Listado de alumnos que deben reforzar cada uno de los contenidos evaluados
        en '<?php echo $nombre_actividad;?>':
    <div id="matriz_resago"></div>    
    <?php
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
        
    </div>
        <br class="ancho"/>
        <hr class="ancho"/>
        
        <p>La siguiente tabla muestra la lista del curso y sus resultados generales: </p>
        <div id="tabla_notas"></div>
        <?php
        
        $s = '<table border=\"1\"><tr><th><b>Nombre</b></th><th><b>Nota '.$nombre_actividad.'</b></th><th>Minutos en la Plataforma</th></tr>';
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
    </div>
        <br/><br/>
        <div class="footer"></div>
    </body>
</html>
