<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface GruposDAO{
	
	/**
	 * Devuelve el grupo-galyleo correspondiente al grupo-moodle
	 * @param unknown_type $grupo_id_in_moodle
	 */
	public function getGrupoByIdEnMoodle($platform, $grupo_id_in_moodle);
	

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Grupos 
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
 	 * @param grupo primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Grupos grupo
 	 */
	public function insert($grupo);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Grupos grupo
 	 */
	public function update($grupo);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByNombre($value);

	public function queryByIdSede($value);

	public function queryByIdentificadorMoodle($value);


	public function deleteByNombre($value);

	public function deleteByIdSede($value);

	public function deleteByIdentificadorMoodle($value);


}
?>