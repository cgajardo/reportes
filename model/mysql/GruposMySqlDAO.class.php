<?php
/**
 * Class that operate on table 'grupos'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class GruposMySqlDAO implements GruposDAO{
	
	
	/**
	 * Devuelve una lista de Grupos asociados a un Curso
	 * 
	 * @author cgajardo
	 * @param int $curso_id
	 */
	public function getGruposInCurso($curso_id){
		$sql = 'SELECT g.* '.
			'FROM grupos as g, cursos_has_grupos as cg '.
			'WHERE g.id = cg.id_grupo AND cg.id_curso = ? '.
			'ORDER BY LENGTH(g.nombre), g.nombre ';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($curso_id);
		
		return $this->getList($sqlQuery);
	}
	
	
	/**
	 * Esta función devuelve el grupo asociado a un curso y un estudiante
	 * 
	 * @author cgajardo
	 * @param int $usuario_id
	 * @param int $curso_id
	 */
	public function getGrupoByCursoAndUser($usuario_id, $curso_id){
		$sql = 'SELECT g.* '.
		'FROM grupos as g, grupos_has_estudiantes as ge, cursos_has_grupos as cg '.
		'WHERE ge.id_grupo = g.id AND cg.id_grupo = g.id AND ge.id_persona = ? AND cg.id_curso = ? ';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($usuario_id);
		$sqlQuery->setNumber($curso_id);
		
		return $this->getRow($sqlQuery);
	}
	
	
	/**
	 * Devuelve el grupo-galyleo correspondiente al grupo-moodle
	 * @param unknown_type $grupo_id_in_moodle
	 */
	public function getGrupoByIdEnMoodle($platform, $grupo_id_in_moodle){
		$sql = 'SELECT id, nombre, id_sede FROM grupos WHERE identificador_moodle = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($platform.'_'.$grupo_id_in_moodle);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return GruposMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM grupos WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM grupos';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM grupos ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param grupo primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM grupos WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param GruposMySql grupo
 	 */
	public function insert($grupo){
		$sql = 'INSERT INTO grupos (nombre, id_sede, identificador_moodle) VALUES (?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($grupo->nombre);
		$sqlQuery->setNumber($grupo->idSede);
		$sqlQuery->set($grupo->identificadorMoodle);

		$id = $this->executeInsert($sqlQuery);	
		$grupo->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param GruposMySql grupo
 	 */
	public function update($grupo){
		$sql = 'UPDATE grupos SET nombre = ?, id_sede = ?, identificador_moodle = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($grupo->nombre);
		$sqlQuery->setNumber($grupo->idSede);
		$sqlQuery->set($grupo->identificadorMoodle);

		$sqlQuery->setNumber($grupo->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM grupos';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByNombre($value){
		$sql = 'SELECT * FROM grupos WHERE nombre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByIdSede($value){
		$sql = 'SELECT * FROM grupos WHERE id_sede = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByIdentificadorMoodle($value){
		$sql = 'SELECT * FROM grupos WHERE identificador_moodle = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByNombre($value){
		$sql = 'DELETE FROM grupos WHERE nombre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByIdSede($value){
		$sql = 'DELETE FROM grupos WHERE id_sede = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByIdentificadorMoodle($value){
		$sql = 'DELETE FROM grupos WHERE identificador_moodle = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return GruposMySql 
	 */
	protected function readRow($row){
		$grupo = new Grupo();
		
		$grupo->id = $row['id'];
		$grupo->nombre = $row['nombre'];
		$grupo->idSede = $row['id_sede'];

		return $grupo;
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
	 * @return GruposMySql 
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