<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface QuizesDAO{
	
	/**
	 * Entrega un listado de quizes cuyo nombre contiene "evalua"
	 *
	 * TODO: revisar porque quiza es mejor seleccionar aquellos que tienen fecha de cierre
	 * @author cgajardo
	 * @param int $id_curso
	 */
	public function queryEvaluacionesByIdCurso($id_curso);
	
	/**
	 * Devuelve la lista de quizes evaluados cerrados hasta este momento.
	 *
	 * @author cgajardo
	 * @param int $curso_id
	 */
	public function queryCerradosByIdCurso($curso_id);
	
	/**
	 * Devuelve el quiz correspondiente en galyleo seg�n el id de quiz en moodle
	 * @param string $plataforma
	 * @param int $quiz_id_in_moodle
	 */
	public function getGalyleoQuizByMoodleId($plataforma, $quiz_id_in_moodle);
	
	/**
	* cgajardo:
	* retorna la lista de quizes que ha rendido un usuario
	* @param int $idUsuario
	* @return Quize list
	*/
	public function getQuizesByUsuario($idUsuario);

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Quizes 
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
 	 * @param quize primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Quizes quize
 	 */
	public function insert($quize);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Quizes quize
 	 */
	public function update($quize);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByNombre($value);

	public function queryByIdCurso($value);

	public function queryByFechaCierre($value);

	public function queryByPuntajeMaximo($value);

	public function queryByNotaMaxima($value);


	public function deleteByNombre($value);

	public function deleteByIdCurso($value);

	public function deleteByFechaCierre($value);

	public function deleteByPuntajeMaximo($value);

	public function deleteByNotaMaxima($value);
        
        public function queryDiagnosticosByIdCurso($curso_id);
        
        public function queryAvancesByIdCurso($curso_id);
        
        public function getQuizWithCierre();
        
}
?>