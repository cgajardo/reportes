<?php
/**
 * Class that operate on table 'contenidos'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class ContenidosMySqlDAO implements ContenidosDAO{
	
	/**
	 * Esta funcion devuelve todos los contenidos hijos de un contenido
	 *
	 * @author cgajardo
	 * @param int $id_contenido
	 * @return list $contenidos_hijos
	 */
	public function getHijos($id_contenido){
		$sql = 'SELECT c1.* '.
			'FROM contenidos c1 '.
			'WHERE padre = ? '.
			'ORDER BY c1.nombre ASC ';
		 
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id_contenido);
		 
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Devuelve los contenidos cuyo nombre es similar al parametro $likeString
	 * 
	 * @author cgajardo
	 * @param string $likeString
	 */
	public function getLike($likeString){
		$sql = 'SELECT * '.
		'FROM contenidos '.
		'WHERE nombre LIKE ? '.
		'LIMIT 10';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setString($likeString.'%');
		
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Retornar todos los contenidos asociado a un quiz.
	 * Se utiliza principalmente para la matriz de desempe�o
	 * 
	 * @author cgajardo
	 * @param int $quiz_id
	 */
	public function getContenidosByQuiz($quiz_id){
		$sql = 'SELECT c.* '.
				'FROM contenidos as c, preguntas as p '.
				'WHERE p.id_contenido = c.id '.
				'AND p.id IN (SELECT qp.id_pregunta '.
                              'FROM quizes_has_preguntas AS qp '.
                              'WHERE qp.id_quiz = ?) '.
				'GROUP BY c.id';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($quiz_id);
		
		return $this->getContenidoLogroArray($sqlQuery);
	}
	
	/**
	 * Esta función permite mantener la compatibilidad con la misma funcion de IntentodDAO
	 * que permite mostrar los quizes no rendidos en la matriz de desempeño
	 * 
	 * @author cgajardo
	 * @param SqlQuery $sqlQuery
	 */
	protected function getContenidoLogroArray($sqlQuery){
		$contenidos = $this->getList($sqlQuery);
		$ret = array();
		foreach ($contenidos as $id => $contenido){
			$ret[$id] = array('contenido' => $contenido, 'logro'=> -1, 'numero_preguntas'=>'0');
		}
		return $ret;
	}

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return ContenidosMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM contenidos WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM contenidos';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM contenidos ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param contenido primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM contenidos WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ContenidosMySql contenido
 	 */
	public function insert($contenido){
		$sql = 'INSERT INTO contenidos (nombre, link_repaso, frase_no_logrado, frase_logrado,padre) VALUES (?, ?, ?, ?,?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($contenido->nombre);
		$sqlQuery->set($contenido->linkRepaso);
		$sqlQuery->set($contenido->fraseNoLogrado);
		$sqlQuery->set($contenido->fraseLogrado);
		$sqlQuery->set($contenido->padre);
		
		$id = $this->executeInsert($sqlQuery);	
		$contenido->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param ContenidosMySql contenido
 	 */
	public function update($contenido){
		$sql = 'UPDATE contenidos SET nombre = ?, link_repaso = ?, frase_no_logrado = ?, frase_logrado = ?, padre= ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($contenido->nombre);
		$sqlQuery->set($contenido->linkRepaso);
		$sqlQuery->set($contenido->fraseNoLogrado);
		$sqlQuery->set($contenido->fraseLogrado);
		$sqlQuery->setNumber($contenido->padre);

		$sqlQuery->setNumber($contenido->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM contenidos';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByNombre($value){
		$sql = 'SELECT * FROM contenidos WHERE nombre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLinkRepaso($value){
		$sql = 'SELECT * FROM contenidos WHERE link_repaso = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByFraseNoLogrado($value){
		$sql = 'SELECT * FROM contenidos WHERE frase_no_logrado = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByFraseLogrado($value){
		$sql = 'SELECT * FROM contenidos WHERE frase_logrado = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByContenidoPadre($value){
		$sql = 'SELECT * FROM contenidos WHERE contenido_padre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByNombre($value){
		$sql = 'DELETE FROM contenidos WHERE nombre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLinkRepaso($value){
		$sql = 'DELETE FROM contenidos WHERE link_repaso = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByFraseNoLogrado($value){
		$sql = 'DELETE FROM contenidos WHERE frase_no_logrado = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByFraseLogrado($value){
		$sql = 'DELETE FROM contenidos WHERE frase_logrado = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByContenidoPadre($value){
		$sql = 'DELETE FROM contenidos WHERE contenido_padre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return ContenidosMySql 
	 */
	protected function readRow($row){
		$contenido = new Contenido();
		
		$contenido->id = $row['id'];
		$contenido->nombre = $row['nombre'];
		$contenido->linkRepaso = $row['link_repaso'];
		$contenido->fraseNoLogrado = $row['frase_no_logrado'];
		$contenido->fraseLogrado = $row['frase_logrado'];
                $contenido->padre = $row['padre'];

		return $contenido;
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
	 * @return ContenidosMySql 
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

    public function queryAllWithPadre() {
        
                $sql = 'SELECT c1.id,c1.nombre,c1.link_repaso,c1.frase_no_logrado,c1.frase_logrado,c2.nombre AS padre '.
                    'FROM contenidos c1 LEFT JOIN contenidos c2 ON c1.padre=c2.id';

                $sqlQuery= new SqlQuery($sql);

                return $this->getList($sqlQuery);
        
    }

    public function loadWithPadre($id) {
                $sql = 'SELECT c1.id,c1.nombre,c1.link_repaso,c1.frase_logrado,c1.frase_no_logrado,c2.nombre AS padre FROM contenidos c1 LEFT JOIN contenidos c2 ON c1.padre=c2.id WHERE c1.id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
    }

    public function getRealContenidos() {
        
//                 $sql = 'SELECT c1.* 
//                         FROM contenidos c1 
//                         JOIN contenidos c2 ON c1.padre=c2.id 
//                         JOIN contenidos c3 ON c2.padre=c3.id 
//                         ORDER BY c1.nombre ASC';
				$sql = 'SELECT c1.* 
                        FROM contenidos c1 
                        WHERE padre = 0    
                        ORDER BY c1.nombre ASC';
                
                return $this->getList(new SqlQuery($sql));
        
    }
}
?>