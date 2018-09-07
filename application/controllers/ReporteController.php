<?php
/**
 * 
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
		 * La  clase ReporteController extiende de la clase CI_Controller, propia del
		 * framework Codeignither
		 * Es una clase que responde que a la  invocacion de los metodos de la clase Reporte_model.
		 * @package   levantamientorequisitos/application/controllers/ReporteController.		 
		 * @version   1.0  Fecha 14-06-2018             
	*/ 

class ReporteController extends CI_Controller {
	/**
		 * Es una función que crea el constructor de la clase. En esta se pueden cargar 
		 * librerias,helper,modelos.		        
	*/ 

    function __construct() {
        parent::__construct();
        //Invocamos a la libreria tcpdf para hacer uso de sus metodos
        $this->load->library('Pdf'); 
        /* 
         * blibioteca de codigo disponible, donde hacemos el llamdo de funciones especiales para permirtir 
         * usar formularios y peticiones de diferentes url 
         */        
		$this->load->helper(array('form', 'url'));                
		//Invocamos a la clase Reporte_model para poder hacer uso de sus metodos
        $this->load->model('Reporte_model'); 
        //Invocamos a la clase Interfaz_model para poder hacer uso de sus metodos
        $this->load->model('Interfaz_model');
        //Invocamos a la clase Normativa_model para poder hacer uso de sus metodos
        $this->load->model('Normativa_model');    

        $this->load->helper('download');    
    }

    /** 
     	 * Este metodo se carga de manera predeterminada cuando llamamos al controlador a traves de la URL	 	 
	*/ 

    public function index() {        
         if($this->session->userdata('login')){//Datos del usuario que se mantienen en sesion

           /* 
             * Agrega los paramametros de la clase sesion a un arreglo.  
             * estos parametros son guardados en la cache cuando el usuario inicia su sesion, los cuales sirven 
             * para realizar validaciones y visualizacion de informacion. 
            */ 
          $login["username"]=$this->session->userdata('username');
          $login["tipo"]=$this->session->userdata('tipo');
          $login["nombre"]=$this->session->userdata('nombre');
          $login["apellido"]=$this->session->userdata('apellido');
          $login["email"]=$this->session->userdata('email');
          $login["login"]=$this->session->userdata('login');          
                   
          }else{ //si el usuario no ha iniciado sesion, entra por este camino y se le redirecciona a la vista del inicio de sesion 
          //Lama a la vista de inicio de sesion.	
          $this->load->view('login');
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
		 * @see 	  para mas informacion consultar la documentacion TCPDF	 https://tcpdf.org/
		 * @return    Un archivo con extensión .pdf con toda la información realcionada
		 * @version   1.0                 
	*/ 

    public function generarPDF() {
    	/*
    	   * Se carga la liberia TCPDF para generar el pdf. 
    	   * para mas informacion consultar la documentacion TCPDF
    	*/    	
        $this->load->library('Pdf');        
        
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('RNF');
		$pdf->SetTitle('Reporte RNF');
		$pdf->SetSubject('RNF');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		    require_once(dirname(__FILE__).'/lang/eng.php');
		    $pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('times', '', 9);			
		$pdf->AddPage();

		$pdf->SetFillColor(255, 255, 127);

		$html .= '<h2> Reporte Requisitos NO funcionales y de Calidad </h3>';
		$html .= '<h3> Proyecto Elicitación Requisitos</h2>';
		$pdf->Ln(3);
		/*
			* Se encarga de recopilar toda la información de los procesos
			* que se encuentra en la base de datos.
		*/
		$procesos = $this->Reporte_model->getReporteInfoProceso();

		$pdf->writeHTML($html,true,false,false,false,'C');
		

				foreach ($procesos as $record) {			
					$pdf->Ln(3);
					$pdf->Cell(0,8,"Informacion Del Proceso",0,false,'L',0,'',false,'M','M');
					$pdf->Ln(6);
					$pdf->Cell(0,8,"Nombre: ".$record->nombre,0,0);
					$pdf->Ln(4);
					$pdf->Cell(0,8,"Prioridad: ".$record->prioridad,0,0 );
					$pdf->Ln(4);
					$pdf->Cell(0,8,"Orden Secuencia: ".$record->orden_secuencia,0,0 );
					$pdf->Ln(4);
					$pdf->Cell(0,8,"Descripción",0,0 );
					$pdf->Ln(5);
					$pdf->MultiCell(175,3,$record->descripcion."\n", 0, 'J', 0, 1, '', '', true);												
					$pdf->Cell(0,8,"Nombre del Rol: ".$record->nombre_R,0,0 );
					$pdf->Ln(5);
					
					
					$idproceso = $record->idproceso;
					/**
						* Se encarga de recopilar toda la información de:
						* interfaces(131), 
						* normativas(132),
						* respuesta (133),
						* asociadas a un proceso en particular que se encuentra en base de datos.
						*@param     Integer $idproceso  identificación del proceso		 			
					*/

					$interfaces = $this->Interfaz_model->getInterfaz_Proceso($idproceso);
					$normativas = $this->Normativa_model->geNormativa_Proceso($idproceso);
					$respuestas = $this->Reporte_model->getRespuestaPregunta($idproceso);
									

					$pdf->Ln(6);
					$pdf->Cell(0,8,"Interfaces Relacionadas al Proceso",0,0 );
					$pdf->Ln(6);

					if($interfaces==false){
							$pdf->Cell(0,8,"No hay interfaces relacionadas para este proceso",0,0);
							$pdf->Ln(6);
						}
						else{
							foreach ($interfaces as $inter) {						
									$pdf->Cell(0,8,"Nombre: ".$inter->nombre,0,0 );
									$pdf->Ln(4);
									$pdf->Cell(0,8,"Descripción",0,0 );
									$pdf->Ln(6);
									$pdf->MultiCell(175,3,$inter->descripcion."\n", 0, 'J', 0, 1, '', '', true);										
									$pdf->Cell(0,8,"Tipo: ".$inter->tipo,0,0 );									
									$pdf->Ln(5);
									$pdf->Cell(0,8,"Detalle Tipo",0,0 );
									$pdf->Ln(5);
									$pdf->MultiCell(175,3,$inter->detalle_tipo."\n", 0, 'J', 0, 1, '', '', true);	
									$pdf->Ln(6);
								}
						}

					$pdf->Ln(4);
					$pdf->Cell(0,8,"Normativas Relacionadas al Proceso",0,0 );
					$pdf->Ln(6);

					if($normativas == false){
						$pdf->Cell(0,8,"No hay normativas relacionadas para este proceso",0,0);
						$pdf->Ln(6);
					}
					else{
						foreach ($normativas as $norma) {
							$pdf->Cell(0,8,"Nombre: ".$norma->nombre,0,0 );
							$pdf->Ln(4);
							$pdf->Cell(0,8,"Descripción",0,0 );							
							$pdf->Ln(5);						
							$pdf->MultiCell(175,3,$norma->descripcion."\n", 0, 'J', 0, 1, '', '', true);	
						}
					}					
					$pdf->Ln(4);
					$pdf->Cell(0,8,"Caracteristicas de calidad Relacionadas al Proceso",0,0 );
					$pdf->Ln(6);	

					if($respuestas ==false){
						$pdf->Cell(0,8,"No hay caracteristicas de calidad relacionadas para este proceso",0,0);
						$pdf->Ln(6);
					}else{

						foreach ($respuestas as $resp) {
							$idsub = $resp->id_sub_caracteristica;
							$infosubcar = $this->Reporte_model->getCaractSubc($idsub);						
							foreach ($infosubcar as $info ) {
									$pdf->Cell(0,8,"Caracteristica: ".$info->nombre,0,0 );
									$pdf->Ln(4);
									$pdf->Cell(0,8,"Subcaracteristica: ".$info->nombreS,0,0 );
									$pdf->Ln(4);									
								}							
									
							$pdf->Cell(0,8,"Pregunta",0,0 );														
							$pdf->Ln(5);
							$pdf->MultiCell(175,3,$resp->nombre."\n", 0, 'J', 0, 1, '', '', true);						
							$pdf->Cell(0,8,"Respuesta",0,0 );
							$pdf->Ln(5);							
							$pdf->MultiCell(175,3,$resp->descripcion."\n", 0, 'J', 0, 1, '', '', true);														

						}
					}																											
					$pdf->AddPage();
				}
		
		// ---------------------------------------------------------
		

		echo json_encode("exito");

		//Close and output PDF document
		ob_clean();
		$pdf->Output('Reporte_Requisitos.pdf', 'F');
		       $data = file_get_contents($this->folder.'Reporte_Requisitos.pdf');
       force_download('Reporte_Requisitos.pdf',$data);
		//end_ob_clean();
		//============================================================+
		// END OF FILE
		//============================================================+
    }
}
