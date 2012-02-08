<?php
/**
 * Class that operate on table 'logs'. Database Mysql.
*
* @author: cgajardo
* @date: 2012-01-30 10:54
*/
class LogsMySqlDAO implements LogsDAO{
	
	
	/**
	 * cgajardo: esta funcion calculará el tiempo que el usuario trabajando en el sistema
	 * entre dos fechas indicadas
	 *
	 * @param date $fecha_inicio
	 * @param date $fecha_fin
	 * @param int $usuario_id
	 * @return int
	 */
	public function getTiempoEntreFechas($fecha_inicio, $fecha_fin, $usuario_id){
		//UNIX_TIMESTAMP
		$sql = 'SELECT tiempo, modulo, accion, id_modulo '.
				'FROM logs '. 
				'WHERE tiempo BETWEEN ? AND ? '.
					'AND id_persona = ? '.
                                'GROUP BY tiempo,modulo,accion,id_modulo '.
				'ORDER BY tiempo ASC';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setString($fecha_inicio);
		$sqlQuery->setString($fecha_fin);
		$sqlQuery->setNumber($usuario_id);
		
		return $this->contadorDeTiempo($sqlQuery);
	}

	public function getTiempoEntreFechas2($fecha_fin, $usuario_id){
		//UNIX_TIMESTAMP
		$sql = 'SELECT tiempo, modulo, accion, id_modulo '.
				'FROM logs '. 
				'WHERE FROM_UNIXTIME(tiempo) BETWEEN DATE_SUB( ? ,INTERVAL 1 MONTH) AND ? '.
					'AND id_persona = ? '.
                                'GROUP BY tiempo,modulo,accion,id_modulo '.
				'ORDER BY tiempo ASC';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setString($fecha_fin);
		$sqlQuery->setString($fecha_fin);
		$sqlQuery->setNumber($usuario_id);

		return $this->contadorDeTiempo($sqlQuery);
	}

        public function getTiempoTarea($fecha_fin, $grupo){
            $sql = 'SELECT id_persona FROM grupos_has_estudiantes '.
                   'WHERE id_grupo=?';
            
            $sqlQuery = new SqlQuery($sql);
            $sqlQuery->setNumber($grupo);
            $tab = QueryExecutor::execute($sqlQuery);
            $tiempos=array();
            for($i=0;$i<count($tab);$i++){
                $tiempos[$tab[$i]['id_persona']]= $this->getTiempoEntreFechas2($fecha_fin,$tab[$i]['id_persona']);
            }
            
            return $tiempos;
        }	 
	/**
	 * Esta funcion cuenta el tiempo
	 * @author cgajardo
	 * @return int
	 */
	protected function contadorDeTiempo($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$suma_tiempo = 0;
		
		for($i=0;$i<count($tab)-1;$i++){
                        if($tab[$i]['accion']!='logout'){
                            $delta = $tab[$i+1]['tiempo']-$tab[$i]['tiempo'];
                            //TODO: revisar ajustar este parametro
                            if($delta <= 3600){
                                    $suma_tiempo += $delta;
                            }else{
                                $suma_tiempo+= 3600;
                            }
                        }
		}
		
		return $suma_tiempo;
	}

}

?>