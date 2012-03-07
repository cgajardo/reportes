<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CursosHasContenidosMySqlDAO
 *
 * @author jtoro
 */
class CursosHasContenidosMySqlDAO implements CursosHasContenidosDAO{
    
    
    protected function readRow($row){
            $CursoHasContenido = new CursosHasContenidos();

            $CursoHasContenido->idCurso = $row['id_curso'];
            $CursoHasContenido->idContenido = $row['id_contenido'];
            $CursoHasContenido->frase = $row['frase'];
            $CursoHasContenido->fechaInicio = $row['fecha_inicio'];
            $CursoHasContenido->fechaCierre = $row['fecha_cierre'];
            $CursoHasContenido->link = $row['link'];
            
            return $CursoHasContenido;
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

    public function clean() {
        
            $sql = 'DELETE FROM cursos_has_contenidos';
            $sqlQuery = new SqlQuery($sql);
            
            return $this->executeUpdate($sqlQuery);
        
    }
    public function delete($idCurso, $fechaInicio, $fechaCierre) {
        
            $sql = 'DELETE FROM cursos_has_contenidos WHERE id_curso = ? AND fecha_inicio = ? AND fecha_cierre = ?';
            $sqlQuery = new SqlQuery($sql);
            $sqlQuery->setNumber($id_curso);
            $sqlQuery->setString($fechaInicio);
            $sqlQuery->setString($fechaCierre);
            
            return $this->executeUpdate($sqlQuery);
            
        
    }
    public function getActuales($id_curso) {
        
            $sql = 'SELECT cc.id_curso, c.nombre as id_contenido, cc.frase, cc.fecha_inicio,cc.fecha_cierre,cc.link 
                FROM cursos_has_contenidos cc JOIN contenidos c ON cc.id_contenido = c.id WHERE fecha_inicio< now() AND fecha_cierre>now() AND id_curso = ?';
            $sqlQuery = new SqlQuery($sql);
            $sqlQuery->setNumber($id_curso);
            
            return $this->getList($sqlQuery);
        
    }
    public function getByCurso($id_curso) {
        
            $sql = 'SELECT * FROM cursos_has_contenidos WHERE id_curso = ?';
            $sqlQuery = new SqlQuery($sql);
            $sqlQuery->setNumber($id_curso);
            
            return $this->getList($sqlQuery);
            
    }
    
    public function getCerradosByCurso($id_curso) {
        
            $sql = 'SELECT * FROM cursos_has_contenidos WHERE id_curso = ? AND fecha_cierre < now()';
            $sqlQuery = new SqlQuery($sql);
            $sqlQuery->setNumber($id_curso);
            
            return $this->getList($sqlQuery);
            
        
    }
    
    public function insert($cursosHasContenidos) {
        
            $sql = 'INSERT INTO cursos_has_contenidos VALUES (?,?,?,?,?,?)';
            $sqlQuery = new SqlQuery;
            $sqlQuery->setNumber($id_curso);
            $sqlQuery->setNumber($id_contenido);
            $sqlQuery->setString($frase);
            $sqlQuery->setString($fechaInicio);
            $sqlQuery->setString($fechaCierre);
            $sqlQuery->setString($link);
            
            return  $this->executeInsert($sqlQuery);
    }
    public function load($idCurso, $fechaInicio, $fechaCierre) {
        
            $sql = 'SELECT * FROM cursos_has_contenidos WHERE id_curso = ? AND fecha_inicio = ? AND fecha_cierre = ?';
            $sqlQuery = new SqlQuery($sql);
            $sqlQuery->setNumber($id_curso);            
            $sqlQuery->setString($fechaInicio);            
            $sqlQuery->setString($fechaCierre);            
            
            return $this->getRow($sqlQuery);
        
    }
    public function queryAll() {
        
        $sql = 'SELECT * FROM cursos_has_contenidos';
        $sqlQuery = new SqlQuery($sql);
        
        return $this->getList($sqlQuery);
        
    }
    public function queryAllOrderBy($orderColumn) {
        
        $sql = 'SELECT * FROM cursos_has_contenidos ORDER BY ?';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->setString($orderColumn);
        
        return $this->getList($sqlQuery);
        
    }
    public function update($cursosHasContenidos,$fechaInicioVieja,$fechaCierreVieja) {
        
        $sql = 'UPDATE cursos_has_contenidos SET frase = ?, fecha_inicio = ?, fecha_cierre = ?, link = ? WHERE id_curso = ? AND fecha_inicio = ? AND fecha_cierre = ?';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->setString($cursosHasContenidos->fecha);
        $sqlQuery->setString($cursosHasContenidos->fechaInicio);
        $sqlQuery->setString($cursosHasContenidos->fechaCierre);
        $sqlQuery->setString($cursosHasContenidos->fechaLink);
        $sqlQuery->setNumber($cursosHasContenidos->idCurso);
        $sqlQuery->setString($fechaInicioVieja);
        $sqlQuery->setString($fechaCierreVieja);
        
    }
    
    public function getCerradosByCursoWithContenidos($id_curso) {
        
            $sql = 'SELECT cc.id_curso, c.nombre as id_contenido, cc.frase, cc.fecha_inicio,cc.fecha_cierre,cc.link 
                FROM cursos_has_contenidos cc JOIN contenidos c ON cc.id_contenido = c.id 
                WHERE id_curso = ? AND fecha_cierre < now() ORDER BY fecha_inicio,fecha_cierre';
            $sqlQuery = new SqlQuery($sql);
            $sqlQuery->setNumber($id_curso);
            
            return $this->getList($sqlQuery);
            
        
    }
}

?>
