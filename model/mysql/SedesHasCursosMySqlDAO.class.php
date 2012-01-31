<?php
/**
 * Class that operate on table 'sedes_has_cursos'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class SedesHasCursosMySqlDAO implements SedesHasCursosDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return SedesHasCursosMySql 
	 */
	public function load($idSede, $idCurso){
		$sql = 'SELECT * FROM sedes_has_cursos WHERE id_sede = ?  AND id_curso = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idSede);
		$sqlQuery->setNumber($idCurso);

		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM sedes_has_cursos';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM sedes_has_cursos ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param sedesHasCurso primary key
 	 */
	public function delete($idSede, $idCurso){
		$sql = 'DELETE FROM sedes_has_cursos WHERE id_sede = ?  AND id_curso = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idSede);
		$sqlQuery->setNumber($idCurso);

		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param SedesHasCursosMySql sedesHasCurso
 	 */
	public function insert($sedesHasCurso){
		$sql = 'INSERT INTO sedes_has_cursos ( id_sede, id_curso) VALUES ( ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		

		
		$sqlQuery->setNumber($sedesHasCurso->idSede);

		$sqlQuery->setNumber($sedesHasCurso->idCurso);

		$this->executeInsert($sqlQuery);	
		//$sedesHasCurso->id = $id;
		//return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param SedesHasCursosMySql sedesHasCurso
 	 */
	public function update($sedesHasCurso){
		$sql = 'UPDATE sedes_has_cursos SET  WHERE id_sede = ?  AND id_curso = ? ';
		$sqlQuery = new SqlQuery($sql);
		

		
		$sqlQuery->setNumber($sedesHasCurso->idSede);

		$sqlQuery->setNumber($sedesHasCurso->idCurso);

		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM sedes_has_cursos';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}



	
	/**
	 * Read row
	 *
	 * @return SedesHasCursosMySql 
	 */
	protected function readRow($row){
		$sedesHasCurso = new SedesHasCurso();
		
		$sedesHasCurso->idSede = $row['id_sede'];
		$sedesHasCurso->idCurso = $row['id_curso'];

		return $sedesHasCurso;
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
	 * @return SedesHasCursosMySql 
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