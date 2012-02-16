<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface PersonasDAO{
	
	/**
	 * Esta función entrega una persona de acuerdo a sus nombres, apellidos
	 * y nombre del grupo al que pertenece. Es una función débil :/
	 *
	 * @author cgajardo
	 * @param string $nombre_alumno
	 * @param string $nombre_grupo
	 * @return Persona $usuario
	 */
	public function getPersonaByNombreGrupo($nombre_alumno, $nombre_grupo);
	
	/**
	 * cgajardo: devuelve la lista de personas que pertecenen a un grupo
	 * en rol de alumnos
	 * @param int $grupo_id
	 */
	public function getEstudiantesInGroup($grupo_id);
	
	/**
	* cgajardo: obtener al usuario de acuerdo a su id en moodle.
	* @param $plataforma, $idUsuario (comprondan identificador_moodle)
	* @return Persona
	*/
	public function getUserInPlatform($platform, $id);

	/**
	 * Get Domain object by primry key
	 *
	 * @param int $id
	 * @return Persona 
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
        
        public function getUserByNombreApellido($nombre, $apellido);
        
        public function getEstudiantesInQuiz($id_quiz,$id_grupo);

}
?>