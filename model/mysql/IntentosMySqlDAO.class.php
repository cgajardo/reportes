<?php
/**
 * Class that operate on table 'intentos'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class IntentosMySqlDAO implements IntentosDAO{
	
	/**
	 * Esta funcion entrega un arreglo de objetos LogroContenido
	 * asociados a un usuario en un quiz
	 * 
	 * @author cgajardo
	 * @param int $usuario_id
	 * @param int $quiz_id
	 */
	public function getLogroPorUnidadTema($usuario_id, $quiz_id){
		
		$sql = 'SELECT sum(puntaje_alumno) AS logro, sum(maximo_puntaje) AS logro_maximo, 
						c.id AS id_contenido, unidad.nombre AS unidad, tema.nombre AS tema '.
				'FROM intentos AS i, contenidos AS c, 
						categorias AS cat, preguntas AS p, contenidos AS unidad, contenidos AS tema '. 
				'WHERE id_persona = ? '. 
					'AND c.id = cat.id_contenido '. 
					'AND p.id_categoria = cat.id '.
					'AND p.id = i.id_pregunta '.
					'AND c.padre = unidad.id '. 
					'AND unidad.padre = tema.id '. 
					'AND id_quiz = ? '.
				'GROUP BY id_contenido ';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($usuario_id);
		$sqlQuery->setNumber($quiz_id);
		
		return $this->getLogroTemaArray($sqlQuery);
		
	}
	
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
		
                $sql = 'SELECT sum(puntaje_alumno)/sum(maximo_puntaje)*100 AS logro, count(*) AS numero_preguntas,c.id_contenido AS contenido
                        FROM preguntas p 
                        JOIN ( 
                            SELECT i.* FROM intentos i 
                            JOIN ( 
                                SELECT id_persona,id_quiz,numero_intento,max(puntaje) 
                                FROM ( 
                                    SELECT id_persona,id_quiz,numero_intento, sum(puntaje_alumno) AS puntaje 
                                    FROM intentos 
                                    WHERE id_quiz=? AND id_persona=? 
                                    GROUP BY id_persona,id_quiz,numero_intento 
                                    ORDER BY puntaje DESC) 
                                AS t1 ) 
                            AS t2 ON i.id_persona=t2.id_persona AND i.id_quiz=t2.id_quiz AND i.numero_intento=t2.numero_intento ) 
                        AS t3 ON p.id = t3.id_pregunta 
                        JOIN categorias c ON p.id_categoria=c.id
                        GROUP BY c.id_contenido';
		
                $sqlQuery = new SqlQuery($sql);
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
        
        public function getLogroPorContenidoGrupo($id_quiz,$id_grupo){
		
		$sql = 'SELECT c.id_contenido AS contenido,sum(puntaje_alumno)/sum(maximo_puntaje)*100 AS logro,count(*) AS numero_preguntas
                        FROM preguntas p 
                        JOIN ( 
                            SELECT i.* FROM intentos i 
                            JOIN ( 
                                SELECT id_persona,id_quiz,numero_intento,max(puntaje) 
                                FROM ( 
                                    SELECT i.id_persona,id_quiz,numero_intento, sum(puntaje_alumno) AS puntaje 
                                    FROM intentos i
                                    JOIN grupos_has_estudiantes ge ON ge.id_persona=i.id_persona
                                    WHERE id_quiz = ? AND id_grupo = ?
                                    GROUP BY i.id_persona,id_quiz,numero_intento 
                                    ORDER BY puntaje DESC)
                                AS t1 
                                GROUP BY id_persona)
                            AS t2 ON i.id_persona=t2.id_persona AND i.id_quiz=t2.id_quiz AND i.numero_intento=t2.numero_intento ) 
                        AS t3 ON p.id = t3.id_pregunta 
                        JOIN categorias c ON p.id_categoria=c.id
                        GROUP BY c.id_contenido
                        ORDER BY logro DESC';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id_quiz);
		$sqlQuery->set($id_grupo);

		return $this->getContenidoLogroArray($sqlQuery);
	}
        
        public function getLogroPorContenidoGrupoDetalle($id_quiz,$id_grupo){
		
		$sql = 'SELECT c.id_contenido AS contenido,t3.id_persona,sum(puntaje_alumno)/sum(maximo_puntaje)*100 AS logro,count(*) AS numero_preguntas
                        FROM preguntas p 
                        JOIN ( 
                            SELECT i.* FROM intentos i 
                            JOIN ( 
                                SELECT id_persona,id_quiz,numero_intento,max(puntaje) 
                                FROM ( 
                                    SELECT i.id_persona,id_quiz,numero_intento, sum(puntaje_alumno) AS puntaje 
                                    FROM intentos i
                                    JOIN grupos_has_estudiantes ge ON ge.id_persona=i.id_persona
                                    WHERE id_quiz = ? AND id_grupo = ?
                                    GROUP BY i.id_persona,id_quiz,numero_intento 
                                    ORDER BY puntaje DESC)
                                AS t1 
                                GROUP BY id_persona)
                            AS t2 ON i.id_persona=t2.id_persona AND i.id_quiz=t2.id_quiz AND i.numero_intento=t2.numero_intento ) 
                        AS t3 ON p.id = t3.id_pregunta 
                        JOIN categorias c ON p.id_categoria=c.id
                        GROUP BY c.id_contenido,t3.id_persona
                        ORDER BY contenido,logro DESC';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id_quiz);
		$sqlQuery->set($id_grupo);

		return $this->getLogroArray($sqlQuery);
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
		$sql = 'SELECT p2.nombre,p2.apellido,id_persona,sum(puntaje_alumno)/sum(maximo_puntaje)*100 AS logro
                        FROM preguntas p 
                        JOIN ( 
                            SELECT i.* FROM intentos i 
                            JOIN ( 
                                SELECT id_persona,id_quiz,numero_intento,max(puntaje) 
                                FROM ( 
                                    SELECT i.id_persona,id_quiz,numero_intento, sum(puntaje_alumno) AS puntaje 
                                    FROM intentos i
                                    JOIN grupos_has_estudiantes ge ON ge.id_persona=i.id_persona
                                    WHERE id_quiz = ? AND id_grupo = ?
                                    GROUP BY i.id_persona,id_quiz,numero_intento 
                                    ORDER BY puntaje DESC)
                                AS t1 
                                GROUP BY id_persona)
                            AS t2 ON i.id_persona=t2.id_persona AND i.id_quiz=t2.id_quiz AND i.numero_intento=t2.numero_intento ) 
                        AS t3 ON p.id = t3.id_pregunta 
                        JOIN categorias c ON p.id_categoria=c.id
                        JOIN personas p2 ON t3.id_persona=p2.id
                        GROUP BY id_persona
                        ORDER BY logro DESC';
	
		//TODO: revisar por qu� algunos valores se escapan de rango y mejorar esta consulta
		$sqlQuery = new SqlQuery($sql);
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
	 * @return NotaLogro Array $ret
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
	
	/**
	 * @author cgajardo
	 * @param Object $sqlQuery
	 * @return LogroContenido Array $ret
	 */
	protected function getLogroTemaArray($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$logroContenido = new LogroContenido();
			$logroContenido->contenido = DAOFactory::getContenidosDAO()->load($tab[$i]['id_contenido']);
			$logroContenido->sumaAlumno = $tab[$i]['logro'];
			$logroContenido->sumaMaxima = $tab[$i]['logro_maximo'];
			$logroContenido->tema = $tab[$i]['tema'];
			$logroContenido->unidad = $tab[$i]['unidad'];
			$ret[$i] = $logroContenido;
		}
		return $ret;
	}
                
    protected function getNotaNombreLogro($sqlQuery){
            
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$notaLogro = new NotaLogro();
			$notaLogro->id = $tab[$i]['id_persona'];
			if($tab[$i]['logro']!=NULL){
                            //$notaLogro->nota = round($tab[$i]['nota']*$tab[$i]['nota_maxima']/100);
                            $notaLogro->logro =  round($tab[$i]['logro']);
                        }else{
                            //$notaLogro->nota = NULL;
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
        
	protected function getLogroArray($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = array('contenido' => $tab[$i]['contenido'], 'id_persona' => $tab[$i]['id_persona'], 'logro'=> $tab[$i]['logro'], 'numero_preguntas' => $tab[$i]['numero_preguntas']);
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
