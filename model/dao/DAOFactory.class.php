<?php

/**
 * DAOFactory
 * @author: http://phpdao.com
 * @date: ${date}
 */
class DAOFactory{
	
	public static function getCategoriasDAO(){
		return new CategoriasMySqlDAO();
	}
	
	/**
	 * @return ContenidosDAO
	 */
	public static function getContenidosDAO(){
		return new ContenidosMySqlDAO();
	}

	/**
	 * @return CursosDAO
	 */
	public static function getCursosDAO(){
		return new CursosMySqlDAO();
	}

	/**
	 * @return CursosHasGruposDAO
	 */
	public static function getCursosHasGruposDAO(){
		return new CursosHasGruposMySqlDAO();
	}

	/**
	 * @return EstadoDAO
	 */
	public static function getEstadoDAO(){
		return new EstadoMySqlDAO();
	}

	/**
	 * @return GruposDAO
	 */
	public static function getGruposDAO(){
		return new GruposMySqlDAO();
	}

	/**
	 * @return GruposHasEstudiantesDAO
	 */
	public static function getGruposHasEstudiantesDAO(){
		return new GruposHasEstudiantesMySqlDAO();
	}

	/**
	 * @return GruposHasProfesoresDAO
	 */
	public static function getGruposHasProfesoresDAO(){
		return new GruposHasProfesoresMySqlDAO();
	}

	/**
	 * @return InstitucionesDAO
	 */
	public static function getInstitucionesDAO(){
		return new InstitucionesMySqlDAO();
	}

	/**
	 * @return InstitucionesHasDirectoresDAO
	 */
	public static function getInstitucionesHasDirectoresDAO(){
		return new InstitucionesHasDirectoresMySqlDAO();
	}

	/**
	 * @return IntentosDAO
	 */
	public static function getIntentosDAO(){
		return new IntentosMySqlDAO();
	}
	
	/**
	 * @return LogsDAO
	 */
	public static function getLogsDAO(){
		return new LogsMySqlDAO();
	}

	/**
	 * @return NotasDAO
	 */
	public static function getNotasDAO(){
		return new NotasMySqlDAO();
	}

	/**
	 * @return PersonasDAO
	 */
	public static function getPersonasDAO(){
		return new PersonasMySqlDAO();
	}

	/**
	 * @return PlataformaQuizDAO
	 */
	public static function getPlataformaQuizDAO(){
		return new PlataformaQuizMySqlDAO();
	}

	/**
	 * @return PlataformasDAO
	 */
	public static function getPlataformasDAO(){
		return new PlataformasMySqlDAO();
	}

	/**
	 * @return PreguntasDAO
	 */
	public static function getPreguntasDAO(){
		return new PreguntasMySqlDAO();
	}

	/**
	 * @return QuizesDAO
	 */
	public static function getQuizesDAO(){
		return new QuizesMySqlDAO();
	}

	/**
	 * @return QuizesHasPreguntasDAO
	 */
	public static function getQuizesHasPreguntasDAO(){
		return new QuizesHasPreguntasMySqlDAO();
	}

	/**
	 * @return ReportesDAO
	 */
	public static function getReportesDAO(){
		return new ReportesMySqlDAO();
	}

	/**
	 * @return SedesDAO
	 */
	public static function getSedesDAO(){
		return new SedesMySqlDAO();
	}

	/**
	 * @return SedesHasCursosDAO
	 */
	public static function getSedesHasCursosDAO(){
		return new SedesHasCursosMySqlDAO();
	}

	/**
	 * @return SedesHasDirectoressedeDAO
	 */
	public static function getSedesHasDirectoressedeDAO(){
		return new SedesHasDirectoressedeMySqlDAO();
	}
        
        public static function getCursosHasContenidos(){
                return new CursosHasContenidosMySqlDAO();
        }
        
}
?>
