<?php
/**
 * Class that operate on table 'cursos_has_grupos'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class CursosHasGruposMySqlDAO implements CursosHasGruposDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return CursosHasGruposMySql 
	 */
	public function load($idGrupo, $idCurso){
		$sql = 'SELECT * FROM cursos_has_grupos WHERE id_grupo = ?  AND id_curso = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idGrupo);
		$sqlQuery->setNumber($idCurso);

		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM cursos_has_grupos';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM cursos_has_grupos ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param cursosHasGrupo primary key
 	 */
	public function delete($idGrupo, $idCurso){
		$sql = 'DELETE FROM cursos_has_grupos WHERE id_grupo = ?  AND id_curso = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idGrupo);
		$sqlQuery->setNumber($idCurso);

		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param CursosHasGruposMySql cursosHasGrupo
 	 */
	public function insert($cursosHasGrupo){
		$sql = 'INSERT INTO cursos_has_grupos ( id_grupo, id_curso) VALUES ( ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		

		
		$sqlQuery->setNumber($cursosHasGrupo->idGrupo);

		$sqlQuery->setNumber($cursosHasGrupo->idCurso);

		$this->executeInsert($sqlQuery);	
		//$cursosHasGrupo->id = $id;
		//return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param CursosHasGruposMySql cursosHasGrupo
 	 */
	public function update($cursosHasGrupo){
		$sql = 'UPDATE cursos_has_grupos SET  WHERE id_grupo = ?  AND id_curso = ? ';
		$sqlQuery = new SqlQuery($sql);
		

		
		$sqlQuery->setNumber($cursosHasGrupo->idGrupo);

		$sqlQuery->setNumber($cursosHasGrupo->idCurso);

		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM cursos_has_grupos';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}



	
	/**
	 * Read row
	 *
	 * @return CursosHasGruposMySql 
	 */
	protected function readRow($row){
		$cursosHasGrupo = new CursosHasGrupo();
		
		$cursosHasGrupo->idGrupo = $row['id_grupo'];
		$cursosHasGrupo->idCurso = $row['id_curso'];

		return $cursosHasGrupo;
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
	 * @return CursosHasGruposMySql 
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