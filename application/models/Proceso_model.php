    <?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * esta clase manipula la peticiones que hace el controlador que extiende de la clase CI_Model.
 * ademas interactua con la base de datos enviando y recibiendo informacion del controlador.
 * Autor: Kristein Johan Ordoñez
 * Fecha: 2018-06-13 
 */
class Proceso_model extends CI_Model {

    function __construct() { ///funcion por defecto
        parent:: __construct(); 
    }
    /*
     * funcion que es invocada desde el controlador, la cual no tiene parametros de entrada pero si retorna un arreglo de
     * los procesos, siempre y cuando hayan datos, si no retorna FALSE.
     */
    function getProcesos() {
        //creamos la consulta, utilizamos los metodos que nos ofrece el framework para interatuar de manera mas facil con la base de datos 
        $this->db->select('P.nombre, P.descripcion, P.prioridad, P.orden_secuencia, P.idproceso, R.nombre rol');
        $this->db->from('proceso P');
        $this->db->join('role R','P.id_role = R.idrole');
        $data=$this->db->get();

        if ($data->num_rows() > 0) { //si el numero de filas es mayor a 0
            return $data->result_array(); //retorna un arreglo de tipo proceoss
        } else {
            return false; /// si no hay datos  en la tabla retorna false
        }
    }
    
    /*
     * funcion que es invocada desde el controlador, la cual no tiene parametros de entrada pero si retorna un arreglo de
     * los procesos secuanciados, siempre y cuando hayan datos, si no retorna FALSE.
     */
    function getProcesosS() { //Lista los procesos ordenados para la secuenciasion
        
        //creamos la consulta, utilizamos los metodos que nos ofrece el framework para interatuar de manera mas facil con la base de datos 
        $this->db->from("proceso");
        $this->db->order_by("orden_secuencia", "asc");
        $data = $this->db->get(); //nombre de la tabla en la base de datos
        if ($data->num_rows() > 0) { //si el numero de filas es mayor a 0
            return $data->result_array(); //retorna un arreglo de tipo proceoss
        } else {
            return false; /// si no hay datos  en la tabla retorna false
        }
    }
    
    /*
     * funcion que es invocada desde el controlador, la cual no tiene parametros de entrada pero si retorna al controlador 
     * un arreglo de los procesos ordenados.
     */
    function getProces() {
        
        //creamos la consulta a traves de los metodos del framework
        $this->db->order_by("nombre", "asc");
        $data = $this->db->get("proceso"); //nombre de la tabla en la base de datos
        if ($data->num_rows() > 0) { //si el numero de filas es mayor a 0
            return $data->result_array(); //retorna un arreglo de tipo roles
        } else {
            return false; /// si no hay datos  en la tabla retorna false
        }
    }
    
    /*
     * funcion que es invocada desde el controlador, la cual recibe como parametro de entrada un arreglo con los datos 
     * del proceso para ser agregados a la base de datos y retornando como resultado una bandera de tipo boolean.
     */
    function registrarProceso($data) {
        /*
         * llamaos a la funcion insert a traves del metodo que pertenece al framwork y le pasamos como valores el nombre 
         * de la tabla en la base de datos y los valores a registrar
         */
        $this->db->insert('proceso', $data);
        if ($this->db->affected_rows()) { //si hay registros nuevos devuelve verdadero
            return true; //retorna al controlador la bandera
        } else {
            return false; //si no hizo la insercion, devuelve false al controlador
        }
    }
    
    /*
     * funcion que es invocada desde el controlador, la cual recibe como parametro de entrada el id del proceso 
     * el cual sirve para consultar los datos pertenecientes al proceso en la base de datos y retornando al controlador
     * el arreglo de los datos del proceso.
     */
    function proceso_Id($id_pro) {
        //creamos la consulta y hacemor un inner join con la tabla role para obtener la informacion perteneciente al proceso
        $this->db->select('P.nombre, P.descripcion, P.prioridad, P.orden_secuencia, P.idproceso, R.nombre rol, P.id_role');
        $this->db->where("idproceso", $id_pro);
        $this->db->from('proceso P');
        $this->db->join('role R','P.id_role = R.idrole');
        $data = $this->db->get();
        //si hay valores que mostrar
        if ($data->num_rows() > 0) {
            //retornamos al controlador los datos del proceso en un arreglo con una sola fila
            return $data->row(); 
        } else {
            //si no hay informacion, retornamos al controlador el valor de false.
            return false;
        }
    }
    
    /*
     * funcion que es invocada desde el controlador, la cual recibe como parametro de entrada un arreglo con los datos 
     * del proceso para ser actualizados a la base de datos y retornando como resultado una bandera de tipo boolean.
     */
    function actualizarProceso($data, $id) {
        
        /* 
         * creamos la consulta y le pasamos como parametros de entrada el nombre del campo 
         * por el cual se desea actualizar y los datos que quermos actualizar enviados desde el controlador
         */
        $this->db->where("idproceso", $id);
        $this->db->update('proceso', $data);
       
        if ($this->db->affected_rows()) { //si realizo la actualizacion de forma correcta, retorna verdadero al controlador
            return true;
        } else {
            //si no se actualizaron los datos, retorna falso al controlador
            return false;
        }
    }
    /*
     * funcion que es invocada desde el controlador, la cual recibe como parametro de entrada el id del proceso
     * del proceso al cual queremos eliminar de la base de datos y retornamos como resultado una bandera de 
     * tipo boolean si el proceso fue eliminado o no.
     */
    function eliminarProceso($id_proceso){
        
        //creamos la consulta y le pasamos como parametro el valor de la columna por el cual queremos eliminar el registro
        //en este caso el identificador del proceso y su respectivo valor
        $this->db->where("idproceso", $id_proceso);
        $this->db->delete('proceso'); //llamamos la consulta
       if ($this->db->affected_rows()) {//si el proceso fue eliminado            
            return true; //retorna verdadero al controlador
        } else {
            return false; //si no fue eliminado, retorna falso al controlador
        }
    }
    
    /*
     * funcion que es invocada desde el controlador, el cual recibe como parametro de entrala el nomdre y la descripcion
     * del proceso para buscarla en la base de datos y saber si existe esta informacion, retornando como resultado 
     * una bandera de tipo boolean.
     */
    function existe_proceso($nombre, $descrip) {
        //creamos la consulta de busqueda de los valores, pasandole como parametros las columnas por las cuales queremos buscar
        //y su respectivo valor a buscar.
        $this->db->select('*');
        $this->db->where("nombre", $nombre);
        $this->db->where("descripcion", $descrip);
        $this->db->from('proceso'); //llamos la consulta a la base de datos
        $data = $this->db->get();
        if ($data->num_rows() > 0) {//si hay valores, retornamos verdadero al controlador
            return true;
        } else {
            return false; //si no hay datos, retornamos falso al controlador.
        }
    } 
}
