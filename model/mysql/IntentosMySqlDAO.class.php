<?php
/**
 * Class that operate on table 'intentos'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class IntentosMySqlDAO implements IntentosDAO{
	
	/**
	 * Retorna el logro por quiz para un alumno
	 * 
	 * @author cgajardo
	 * @param int $alumno_id
	 */
	public function getLogroPorQuiz($alumno_id){
		$sql = 'SELECT q.nombre AS nombre, round(max(m.logro)) AS logro '. 
				'FROM('.
    				'SELECT i.id_quiz, i.numero_intento as intento, '. 
    				'sum(i.puntaje_alumno)/sum(i.maximo_puntaje)*100 as logro '. 
    				'FROM intentos AS i, preguntas as p, quizes_has_preguntas as qp '. 
    				'WHERE p.id = i.id_pregunta AND i.id_persona = ? AND p.id = qp.id_pregunta '. 
    			'GROUP BY i.id_quiz, i.numero_intento) '.
    			'AS m, quizes as q '.
				'WHERE m.id_quiz = q.id AND q.nombre LIKE "%evalua%" '.
				'GROUP BY m.id_quiz ';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($alumno_id);
		
		return $this->getQuizLogroArray($sqlQuery);
	}
	
	/**
	 * Esta funcion devuelve un par: contenido-porcentaje para un usuario en un quiz dado
	 *
	 * @author cgajardo
	 * @param int $id_quiz
	 * @param int $id_usuario
	 */
	public function getLogroPorContenido($id_quiz, $id_usuario){
		
                $sql = 'SELECT * FROM (
                        SELECT t.* FROM (
                        SELECT nombre, apellido,x.* FROM personas p JOIN (
                        SELECT id_persona,logro,t2.numero_intento,t2.id_contenido as contenido,n as numero_preguntas FROM
                        (
                        SELECT id_persona, sum(puntaje_alumno)/sum(maximo_puntaje)*100 AS logro, numero_intento, id_contenido FROM (
                        SELECT i.*,p.id_contenido FROM intentos i JOIN preguntas p ON i.id_pregunta=p.id
                        WHERE i.id_quiz=?
                        ORDER BY id_persona,numero_intento,id_contenido) as t
                        GROUP BY id_persona,numero_intento,id_contenido) as t2
                        JOIN (SELECT numero_intento,id_contenido,n FROM ( 
                        SELECT id_persona,numero_intento,id_contenido,count(*) AS n FROM (
                        SELECT i.*,p.id_contenido FROM intentos i JOIN preguntas p ON i.id_pregunta=p.id
                        WHERE i.id_quiz = ?
                        ORDER BY id_persona) as t
                        GROUP BY id_persona,numero_intento,id_contenido) as s
                        GROUP BY id_contenido
                        ) as t3 ON t2.id_contenido=t3.id_contenido
                        ) as x ON p.id=x.id_persona JOIN grupos_has_estudiantes ge ON ge.id_persona=x.id_persona) as t
                        JOIN (SELECT nc.id_persona, max(nc.nota) as nota, nc.nmax as nota_maxima,nc.nmin AS nota_minima,numero_intento
                        FROM (SELECT id_persona, q.nota_maxima AS nmax,q.nota_minima AS nmin, sum(puntaje_alumno)*(q.nota_maxima-q.nota_minima)/q.puntaje_maximo+q.nota_minima AS nota, numero_intento 
                        FROM intentos JOIN quizes as q ON id_quiz=q.id WHERE id_quiz = ?
                        GROUP BY id_persona, numero_intento ORDER BY nota DESC) AS nc 
                        WHERE nc.nota <= nc.nmax GROUP BY nc.id_persona) AS u ON t.numero_intento=u.numero_intento AND t.id_persona=u.id_persona) as x
                        WHERE id_persona=? ';
		
                $sqlQuery = new SqlQuery($sql);
                $sqlQuery->setNumber($id_quiz);
                $sqlQuery->setNumber($id_quiz);
                $sqlQuery->setNumber($id_quiz);
                $sqlQuery->setNumber($id_usuario);
                
		return $this->getContenidoLogroArray($sqlQuery);
	}
        
        /*
         * jtoro:Obtiene el promedio de logro por cada contenido de un quiz
         */
        
	public function getPromedioLogroPorContenido($id_quiz, $id_grupo){
		
            $sql =  'SELECT id_contenido as contenido,n as numero_preguntas, round(avg(logro)) as logro FROM grupos_has_estudiantes ge JOIN ( '.
                    'SELECT id_persona,logro,t2.numero_intento,t2.id_contenido,n FROM '.
                    '(SELECT id_persona, sum(puntaje_alumno)/sum(maximo_puntaje)*100 AS logro, numero_intento, id_contenido FROM ( '.
                    'SELECT i.*,p.id_contenido FROM intentos i JOIN preguntas p ON i.id_pregunta=p.id '.
                    'WHERE i.id_quiz=? '.
                    'ORDER BY id_persona,numero_intento,id_contenido) as t '.
                    'GROUP BY id_persona,numero_intento,id_contenido) as t2 '.
                    'JOIN (SELECT numero_intento,id_contenido,n FROM ( '.
                    'SELECT id_persona,numero_intento,id_contenido,count(*) AS n FROM ( '.
                    'SELECT i.*,p.id_contenido FROM intentos i JOIN preguntas p ON i.id_pregunta=p.id '.
                    'WHERE i.id_quiz = ? '.
                    'ORDER BY id_persona) as t '.
                    'GROUP BY id_persona,numero_intento,id_contenido) as s '.
                    'GROUP BY id_contenido '.
                    ') as t3 ON t2.id_contenido=t3.id_contenido AND t2.numero_intento=t3.numero_intento '.
                    ') as x ON ge.id_persona=x.id_persona '.
                    'WHERE ge.id_grupo=? '.
                    'GROUP BY id_contenido, numero_preguntas';

            $sqlQuery = new SqlQuery($sql);
            $sqlQuery->setNumber($id_quiz);
            $sqlQuery->setNumber($id_quiz);
            $sqlQuery->setNumber($id_grupo);
           
        return $this->getContenidoLogroArray($sqlQuery);
	}  
        
        public function getLogroPorContenido2($id_grupo,$id_quiz,$id_contenido){
            $sql='SELECT t2.apellido, t2.nombre, logro FROM '.
                '(SELECT p.id_contenido as contenido, e.apellido,e.nombre,e.id, floor(sum(i.puntaje_alumno)/sum(i.maximo_puntaje)*100) as logro, count(qp.id_pregunta) as numero_preguntas '.
                'FROM preguntas as p, quizes_has_preguntas as qp, intentos AS i '.
                'JOIN grupos_has_estudiantes AS ge ON i.id_persona=ge.id_persona '.
                'JOIN personas e ON i.id_persona= e.id '.
                'WHERE p.id = i.id_pregunta AND i.id_quiz = ? AND ge.id_grupo= ? AND p.id = qp.id_pregunta '.
                'AND p.id_contenido=? '.
                'GROUP BY p.id_contenido,e.apellido,e.nombre,e.id '.
                'ORDER BY logro) AS t '.
                'RIGHT JOIN (SELECT p.apellido,p.nombre,id_persona FROM personas p JOIN grupos_has_estudiantes ON p.id=id_persona WHERE id_grupo=?) AS t2 ON t2.id_persona=t.id '.
                'ORDER BY apellido,nombre ';

                $sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id_quiz);
		$sqlQuery->set($id_grupo);
		$sqlQuery->set($id_contenido);
                $sqlQuery->set($id_grupo);
                
                return $this->getContenidoLogroGrupoArray($sqlQuery);
                
        }
        
        /*
         * jtoro: obtiene las notas de todos los usuario en un quiz
         * @param int $quiz_id
         */
        
        public function getLogroPorContenidoGrupo($id_quiz){
		
		$sql = 'SELECT p.id_contenido as contenido, floor(sum(i.puntaje_alumno)/sum(i.maximo_puntaje)*100) as logro, count(qp.id_pregunta) as numero_preguntas '.
				'FROM intentos  AS i, preguntas as p, quizes_has_preguntas as qp '.
				'WHERE p.id = i.id_pregunta AND i.id_quiz = ? AND p.id = qp.id_pregunta '.
				'GROUP BY p.id_contenido';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id_quiz);
		return $this->getContenidoLogroArray($sqlQuery);
	}
	
	/**
	 * cgajardo: obtiene la nota de un usuario en un quiz
	 *
	 * @param int $quiz_id
	 * @param int $usuario_id
	 * @return NotaLogro $logro
	 */
	public function getNotaInQuizByPersona($quiz_id, $usuario_id){
		$sql = 'SELECT nc.id_persona, max(nc.nota) as nota, nc.nmax as nota_maxima,nc.nmin AS nota_minima '.
				'FROM (SELECT id_persona, q.nota_maxima AS nmax,q.nota_minima AS nmin, sum(puntaje_alumno)*(q.nota_maxima-q.nota_minima)/q.puntaje_maximo+q.nota_minima AS nota, numero_intento '.
				'FROM intentos, quizes as q WHERE id_quiz = ? AND q.id = ? AND id_persona = ? '.
				'GROUP BY id_persona, numero_intento) AS nc '.
				'WHERE nc.nota <= nc.nmax GROUP BY nc.id_persona';
	
		//TODO: revisar por qu� algunos valores se escapan de rango y mejorar esta consulta
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($quiz_id);
		$sqlQuery->set($quiz_id);
		$sqlQuery->set($usuario_id);
		return $this->getNotaLogro($sqlQuery);
	}
	
	/**
	 * cgajardo: devuelve un arreglo de notas del grupo, ordenadas de mayor a menor
	 * @param int $quiz
	 * @param int $grupo
	 */
	public function getNotasGrupo($quiz,$grupo){
		$sql = 'SELECT nc.id_persona, max(nc.nota) as nota, nc.nmax as nota_maxima,nc.nmin AS nota_minima '.
				'FROM (SELECT id_persona, q.nota_maxima AS nmax, q.nota_minima AS nmin, sum(puntaje_alumno)*(q.nota_maxima-q.nota_minima)/q.puntaje_maximo+q.nota_minima AS nota, numero_intento '.
				'FROM intentos, quizes as q '.
				' WHERE id_quiz = ? AND q.id = ? AND id_persona in ('.
				'SELECT id_persona FROM grupos_has_estudiantes WHERE id_grupo = ?) '.
				'GROUP BY id_persona, numero_intento) AS nc '.
				'WHERE nc.nota <= nc.nmax GROUP BY nc.id_persona ORDER BY nota DESC';
	
		//TODO: revisar por qu� algunos valores se escapan de rango y mejorar esta consulta
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($quiz);
		$sqlQuery->set($quiz);
		$sqlQuery->set($grupo);
		return $this->getNotaLogro($sqlQuery);
	}
	
            /*
             * jtoro:devuelve una arreglo de nombres,apellidos y notas del grupo ordenadas de mayor a menor
             * @param int $quiz
             * @param int $grupo
             */
        
        public function getNotasNombreGrupo($quiz,$grupo){
		$sql = 'SELECT t1.nombre,t1.apellido,t1.id as id_persona,t2.logro as nota, nota_maxima FROM '.
                        '(SELECT nombre,apellido,id FROM personas JOIN grupos_has_estudiantes ON id=id_persona WHERE id_grupo=?) as t1 '.
                        'LEFT JOIN '.
                        '(SELECT nombre,apellido,tabla.id_persona, sum(logro*n)/sum(n) as logro ,numero_intento, nota_maxima FROM ( '.
                        'SELECT nombre, apellido,x.* FROM personas p JOIN ( '.
                        'SELECT id_persona,logro,t2.numero_intento,t2.id_contenido,n, nota_maxima FROM '.
                        '(SELECT id_persona, sum(puntaje_alumno)/sum(maximo_puntaje)*100 AS logro, numero_intento, id_contenido, nota_maxima FROM ( '.
                        'SELECT i.*,p.id_contenido,q.nota_maxima FROM intentos i JOIN preguntas p ON i.id_pregunta=p.id '.
                        'JOIN quizes q ON q.id=i.id_quiz '.
                        'WHERE i.id_quiz=? '.
                        'ORDER BY id_persona,numero_intento,id_contenido) as t '.
                        'GROUP BY id_persona,numero_intento,id_contenido) as t2 '.
                        'JOIN (SELECT numero_intento,id_contenido,n FROM ( '.
                        'SELECT id_persona,numero_intento,id_contenido,count(*) AS n FROM ( '.
                        'SELECT i.*,p.id_contenido FROM intentos i JOIN preguntas p ON i.id_pregunta=p.id '.
                        'WHERE i.id_quiz = ? '.
                        'ORDER BY id_persona) as t '.
                        'GROUP BY id_persona,numero_intento,id_contenido) as s '.
                        'GROUP BY id_contenido '.
                        ')as t3 ON t2.id_contenido=t3.id_contenido AND t2.numero_intento=t3.numero_intento '.
                        ')as x ON p.id=x.id_persona JOIN grupos_has_estudiantes ge ON ge.id_persona=x.id_persona '.
                        ') as tabla JOIN grupos_has_estudiantes ge ON ge.id_persona=tabla.id_persona '.
                        'WHERE ge.id_grupo=? '.
                        'GROUP BY nombre,apellido,id_persona,numero_intento '.
                        'ORDER BY logro DESC,apellido,nombre) as t2 ON t1.id=t2.id_persona ORDER BY t2.logro DESC';
	
		//TODO: revisar por qu� algunos valores se escapan de rango y mejorar esta consulta
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($grupo);
                $sqlQuery->setNumber($quiz);
		$sqlQuery->setNumber($quiz);
		$sqlQuery->setNumber($grupo);
                 
		return $this->getNotaNombreLogro($sqlQuery);
	}
	/**
	 * cgajardo: Devuelve una lista de los quizes que ha respondido un usuario
	 * @param $idUsuarioGalyleo en identificador del usuario en la plataforma de reportes
	 * @return $quizes_id devuelve una lista de intentos
	 */
	public function getIntentosByUsuario($idUsuarioGalyleo){
		$sql = 'SELECT * FROM intentos WHERE id_persona = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idUsuarioGalyleo);
	
		return $this->getList($sqlQuery);
	}
	
	/**
	 * cgajardo:
	 * obtener todos los intentos de un usuario para un control y una pregunta dada
	 */
	public function getIntentosByUsuarioQuizPregunta($idPersona, $idQuiz, $idPregunta){
		$sql = 'SELECT * FROM intentos WHERE id_persona = ?  AND id_quiz = ?  AND id_pregunta = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idPersona);
		$sqlQuery->setNumber($idQuiz);
		$sqlQuery->setNumber($idPregunta);
	
		return $this->getRow($sqlQuery);
	}
	
	
	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return IntentosMySql 
	 */
	public function load($id, $idPersona, $idQuiz, $idPregunta){
		$sql = 'SELECT * FROM intentos WHERE id = ?  AND id_persona = ?  AND id_quiz = ?  AND id_pregunta = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		$sqlQuery->setNumber($idPersona);
		$sqlQuery->setNumber($idQuiz);
		$sqlQuery->setNumber($idPregunta);

		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM intentos';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM intentos ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param intento primary key
 	 */
	public function delete($id, $idPersona, $idQuiz, $idPregunta){
		$sql = 'DELETE FROM intentos WHERE id = ?  AND id_persona = ?  AND id_quiz = ?  AND id_pregunta = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		$sqlQuery->setNumber($idPersona);
		$sqlQuery->setNumber($idQuiz);
		$sqlQuery->setNumber($idPregunta);

		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param IntentosMySql intento
 	 */
	public function insert($intento){
		$sql = 'INSERT INTO intentos (puntaje_alumno, fecha, numero_intento, id, id_persona, id_quiz, id_pregunta) VALUES (?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($intento->puntajePregunta);
		$sqlQuery->set($intento->fecha);
		$sqlQuery->setNumber($intento->numeroIntento);

		
		$sqlQuery->setNumber($intento->id);

		$sqlQuery->setNumber($intento->idPersona);

		$sqlQuery->setNumber($intento->idQuiz);

		$sqlQuery->setNumber($intento->idPregunta);

		$this->executeInsert($sqlQuery);	
		//$intento->id = $id;
		//return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param IntentosMySql intento
 	 */
	public function update($intento){
		$sql = 'UPDATE intentos SET puntaje_alumno = ?, fecha = ?, numero_intento = ? WHERE id = ?  AND id_persona = ?  AND id_quiz = ?  AND id_pregunta = ? ';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($intento->puntajePregunta);
		$sqlQuery->set($intento->fecha);
		$sqlQuery->setNumber($intento->numeroIntento);

		
		$sqlQuery->setNumber($intento->id);

		$sqlQuery->setNumber($intento->idPersona);

		$sqlQuery->setNumber($intento->idQuiz);

		$sqlQuery->setNumber($intento->idPregunta);

		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM intentos';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByPuntajePregunta($value){
		$sql = 'SELECT * FROM intentos WHERE puntaje_alumno = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByFecha($value){
		$sql = 'SELECT * FROM intentos WHERE fecha = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByNumeroIntento($value){
		$sql = 'SELECT * FROM intentos WHERE numero_intento = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByPuntajePregunta($value){
		$sql = 'DELETE FROM intentos WHERE puntaje_alumno = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByFecha($value){
		$sql = 'DELETE FROM intentos WHERE fecha = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByNumeroIntento($value){
		$sql = 'DELETE FROM intentos WHERE numero_intento = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return IntentosMySql 
	 */
	protected function readRow($row){
		$intento = new Intento();
		
		$intento->id = $row['id'];
		$intento->idPersona = $row['id_persona'];
		$intento->idQuiz = $row['id_quiz'];
		$intento->idPregunta = $row['id_pregunta'];
		$intento->puntajePregunta = $row['puntaje_alumno'];
		$intento->fecha = $row['fecha'];
		$intento->numeroIntento = $row['numero_intento'];

		return $intento;
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
	 * @return IntentosMySql 
	 */
	protected function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRow($tab[0]);		
	}
	
	/**
	 * @author cgajardo
	 * @param object $sqlQuery
	 * @return int $intento
	 */
	
	private function getIntentoConMayorPuntaje($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$intento = 1;
		if(count($tab)==0){
			return $intento;
		}
		
		$mayor = 0;
		
		for($i=0;$i<count($tab);$i++){
			if($tab[$i] > $mayor){
				$mayor = $tab[$i]['logro'];
				$intento = $tab[$i]['intento'];
			} 
		}
		
		return $intento;
	}
	
	/**
	 * @author cgajardo
	 * @param object $sqlQuery
	 * @return NotaLogro $ret
	 */
	protected function getNotaLogro($sqlQuery){
	
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$notaLogro = new NotaLogro();
			$notaLogro->id = $tab[$i]['id_persona'];
			$notaLogro->logro = round(($tab[$i]['nota']-$tab[$i]['nota_minima'])*($tab[$i]['nota_maxima']-$tab[$i]['nota_minima'])/100);
			$notaLogro->nota =  round($tab[$i]['nota']);
            $ret[$i] = $notaLogro;
		}
		return $ret;
	}
                
        protected function getNotaNombreLogro($sqlQuery){
            
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$notaLogro = new NotaLogro();
			$notaLogro->id = $tab[$i]['id_persona'];
			if($tab[$i]['nota']!=NULL){
                            $notaLogro->nota = round($tab[$i]['nota']*$tab[$i]['nota_maxima']/100);
                            $notaLogro->logro =  round($tab[$i]['nota']);
                        }else{
                            $notaLogro->nota = NULL;
                            $notaLogro->logro =  NULL;
                        }
                        $notaLogro->nombre = $tab[$i]['nombre'];
                        $notaLogro->apellido = $tab[$i]['apellido'];
                        $ret[$tab[$i]['id_persona']] = $notaLogro;
            }
		return $ret;
	}
	
	/**
	 * @author cgajardo
	 * @param object $sqlQuery
	 */
	protected function getArray($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $tab[$i]['nota'];
		}
		return $ret;
	}
	
	protected function getContenidoLogroArray($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$contenido = DAOFactory::getContenidosDAO()->loadWithPadre($tab[$i]['contenido']);
			$ret[$i] = array('contenido' => $contenido, 'logro'=> $tab[$i]['logro'], 'numero_preguntas' => $tab[$i]['numero_preguntas']);
		}
		return $ret;
	}
	
	protected function getQuizLogroArray($sqlQuery) {
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = array('quiz' => $tab[$i]['nombre'], 'logro'=> $tab[$i]['logro']);
		}
		return $ret;
		
	}
	
	protected function getContenidoLogroGrupoArray($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = array('apellido' => $tab[$i]['apellido'],'nombre'=>$tab[$i]['nombre'], 'logro'=> $tab[$i]['logro']);
		}
		return $ret;
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

    public function getLogroPorContenidoWithPadre($id_quiz, $id_usuario) {
            $sql = 'SELECT * FROM (
                        SELECT nombre, apellido,x.* FROM personas p JOIN (
                        SELECT id_persona,logro,t2.numero_intento,t2.id_contenido as contenido,n as numero_preguntas FROM
                        (
                        SELECT id_persona, sum(puntaje_alumno)/sum(maximo_puntaje)*100 AS logro, numero_intento, id_contenido FROM (
                        SELECT i.*,p.id_contenido FROM intentos i JOIN preguntas p ON i.id_pregunta=p.id
                        WHERE i.id_quiz=?
                        ORDER BY id_persona,numero_intento,id_contenido) as t
                        GROUP BY id_persona,numero_intento,id_contenido) as t2
                        JOIN (SELECT numero_intento,id_contenido,n FROM (
                        SELECT id_persona,numero_intento,id_contenido,count(*) AS n FROM (
                        SELECT i.*,p.id_contenido FROM intentos i JOIN preguntas p ON i.id_pregunta=p.id
                        WHERE i.id_quiz = ?
                        ORDER BY id_persona) as t
                        GROUP BY id_persona,numero_intento,id_contenido) as s
                        GROUP BY id_contenido
                        ) as t3 ON t2.id_contenido=t3.id_contenido AND t2.numero_intento=t3.numero_intento
                        ) as x ON p.id=x.id_persona JOIN grupos_has_estudiantes ge ON ge.id_persona=x.id_persona) as t
                        WHERE id_persona=? ';
		
                $sqlQuery = new SqlQuery($sql);
                $sqlQuery->setNumber($id_quiz);
                $sqlQuery->setNumber($id_quiz);
                $sqlQuery->setNumber($id_usuario);
                
		return $this->getContenidoLogroArray($sqlQuery);
    }

    public function getNotasCurso($quiz, $curso) {
                $sql = 'SELECT nc.id_persona, max(nc.nota) as nota, nc.nmax as nota_maxima,nc.nmin AS nota_minima '. 
                       'FROM (SELECT id_persona, q.nota_maxima AS nmax, q.nota_minima AS nmin, sum(puntaje_alumno)*(q.nota_maxima-q.nota_minima)/q.puntaje_maximo+q.nota_minima AS nota, numero_intento '. 
                       'FROM intentos, quizes as q '.
                       'WHERE id_quiz = ? AND q.id = ? AND q.id_curso=? '.
                       'GROUP BY id_persona, numero_intento) AS nc '. 
                       'WHERE nc.nota <= nc.nmax GROUP BY nc.id_persona ORDER BY nota DESC';
	
		//TODO: revisar por qu� algunos valores se escapan de rango y mejorar esta consulta
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($quiz);
		$sqlQuery->set($quiz);
		$sqlQuery->set($curso);
		return $this->getNotaLogro($sqlQuery);
    }
	
	
}
?>
