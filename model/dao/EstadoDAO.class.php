<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface EstadoDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Estado 
	 */
	public function load($idPlataforma, $variable);

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
 	 * @param estado primary key
 	 */
	public function delete($idPlataforma, $variable);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Estado estado
 	 */
	public function insert($estado);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Estado estado
 	 */
	public function update($estado);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByValor($value);


	public function deleteByValor($value);


}
?>