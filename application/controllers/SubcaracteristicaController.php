<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
         * La  clase SubcaracteristicaController extiende de la clase CI_Controller, propia del
         * framework Codeignither
         * Es una clase que responde a la invocacion a los metodos de la clase Subcaracteristica_model.
         * @package   levantamientorequisitos/application/controllers/SubcaracteristicaController.         
         * @version   1.0  Fecha 13-06-2018                 
    */ 

class SubcaracteristicaController extends CI_Controller {
    
    /**
         * Es una función que crea el constructor de la clase. En esta se pueden cargar 
         * librerias,helper,modelos.                
    */ 
    function __construct() {
        parent::__construct();
        //Invocamos a la clase Subcaracteristica_model para poder hacer uso de sus metodos
        $this->load->model('Subcaracteristica_model'); 
        //Invocamos a la clase Caracteristicas_model para poder hacer uso de sus metodos
        $this->load->model('Caracteristicas_model');
        /* 
         * biblioteca de codigo disponible, donde hacemos el llamdo de funciones especiales para permirtir 
         * usar formularios y peticiones de diferentes url 
         */        
        $this->load->helper(array('form', 'url'));        
    }

    /**
         /** 
         * Este metodo se carga de manera predeterminada cuando llamamos al controlador a traves de la URL       
         * funcion que carga la vista
    */ 

    function index() {
        
        if($this->session->userdata('login')){
            //Datos del usuario que se mantienen en sesion
            $login["username"]=$this->session->userdata('username');
            $login["tipo"]=$this->session->userdata('tipo');
            $login["nombre"]=$this->session->userdata('nombre');
            $login["apellido"]=$this->session->userdata('apellido');
            $login["email"]=$this->session->userdata('email');
            $login["login"]=$this->session->userdata('login');
            
            $this->load->view('subcaracteristica_view', $login);

        }else{
            $this->load->view('login');
        }
    }

    /**
         * registrarSubcaracteristica 
         * 
         * Registra los datos de una subcaracteristica los datos se obtienen mediante metodo POST
         * desde la vista subcarateristica_view.php  y utiliza la clase Subcaracteristica_model
         * metodo registrarSubcaracteristica para registrarlos en la base de datos.
         * 
         *                    
         * @param     la funcion no recibe parametros 
         * @return    true o false        
         * @version   1.0                 
    */ 

    function registrarSubcaracteristica() {
        $user=array(
            //parametros de entrada desde la vista por medio de peticiones AJAX de tipo POST
            'nombre'=>$this->input->post('nombreControlador'),
            'descripcion'=>$this->input->post('descripcionControlador'),
            'id_caract'=>$this->input->post('id_caractControlador')            
          );                
            $result = $this->Subcaracteristica_model->registrarSubcaracteristica($user);
            //restorna el resultado a la vista.
            echo json_decode($result);        
    }

    
    /**
         * listarSubcaracteristicas 
         * 
         * Metodo que retorna una lista de las subcaracteristicas, este es llamado a traves de una peticion AJAX
         *                
         * @param     la funcion no recibe paramateros 
         * @return    Un arreglo $result. con la informacion de la subcaracteristicas
         * @version   1.0                 
    */ 

    function listarSubcaracteristicas() {
        //llama al metodo que pertenece al modelo
        $data = $this->Subcaracteristica_model->getSubcaracteristica();  
        if (!$data) { //si el retorno es falso lo devuelve a la vista
            echo json_encode(null);
        } else {
            //Se crea  un arreglo
            $row = array(); 
            foreach ($data as $datos) { //foreach para recorrer la lista de las subcaracteristicas  que retorno el modelo
                //botonos, esto es codigo html
                $id_sub = $datos['id_sub'];
                $btnView = "<button class='btn btn-primary btn-sm' onclick='verSubcaracteristica($id_sub);' data-toogle='tooltip' title='Ver Información Subcaracteristica'><span class='glyphicon glyphicon-search'></span></button>";
                $btnEdit = "<button class='btn btn-warning btn-sm' onclick='actualizarSubcaracteristica($id_sub);' data-toogle='tooltip' title='Actualizar Información Subcaracteristica'><span class='glyphicon glyphicon-pencil'></span></button>";
                $btnDelete = "<button class='btn btn-danger btn-sm' onclick='eliminarSubcaracteristica($id_sub);' data-toogle='tooltip' title='Eliminar Subcaracteristica'><span class='glyphicon glyphicon-trash'></span></button>";
                
                if ($this->session->userdata('tipo')==3 || $this->session->userdata('tipo')==2) {
                    ///empiezo a llenar el arreglo con los datos de la BD para mostrarlos en la vista
                    $row[] = array(                    
                        'nombre' => $datos['nombre'],
                        'descripcion' => $datos['descripcion'],
                        'caracteristica' => $datos['nombre_c'],
                        'accion' => $btnView 
                    );
                }
                else{
                    ///empiezo a llenar el arreglo con los datos de la BD para mostrarlos en la vista
                    $row[] = array(                    
                        'nombre' => $datos['nombre'],
                        'descripcion' => $datos['descripcion'],
                        'caracteristica' => $datos['nombre_c'],
                        'accion' => $btnView . " " . $btnEdit . " " . $btnDelete
                    );
                }
                
                
            }
            $result = array("data" => $row);
            ///retorno el arreglo a la vista
            echo json_encode($result); 
        }
    }

    //Carga desde BD de datos todas las caracteristicas     
    function cargarCaracteristicas(){
        $result = $this->Caracteristicas_model->getCaracteristicas();
        echo json_encode($result);
    }

    /**
         * actualizarSubcaracteristica. 
         * Funcion que es invocada desde la vista subcaracteristica_view.php
         * Actualiza la informacion de una subcaracteristica 
         *                 
         * @param     la funcion no recibe paramateros 
         * @return    true o false
         * @version   1.0                 
    */ 

    function actualizarSubcaracteristica() {

        $nombre = $this->input->post('nombre');
        $descripcion = $this->input->post('descripcion');
        $caracteristica = $this->input->post('caracteristica');
        $id_sub = $this->input->post('id_sub');

        $params['nombre'] = $nombre;
        $params['descripcion'] = $descripcion;
        $params['caracteristica'] = $caracteristica;

        $result = $this->Subcaracteristica_model->actualizarSubcaracteristica($params, $id_sub);
        ///retorno true o false 
        echo json_decode($result);
    }

    /**
         * consultarSubcaracId 
         * Funcion que es invocada desde la vista subcaracteristica_view.php
         * Consulta la informacion de una subcaracteristica. Haciendo uso de la clase
         * Subcaracteristica_model que se encarga de obtener la información. 
         * @param     la funcion no recibe paramateros 
         * @return    La información de la subcaracteristica de acuerdo al $id. False si no coindicide.
         * @version   1.0                 
    */ 

    function consultarSubcaracId() {
        $id = $this->input->post('id_sub');
        $result = $this->Subcaracteristica_model->Subcaracteristica_ID($id);
        echo json_encode($result);
    }

    /**
         * eliminarSubcaracteristica         
         * Se encarga de eliminar un registro de subcaracteristicas            
         * @param     la funcion no recibe paramateros 
         * @return    true o false
         * @version   1.0                 
    */ 

    function eliminarSubcaracteristica() {
        $id_sub = $this->input->post('id_sub');
        $result = $this->Subcaracteristica_model->eliminarSubcaracteristica($id_sub);
        ///retorno true o false 
        echo json_encode($result);
    }


    function listarSubCarateristicas_Id(){
        $id = $this->input->post('id');
        $result = $this->Subcaracteristica_model->ListarSubCaracteristicas($id);
        echo json_encode($result);
    }
}
