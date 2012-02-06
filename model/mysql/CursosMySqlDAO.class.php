<?php
/**
 * Class that operate on table 'cursos'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class CursosMySqlDAO implements CursosDAO{
	
	/**
	 * Entrega un listado en los cuales el usuario est� inscrito
	 * 
	 * @author: cgajardo
	 * @param int $usuario_id
	 */
	public function getCursosByUsuario($usuario_id){
		$sql = 'SELECT c.* '.
				'FROM cursos as c '.
				'WHERE c.id IN ('.
					'SELECT id_curso '. 
                	'FROM cursos_has_grupos '.
                	'WHERE id_grupo IN ('.
                		'SELECT id_grupo '.  
                      	'FROM grupos_has_estudiantes '.
						'WHERE id_persona = ?)'.
                	') '. 
				'ORDER BY c.id ASC';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($usuario_id);
		
		return $this->getList($sqlQuery);
		
	}
	
	
	/**
	 * 
	 * @param int $grupo_id
	 */
	public function getCursoByGrupoId($grupo_id){
		$sql = "SELECT c.* FROM cursos AS c, cursos_has_grupos AS cg WHERE cg.id_curso = c.id AND cg.id_grupo = ?";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($grupo_id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return CursosMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM cursos WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM cursos';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM cursos ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param curso primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM cursos WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param CursosMySql curso
 	 */
	public function insert($curso){
		$sql = 'INSERT INTO cursos (nombre, nombre_corto, identificador_moodle) VALUES (?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($curso->nombre);
		$sqlQuery->set($curso->nombreCorto);
		$sqlQuery->set($curso->identificadorMoodle);

		$id = $this->executeInsert($sqlQuery);	
		$curso->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param CursosMySql curso
 	 */
	public function update($curso){
		$sql = 'UPDATE cursos SET nombre = ?, nombre_corto = ?, identificador_moodle = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($curso->nombre);
		$sqlQuery->set($curso->nombreCorto);
		$sqlQuery->set($curso->identificadorMoodle);

		$sqlQuery->setNumber($curso->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM cursos';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByNombre($value){
		$sql = 'SELECT * FROM cursos WHERE nombre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByNombreCorto($value){
		$sql = 'SELECT * FROM cursos WHERE nombre_corto = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByIdentificadorMoodle($value){
		$sql = 'SELECT * FROM cursos WHERE identificador_moodle = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setString($value);
		return $this->getRow($sqlQuery);
	}


	public function deleteByNombre($value){
		$sql = 'DELETE FROM cursos WHERE nombre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByNombreCorto($value){
		$sql = 'DELETE FROM cursos WHERE nombre_corto = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByIdentificadorMoodle($value){
		$sql = 'DELETE FROM cursos WHERE identificador_moodle = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return CursosMySql 
	 */
	protected function readRow($row){
		$curso = new Curso();
		
		$curso->id = $row['id'];
		$curso->nombre = $row['nombre'];
		$curso->nombreCorto = $row['nombre_corto'];
		$curso->identificadorMoodle = $row['identificador_moodle'];

		return $curso;
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
	 * @return CursosMySql 
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