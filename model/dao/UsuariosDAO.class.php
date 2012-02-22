<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-02-21 18:03
 */
interface UsuariosDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Usuarios 
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
 	 * @param usuario primary key
 	 */
	public function delete($id, $email);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Usuarios usuario
 	 */
	public function insert($usuario);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Usuarios usuario
 	 */
	public function update($usuario);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByNombres($value);

	public function queryByApellidos($value);


	public function deleteByNombres($value);

	public function deleteByApellidos($value);


}
?>