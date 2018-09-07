<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class PreguntasController extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('Preguntas_model'); //Para conectarse con el modelo de procesos
        $this->load->model('Caracteristicas_model');
        $this->load->model('Subcaracteristica_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }
    
    function index() {//funcion que carga la vista
        if ($this->session->userdata('login')) {
            $login["username"] = $this->session->userdata('username');
            $login["tipo"] = $this->session->userdata('tipo');
            $login["nombre"] = $this->session->userdata('nombre');
            $login["apellido"] = $this->session->userdata('apellido');
            $login["email"] = $this->session->userdata('email');
            $login["login"] = $this->session->userdata('login');

            $this->load->view('preguntas_view', $login);
        } else {
            $this->load->view('login');
        }
    }
    
    function insertarPregunta(){
        $nombre = $this->input->post('nombre');
        $caracteristica = $this->input->post('id_caract');
        $params['nombre'] = $nombre;
        $params['id_sub_caracteristica'] = $caracteristica;
        
        $result = $this->Preguntas_model->agregarPregunta($params);
        echo json_encode($result);
            
    }
    
    function listarPreguntas(){
        
        $data = $this->Preguntas_model->getPregunta();  //llama al metodo que pertenece al modelo
        if (!$data) { //si el retorno es falso
            echo json_encode(false);
        } else {
            $row = array(); //creo un arreglo
            foreach ($data as $datos) { //foreach para recorrer la lista de los procesos que retorno el modelo
                
                $id_pregunta = $datos['id'];
                $btnView = "<button class='btn btn-primary btn-sm' onclick='verPreguntas($id_pregunta);'><span class='glyphicon glyphicon-search'></span></button>";
                $btnEdit = "<button class='btn btn-warning btn-sm' onclick='actualizarPregunta($id_pregunta);'><span class='glyphicon glyphicon-pencil'></span></button>";
                $btnDelete = "<button class='btn btn-danger btn-sm' onclick='eliminarPregunta($id_pregunta);'><span class='glyphicon glyphicon-trash'></span></button>";
                
                if ($this->session->userdata('tipo')==3 || $this->session->userdata('tipo')==2) {
                    ///empiezo a llenar el arreglo con los datos de la BD para mostrarlos en la vista
                    $row[] = array(
                        'nombre' => $datos['nombre'],
                        'nombreC' => $datos['nombre_sb'],
                        'accion' => $btnView
                    );
                }
                else{
                    ///empiezo a llenar el arreglo con los datos de la BD para mostrarlos en la vista
                $row[] = array(
                    'nombre' => $datos['nombre'],
                    'nombreC' => $datos['nombre_sb'],
                    'accion' => $btnView . " " . $btnEdit . " " . $btnDelete
                );
                }
                
                
            }
            $result = array("data" => $row);
            echo json_encode($result); ///retorno el arreglo a la vista
        }
    }
    
    function getPreguntaCaracteristica(){
        $id=$this->input->post('id_pro');
        $data=$this->Preguntas_model->normativa_Proceso($id);
        echo json_encode($data);
    }
    
    function consultarPreguntaId(){
        $id = $this->input->post('id');
        $result = $this->Preguntas_model->pregunta_Id($id);
        echo json_encode($result);
    }
    
    function eliminarPregunta() {

        $id = $this->input->post('id');
        if (is_numeric($id)) {
            $result = $this->Preguntas_model->eliminarPreguntas($id);
            echo json_encode($result);
        }
    }
    
    function actualizarPregunta(){
        
        $nombre = $this->input->post('nombre');
        $id_caract = $this->input->post('id_caract');
        $id_pre = $this->input->post('id_pre');

        $params['nombre'] = $nombre;
        $params['id_sub_caracteristica'] = $id_caract;

        $result = $this->Preguntas_model->actualizarPregunta($params, $id_pre);
        echo json_encode($result);
    }
    
    function listaCaracteristicas() {
        $result = $this->Subcaracteristica_model->ListarSubCaracteristicas_All();
        echo json_encode($result);
    }
    
}
