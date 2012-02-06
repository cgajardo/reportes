<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface SedesDAO{
	
	/**
	 * Esta función devuelve la lista de sedes en las cuales una persona es director
	 *
	 * @author cgajardo
	 * @param int $director_id
	 */
	public function getSedesByDirector($director_id);

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Sedes 
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
 	 * @param sede primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Sedes sede
 	 */
	public function insert($sede);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Sedes sede
 	 */
	public function update($sede);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByNombre($value);

	public function queryByPais($value);

	public function queryByRegion($value);

	public function queryByCiudad($value);

	public function queryByIdInstitucion($value);


	public function deleteByNombre($value);

	public function deleteByPais($value);

	public function deleteByRegion($value);

	public function deleteByCiudad($value);

	public function deleteByIdInstitucion($value);


}
?>