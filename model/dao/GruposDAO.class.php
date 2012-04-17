<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface GruposDAO{
	
	/**
	 * Devuelve el grupo de un curso para un nombre dado
	 *
	 * @author cgajardo
	 * @param int $curso_id
	 * @param string $nombre_grupo
	 */
	public function getGrupoByCursoAndNombre($curso_id, $nombre_grupo);
	
	/**
	 * Devuelve una lista de Grupos asociados a un Curso
	 *
	 * @author cgajardo
	 * @param int $curso_id
	 */
	public function getGruposInCurso($curso_id);
	
	/**
	 * Esta función devuelve el grupo asociado a un curso y un estudiante
	 *
	 * @author cgajardo
	 * @param int $usuario_id
	 * @param int $curso_id
	 */
	public function getGrupoByCursoAndUser($usuario_id, $curso_id);
	
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
        
        public function getGruposInSede($id_sede);
        
        public function getGruposInCursoAndSede($id_curso,$id_sede);


}
?>
