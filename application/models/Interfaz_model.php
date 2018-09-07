<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * esta clase recibe peticiones del controlador InterfazController.
 * realiza las funcionalidades del CRUD de interfaces conectandodose con la base de datos
 * y enviando los resultados a la clase controlador.
 */
class Interfaz_model extends CI_Model {

    function __construct() { ///funcion por defecto, NO QUITAR
        parent:: __construct();
    }

    /*
     * funcion invocada desde el controlador la cual recibe como entrada un arreglo
     * de los datos para registarlos en la base datos
     * retorna un resultado de tipo boolean de si los datos fueron insertados
=======
    
    /**
     * esta funcion es llamada desde el controlador 'InterfazController' para insetar un nuevo registro de una interfaz
     * @param type $datos : array que contiene los datos de la interfaz que se va a insertar en al bd
     * @return : retorna true si la inserta exitosamente y false si no pudo insertar el registro(inetrfaz)

     */
    function agregarInterfaz($datos){
        $this->db->insert('interfaz', $datos);
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * funcion que consulta todas las interdaces de la base de datos esta funcion es llamada desde el controlador 'InterfazController'
     * @return : $data que es un array de datos donde estan todas las interfaces que hay en la BD asociados a sus respectivos
     * procesos ó retorna false si no hay ninguna interfaz registrada
     */
    function getInterfaz(){
        $this->db->select('I.nombre,I.descripcion,I.tipo,I.detalle_tipo,P.nombre proceso,I.id');
        $this->db->from('interfaz I');
        $this->db->join('proceso P','I.proceso = P.idproceso');
        $data=$this->db->get();

        if($data->num_rows()>0){
            return $data->result_array();
        }else{
            return false;
        }
    }
    /**
     * funcion para consultar las interfaces asociadas a un determinadao proceso , esta funcion es llamada desde el controlados 'InterfazController'
     * @param type $id : es el id del oproceso al cual se le quieren consultar sus interfaces 
     * @return : un array con las interfaces que tiene el proceso vinculadas o retora false si no hay interfaces registradaas para el proceso con id : $id
     */
    function getInterfaz_Proceso($id){
        $this->db->select('I.nombre,I.descripcion,I.tipo,I.detalle_tipo');
        $this->db->where('I.proceso', $id);
        $this->db->from('interfaz I');
        $this->db->join('proceso P','I.proceso = P.idproceso');
        $data=$this->db->get();
        if($data->num_rows()>0){
            return $data->result();
        }else{
            return false;
        }
    }
    
    /**
     * esta funcion consuñta los datos de una interfaz recibe un id y es invocada desde el controlador InterfazController
     * @param type $id_interfaz: entero para consultar los datos de una interfaz determinada
     * @return : los datos de la interfaz o false en caso de que no haya interfaz registrada con ese id o falle la consulta
     */
    function interfaz_Id($id_interfaz) {

        $this->db->select('I.nombre,I.descripcion,I.tipo,I.detalle_tipo,P.nombre nombreproceso,P.descripcion descripcionproceso, I.proceso');
        $this->db->where('I.id', $id_interfaz);
        $this->db->from('interfaz I');
        $this->db->join('proceso P','P.idproceso = I.proceso');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->row();
        } else {
            return false;
        }
    }
    
    function interfaz_Idint($id_interfaz) {

        $this->db->select('*');
        $this->db->where('id', $id_interfaz);
        $this->db->from('interfaz');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->row();
        } else {
            return false;
        }
    }

    /**
     * funcion para eliminar una interfaz, recibe el id de la interfaz y es invocada desde InterfazController
     * @param type $id: el id de la interfaz que queremos eliminar
     * @return : true si logra eliminar la interfaz, false si no se elimina la interfaz
     */
    function eliminarInterfaz($id){
        $this->db->where("id", $id);
        $this->db->delete('interfaz');
       if ($this->db->affected_rows()) {           
            return true;
        } else {
            return false;
        }
    }
    /**
     * funcion para edita una interfaz, recibe el id de la interfaz los nuevos valores de los datos de la interfaz,
     * esta funcion es invocada desde  InterfazController
     * @param type $data : array con los datos que se van a actualixar de la interfaz
     * @param type $id : el id de la interfaz que se va a actualizar
     * @return true si se actualiza o false si no se puede actualizar dicha interfaz
     */
    function actualizarInterfaz($data, $id) {//actualizar
        $this->db->where("id", $id);
        $this->db->update('interfaz', $data);
       
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
    
    function getTipo_Interfaz(){
        $this->db->select('*');
        $this->db->from('tipo_interfaz');
        $data=$this->db->get();
        if($data->num_rows()>0){
            return $data->result();
        }else{
            return false;
        }
    }
}
