<?php
/**
 * Class that operate on table 'logs'. Database Mysql.
*
* @author: cgajardo
* @date: 2012-01-30 10:54
*/
class LogsMySqlDAO implements LogsDAO{
	
	
	/**
	 * cgajardo: esta funcion calcular‡ el tiempo que el usuario trabajando en el sistema
	 * entre dos fechas indicadas
	 *
	 * @param date $fecha_inicio
	 * @param date $fecha_fin
	 * @return int
	 */
	public function getTiempoEntreFechas($fecha_fin,$fecha_inicio = '0'){
		
		$sql = '';
	
		return 100;
	
	}

}

?>