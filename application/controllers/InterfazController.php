<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * Esta clase recibe las peticiones desde las vistas interfaz y procesos, la cual invoca a 
 * los metodos la clase Interfaz_model realizando diferentes consultas en la base de datos (CRUD),
 * para finalmente mostrar los datos retornados a las vistas. 
 * Autor: Kristein Johan Ordoñez
 * Fecha: 2018-06-10
 */
class InterfazController extends CI_Controller {

//constructor por defecto

    /**
     * Constructir donde se carga todas las librerias del framework que usaremos
     * Tambien carga los modelos  procesos e interfaces para usarlos al consultar datos
     */
    function __construct() {

        parent::__construct();
        //Invocamos a la clase Interfaz_model y Proceso_model para poder hacer uso de sus metodos
        $this->load->model('Interfaz_model');   
        $this->load->model('Proceso_model');
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
=======
    /**
     * Cargamos la vista principal de las interfaces de los procesos si el usuario esta logueado,
     * de lo contrario redirigimos al index(login)
>>>>>>> dev
     */
    function index() {//funcion que carga la vista
        //si el usuario ha iniciado session, se cargan sus datos en un arreglo para ser mostrados en la vista
        if ($this->session->userdata('login')) {
            $login["username"]=$this->session->userdata('username'); //llenamos el objeto 'sesion' con los datos del usuario que ha iniciado
            $login["tipo"]=$this->session->userdata('tipo');         //sesion
            $login["nombre"]=$this->session->userdata('nombre');
            $login["apellido"]=$this->session->userdata('apellido');
            $login["email"]=$this->session->userdata('email');
            $login["login"]=$this->session->userdata('login');
            //llamamos a la vista de interfaces           
            $this->load->view('interfaces_view',$login);
        } else {
            //redireccionamos a la vista login cuando no ha iniciado sesion
            $this->load->view('login');
        }
    }

    /**
     * con esta funcion capturramos los datos de la interfaz de proceso que nos llegan por medio de una peticion AJAX
     * de tipo POST y por medio del modelo 'Interfaz_model' los insertamos en la BD
     */
    function insertarInterfaz() {
        
        // se obtiene los valores de las variables que bienen por post

        $nombre = $this->input->post('nombre');
        $desc = $this->input->post('descripcion');
        $tipo = $this->input->post('tipo');
        $detalleTipo = $this->input->post('detalleT');
        $preoceso = $this->input->post('proceso');
        //se guardan en un array esas variables
        $params['nombre'] = $nombre;
        $params['descripcion'] = $desc;
        $params['tipo'] = $tipo;
        $params['detalle_tipo'] = $detalleTipo;
        $params['proceso'] = $preoceso;

        /*
         * invoca al metodo de agregar interfaz que esta en la clase modelo, para guardar la informacion en la base de datos
         */
        // se invova al modelo para hacer la insercion de los datos en laBD
        $result = $this->Interfaz_model->agregarInterfaz($params);
        
        echo json_encode($result); //Comentar para la prueba unitaria
        //return json_encode($result); 
    }
    /**
     * metodo que es invocado desde la vista Interfaces, el cual llama a la clase Interfaz_model
     * retornando una lista de las interfaces que se encuentran registradas por cada proceso. 
     * Este metodo es invocado a traves de una peticion AJAX
     */
    public function listarInterfaces(){

        $data= $this->Interfaz_model->getInterfaz();

        if(!$data){
            echo json_encode(null);
        }
        else{
            $row= array();
            foreach($data as $datos){//foreach para recorrer la lista de los procesos que retorno el modelo
                    //botones, esto es codigo html
                    //codigo html dinamico
                $idInterfaz= $datos['id'];
                $btnView = "<button class = 'btn btn-primary btn-sm' onclick='verInterfaz($idInterfaz);'><span class ='glyphicon glyphicon-search'></span></button>";
                $btnEdit = "<button class = 'btn btn-warning btn-sm' onclick='actualizarInterfaz($idInterfaz);'><span class ='glyphicon glyphicon-pencil'></span></button>";
                $btnDelete = "<button class = 'btn btn-danger btn-sm' onclick='eliminarinterfaz($idInterfaz);'><span class ='glyphicon glyphicon-trash'></span></button>";
                
                if($datos['tipo']==1){
                    $tipo="Automatica";
                }
                if($datos['tipo']==2){
                    $tipo="Semiautomatica";
                }
                if($datos['tipo']==3){
                    $tipo="Manual";
                }
                if ($this->session->userdata('tipo')==3) {
                    $row[] = array(                    
                        'nombre' => $datos['nombre'],
                        'descripcion' => $datos['descripcion'],
                        'tipo' => $tipo,
                        'detalleTipo' => $datos['detalle_tipo'],
                        'proceso' => strtoupper($datos['proceso']),
                        'accion' => $btnView 
                    );
                }
                else{
                    $row[] = array(                    
                        'nombre' => $datos['nombre'],
                        'descripcion' => $datos['descripcion'],
                        'tipo' => $tipo,
                        'detalleTipo' => $datos['detalle_tipo'],
                        'proceso' => strtoupper($datos['proceso']),
                        'accion' => $btnView . " " . $btnEdit . " " . $btnDelete
                    );
                }
                
            }
            $result = array("data" => $row);
            echo json_encode($result);
        }
    }
    /**
     * funcion que lista todos los procesos registrados utilizando la clase Proceso_model
     * y retorna un JSON con todos los procesos registrados
     */
    function listaProcesos() {
        $result = $this->Proceso_model->getProces();
        echo json_encode($result);
    }

    /**
     * Esta funcion es invocada por medio de AJAX y es tipo post para listar todas las interfaces que perteneces a 
     * un deteerminado proceso.
     * Consultamos todas las interfaces relacionadas con el proceso por medio del parametro 'id_pro' que trae la peticion post
     * y retornamos un JSON con las interfaces que estan asociadas a ese proceso especifico

     */
    function listarInterfazProceso(){
        //parametro de entrada, enviado desde la vista por medio de AJAX
         $id = $this->input->post('id_pro');
         //invoca al metodo en la clase modelo que retorna la informacion del proceso
         $result = $this->Interfaz_model->getInterfaz_Proceso($id);
         //envia el resultado del proceso a la vista
         echo json_encode($result);
    }
    
    /**
     * Con esta funcion consultamos los datos de uan interfaz determinada, es invocada desde la vista de interfaces
     * y recive el id de la interfaz que lo trae la peticion post por medio de AJAX utilizamos la clase Interfaz_model(modelo)
     * para consultar los datod de esa interfaz y retornamos esos datos en un  JSON
     */
    function consultarInterfazId(){
         $id = $this->input->post('id');
         $result = $this->Interfaz_model->interfaz_Id($id);
         echo json_encode($result);
    }   
    
    function consultarInterfazIDint(){
         $id = $this->input->post('id');
         $result = $this->Interfaz_model->interfaz_Idint($id);
         echo json_encode($result);
    }

    /**
     * PAra eliminar la interfaz recibimos por post el id de la interfaz a eliminar, usamos la clase Interfaz_model 
     * y eliminamos la interfaz, retornamos TRUE si la elimino o FALSE si no pudo eliminarla por cualquier motivo por medio de un JSON
     */
    function eliminarInterface() {
        //parametro de entrada enviado desde la vista por medio de AJAX
        $id = $this->input->post('id');
        if (is_numeric($id)) {
            //invoca al metodo de la clase modelo, el cual elimina una interfaz de la base de datps
            $result = $this->Interfaz_model->eliminarInterfaz($id);
            //envia el ressultado a la base de datos    
            echo json_encode($result);
        }
    }
    /**
     * para actualizar una interfaz recibimos los nuevos datos por peticion post y AJAX que son llenados desde la vista de 'interfacces'
     * y haciendo uso de la clase Interfaz_model actualizamos esa interfaz con su id retornando TRUE si fueexitoso o FALSE si no se pudo actualizar
     */
    function actualizarInterfaz(){
        
        $nombre = $this->input->post('nombre');
        $descripcion = $this->input->post('descripcion');
        $tipo = $this->input->post('tipo');
        $detalle_tipo = $this->input->post('detalleTipo');
        $proceso = $this->input->post('proceso');
        $id_int = $this->input->post('id_int');

        $params['nombre'] = $nombre;
        $params['descripcion'] = $descripcion;
        $params['tipo'] = $tipo;
        $params['detalle_tipo'] = $detalle_tipo;
        $params['proceso'] = $proceso;

        $result = $this->Interfaz_model->actualizarInterfaz($params, $id_int);
        echo json_encode($result);
    }
    
   // PREUEBAS UNITARIAS
    
    //Prueba unitaria insertar una interfaz
    function pruebaInsertarInterfaz() {     // ---> prueba unitaria de la funcion Insertar interfaz 
        $test = $this->insertarInterfaz();  //el metodo post para prueba esta en el archio interface.js en el la funcion para insertar interfaaz
        $expected_result = "true";
        $test_name = 'comprobar si inserta o no una interfaz en la BD';
        $this->unit->run($test, $expected_result, $test_name);
        echo $this->unit->report();
    }
    
    function listarTipo_Interfaz(){
         $result = $this->Interfaz_model->getTipo_Interfaz();
         echo json_encode($result);
    }
}
