<?php 
/**
		 * Generar archivo PDF. 
		 * 
		 * Crea un archivo PDf con toda la información del los procesos
		 * sus interfaces,normativas y caracteristicas de calidad que se encuentran asosciados.
		 * 
		 *
		 * @package   levantamientorequisitos/application/controllers/ReporteController.php/generarPDF		 		 
		 * @param     la funcion no recibe paramateros 
		 * @return    Un archivo con extensión .pdf con toda la información realcionada
		 * @version   1.0                 
	*/ 

class Reporte_model extends CI_Model
{	
	function __construct()
	{
		parent:: __construct();
	}
	/**
		 * Generar archivo PDF. 
		 * 
		 * Crea un archivo PDf con toda la información del los procesos
		 * sus interfaces,normativas y caracteristicas de calidad que se encuentran asosciados.
		 * 
		 *
		 * @package   levantamientorequisitos/application/controllers/ReporteController.php/generarPDF		 		 
		 * @param     la funcion no recibe paramateros 
		 * @return    Un archivo con extensión .pdf con toda la información realcionada
		 * @version   1.0                 
	*/ 


	function getReporteInfoProceso(){
		$this->db->select('P.idproceso,P.nombre,P.prioridad,P.orden_secuencia,P.descripcion,R.nombre nombre_R');
		$this->db->from('proceso P');		
		$this->db->join('role R','R.idrole = P.id_role');
		$this->db->order_by('P.orden_secuencia','asc');

		$data=$this->db->get();

        if($data->num_rows()>0){
            //return $data->result_array();
            return $data->result();
        }else{
            return false;
        }
	}
	/**
		 * Generar archivo PDF. 
		 * 
		 * Crea un archivo PDf con toda la información del los procesos
		 * sus interfaces,normativas y caracteristicas de calidad que se encuentran asosciados.
		 * 
		 *
		 * @package   levantamientorequisitos/application/controllers/ReporteController.php/generarPDF		 		 
		 * @param     la funcion no recibe paramateros 
		 * @return    Un archivo con extensión .pdf con toda la información realcionada
		 * @version   1.0                 
	*/ 

	function getReporteInfoRespuesta($idproceso){
		$this->db->select('id_pregunta,descripcion');
		$this->db->from('respuesta');				
		$this->db->where('id_proceso',$idproceso);

		$data=$this->db->get();

        if($data->num_rows()>0){            
            return $data->result();
        }else{
            return false;
        }			
	}
	

	/**
		 * Generar archivo PDF. 
		 * 
		 * Crea un archivo PDf con toda la información del los procesos
		 * sus interfaces,normativas y caracteristicas de calidad que se encuentran asosciados.
		 * 
		 *
		 * @package   levantamientorequisitos/application/controllers/ReporteController.php/generarPDF		 		 
		 * @param     la funcion no recibe paramateros 
		 * @return    Un archivo con extensión .pdf con toda la información realcionada
		 * @version   1.0                 
	*/ 


	function getRespuestaPregunta($idproceso) {
        $this->db->select('R.descripcion,P.nombre,P.id_sub_caracteristica');
        $this->db->where('R.id_proceso', $idproceso);
        $this->db->from('respuesta R');
        $this->db->join('preguntas P','P.id = R.id_pregunta');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result();
        } else {
            return false;
        }
    }

    /**
		 * Generar archivo PDF. 
		 * 
		 * Crea un archivo PDf con toda la información del los procesos
		 * sus interfaces,normativas y caracteristicas de calidad que se encuentran asosciados.
		 * 
		 *
		 * @package   levantamientorequisitos/application/controllers/ReporteController.php/generarPDF		 		 
		 * @param     la funcion no recibe paramateros 
		 * @return    Un archivo con extensión .pdf con toda la información realcionada
		 * @version   1.0                 
	*/ 


    function getCaractSubc($idsub) {
        $this->db->select('S.nombre nombreS,C.nombre');
        $this->db->where('S.id_sub', $idsub);
        $this->db->from('sub_caracteristica S');
        $this->db->join('caracteristica C','C.id = S.id_caract');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result();
        } else {
            return false;
        }
    }

}