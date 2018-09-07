<?php

/* 
 
Esta clase es el controlador para gestionar las normativas asociadas a cada proceso
 * 
 */
/*
 * Esta clase recibe las peticiones desde la vista normativa, la cual invoca a 
 * los metodos la clase Normativa_model realizando diferentes consultas en la base de datos (CRUD),
 * para finalmente mostrar los datos retornados a las vistas. 
 * Autor: Kristein Johan Ordoñez - Alejandra Tapia
 * Fecha: 2018-06-13
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class NormativaController extends CI_Controller {

    //Funcion para conectarse y/o cargar modelos y clases
    function __construct() {
        parent::__construct();
        $this->load->model('Proceso_model'); 
        $this->load->model('Normativa_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('unit_test');
    }
    
    //funcion que carga la vista de login
    function index() {
        if ($this->session->userdata('login')) {
            $login["username"] = $this->session->userdata('username');
            $login["tipo"] = $this->session->userdata('tipo');
            $login["nombre"] = $this->session->userdata('nombre');
            $login["apellido"] = $this->session->userdata('apellido');
            $login["email"] = $this->session->userdata('email');
            $login["login"] = $this->session->userdata('login');

            $this->load->view('normativa_view', $login);
        } else {
            $this->load->view('login');
        }
    }
    
    //Funcion que recibe los datos de una nueva normativa, y crea una nueva normativa mediante el modelo 
    function agregarNormativa() {
        $idproceso = $this->input->post('id_pro');
        $nombre = $this->input->post('nombre');
        $desc = $this->input->post('descripcion');
        
        $params['idproceso'] = $idproceso;
        $params['nombre'] = $nombre;
        $params['descripcion'] = $desc;
        $existe = $this->Normativa_model->existe_normativa($nombre);
        if ($existe) {
            echo json_encode("exist");
        } else {
            $result = $this->Normativa_model->agregarNormativa($params);
            echo json_encode($result);
        }
    }
       
    //Funcion que obtiene todas las normativas del modelo y las lista, adicionando los botones de gestion para cada nromativa
    function listarNormativas(){
        $data = $this->Normativa_model->getNormativas();
        if(!$data){
            echo json_encode(null);
        }else{
            $row=array();
            foreach ($data as $datos){                
                $idNorma=$datos['idnormativa'];
                $btnView = "<button class = 'btn btn-primary btn-sm' onclick='verNormativa($idNorma);'><span class ='glyphicon glyphicon-search'></span></button>";
                $btnEdit = "<button class = 'btn btn-warning btn-sm' onclick='actualizarNorm($idNorma);'><span class ='glyphicon glyphicon-pencil'></span></button>";
                $btnDelete = "<button class = 'btn btn-danger btn-sm' onclick='eliminarNormativa($idNorma);'><span class ='glyphicon glyphicon-trash'></span></button>";
                
                $descrip=$datos['descrip'];
                if(strlen ($descrip)>50){
                    $descrip=substr($descrip, 0, 50);
                    $descrip.="...";
                }
                
                $txt_descrip='<a href="#" onclick="verDescripNorma('.$idNorma.')">'.$descrip.'</a>';
                
                if ($this->session->userdata('tipo')==3) {
                    $row[]=array(
                        'nombre' => $datos['nombre_norma'],
                        'descripcion' => $txt_descrip,
                        'idproceso' => $datos['nombre_pro'],
                        'accion' => $btnView 
                    );
                }
                else{
                    $row[]=array(
                        'nombre'=>$datos['nombre_norma'],
                        'descripcion' =>$txt_descrip,
                        'idproceso'=>$datos['nombre_pro'],
                        'accion'=>$btnView." ".$btnEdit." ".$btnDelete
                    );
                }
                
            }
            $result = array("data" => $row);
            echo json_encode($result);
        }
    }
    
    //Funcion que obtiene la lista de procesos del modelo para cargar los procesos para adicionar o editar la normativa
    function listaProcesos() {
        $result = $this->Proceso_model->getProces();
        echo json_encode($result);
    }
     
    /*
     * funcion que recibe una peticion des de la vista y el parametro Id del proceso, para 
     * luego ser enviados a la clase Normativa_model que se comunica con la base de datos y 
     * que retorna la lista las normativas asociadas
     */
    function listarNormativaProceso(){
        //parametro de entrada enviado desde la vista proceso a traves de AJAX
         $id = $this->input->post('id_pro');
         //invoca al metodo de la clase modelo, que retorna la informacion de las politicas
         $result = $this->Normativa_model->geNormativa_Proceso($id);
         //envia el resultado a la vista
         echo json_encode($result);
    }
    
    //Recibe Id de normativa y obtiene su descritpcion 
    function getDescripNormativa(){        
        alert("id en controller "+$id);
        $data=$this->Normativa_model->normativa_Id($id);
        echo json_encode($data);
    }
    
    //Recibe Id del proceso y obtiene la normativa asociada
    function getNormativaProceso(){
        $id=$this->input->post('id_pro');
        $data=$this->Normativa_model->normativa_Proceso($id);
        echo json_encode($data);
    }   
    
    //Recibe Id de normativa y la elimina
    function eliminarNormativa() {

        $id = $this->input->post('id');
        if (is_numeric($id)) {
            $result = $this->Normativa_model->eliminarNormativa($id);
            echo json_encode($result);
        }
    }
    
    //Recibe Id de normativa y actualiza cada campo, mediante el modelo
    function actualizarNormativa(){
                
        $id_nor = $this->input->post('id_nor');            
        $idproceso = $this->input->post('proceso');
        $nombre = $this->input->post('nombre');
        $desc = $this->input->post('descripcion');        
        
        $params['idproceso'] = $idproceso;
        $params['nombre'] = $nombre;
        $params['descripcion'] = $desc;

        $result = $this->Normativa_model->actualizarNormativa($params, $id_nor);
        echo json_encode($result);
    }
    
    //Recibe Id de normativa devuelve el registro
    function consultarNormativaId(){
         $id = $this->input->post('id');
         $result = $this->Normativa_model->normativa_Id($id);
         echo json_encode($result);
    }
    
   
}

