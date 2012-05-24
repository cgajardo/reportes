<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface CursosDAO{
	
	/**
	 * Esta funcion sólo debería usarse en las llamada de ajax,
	 * fuera de ahí no tien sentido y podría ser inseguro usarlas
	 *
	 * Devulve un curso de acuerdo al nombre del grupo y el curso
	 *
	 * @author cgajardo
	 * @param string $nombre_grupo
	 * @param string $nombre_grupo
	 */
	public function getCursoByNombreGrupoCurso($nombre_grupo, $nombre_grupo);
	
	/**
	 * Devuelve un curso para un nombre y un usuario dado
	 *
	 * @author cgajardo
	 * @param int $usuario_id
	 * @param string $nombre_curso
	 */
	public function getCursosByUsuarioAndNombre($usuario_id, $nombre_curso);
	
	/**
	 * Devuelve un curso en una Sede de nombre dado.
	 *
	 * @author cgajardo
	 * @param int $sede_id
	 * @param string $nombre_curso
	 */
	public function getCursoBySedeAndNombre($sede_id, $nombre_curso);
	
	/**
	 * Devuelve una lista de cursos asociados a una Sede
	 *
	 * @authos: cgajardo
	 * @param int $sede_id
	 */
	public function getCursosInSede($sede_id);
	
	/**
	 * Entrega un listado en los cuales el usuario está inscrito
	 *
	 * @author: cgajardo
	 * @param int $usuario_id
	 */
	public function getCursosByUsuario($usuario_id);

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Cursos 
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
 	 * @param curso primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Cursos curso
 	 */
	public function insert($curso);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Cursos curso
 	 */
	public function update($curso);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByNombre($value);

	public function queryByNombreCorto($value);

	public function queryByIdentificadorMoodle($value);


	public function deleteByNombre($value);

	public function deleteByNombreCorto($value);

	public function deleteByIdentificadorMoodle($value);

        public function getNivelacionCierre($id_curso);
        
}
?>
