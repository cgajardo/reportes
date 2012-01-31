<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface PersonasDAO{
	
	/**
	* cgajardo: obtener al usuario de acuerdo a su id en moodle.
	* @param $plataforma, $idUsuario (comprondan identificador_moodle)
	* @return Persona
	*/
	public function getUserInPlatform($platform, $id);

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Personas 
	 */
	public function load($id, $nombre, $apellido);

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
 	 * @param persona primary key
 	 */
	public function delete($id, $nombre, $apellido);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Personas persona
 	 */
	public function insert($persona);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Personas persona
 	 */
	public function update($persona);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByUsuario($value);

	public function queryByCorreo($value);

	public function queryByRut($value);

	public function queryByIdentificadorMoodle($value);

	public function queryByRolMoodle($value);


	public function deleteByUsuario($value);

	public function deleteByCorreo($value);

	public function deleteByRut($value);

	public function deleteByIdentificadorMoodle($value);

	public function deleteByRolMoodle($value);


}
?>