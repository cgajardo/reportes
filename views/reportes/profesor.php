<?php 

    include 'application/graficos.php';
    $notas_grupo = $_SESSION['notas_grupo'];
    $nota_maxima = $_SESSION['nota_maxima'];
    $nombre_actividad = $_SESSION['nombre_actividad'];
    $usuario = $_SESSION['usuario'];
    $matriz_desempeño = $_SESSION['matriz_desempeño'];
    $promedio_grupo = $_SESSION['promedio_grupo'];
    $tiempos = $_SESSION['tiempos'];
    $matriz_contenidos = $_SESSION['matriz_contenidos'];
    

?>
<html>
    <head>
        <title><?php echo $titulo; ?></title>
        <link rel="stylesheet" type="text/css" href="/reportes/views/styles/galyleo.css" />
  	<style type="text/css">
            .border{
                border:1px solid;
            }
            .grafico{
                width: 48%;
                position:relative;
                margin:1%;
                float:left;
            }
            .header_institucion {
		background-image: url("views/images/logos/<?php echo $institucion->nombreCorto;?>-header.png");
		background-position: center;
		background-repeat: no-repeat;
		height: 150px;
		margin-top: -8px;
	}
	</style>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <!-- javascript for ranking_curso -->
        <?php
            ranking_notas()
        ?>
        <!-- javascript for ranking_curso2 -->
        <?php
            ranking_tiempos();
        ?>
        <!-- javascript for comparacion_promedio -->
        <?php
            promedio();
        ?>
        <!-- javascript for histograma -->
        <?php
            histograma();
        ?>
        <!-- javascript for aprobados -->
        <?php
            pie_rendimiento();
            $aprobados = $_SESSION['aprobados'];
            $reprobados = $_SESSION['reprobados'];
            $ausentes = $_SESSION['ausentes'];
            
        ?>
        <!-- javascript for logro_por_contenido -->
        <?php
        porcentaje_logro();
        ?>
    </head>
    <body class="center">
        <div class="header_institucion"></div>
        <h1 style="{text_align:center;}">Informe de Gesti&oacuten para el Docente</h1>
        <span>
            <?php 
                echo fecha_hoy();
                //var_dump($matriz_desempeño);
            ?>
        </span><br/>
        <b>EVALUACI&Oacute;N </b> <?php echo $nombre_actividad; ?><br/>
        <b>CURSO </b> <?php echo $nombre_curso." - ".$nombre_grupo; ?><br/>
        <b>DOCENTE </b> <?php echo $usuario->nombre." ".$usuario->apellido; ?><br/>
        <hr/>
        <div class="center">
            Estimado Docente:<br/>
            A continuaci&oacute;n podr&aacute; ver la Matriz de Desempe&ntilde;o de las evaluaciones
            rendidas a la fecha y en las p&aacute;ginas siguientes encontrar&aacute;
            los resultados de la &uacute;ltima actividad rendida.
        <div id="matriz_desempeno">           
            <div class="center">
    <?php
        //hola mundo
    	 matriz_desempeño();
        
    ?>
            </div>
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
        <div>
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
    <div id="matriz_resago" class="matriz">           
        Listado de alumnos que deben reforzar cada uno de los contenidos evaluados
        en '<?php echo $nombre_actividad;?>':
        
    <?php
        matriz_resago();
    ?>
        
    </div>
        <hr/>
        La siguiente tabla muestra la lista del curso y sus resultados generales: 
        <div id="tabla_notas">
        <?php
            tabla_notas();
        ?>  
        </div>
        </div>
        <br/><br/>
        <script>
            function asd(){
                if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp=new XMLHttpRequest();
                } else {// code for IE6, IE5
                        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }

                xmlhttp.onreadystatechange = function(){

                        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                        xmlhttp.responseText;
                        }
                }
                xmlhttp.open("GET","quiz_profesor?plataforma=utfsm&usuario=1104&grupo=24&quiz=61",true);
                xmlhttp.send();
            }
        
        </script>
    <button onclick="asd()"></button>
    <div class="footer"></div>
    </body>
