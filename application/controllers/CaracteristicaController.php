<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * esta clase caracteristica recibe peticiones de las vista caracteristicas, la cual invoca a las
 * clases modelos caracteristicas, subcaracteristicas y procesos, accediendo a sus metodos para motrar 
 * el resultado de las consultas 
 */
class CaracteristicaController extends CI_Controller {
    
    ///constructor por defecto
    function __construct() {
        parent::__construct();
        //Invocamos a las clases modelos para poder hacer uso de sus metodos
        $this->load->model('Caracteristicas_model');
        $this->load->model('Subcaracteristica_model');
        $this->load->model('Proceso_model');
        /*
         * bolbioteca de codigo disponible, donde hacemos el llamdo de funciones especiales para permirtir
         * usar formularios y peticiones de diferentes url
         */
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('unit_test');
    }
    
    /*
     * Este metodo se carga de manera predeterminada cuando llamamos al controlador a traves de la URL
     */
    function index() {//funcion que carga la vista
        //verificamos si el usuario ha iniciado sesion
        if ($this->session->userdata('login')) {
            /*
             * Agrega los paramametros de la clase sesion a un arreglo. 
             * estos parametros son guardados en la cache cuando el usuario inicia su sesion, los cuales sirven
             * para realizar validaciones y visualizacion de informacion en la vista proceso
             */
            $login["username"] = $this->session->userdata('username');
            $login["tipo"] = $this->session->userdata('tipo');
            $login["nombre"] = $this->session->userdata('nombre');
            $login["apellido"] = $this->session->userdata('apellido');
            $login["email"] = $this->session->userdata('email');
            $login["login"] = $this->session->userdata('login');
            //llama a la vista caracteristica y le pasamos como parametro el arreglo.
            $this->load->view('caracteristica_view', $login);
        } else {
            //si el usuario no ha iniciado sesion, llama a la vista login de inicio de sesion
            $this->load->view('login');
        }
    }
    
    /*
     *funcion que recibe peticiones desde la vista caracteristicas, la cual invoca al metodo de cosultar 
     * las caracteristicas en la clase modelo.
     * retornando como resultado un JSON que contiene la informacion de las caracteristicas 
     */
    function listarCaracteristicas() {
        //invoca la funcion de listar caracteristicas en la clade modelo
        $data = $this->Caracteristicas_model->getCaracteristicas();
        if (!$data) {
            echo json_encode(false);
        } else {
            $row = array();
            //mediante un ciclo for, procesa los datos enviados desde el modelo, para enviarlos 
            //a la vista
            foreach ($data as $datos) {

                $id = $datos['id'];
                $btnView = "<button class = 'btn btn-primary btn-sm' onclick='viewCaracteristica(" . json_encode($datos) . ");'><span class ='glyphicon glyphicon-search'></span></button>";
                $btnEdit = "<button class = 'btn btn-warning btn-sm' onclick='editCaracteristica(" . json_encode($datos) . ");'><span class ='glyphicon glyphicon-pencil'></span></button>";
                $btnDelete = "<button class = 'btn btn-danger btn-sm' onclick='deleteCaracteristica($id);'><span class ='glyphicon glyphicon-trash'></span></button>";

                $btn_add_caract = "<button class = 'btn btn-primary btn-sm' onclick='sub_caracteristica($id);'><i class='fa fa-sitemap'></i></button>";
                $btn_add_preg = "<button class = 'btn btn-primary btn-sm' onclick='agregarPregunta($id);'><i class='fa fa-question-circle'></i></button>";

                $descrip = $datos['descripcion'];
                if (strlen($descrip) > 50) {
                    $descrip = substr($descrip, 0, 50);
                    $descrip .= "...";
                }
                //$txt_descrip='<a href="#" onclick="verDescripNorma('.$idNorma.')">'.$descrip.'</a>';
                if ($this->session->userdata('tipo')==3 || $this->session->userdata('tipo')==2) {
                    $row[] = array(
                        'nombre' => $datos['nombre'],
                        'descrip' => $descrip,
                        'accion' => $btnView
                    );
                }
                else{
                    $row[] = array(
                        'nombre' => $datos['nombre'],
                        'descrip' => $descrip,
                        'accion' => $btnView . " " . $btnEdit . " " . $btnDelete . " " . $btn_add_caract . " " . $btn_add_preg
                    );
                }
                
            }
            $result = array("data" => $row);
            //envia el resultado por medio de un JSON
            echo json_encode($result);
        }
    }
    /*
     * funcion que recibe una peticion desde la vista, la cual recibe como parametros los datos 
     * de la caracteristica para posteriormente enviarlos al modelo e insertalos a la base de datos.
     * retorna un resultado de tipo boolean, retornando false o true de si los datos fueron insertados o no  
     */
    function insertarCaracteristica() {
        
        //recibe los parametros desde la vista po medio de AJAX
        if ($this->input->is_ajax_request()) {
            $nombre = $this->input->post('nombre');
            $desc = $this->input->post('descripcion');
            $params['nombre'] = $nombre;
            $params['descripcion'] = $desc;
            //verificamos que no exista la caracteristica con la misma informacion
            if ($this->Caracteristicas_model->existe_caracteristica($nombre)) {
                echo json_encode("exist");
            } else {
                //invocamos al metodo de la clase modelo enviando los datos de la nueva caracteristica
                $result = $this->Caracteristicas_model->agregarCaracteristica($params);
                //envia el resultado de la consulta a la base de datos
                echo json_encode($result); 
            }
        }
    }
    /*
     * funcion que recibe una peticion desde la vista, la cual recibe como parametros los datos 
     * de la caracteristica para posteriormente enviarlos al modelo y actualizarlos en la base de datos.
     * retorna un resultado de tipo boolean, retornando false o true de si los datos fueron actualizados  
     */
    function actualizarCaracteristica() {
        //parametros de entrada enviados desde la vista a traves de POST
        if ($this->input->is_ajax_request()) {
            $nombre = $this->input->post('nombre');
            $desc = $this->input->post('descripcion');
            $id = $this->input->post('id');
            $params['nombre'] = $nombre;
            $params['descripcion'] = $desc;
            //invocamos al metodo de actualizar las caracteristicas en la clase modelo
            $result = $this->Caracteristicas_model->actualizarCaracteristica($params, $id);
            //envia el resultado a la vista
            echo json_encode($result); 
        }
    }

    /*
     * funcion que recibe una peticion desde la vista caracteristica, la cual recibe como parametro el identificador 
     * de la caracteristica para posteriormente enviarlos al modelo y eliminarlo de la base de datos.
     * retorna un resultado de tipo boolean, retornando false o true de si la caracteristica fue eliminada.  
     */
    function eliminarCaracteristica() {
        if ($this->input->is_ajax_request()) {
            //parametro de entrada enviado desde la vista por medio de AJAX
            $id = $this->input->post('id');
            //invoca al metodo de elmimnar caracteristica en la clase modelo
            $result = $this->Caracteristicas_model->eliminarCaracteristica($id);
            if ($result) {
                //consulta las subcaracteristicas asociadas
                $data_sc = $this->listarSubCarateristicas_Id($id);
                if (!$data_sc) {
                    //si no hay preguntas
                } else {
                    foreach ($data_sc as $datos) {
                        //elimina todas las preguntas asociadas a la subcaracteristica
                        $this->Caracteristicas_model->eliminarPreguntas($datos->id_sub);
                    }
                    //elimina todas las subcaracteristicas asociadas a la caracteristica
                    $this->Caracteristicas_model->eliminarSubCaracteristica($id); ///elimina en cascada las subcaractristicas que pertenecen a esta caracterstica
                }
            }
            //envia el resultado a la vista
            echo json_encode($result);
        }
    }
    
    /*
     * funcion que lista las subcaracteristicas pertenecientes a una caracteristica
     */
    function listarSubCarateristicas_Id($id) {
        //invoca al metodo de consultar las sub caracteristicas en la clase modelo
        //pasandole como parametro el identificador de la caracteristica
        $result = $this->Subcaracteristica_model->ListarSubCaracteristicas($id);
        return $result;
    }

}
