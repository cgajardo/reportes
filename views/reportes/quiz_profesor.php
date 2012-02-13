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

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<!-- javascript for ranking_curso -->
<?php

    ranking_notas()

?>
<div id="ranking_curso"></div>