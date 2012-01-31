<?php

/**
 * DAOFactory
 * @author: http://phpdao.com
 * @date: ${date}
 */
class DAOFactory{
	
	/**
	 * @return ContenidosDAO
	 */
	public static function getContenidosDAO(){
		return new ContenidosMySqlExtDAO();
	}

	/**
	 * @return CursosDAO
	 */
	public static function getCursosDAO(){
		return new CursosMySqlExtDAO();
	}

	/**
	 * @return CursosHasGruposDAO
	 */
	public static function getCursosHasGruposDAO(){
		return new CursosHasGruposMySqlExtDAO();
	}

	/**
	 * @return EstadoDAO
	 */
	public static function getEstadoDAO(){
		return new EstadoMySqlExtDAO();
	}

	/**
	 * @return GruposDAO
	 */
	public static function getGruposDAO(){
		return new GruposMySqlExtDAO();
	}

	/**
	 * @return GruposHasEstudiantesDAO
	 */
	public static function getGruposHasEstudiantesDAO(){
		return new GruposHasEstudiantesMySqlExtDAO();
	}

	/**
	 * @return GruposHasProfesoresDAO
	 */
	public static function getGruposHasProfesoresDAO(){
		return new GruposHasProfesoresMySqlExtDAO();
	}

	/**
	 * @return InstitucionesDAO
	 */
	public static function getInstitucionesDAO(){
		return new InstitucionesMySqlExtDAO();
	}

	/**
	 * @return InstitucionesHasDirectoresDAO
	 */
	public static function getInstitucionesHasDirectoresDAO(){
		return new InstitucionesHasDirectoresMySqlExtDAO();
	}

	/**
	 * @return IntentosDAO
	 */
	public static function getIntentosDAO(){
		return new IntentosMySqlExtDAO();
	}

	/**
	 * @return NotasDAO
	 */
	public static function getNotasDAO(){
		return new NotasMySqlExtDAO();
	}

	/**
	 * @return PersonasDAO
	 */
	public static function getPersonasDAO(){
		return new PersonasMySqlExtDAO();
	}

	/**
	 * @return PlataformaQuizDAO
	 */
	public static function getPlataformaQuizDAO(){
		return new PlataformaQuizMySqlExtDAO();
	}

	/**
	 * @return PlataformasDAO
	 */
	public static function getPlataformasDAO(){
		return new PlataformasMySqlExtDAO();
	}

	/**
	 * @return PreguntasDAO
	 */
	public static function getPreguntasDAO(){
		return new PreguntasMySqlExtDAO();
	}

	/**
	 * @return QuizesDAO
	 */
	public static function getQuizesDAO(){
		return new QuizesMySqlExtDAO();
	}

	/**
	 * @return QuizesHasPreguntasDAO
	 */
	public static function getQuizesHasPreguntasDAO(){
		return new QuizesHasPreguntasMySqlExtDAO();
	}

	/**
	 * @return ReportesDAO
	 */
	public static function getReportesDAO(){
		return new ReportesMySqlExtDAO();
	}

	/**
	 * @return SedesDAO
	 */
	public static function getSedesDAO(){
		return new SedesMySqlExtDAO();
	}

	/**
	 * @return SedesHasCursosDAO
	 */
	public static function getSedesHasCursosDAO(){
		return new SedesHasCursosMySqlExtDAO();
	}

	/**
	 * @return SedesHasDirectoressedeDAO
	 */
	public static function getSedesHasDirectoressedeDAO(){
		return new SedesHasDirectoressedeMySqlExtDAO();
	}


}
?>