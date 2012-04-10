<?php
/**
 * Class that operate on table 'categorias'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-24 15:19
 */
class CategoriasMySqlDAO implements CategoriasDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return CategoriasMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM categorias WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM categorias';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM categorias ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param categoria primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM categorias WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param CategoriasMySql categoria
 	 */
	public function insert($categoria){
		$sql = 'INSERT INTO categorias (nombre, padre, identificador_moodle) VALUES (?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($categoria->nombre);
		$sqlQuery->setNumber($categoria->padre);
		$sqlQuery->set($categoria->identificadorMoodle);

		$id = $this->executeInsert($sqlQuery);	
		$categoria->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param CategoriasMySql categoria
 	 */
	public function update($categoria){
		$sql = 'UPDATE categorias SET nombre = ?, padre = ?, identificador_moodle = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($categoria->nombre);
		$sqlQuery->setNumber($categoria->padre);
		$sqlQuery->set($categoria->identificadorMoodle);

		$sqlQuery->setNumber($categoria->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM categorias';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByNombre($value){
		$sql = 'SELECT * FROM categorias WHERE nombre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPadre($value){
		$sql = 'SELECT * FROM categorias WHERE padre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByIdentificadorMoodle($value){
		$sql = 'SELECT * FROM categorias WHERE identificador_moodle = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByNombre($value){
		$sql = 'DELETE FROM categorias WHERE nombre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPadre($value){
		$sql = 'DELETE FROM categorias WHERE padre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByIdentificadorMoodle($value){
		$sql = 'DELETE FROM categorias WHERE identificador_moodle = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return CategoriasMySql 
	 */
	protected function readRow($row){
		$categoria = new Categoria();
		
		$categoria->id = $row['id'];
		$categoria->nombre = $row['nombre'];
		$categoria->padre = $row['padre'];
		$categoria->identificadorMoodle = $row['identificador_moodle'];

		return $categoria;
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
	 * @return CategoriasMySql 
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
        
        public function getCategoriasByQuiz($id_quiz){
                $sql ='SELECT c.* 
                        FROM categorias c 
                        JOIN quizes_has_categorias qc ON qc.id_categoria=c.id 
                        WHERE qc.id_quiz = ? ';
                
                $sqlQuery = new SqlQuery($sql);
                $sqlQuery->setNumber($id_quiz);
                
                return $this->getList($sqlQuery);
        }
        
        public function getCategoriasByQuizWithContenido($id_quiz){
            $sql ='SELECT c.id,c.nombre,c2.nombre AS id_contenido,c.padre,c.identificador_moodle 
                        FROM categorias c 
                        JOIN quizes_has_categorias qc ON qc.id_categoria=c.id 
                        LEFT JOIN contenidos c2 ON c.id_contenido = c2.id 
                        WHERE qc.id_quiz = ? ';
                
                $sqlQuery = new SqlQuery($sql);
                $sqlQuery->setNumber($id_quiz);
                
                return $this->getList($sqlQuery);
            
        }
}
?>