<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface InstitucionesDAO{
	
	/**
	 * Esta función entrega la institución en la cual el usuario es director.
	 *
	 * @author cgajardo
	 * @param int $director_id
	 */
	public function getInstitucionByDirectorId($director_id);
	
	/**
	 * Esta función devuelve la institacion asociada a una plataforma
	 * dado el nombre de la plataforma
	 *
	 * @author cgajardo
	 * @param string $platforma
	 */
	public function getInstitucionByNombrePlataforma($platforma);
	
	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Instituciones 
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
 	 * @param institucione primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Instituciones institucione
 	 */
	public function insert($institucione);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Instituciones institucione
 	 */
	public function update($institucione);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByNombre($value);

	public function queryByNombreCorto($value);


	public function deleteByNombre($value);

	public function deleteByNombreCorto($value);
        
        public function getInstitucionByAlumno($id_usuario);
        
        public function getInstitucionByProfesor($id_usuario);
        
        public function getInstitucionByDirectorPlataforma($id_usuario,$platform);


}
?>