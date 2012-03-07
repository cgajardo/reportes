<?php
/**
 * Class that operate on table 'preguntas'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class PreguntasMySqlDAO implements PreguntasDAO{
	
	/**
	 * Devuelve el total de preguntas existentes en las base de datos 
	 * que no están asociadas a un contenido
	 * @author cgajardo
	 */
	public function countSinAsociar(){
		$sql = 'SELECT COUNT(id) AS total '.
				'FROM preguntas '.
				'WHERE id_contenido = null ';
	
		$sqlQuery = new SqlQuery($sql);
	
		return $this->getCount($sqlQuery);
	}
	
	/**
	 * Esta funcion devuelve un grupo de preguntas que no tienen asociado
	 * un id de contenido, útil para la paginación
	 *
	 * @author cgajardo
	 * @param int $from
	 * @param int $delta
	 */
	public function getSinAsociarFrom($from, $delta){
		$sql = 'SELECT * '.
				'FROM preguntas '.
				'WHERE id_contenido IS NULL '.
				'LIMIT ? , ?';
	
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($from);
		$sqlQuery->setNumber($delta);
	
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Devuelve el total de preguntas existentes en las base de datos
	 * @author cgajardo
	 */
	public function count(){
		$sql = 'SELECT COUNT(id) AS total '.
			'FROM preguntas';
		
		$sqlQuery = new SqlQuery($sql);
		
		return $this->getCount($sqlQuery);
	}
	
	/**
	 * Esta funcion devuelve un grupo de preguntas, útil para la paginación
	 * 
	 * @author cgajardo
	 * @param int $from
	 * @param int $delta
	 */
	public function getFrom($from, $delta){
		$sql = 'SELECT * '.
			'FROM preguntas '.
			'ORDER BY  id_contenido '.
			'LIMIT ? , ?';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($from);
		$sqlQuery->setNumber($delta);
		
		return $this->getList($sqlQuery);
	}
        
        public function getFromWithPatron($from, $delta,$patron){
		$sql = 'SELECT * '.
			'FROM preguntas '.
                        'WHERE nombre REGEXP ?'.
			'ORDER BY  id_contenido '.
			'LIMIT ? , ?';
		
		$sqlQuery = new SqlQuery($sql);
                $sqlQuery->setString($patron);
		$sqlQuery->setNumber($from);
		$sqlQuery->setNumber($delta);
		
		return $this->getList($sqlQuery);
	}

	/**
	 * @author: cgajardo
	 * 
	 * Esta función devuelve todas las preguntas que aun no se han asociado a un contenido 
	 */
	public function getAllSinContenido(){
		$sql = 'SELECT * FROM preguntas WHERE id_contenido IS NULL';
		$sqlQuery = new SqlQuery($sql);
		
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return PreguntasMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM preguntas WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM preguntas';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM preguntas ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param pregunta primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM preguntas WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param PreguntasMySql pregunta
 	 */
	public function insert($pregunta){
		$sql = 'INSERT INTO preguntas (identificador_moodle, id_contenido) VALUES (?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($pregunta->identificadorMoodle);
		$sqlQuery->setNumber($pregunta->idContenido);

		$id = $this->executeInsert($sqlQuery);	
		$pregunta->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param PreguntasMySql pregunta
 	 */
	public function update($pregunta){
		$sql = 'UPDATE preguntas SET identificador_moodle = ?, id_contenido = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($pregunta->identificadorMoodle);
                $sqlQuery->setNumber($pregunta->contenido);

		$sqlQuery->set($pregunta->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM preguntas';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByIdentificadorMoodle($value){
		$sql = 'SELECT * FROM preguntas WHERE identificador_moodle = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByIdContenido($value){
		$sql = 'SELECT * FROM preguntas WHERE id_contenido = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByIdentificadorMoodle($value){
		$sql = 'DELETE FROM preguntas WHERE identificador_moodle = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByIdContenido($value){
		$sql = 'DELETE FROM preguntas WHERE id_contenido = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return PreguntasMySql 
	 */
	protected function readRow($row){
		$pregunta = new Pregunta();
		
		$pregunta->id = $row['id'];
		$pregunta->identificadorMoodle = $row['identificador_moodle'];
		$pregunta->contenido = DAOFactory::getContenidosDAO()->load($row['id_contenido']);
		$pregunta->nombre = $row['nombre'];

		return $pregunta;
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
	 * @return PreguntasMySql 
	 */
	protected function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRow($tab[0]);		
	}
	
	protected function getCount($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		
		if(count($tab)==0){
			return 0;
		}
		
		return $tab[0]['total'];
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

    public function getPreguntaByCategoria($nombre_categoria) {
                $sql = 'SELECT p.* FROM preguntas p WHERE p.nombre=?';
                $sqlQuery = new SqlQuery($sql);
                $sqlQuery->setString($nombre_categoria);
                return $this->getList($sqlQuery);
                
    }

    public function getPreguntaByPatron($patron) {
                $sql= 'SELECT * FROM preguntas p WHERE nombre REGEXP ?';
                $sqlQuery =  new SqlQuery($sql);
                $sqlQuery->setString($patron);
                return $this->getList($sqlQuery);
    }

    public function countWithPatron($patron) {                
		$sql = 'SELECT COUNT(id) AS total '.
				'FROM preguntas '.
				'WHERE nombre REGEXP ? ';
	
		$sqlQuery = new SqlQuery($sql);
                $sqlQuery->setString($patron);
                
		return $this->getCount($sqlQuery);
	
    }

    public function getPregutasByQuizWithContenido($id_quiz) {
        
                $sql = 'SELECT p.* 
                        FROM preguntas p JOIN quizes_has_preguntas qp ON p.id=qp.id_pregunta 
                        LEFT JOIN contenidos c ON p.id_contenido=c.id WHERE id_quiz = ?';
                
                $sqlQuery = new SqlQuery($sql);
                $sqlQuery->setNumber($id_quiz);
                
                return $this->getList($sqlQuery);
        
    }
}
?>