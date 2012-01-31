<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface GruposHasProfesoresDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return GruposHasProfesores 
	 */
	public function load($idPersona, $idGrupo);

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
 	 * @param gruposHasProfesore primary key
 	 */
	public function delete($idPersona, $idGrupo);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param GruposHasProfesores gruposHasProfesore
 	 */
	public function insert($gruposHasProfesore);
	
	/**
 	 * Update record in table
 	 *
 	 * @param GruposHasProfesores gruposHasProfesore
 	 */
	public function update($gruposHasProfesore);	

	/**
	 * Delete all rows
	 */
	public function clean();



}
?>