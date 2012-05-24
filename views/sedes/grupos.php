<?php
    echo '<br/><b>'.utf8_encode($curso->nombre).'</b><select onchange="asociarCurso('.$curso->id.',this.value)">'.$combo;
    echo '<br/><h2>Grupos:</h2><br/>';
    echo '<table border="1" align="center"><tr><th>Nombre</th><th>Sede Actual</th><th>Nueva Sede</th></tr>';
    foreach($grupos as $grupo){
        echo '<tr><td>'.$grupo->nombre.'</td><td id="grupo'.$grupo->id.'">'.@($sedes[$grupo->idSede]->nombre).
                '</td><td><select onchange="asociarGrupo('.$grupo->id.',this.value)">'.$combo;
    }
?>
