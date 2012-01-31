<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface InstitucionesHasDirectoresDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return InstitucionesHasDirectores 
	 */
	public function load($idInstituacion, $idPersona);

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
 	 * @param institucionesHasDirectore primary key
 	 */
	public function delete($idInstituacion, $idPersona);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param InstitucionesHasDirectores institucionesHasDirectore
 	 */
	public function insert($institucionesHasDirectore);
	
	/**
 	 * Update record in table
 	 *
 	 * @param InstitucionesHasDirectores institucionesHasDirectore
 	 */
	public function update($institucionesHasDirectore);	

	/**
	 * Delete all rows
	 */
	public function clean();



}
?>