<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface SedesHasDirectoressedeDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return SedesHasDirectoressede 
	 */
	public function load($idPersona, $idSede);

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
 	 * @param sedesHasDirectoressede primary key
 	 */
	public function delete($idPersona, $idSede);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param SedesHasDirectoressede sedesHasDirectoressede
 	 */
	public function insert($sedesHasDirectoressede);
	
	/**
 	 * Update record in table
 	 *
 	 * @param SedesHasDirectoressede sedesHasDirectoressede
 	 */
	public function update($sedesHasDirectoressede);	

	/**
	 * Delete all rows
	 */
	public function clean();



}
?>