<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface ReportesDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Reportes 
	 */
	public function load($id);

	/**
	 * Get all records from table
	 */
	public function queryAll();
	
	/**
	 * Get all records from table ordered by field
	 * @Param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn);
	
	/**
 	 * Delete record from table
 	 * @param reporte primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Reportes reporte
 	 */
	public function insert($reporte);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Reportes reporte
 	 */
	public function update($reporte);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByIdPlataforma($value);

	public function queryByComponente($value);


	public function deleteByIdPlataforma($value);

	public function deleteByComponente($value);


}
?>