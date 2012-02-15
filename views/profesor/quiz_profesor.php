<?php
    
    echo "{";
    echo "promedio:";
    promedio();
    echo ",porcentaje_logro:";
    porcentaje_logro();
    echo ",histograma:";
    histograma();
    echo ",pie_rendimiento:";
    pie_rendimiento();
    echo ",ranking_notas:";
    ranking_notas();
    echo ",ranking_tiempo:";
    ranking_tiempos();
    echo ",matriz_resago:";
    matriz_resago();
    echo ",tabla_notas";
    tabla_notas();
    echo "}";
        
    
    function promedio(){      
        $promedio_grupo = $_SESSION['promedio_grupo'];
        
        echo "[['Promedio Curso', ".$promedio_grupo."]]";
    }
    
    function porcentaje_logro(){
        
        $matriz_desempeño = $_SESSION['matriz_desempeño'];
        $nombre_actividad = $_SESSION['nombre_actividad'];
        
        $logros_actividad=$matriz_desempeño[$nombre_actividad];
        echo "[";
        for($i=0;$i<count($logros_actividad);$i++){
            if($i<count($logros_actividad)-1){                
                echo '["'.$logros_actividad[$i]['contenido']->nombre.'",'.(round($logros_actividad[$i]['logro'])/100).'],';
            }else{
                echo '["'.$logros_actividad[$i]['contenido']->nombre.'",'.(round($logros_actividad[$i]['logro'])/100).']';
            }
        }
        echo "]";
    }
    
    function histograma(){
        
        $notas_grupo = $_SESSION['notas_grupo'];
        $nota_maxima = $_SESSION['nota_maxima'];
        
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
                
                    echo '[[\'0-'.($nota_maxima/5).'\','.$conj_notas[0].'],'; 
                    echo '[\''.($nota_maxima/5).'-'.($nota_maxima*2/5).'\','.$conj_notas[1].'],'; 
                    echo '[\''.($nota_maxima*2/5).'-'.($nota_maxima*3/5).'\','.$conj_notas[2].'],'; 
                    echo '[\''.($nota_maxima*3/5).'-'.($nota_maxima*4/5).'\','.$conj_notas[3].'],'; 
                    echo '[\''.($nota_maxima*4/5).'-'.($nota_maxima).'\','.$conj_notas[4].']]'; 
    }
    
    function pie_rendimiento(){
        
        $notas_grupo = $_SESSION['notas_grupo'];
        
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
                
        echo "[['Aprobados',".$aprobados."],['Reprobados',".$reprobados."],['Ausentes',".$ausentes."]]";
        
    }
    
    function ranking_notas(){
        
        $notas_grupo = $_SESSION['notas_grupo'];
        
        $i = 1;
        $prof =  es_profesor();
        echo "[";
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
        echo "]";
    }
    
    function ranking_tiempos(){
        
        $notas_grupo = $_SESSION['notas_grupo'];
        $tiempos = $_SESSION['tiempos'];
        
        echo "[";
        $i=0;
        foreach ($notas_grupo as $id => $nota) {
            if ($i == count($notas_grupo) - 1) {
                echo '[\'' . $nota->apellido . " " . $nota->nombre . '\', ' . (int)($tiempos[$nota->id]/60) . ']';
            } else {
                echo '[\'' . $nota->apellido . " " . $nota->nombre . '\', ' . (int)($tiempos[$nota->id]/60) . '],';
            }
            $i++;
        }
        echo "]";
        
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
        echo "\"".$s;
    }
    
    function tabla_notas(){
        
    }
    
    function es_profesor(){
        $notas_grupo = $_SESSION['notas_grupo'];
        $usuario = $_SESSION['usuario'];
        $resp=TRUE;
        if(@$notas_grupo[$usuario->id]!=NULL){
            $resp=FALSE;
        }
        return $resp;
    }
?>