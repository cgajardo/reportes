<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface PreguntasDAO{
	
	/**
	 * Devuelve el total de preguntas existentes en las base de datos
	 * @author cgajardo
	 */
	public function count();
	
	/**
	 * Esta funcion devuelve un grupo de preguntas, útil para la paginación
	 *
	 * @author cgajardo
	 * @param int $from
	 * @param int $delta
	 */
	public function getFrom($from, $delta);
	
	
	/**
	 * @author: cgajardo
	 *
	 * Devuelve todas las preguntas que aun no se han asociado a un contenido
	 */
	public function getAllSinContenido();

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Preguntas 
	 */
	public function load($id);

	/**
	 * Get all records from table
	 */
	public function queryAll();
	
	/**
	 * Get all records from table ordered by field
	 * @Param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn);
	
	/**
 	 * Delete record from table
 	 * @param pregunta primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Preguntas pregunta
 	 */
	public function insert($pregunta);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Preguntas pregunta
 	 */
	public function update($pregunta);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByIdentificadorMoodle($value);

	public function queryByIdContenido($value);

	public function deleteByIdentificadorMoodle($value);

	public function deleteByIdContenido($value);
        
    public function getPreguntaByCategoria($nombre_categoria);

        public function getPreguntaByPatron($patron);
        
        public function countWithPatron($patron);
        
        public function getPregutasByQuizWithContenido($id_quiz);

}
?>