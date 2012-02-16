<div id="matriz_desempeno" style="margin-bottom: 20px;">
    <?php
    	foreach($matriz_desempeño as $quiz => $columna){
    		$celdas = '';
    		$logro_quiz = 0;
    		$total_preguntas = 0;
    		
    		foreach ($columna as $celda){
    			$celdas .= '<tr>';
    			//nos permite identificar si el control fue rendido o no
    			if($celda['logro'] == -1){
    				$celdas .= '<td class="no_rendido">'.utf8_encode($celda['contenido']->nombre).'</td>';
    			}elseif($celda['logro'] <= 45){
    				$celdas .= '<td class="insuficiente">'.utf8_encode($celda['contenido']->nombre).' ('.round($celda['logro']).'%)</td>';
    			}elseif($celda['logro'] > 45 && $celda['logro'] < 55 ){
    				$celdas .= '<td class="suficiente">'.utf8_encode($celda['contenido']->nombre).' ('.round($celda['logro']).'%)</td>';
    			}elseif ($celda['logro'] >= 55){
    				$celdas .= '<td class="destacado">'.utf8_encode($celda['contenido']->nombre).' ('.round($celda['logro']).'%)</td>';
    			}else{
    				$celdas .= '<td class="no_rendido">'.utf8_encode($celda['contenido']->nombre).' ('.round($celda['logro']).'%)</td>';
    			}
    			$celdas .= '</td>';
    			$logro_quiz += $celda['logro']*$celda['numero_preguntas'];
    			$total_preguntas += $celda['numero_preguntas'];
    		}
    		
    		echo '<table class="matriz">';
    		echo '<tr><td class="header">';
    		// caso de quiz no rendido
    		if ($total_preguntas == 0){
    			echo $quiz.' (-)';
    		}else{
    			echo $quiz.' ('.round($logro_quiz/$total_preguntas).'%)';
    		}
    		echo '</td></td>';
    		echo $celdas;
    		echo '</table>';	
    	} 
    ?>
    </div>