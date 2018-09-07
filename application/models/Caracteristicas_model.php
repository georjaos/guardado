<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * esta clase recibe peticiones del controlador CaracteristicasController.
 * realiza las funcionalidades del CRUD de caracteristicas conectandodose con la base de datos
 * y enviando los resultados a la clase controlador.
 */
class Caracteristicas_model extends CI_Model {

    function __construct() {
        parent:: __construct();
    }

    //lista todas las carcateriscas guardadas en la base de datos
    //retornando un arreglo de las caracteristicas al controlador
    function getCaracteristicas() {

        $this->db->select('*');
        $this->db->order_by('nombre','asc');
        $this->db->from('caracteristica');
        $data = $this->db->get();
        if ($data->num_rows() > 0) { //si el numero de filas es mayor a 0
            return $data->result_array(); //retorna un arreglo de tipo proceoss
        } else {
            return false; /// si no hay datos  en la tabla retorna false
        }
    }
    /*
     * funcion que es invocada por el controlador CaracteristicaController, el cual envia los datos de
     * la caracteristica para registrarlos a la base de datos.
     * retornando un resultado de tipo boolean de si los datos fueron registrados.
     */
    function agregarCaracteristica($datos) {
        //llamamos a la consulta de insertar caracteristica
        $this->db->insert('caracteristica', $datos);
        //retorna el resultado
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
    /*
     * funcion que es invocada por el controlador CaracteristicaController, la cual verifica
     * si existe una caracteristica con los datos enviados desde el controlador
     * retornando un resultado de tipo boolean de si esxite una caracteristica con los mismos datos.
     */
    function existe_caracteristica($nombre) {

        $this->db->select('*');
        $this->db->where("nombre", $nombre);
        $this->db->from('caracteristica');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    /*
     * funcion que es invocada por el controlador CaracteristicaController, el cual envia los datos de
     * la caracteristica para actualizarlos a la base de datos.
     * retornando un resultado de tipo boolean de si los datos fueron actualizados.
     */
    function actualizarCaracteristica($data, $id) {//actualizar
        $this->db->where("id", $id);
        $this->db->update('caracteristica', $data);
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
    /*
     * funcion que es invocada desde la clase controlador caracteristica, la cual elimina una caracteristica
     * de la base de datos, recibiendo como parametro el identificador de la caracteristica.
     * retorna un valor de tipo boolean de si los datos fueron eliminados
     */
    function eliminarCaracteristica($id) {
        $this->db->where("id", $id);
        $this->db->delete('caracteristica');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    /*
     * funcion que es invocada desde la clase controlador caracteristica, la cual elimina las subcaracteristicas
     * pertenecientes a la caracteristica alojadas en la base de datos, recibiendo como parametro 
     * el identificador de la caracteristica.
     * retorna un valor de tipo boolean de si los datos fueron eliminados
     */
    function eliminarSubCaracteristica($id_caract) {
        $this->db->where("id_caract", $id_caract);
        $this->db->delete('sub_caracteristica');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    /*
     * funcion que es invocada desde la clase controlador caracteristica, la cual elimina las preguntas
     * pertenecientes a la subcaracteristica alojadas en la base de datos, recibiendo como parametro 
     * el identificador de la subcaracteristica.
     * retorna un valor de tipo boolean de si los datos fueron eliminados
     */
    function eliminarPreguntas($id_caract) {
        $this->db->where("id_sub_caracteristica", $id_caract);
        $this->db->delete('preguntas');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    /*
     * funcion que es invocada por el controlador CaracteristicaController.
     * retorna un arreglo de las caracteristicas registradas en la base de datos
     */
    function getCaract() {
        $this->db->order_by("nombre", "asc");
        $data = $this->db->get("caracteristica"); //nombre de la tabla en la base de datos
        if ($data->num_rows() > 0) { //si el numero de filas es mayor a 0
            return $data->result_array(); //retorna un arreglo de caracteristicas
        } else {
            return false; /// si no hay datos  en la tabla retorna false
        }
    }

}
