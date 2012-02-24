<?php
/**
 * Class that operate on table 'quizes'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class QuizesMySqlDAO implements QuizesDAO{
	
	/**
	 * Entrega un listado de quizes cuyo nombre contiene "evalua"
	 * 
	 * TODO: revisar porque quiza es mejor seleccionar aquellos que tienen fecha de cierre
	 * @author cgajardo
	 * @param int $id_curso
	 */
	public function queryEvaluacionesByIdCurso($id_curso){
		$sql = 'SELECT q.* '.
                        'FROM quizes AS q JOIN plataforma_quiz pq ON q.id=pq.id_quiz '. 
                        'JOIN plataformas p ON pq.id_plataforma=p.id '. 
                        'JOIN instituciones i ON i.id_plataforma=p.id '.
                        'WHERE id_curso = ? AND q.nombre REGEXP prefijo_tarea '. 
                        'ORDER BY fecha_cierre ASC';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id_curso);
		
		return $this->getList($sqlQuery);
		
	}
	
	/**
	 * DEPRECATED
	 * 
	 * Esta funcion entrega un listado de actividades evaluadas asociadas a un curso moodle
	 * @author cgajardo
	 * @param string $identificador_moodle_curso
	 */
	public function queryEvaluacionesByIdCursoMoodle($identificador_moodle_curso){
		$sql = 'SELECT q.* '.
				'FROM quizes AS q, cursos as c '.
				'WHERE id_curso = c.id AND q.nombre LIKE "%evalua%" AND c.identificador_moodle=? '.
				'ORDER BY fecha_cierre ASC';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setString($identificador_moodle_curso);
		
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Devuelve la lista de quizes evaluados cerrados hasta este momento.
	 * 
	 * @author cgajardo 
	 * @param int $curso_id
	 */
	public function queryCerradosByIdCurso($curso_id){
		$sql = 'SELECT q.* '. 
                        'FROM quizes AS q '. 
                        'JOIN sedes_has_cursos sc ON q.id_curso=sc.id_curso '.
                        'JOIN sedes s ON sc.id_sede=s.id '.
                        'JOIN instituciones i ON s.id_institucion=i.id '.
                        'WHERE q.id_curso = ? AND q.nombre REGEXP i.prefijo_tarea '.
                        'AND q.fecha_cierre > 0 AND q.fecha_cierre < NOW() ORDER BY nombre ASC';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($curso_id);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Devuelve el quiz correspondiente en galyleo seg�n el id de quiz en moodle
	 * @param string $plataforma
	 * @param int $quiz_id_in_moodle
	 */
	public function getGalyleoQuizByMoodleId($plataforma, $quiz_id_in_moodle){
		$sql = 'SELECT q.* FROM plataforma_quiz AS pq, plataformas AS p, quizes AS q '.
				'WHERE q.id = pq.id_quiz AND p.id = pq.id_plataforma AND p.nombre = ? AND id_quiz_moodle = ? ';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($plataforma);
		$sqlQuery->set($quiz_id_in_moodle);
		return $this->getRow($sqlQuery);
	}

	
	/**
	* cgajardo:
	* retorna la lista de quizes que ha rendido un usuario
	* @param int $idUsuario
	* @return Quize list
	*/
	public function getQuizesByUsuario($idUsuario){
		$sql = 'SELECT distinct quizes.id, quizes.nombre FROM quizes, intentos '.
					'WHERE quizes.id = intentos.id_quiz AND intentos.id_persona = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idUsuario);
	
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return QuizesMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM quizes WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM quizes';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM quizes ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param quize primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM quizes WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param QuizesMySql quize
 	 */
	public function insert($quize){
		$sql = 'INSERT INTO quizes (nombre, id_curso, fecha_cierre, puntaje_maximo, nota_maxima) VALUES (?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($quize->nombre);
		$sqlQuery->set($quize->idCurso);
		$sqlQuery->set($quize->fechaCierre);
		$sqlQuery->setNumber($quize->puntajeMaximo);
		$sqlQuery->setNumber($quize->notaMaxima);

		$id = $this->executeInsert($sqlQuery);	
		$quize->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param QuizesMySql quize
 	 */
	public function update($quize){
		$sql = 'UPDATE quizes SET nombre = ?, id_curso = ?, fecha_cierre = ?, puntaje_maximo = ?, nota_maxima = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($quize->nombre);
		$sqlQuery->set($quize->idCurso);
		$sqlQuery->set($quize->fechaCierre);
		$sqlQuery->setNumber($quize->puntajeMaximo);
		$sqlQuery->setNumber($quize->notaMaxima);

		$sqlQuery->setNumber($quize->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM quizes';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByNombre($value){
		$sql = 'SELECT * FROM quizes WHERE nombre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByIdCurso($value){
		$sql = 'SELECT * FROM quizes WHERE id_curso = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByFechaCierre($value){
		$sql = 'SELECT * FROM quizes WHERE fecha_cierre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPuntajeMaximo($value){
		$sql = 'SELECT * FROM quizes WHERE puntaje_maximo = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByNotaMaxima($value){
		$sql = 'SELECT * FROM quizes WHERE nota_maxima = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByNombre($value){
		$sql = 'DELETE FROM quizes WHERE nombre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByIdCurso($value){
		$sql = 'DELETE FROM quizes WHERE id_curso = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByFechaCierre($value){
		$sql = 'DELETE FROM quizes WHERE fecha_cierre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPuntajeMaximo($value){
		$sql = 'DELETE FROM quizes WHERE puntaje_maximo = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByNotaMaxima($value){
		$sql = 'DELETE FROM quizes WHERE nota_maxima = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return QuizesMySql 
	 */
	protected function readRow($row){
		$quize = new Quize();
		
		$quize->id = $row['id'];
		$quize->nombre = $row['nombre'];
		$quize->idCurso = $row['id_curso'];
		$quize->fechaCierre = $row['fecha_cierre'];
		$quize->puntajeMaximo = $row['puntaje_maximo'];
		$quize->notaMaxima = $row['nota_maxima'];
		$quize->notaMinima = $row['nota_minima'];

		return $quize;
	}
	
	protected function getList($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRow($tab[$i]);
		}
		return $ret;
	}
	
	/**
	 * Get row
	 *
	 * @return QuizesMySql 
	 */
	protected function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRow($tab[0]);		
	}
	
	/**
	 * Execute sql query
	 */
	protected function execute($sqlQuery){
		return QueryExecutor::execute($sqlQuery);
	}
	
		
	/**
	 * Execute sql query
	 */
	protected function executeUpdate($sqlQuery){
		return QueryExecutor::executeUpdate($sqlQuery);
	}

	/**
	 * Query for one row and one column
	 */
	protected function querySingleResult($sqlQuery){
		return QueryExecutor::queryForString($sqlQuery);
	}

	/**
	 * Insert row to table
	 */
	protected function executeInsert($sqlQuery){
		return QueryExecutor::executeInsert($sqlQuery);
	}
}
?>