<?php

/*
 * esta clase recibe peticiones del controlador DefinirRNFController.
 * realiza las funcionalidades del CRUD de las respuestas conectandodose con la base de datos
 * y enviando los resultados a la clase controlador.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class RNF_model extends CI_Model {

    function __construct() { ///funcion por defecto
        parent:: __construct();
    }
    /*
     * funcion invocada desde el controlador DefinirRNFController la cual recibe comoparametros
     * el arrgelo de los datos a intertar en la base de datos
     * retorna una bandera de tipo boolean de si los datos fueron registrados.
     */
    function guardarRespuesta($datos) {
        $this->db->insert('respuesta', $datos);
        if ($this->db->affected_rows()) {
            return true; //los datos fueron registrados
        } else {
            return false;//los datos no fueron registrados
        }
    }
    
    /*
     * funcion que es invocada desde el controlador DefinirRNFController la cual recibe los 
     * parametros de busqueda para retornar un arreglo al controlador con los datos de la consulta.
     */
    function getRespuestaProceso($id_preg, $id_proc) {

        $this->db->select('*');
        $this->db->where("id_pregunta", $id_preg);
        $this->db->where("id_proceso", $id_proc);
        $this->db->from('respuesta');
        $data = $this->db->get();
        if ($data->num_rows() > 0) { //si el numero de filas es mayor a 0
            return $data->row(); //retorna la fila
        } else {
            return false; /// no hay datos, no existe
        }
    }
    /*
     * funcion que es invocada desde el controlador DefinirRNFController yq ue recibe los parametros 
     * de busqueda para verificar si existe una respuesta a un proceso asociado.
     * retorna una bandera de tipo boolean de si esixten los datos en la base de datos.
     */
    function existeRespuestaProceso($id_preg, $id_proc) {

        $this->db->select('id');
        $this->db->where("id_pregunta", $id_preg);
        $this->db->where("id_proceso", $id_proc);
        $this->db->from('respuesta');
        $data = $this->db->get();
        if ($data->num_rows() > 0) { //si el numero de filas es mayor a 0
            return true; //si existe
        } else {
            return false; /// no hay datos, no existe
        }
    }

    /*
     * funcion que es invocada desde la clase DefinirRNFController la cual recibe los parametros de entrada
     * de una respuesta para poder actualizar estos datos en la base de datos
     * retorna una variable de tipo boolean de si los datos fueron actualizados.
     */
    function actualizarRespuestaProceso($data, $id_preg, $id_proc) {//actualizar
        $this->db->where("id_pregunta", $id_preg);
        $this->db->where("id_proceso", $id_proc);
        $this->db->update('respuesta', $data);
        if ($this->db->affected_rows()) {
            return true;//retorna el reusltado
        } else {
            return false;//retorna el reusltado
        }
    }
    
    /*
     * funcion que es invocada desde la clase DefinirRNFController la cual recibe los parametros de entrada
     * de una respuesta para poder eliminarala de la base de datos.
     * retorna una variable de tipo boolean de si los datos fueron eliminados.
     */
    function eliminarRespuestaProceso($id_preg, $id_proc) {
        $this->db->where("id_pregunta", $id_preg);
        $this->db->where("id_proceso", $id_proc);
        $this->db->delete('respuesta');
        if ($this->db->affected_rows() > 0) {
            return true;//retorna el reusltado
        } else {
            return false; //retorna el reusltado
        }
    }

}
