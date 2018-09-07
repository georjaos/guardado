<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Esta clase ProcesoController extiende de la clase CI_controller, 
 * es una clase que responde a eventos de la vista procesos_view.php y que invoca a los metodos de la clase
 * Proceso_model, la cual realiza el CRUD de los Procesos, para finalmente mostrar los datos retornados
 * a la vista procesos_view.
 * Autor: Kristein Johan Ordoñez
 * Fecha: 2018-06-13 
 */

class ProcesoController extends CI_Controller {

    //creamos el constructor de la clase
    function __construct() {
        parent::__construct();
        //Invocamos a la clase Proceso_model para poder hacer uso de sus metodos
        $this->load->model('Proceso_model');

        //Invocamos a la clase Normativa_model para poder hacer uso de sus metodos
        $this->load->model('Normativa_model');

        //Invocamos a la clase Rol_model para poder hacer uso de sus metodos
        $this->load->model('Rol_model');

        //Invocamos a la clase Paralelo_model para poder hacer uso de sus metodos
        $this->load->model('Paralelo_model');
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
        /*
         * condicional que verifica si el usuario que desea ingresar a la vista proceso 
         * a iniciado sesion
         */
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

            //llama a la vista proceso y le pasamos como parametro el arreglo.
            $this->load->view('procesos_view', $login);

            //si el usuario no ha iniciado sesion, entra por este camino y se le redirecciona a la vista del inicio de sesion
        } else {
            //llama a la vista login de inicio de sesion
            $this->load->view('login');
        }
    }
    /*
     * funcion que carga las vista de secuenciar procesos
     */
    function secuencia() {//funcion que carga la vista
        if ($this->session->userdata('login')) {
            $login["username"] = $this->session->userdata('username');
            $login["tipo"] = $this->session->userdata('tipo');
            $login["nombre"] = $this->session->userdata('nombre');
            $login["apellido"] = $this->session->userdata('apellido');
            $login["email"] = $this->session->userdata('email');
            $login["login"] = $this->session->userdata('login');

            $this->load->view('secuenciaDeProcesos_view', $login);
        } else {
            $this->load->view('login');
        }
        //$this->load->view('secuenciaDeProcesos_view');
        //$this->pruebaListarProcesosSecuencia(); //---> llamamos a la prueba unitaria de la funcion secuenciar procesos (el metodo mas importante "listar los procesos")
    }

    /*
     * metodo que es invocado desde la vista procesos, el cual llama a la clase Proceso_model
     * retornando una lista de los procesos que se encuntran secuenciados y en paralelo. 
     * Este metodo es invocado a traves de una peticion AJAX
     */

    public function listarProcesos() {

        /*
         * parametro de entrada, que es usado para recibir una peticion de AJAX por medio de POST
         * el cual nos sirve para obtener los procesos que son paralelos
         */
        $paralelos = $this->input->post('paralelos');

        /*
         * llamamos al metodo de la clase Proceso_model, el cual devuel un arreglo de los procesos
         * consultados en la base de datos y lo asigna a la variable data.
         */
        $data = $this->Proceso_model->getProcesos();

        //si el vallor asignado a la variable data es FALSE, es porque la consulta no devolvio degistros de la base de datos
        if (!$data) {
            //retornamos null codifiado como JSON para que pueda ser leido en la vista proceso
            echo json_encode(null);
        } else {

            if ($paralelos) {
                $row = array(); //creamos un arreglo para asignar los valores del proceso
                //mediante el foreach recorremos el arreglo de datos que fueron traidos desde la clase modelo
                foreach ($data as $datos) {

                    $id_pro = $datos['idproceso'];
                    //codigo html paraser mostrado de forma dinamica en la vista
                    $btnUp = "<button class='btn btn-success btn-sm' onclick='subirProceso($id_pro)'><span class='glyphicon glyphicon-menu-up'></span></button>";

                    $prioridad = "";
                    if ($datos['prioridad'] == 1) {
                        $prioridad = "ALTA";
                    }
                    if ($datos['prioridad'] == 2) {
                        $prioridad = "MEDIA";
                    }
                    if ($datos['prioridad'] == 3) {
                        $prioridad = "BAJA";
                    }

                    //llenamos el arreglo con los datos procesados 
                    $row[] = array(
                        //'id' => $datos['idproceso'],
                        'nombre' => $datos['nombre'],
                        'desc' => $datos['descripcion'],
                        'prioridad' => $prioridad,
                        'accion' => $btnUp
                    );
                }
                $result = array("data" => $row);
                //retornamos el arreglo y lo codificamos mediante JSON para finalmente ser enviado a la vista proceso
                echo json_encode($result);
            } else {
                $row = array();

                foreach ($data as $datos) { //foreach para recorrer la lista de los procesos que retorno el modelo
                    //botonos, esto es codigo html
                    //codigo html dinamico
                    $id_pro = $datos['idproceso'];
                    $btnView = "<button class='btn btn-primary btn-sm' onclick='verProceso($id_pro);'data-toggle='tooltip' title='Ver Información del proceso(Normativas,Interfaces)'><span class='glyphicon glyphicon-search'></span></button>";
                    $btnEdit = "<button class='btn btn-warning btn-sm' onclick='actualizarProceso($id_pro);' data-toggle='tooltip' data-placement='top' title='Edita información del proceso'><span class='glyphicon glyphicon-pencil'></span></button>";
                    $btnDelete = "<button class='btn btn-danger btn-sm' onclick='eliminar($id_pro);'data-toggle='tooltip' title='Elimina Información del proceso'><span class='glyphicon glyphicon-trash'></span></button>";
                    $btnNormativa = "<button class='btn btn-success btn-sm' onclick='agregarNormativa($id_pro);' data-toggle='tooltip' title='Agregar Normativa(s) al proceso'><span class='glyphicon glyphicon-list-alt'></span></button>";
                    $btnInterfaz = "<button class='btn btn-info btn-sm' onclick='agregarInterfaz($id_pro);' data-toggle='tooltip' title='Agrega Interfaz(es) al proceso'><span class='glyphicon glyphicon-random'></span></button>";

                    $btnRNF = "<button class='btn btn-default btn-xs' onclick='ir_rnf(" . $id_pro . ")' data-toggle='tooltip' title='Definir RNF'>RNF</button>";

                    $prioridad = "";
                    if ($datos['prioridad'] == 1) {
                        $prioridad = "ALTA";
                    }
                    if ($datos['prioridad'] == 2) {
                        $prioridad = "MEDIA";
                    }
                    if ($datos['prioridad'] == 3) {
                        $prioridad = "BAJA";
                    }

                    //validamos si el usuario tiene permisos, para mostrar ciertos datos en la vista
                    if ($this->session->userdata('tipo') == 3) {

                        //llenamos el arreglo con los datos procesados 
                        $row[] = array(
                            //'id' => $datos['idproceso'],
                            'nombre' => $datos['nombre'],
                            'desc' => $datos['descripcion'],
                            'prioridad' => $prioridad,
                            'secuencia' => $datos['orden_secuencia'],
                            'role' => strtoupper($datos['rol']),
                            'accion' => $btnView . " " . $btnRNF
                        );
                    } else {
                        //llenamos el arreglo con los datos procesados 
                        $row[] = array(
                            //'id' => $datos['idproceso'],
                            'nombre' => $datos['nombre'],
                            'desc' => $datos['descripcion'],
                            'prioridad' => $prioridad,
                            'secuencia' => $datos['orden_secuencia'],
                            'role' => strtoupper($datos['rol']),
                            'accion' => $btnView . " " . $btnEdit . " " . $btnDelete . " " . $btnNormativa . " " . $btnInterfaz . " " . $btnRNF
                        );
                    }
                }
                $result = array("data" => $row);
                echo json_encode($result); ///retorno el arreglo coficiaco como JSON a la vista 
            }
        }
    }

    /*
     * metodo que es invocado desde la vista procesos, el cual llama a la clase Proceso_model
     * retornando una lista de los procesos que se encuentran en paralelo. 
     * Este metodo es invocado a traves de una peticion AJAX
     */

    function listarProcesosParalelos() {

        //parametro de entrada con el identificador de los procesos
        $proceso = $this->input->post('proceso');

        /*
         * invoamos al metodo en la clase modelo, el cual le pasamos como parametro de entrada el identificador
         * del proceso para posteriormete devolver un arreglo con los procesos
         */
        $data = $this->Paralelo_model->getProcesosParalelos($proceso);
        //si el valor retornado es FALSE envia a la vista null
        if (!$data) {
            echo json_encode(null);
        } else {

            $row = array(); //creo un arreglo
            //foreach para recorrer la lista de los procesos que fueron retornados de la clase modelo
            foreach ($data as $datos) {

                //botones, codigo codigo html
                $id_pro = $datos['proceso'];
                $btnUp = "<button class='btn btn-danger btn-sm' onclick='bajarProceso($id_pro);'><span class='glyphicon glyphicon-chevron-down'></span></button>";


                ///empiezo a llenar el arreglo con los datos de la BD para mostrarlos en la vista
                $prioridad = "";
                if ($datos['prioridad'] == 1) {
                    $prioridad = "ALTA";
                }
                if ($datos['prioridad'] == 2) {
                    $prioridad = "MEDIA";
                }
                if ($datos['prioridad'] == 3) {
                    $prioridad = "BAJA";
                }
                //guardo los datos procesados en un arreglo
                $row[] = array(
                    //'id' => $datos['idproceso'],
                    'nombre' => $datos['nombre'],
                    'desc' => $datos['descripcion'],
                    'prioridad' => $prioridad,
                    'accion' => $btnUp
                );
            }
            $result = array("data" => $row);
            echo json_encode($result); ///retorno el arreglo codificado como JSON a la vista proceso
        }
    }

    /*
     * metodo que invocado desde la vista proceso, el cual establece un proceso como paraleo a otro proceso 
     * mediante sus identificadores insertantdolos en la base de datos, devolviendo como resultado una bandera
     * booleana
     */

    function establecerParalelo() {

        //parametros de entrada desde la vista por medio de peticiones AJAX de tipo POST
        $proceso = $this->input->post('proceso');
        $paralelo = $this->input->post('paralelo');

        //se crea un arreglo con los nombres de las columnas de la tabla proceso para luego ser agregados a la base de datos.
        $params['proceso'] = $proceso;
        $params ['paralelo'] = $paralelo;

        /*
         * invoca al metodo de insertar que esta en la clase modelo, al cual le pasamos como parametro el arreglo
         * de los campos de la base de datos con sus valores.
         * posteriormente el resultado se asigna a la variable result
         */
        $result = $this->Paralelo_model->insertar($params);

        //resultado de la consulta que fue procesado y codificado como JSON para ser enviado a la vista
        echo json_encode($result);
    }

    /*
     * metodo invocado desde la vista proceso el cual hace ina peticion al modelo para registar los datos en la base de datos
     * y porsteriormente enviar una bandera booleana de si los datos fueron registrados. 
     */

    function registrarProceso() {

        //parametros de entrada desde la vista por medio de peticiones AJAX de tipo POST
        $nombre = $this->input->post('nombre');
        $desc = $this->input->post('descripcion');
        $priodidad = $this->input->post('prioridad');
        $role = $this->input->post('role');
        $secuencia = $this->input->post('secuencia');

        //se crea un arreglo con los nombres de las columnas de la tabla proceso para luego ser agregados a la base de datos.
        $params['nombre'] = $nombre;
        $params['descripcion'] = $desc;
        $params['prioridad'] = $priodidad;
        $params['orden_secuencia'] = $secuencia;
        $params['id_role'] = $role;

        //verificamos si existe un proceso con las mismas caracteristicas
        $existe = $this->Proceso_model->existe_proceso($nombre, $desc);
        //si existe devolvemos un valor codificado como JSON a la vista, de lo contratio continuamos con el proceso de registrar
        if ($existe) {
            echo json_encode("exist");
        } else {

            //invoca al metodo de la clase modelo, el cual inserta un nuevo registro a la base de datos
            $result = $this->Proceso_model->registrarProceso($params);
            //restorna el resultado a la vista.
            echo json_encode($result);
        }
    }

    /*
     * metodo que es invocado desde la vista procesos, el cual recibe como parametros datos del proceso
     * que son enviados al modelo para posteriormente ser actualizados en la base de datos. 
     * finalmente enviar una bandera booleana si el proceso fue actualizado o no.
     */

    function actualizarProceso() {

        //parametros de entrada desde la vista por medio de peticiones AJAX de tipo POST
        $nombre = $this->input->post('nombre');
        $desc = $this->input->post('descripcion');
        $priodidad = $this->input->post('prioridad');
        $role = $this->input->post('role');
        $id_pro = $this->input->post('id_pro');

        //se crea un arreglo con los nombres de las columnas de la tabla proceso para luego ser agregados a la base de datos.
        $params['nombre'] = $nombre;
        $params['descripcion'] = $desc;
        $params['prioridad'] = $priodidad;
        $params['id_role'] = $role;
        //invoca al metodo de la clase modelo, el cual actualiza los registros de un proceso en la base de datos
        $result = $this->Proceso_model->actualizarProceso($params, $id_pro);
        //restorna el resultado a la vista.
        echo json_encode($result);
    }

    /*
     * metodo que es invocado desde la vista procesos y que sirve para consular en la clase Proceso_model 
     * la informacion de un proceso y que retornna la informacion del proceso.
     */

    function consultarProcesoId() {
        //parametros de entrada desde la vista por medio de peticiones AJAX de tipo POST
        $id = $this->input->post('id_pro');

        //invoca al metodo de la clase modelo, el cual consulta los registros de un proceso en la base de datos y los retorna en un arreglo
        $result = $this->Proceso_model->proceso_Id($id);
        //restorna el resultado a la vista.
        echo json_encode($result);
    }

    /*
     * metodo que es invocado desde la vista procesos y la vista roles, el cual que sirve 
     * para consular todos los roles de los procesos registrados en la base de datos
     */

    function listaRoles() {
        //invoca al metodo de la clase Rol_model, el cual consulta los registros de un rol en la base de datos y los retorna en un arreglo
        $result = $this->Rol_model->getRole();
        //restorna el resultado a la vista.
        echo json_encode($result);
    }

    /*
     * metodo que es invocado desde la vista secuenciar_procesos, el cual 
     * hace una invocacion al metodo de la clase Proceso_model, el cual retorna un arreglo de los procesos secuenciados
     */

    function listaProcesosSecuencia() {
        //invoca al metodo de la clase Proceso_model, el cual consulta los registros de un los procesos en la base de datos y los retorna en un arreglo
        $result = $this->Proceso_model->getProcesosS();
        //restorna el resultado a la vista.
        echo json_encode($result);
        // return json_encode($result);// descomentar para la prueba
    }

    /*
     * metodo que realiza la prueba unitaria de listar los procesos secuenciados
     */

    function pruebaListarProcesosSecuencia() { // ---> prueba unitaria de la funcion secuenciar procesos (el metoso mas importante "listar los procesos")
        //llamamos al metodo que lista los procesos secuencias
        $test = $this->listaProcesosSecuencia();
        //si el valor resultante es una cadena de texto
        $expected_result = 'is_string';
        $test_name = 'comprobar si trae los procesos desde la base de datos';
        $this->unit->run($test, $expected_result, $test_name);
        //retorna el resultado de la prueba
        echo $this->unit->report();
    }

    /*
     * funcion que es invocada desde la vista y que recibe como parametro el identificador del proceso
     * que finalmente es enviado a la clase Proceso_model para finalmente borrar el registro en la base de datos
     * y retornando una bandera booleana de si el registro fue eliminado.
     */

    function eliminarProceso() {
        //parametros de entrada desde la vista por medio de peticiones AJAX de tipo POST
        $id_pro = $this->input->post('id_pro');
        if (is_numeric($id_pro)) {
            //invoca al metododo de la clase modelo en la base de datos que elimina el registro y el resultado lo asigna el la variable result.
            $result = $this->Proceso_model->eliminarProceso($id_pro);
            //retorna el resultado a la vista para informarle al usuario
            echo json_encode($result);
        }
    }
    /*
     * funcion que es invocada desde el proceso y que recibe como parametro un arreglo desde la vista, el cual se rrecorre
     * mediate un ciclo foreach y va actualizando los valores de la secuencia de cada proceso en la base de datos retornando
     * como resultado un valor de tipo boolean.
     * 
     */
    function actualizarSecuencia() {
        $data = $_POST['proceso_id_array'];
        $i = 0;
        foreach ($data as $dato) {

            $i++;
            //guardo en el arreglo el nombre de la columna de la tabla procesos y el valor a actualizar
            $params['orden_secuencia'] = $i;
            //invoco al metodo de la clase modelo y que actualiza el proceso, el cual retorna un resultado
            $result = $this->Proceso_model->actualizarProceso($params, $dato);
            //el resultado es enviado a la vista de secuenciar procesos.
            echo json_encode($result);
        }
    }

}
