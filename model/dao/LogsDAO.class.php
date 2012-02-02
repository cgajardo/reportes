<?php
/**
 * Intreface DAO
 *
 * @author: cgajardo
 * @date: 2012-01-30 10:55
 */
interface LogsDAO{
	
	/**
	 * cgajardo: esta funcion calcular‡ el tiempo que el usuario trabajando en el sistema
	 * entre dos fechas indicadas
	 *
	 * @param date $fecha_inicio
	 * @param date $fecha_fin
	 * @param int $usuario_id
	 * @return int
	 */
	public function getTiempoEntreFechas($fecha_inicio, $fecha_fin, $usuario_id);
	

}
?>