<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * esta clase Definir resuiqistos no funcionales recibe peticiones de las vista rnf, la cual invoca a las
 * clases modelos caracteristicas, subcaracteristicas, preguntas y procesos, accediendo a sus metodos para motrar 
 * el resultado de las consultas 
 * Autor: Kristein Johan Ordoñez
 * Fecha: 2018-06-13 
 */
class DefinirRNFController extends CI_Controller {
    
    //constructor por defecto
    function __construct() {
        parent::__construct();
        //Invocamos a la clase Proceso_model para poder hacer uso de sus metodos
        $this->load->model('Caracteristicas_model');
        $this->load->model('Subcaracteristica_model');
        $this->load->model('Preguntas_model');
        $this->load->model('Proceso_model');
        $this->load->model('RNF_model');
        /*
         * bolbioteca de codigo disponible, donde hacemos el llamdo de funciones especiales para permirtir
         * usar formularios y peticiones de diferentes url
         */
        $this->load->helper(array('form', 'url'));
        /*
         * Libreria en la cual obtenemos funciones para la validacion de formularios
         */
        $this->load->library('form_validation');
        /*
         * Libreria que nos permite hacer pruebas unitarias con PhpUnit
         */
        $this->load->library('unit_test');
    }
    /*
     * Este metodo se carga de manera predeterminada cuando llamamos al controlador a traves de la URL
     */
    function index() {
        if ($this->session->userdata('login')) {
            /*
             * Agrega los paramametros de la clase sesion a un arreglo. 
             * estos parametros son guardados en la cache cuando el usuario inicia su sesion, los cuales sirven
             * para realizar validaciones y visualizacion de informacion en la vista rnf
             */
            $login["username"] = $this->session->userdata('username');
            $login["tipo"] = $this->session->userdata('tipo');
            $login["nombre"] = $this->session->userdata('nombre');
            $login["apellido"] = $this->session->userdata('apellido');
            $login["email"] = $this->session->userdata('email');
            $login["login"] = $this->session->userdata('login');
            //llama a la vista rnf y le pasamos como parametro el arreglo.
            $this->load->view('rnf_view', $login);
        } else {
             //llama a la vista login de inicio de sesion
            $this->load->view('login');
        }
    }
    /*
     * function que cargar la vista del rnf y que recibe como parametro el identificador del proceso
     * redirigiendo a la vistta rnf.
     */
    function load_rnf_proceso($id_proceso) {

        if ($this->session->userdata('login')) {
            $login['id_proceso'] = $id_proceso;
            $login["username"] = $this->session->userdata('username');
            $login["tipo"] = $this->session->userdata('tipo');
            $login["nombre"] = $this->session->userdata('nombre');
            $login["apellido"] = $this->session->userdata('apellido');
            $login["email"] = $this->session->userdata('email');
            $login["login"] = $this->session->userdata('login');

            $this->load->view('rnf_view', $login);
        } else {
            $this->load->view('login');
        }
    }
    /*
     * este metodo nos permite visualizar las respuestas de las preguntas recibiendo los parametros 
     * enviados desde la vista y retornando un JSON con el resultado de la busqueda.
     */
    function verRespuesta() {
        //peticion AJAX
        if ($this->input->is_ajax_request()) {
            //parametros de netrada enviados por POST
            $id_preg = $this->input->post('id_preg');
            $id_proc = $this->input->post('id_proc');
            //invoca al metodo de ver respuestas en la clase modelo
            $data = $this->RNF_model->getRespuestaProceso($id_preg, $id_proc);
            //envia el resultado a la vista
            echo json_encode($data);
        }
    }
    /*
     * esta funcion permite listar las caracteristicas guaradadas en la base de datos y
     * enviarlas a la vista de rnf
     */
    function listarCaracteristicas() {
        //invoca al metodo de ver carateristicas en la base de datos
        $data = $this->Caracteristicas_model->getCaracteristicas();
        //enviar el resultado a la vista
        echo json_encode($data);
    }
    
    /*
     *este metodo recibe una peticion de la vista, el cual tiene como entrada los parametros
     * para poder visualizar las preguntas de las caracteristicas para luego enviarlos 
     * a la clase modelo y poder consultar su informacion.
     * retorna un JSON con los datos de las preguntas  
     */
    function listarPreguntas_SubCaracteristicas() {
        //pasametros den entrada enviados desde la vista por POST
        $id = $this->input->post('id');
        $id_proc = $this->input->post('id_proc');
        //invoa al metodo de ver preguntas en la clase modelo
        $data = $this->Preguntas_model->preguntas_SubCaracteristicas($id);
        if(!$data){
            
        }else{
            //procesa los datos enviados del modelo para enviarlos a la vista
            foreach ($data as $datos){
                $existe=$this->existeRespuestaProceso($datos->id, $id_proc);
                $check=0;
                if($existe){
                    $check=1;
                }
                $row[]=array(
                    'id'=>$datos->id,
                    'nombre'=>$datos->nombre,
                    'check'=>$check
                );
            }
            //enviar el resultado JSON a la vista
            echo json_encode($row);
        }
    }

    /*
     * funcion que es invocada desde la vista que recibe parametros de entrada que se utilizan
     * para enviarlos al modelo para guardarlos en la base de datos
     * retorna una respuestas de tipo boolean de si los datos fueron registradon en la base de datos
     */
    function guardarRespuesta() {
        //parametros enviados por POST
        if ($this->input->is_ajax_request()) {
            $id_preg= $this->input->post('id_preg');
            $id_proc= $this->input->post('id_proc');
            $descrip= $this->input->post('descrip');
            //verificamos si existe la respuesta
            if($this->existeRespuestaProceso($id_preg, $id_proc)){
                //si existe una respuesta a ese proceso, la actualizamos
                $data=$this->actualizarRespuesta($id_preg, $id_proc, $descrip);
            }else{
                //invoca al metodo de registrar una respuesta a la base de datos
                $data=$this->registrarRespuesta($id_preg, $id_proc, $descrip);
            }
            //retorna el resultado
            echo json_encode($data);
        }
    }
    
    /*
     * function que registra la respuesta a la base de datos
     * retorna el resultado de tipo boolean
     */
    function registrarRespuesta($id_preg, $id_proc, $descrip) {
        $params['id_pregunta'] = $id_preg;
        $params['id_proceso'] = $id_proc;
        $params['descripcion'] = $descrip;
        $data = $this->RNF_model->guardarRespuesta($params);
        return $data;
    }
    
    /*
     * function que actualiza la respuesta a la base de datos
     * retorna el resultado de tipo boolean
     */
    function actualizarRespuesta($id_preg, $id_proc, $descrip) {
        $params['descripcion'] = $descrip;
        $data = $this->RNF_model->actualizarRespuestaProceso($params, $id_preg, $id_proc);
        return $data;
    }
    /*
     * funcion que verifica si existe una respuesta en la base de datos
     * retorna una variable de tipo boolean
     */
    function existeRespuestaProceso($id_preg, $id_proc) {
        $data = $this->RNF_model->existeRespuestaProceso($id_preg, $id_proc);
        return $data;
    }
    
    /*
     * funcion que es invocada desde la vista de gestionar preguntas, la cual recibe los parametros de entrada
     * para eliminar los datos de una respuesta a un proceso.
     * retorna el resutado de la consulta en una variable de tipo boolean de si los datos fueron eliminados de la base de datos
     */
    function eliminarRespuestaProceso() {
        //parametros de entrada enviados desde la vista por POST
        if ($this->input->is_ajax_request()) {
            $id_preg = $this->input->post('id_preg');
            $id_proc = $this->input->post('id_proc');
            //invoca al metodo de la clase modelo que elimina el registro de la respuesta en la base de datos
            $data = $this->RNF_model->eliminarRespuestaProceso($id_preg, $id_proc);
            //envia el resultado a la vista
            echo json_encode($data);
        }
    }
    
    /*
     * funcion que es invocada desde la clase proceso, la cual nos retorna un JSON con los datos de las
     * respuestas que pertenecen a una de pregunta de cada proceso
     */
    function respuestaToPreguntas(){
        //parametros de entrada enviados desde la vista por POST
        if ($this->input->is_ajax_request()) {
            $id_proc = $this->input->post('id_proc');
            //invoca los metodos a la clase modelo para pobeter los arreglos de los resultados de las consultas
            $preguntas = $this->Preguntas_model->numPreguntas();
            $respuestas = $this->Preguntas_model->numRespuestasProceso($id_proc);
            $row=array('preguntas'=>$preguntas->num_preguntas,'respuestas'=>$respuestas->num_respuestas);
            //envio el resultado JSON a la vista
            echo json_encode($row);
        }
    }

}
