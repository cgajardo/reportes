<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface IntentosDAO{
	
	/**
	 * Esta funcion devuelve un par: contenido-porcentaje para un usuario en un quiz dado
	 *
	 * @author cgajardo
	 * @param int $id_quiz
	 * @param int $id_usuario
	 */
	public function getLogroPorContenido($id_quiz, $id_usuario);
	
	/**
	 * cgajardo: obtiene la nota de un usuario en un quiz
	 *
	 * @param int $quiz_id
	 * @param int $usuario_id
	 */
	public function getNotaInQuizByPersona($quiz_id, $usuario_id);
	
	
	/**
	 * cgajardo: devuelve un arreglo de notas del grupo, ordenadas de menor a mayor
	 * @param int $quiz
	 * @param int $grupo
	 */
	public function getNotasGrupo($quiz,$grupo);

	
	/**
	* cgajardo: Devuelve una lista de los quizes que ha respondido un usuario
	* @param $idUsuarioGalyleo en identificador del usuario en la plataforma de reportes
	* @return $quizes_id devuelve una lista de intentos
	*/
	public function getIntentosByUsuario($idUsuarioGalyleo);
	
	
	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Intentos 
	 */
	public function load($id, $idPersona, $idQuiz, $idPregunta);

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
 	 * @param intento primary key
 	 */
	public function delete($id, $idPersona, $idQuiz, $idPregunta);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Intentos intento
 	 */
	public function insert($intento);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Intentos intento
 	 */
	public function update($intento);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByPuntajePregunta($value);

	public function queryByFecha($value);

	public function queryByNumeroIntento($value);


	public function deleteByPuntajePregunta($value);

	public function deleteByFecha($value);

	public function deleteByNumeroIntento($value);

	
	/** 
	* cgajardo:
	* obtener todos los intentos de un usuario para un control y una pregunta dada
	*/
	public function getIntentosByUsuarioQuizPregunta($idPersona, $idQuiz, $idPregunta);
	

}
?>