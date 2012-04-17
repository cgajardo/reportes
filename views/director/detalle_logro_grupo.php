<div id="matriz_desempeno" style="margin-bottom: 20px;" >
    <h4>Seleccione una evaluaci&oacute;n para ver el detalle</h4>
    <table>
        <tr id="tabla_desempeno">
            <?php
//var_dump($quizes_en_curso);
            $i = 0;
            foreach ($matriz_desempeño as $quiz => $columna) {
                echo '<td id="fila_desempeno">';
                $celdas = '';
                $logro_quiz = 0;
                $total_preguntas = 0;

                foreach ($columna as $celda) {
                    $celdas .= '<tr>';
                    //nos permite identificar si el control fue rendido o no
                    if ($celda['logro'] == -1) {
                        $celdas .= '<td class="no_rendido">' . utf8_encode($celda['contenido']->nombre) . '</td>';
                    } elseif ($celda['logro'] <= 45) {
                        $celdas .= '<td class="insuficiente">' . utf8_encode($celda['contenido']->nombre) . ' (' . round($celda['logro']) . '%)</td>';
                    } elseif ($celda['logro'] > 45 && $celda['logro'] < 55) {
                        $celdas .= '<td class="suficiente">' . utf8_encode($celda['contenido']->nombre) . ' (' . round($celda['logro']) . '%)</td>';
                    } elseif ($celda['logro'] >= 55) {
                        $celdas .= '<td class="destacado">' . utf8_encode($celda['contenido']->nombre) . ' (' . round($celda['logro']) . '%)</td>';
                    } else {
                        $celdas .= '<td class="no_rendido">' . utf8_encode($celda['contenido']->nombre) . ' (' . round($celda['logro']) . '%)</td>';
                    }
                    $celdas .= '</tr>';
                    $logro_quiz += $celda['logro'] * $celda['numero_preguntas'];
                    $total_preguntas += $celda['numero_preguntas'];
                }
                $s = $encrypter->encode("plataforma=" . $nombre_sede . "&grupo=" . $grupo->id . "&quiz=" . $quizes_en_grupo[$i]->id);
                echo '<table class="matriz" border="1">';
                echo '<tr><td class="header">';
                echo '<a href="../profesores/reporte?params=' . $s . '">' . $quiz . '</a> (' . round($logro_quiz / $total_preguntas) . '%)';
                echo '</td></td>';
                echo $celdas;
                echo '</table></td>';
                $i++;
            }
            ?>
        </tr>
    </table>
</div>