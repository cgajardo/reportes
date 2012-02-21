<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-02-21 18:03
 */
interface SedesHasDirectoresDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return SedesHasDirectores 
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
 	 * @param sedesHasDirectore primary key
 	 */
	public function delete($idPersona, $idSede);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param SedesHasDirectores sedesHasDirectore
 	 */
	public function insert($sedesHasDirectore);
	
	/**
 	 * Update record in table
 	 *
 	 * @param SedesHasDirectores sedesHasDirectore
 	 */
	public function update($sedesHasDirectore);	

	/**
	 * Delete all rows
	 */
	public function clean();



}
?>