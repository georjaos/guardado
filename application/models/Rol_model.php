<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
         * La clase Rol_model extiende de la clase CI_Model, propia del
         * framework Codeignither. Esta clase recibe peticiones del controlador RolController.
         * conectandodose con la base de datos.
         * @package   levantamientorequisitos/application/models/Rol_model.         
         * @version   1.0  Fecha 14-06-2018             
    */
class Rol_model extends CI_Model {
    /**
      * Constructor de la clase
    */

    function __construct() { ///funcion por defecto, NO QUITAR
        parent:: __construct();
    }
    
    /**
         * getRole  
         * Realiza la consulta a la base de datos de todas los roles 
         * que se encuentran en la BD. 
         * @param     la funcion no recibe paramateros 
         * @return    Un arreglo con toda la información relacionada.
         *            False, si no hay resultados-.
         * @version   1.0                 
    */ 
    function getRole() {
        $this->db->order_by("nombre", "asc");
        $data = $this->db->get("role"); //nombre de la tabla en la base de datos
        if ($data->num_rows() > 0) { //si el numero de filas es mayor a 0
            return $data->result_array(); //retorna un arreglo de tipo roles
        } else {
            return false; /// si no hay datos  en la tabla retorna false
        }
    }

      /**
         * registrarRol
         * Realiza el registro de la información de un rol de proceso a la base de datos.               
         * @param     Array $data. Un arreglo con los datos enviados por el controlador. 
         * @return    True. Si los datos se agregan en la tabla de la base de datos
         *            False. Si no se ingresan los datos.
         * @version   1.0                 
    */ 
    
    function registrarRol($data) {

        $this->db->insert('role', $data);
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
         * rol_Id
         * Realiza la consulta a la base de datos en la tabla roles.
         * @param     Integer $id_rol 
         * @return    True. Un array con toda la información del rol
        *             False. Si no asocia nada en la busqueda.
         * @version   1.0                 
    */ 

    function rol_Id($id_rol) {

        $this->db->select('*');
        $this->db->where('idrole', $id_rol);
        $this->db->from('role');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->row();
        } else {
            return false;
        }
    }

    /**
         * actualizarRol 
         * Actualiza la información de una rol en la base de datos. 
         * @param     Array $data datos del rol, Integer $id  id del rol todos llegan desde el controlador                    
         * @return    True. Si los datos se actualiza en la tabla de la base de datos
         *            False. Si no se actualizan los datos.
         * @version   1.0                 
    */ 
    
    function actualizarRol($data, $id) {//actualizar
        $this->db->where("idrole", $id);
        $this->db->update('role', $data);
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

     /**
         * eliminarRol. 
         * 
         * Elimina un registro de la tabla role
         * @param     Integer $id_sub  id del role
         * @return    True. Si el registro se elimina en la tabla de la base de datos
         *            False. Si no se elimina el registro.
         * @version   1.0                 
    */ 
    
     function eliminarRol($id_rol){
        $this->db->where("idrole", $id_rol);
        $this->db->delete('role');
       if ($this->db->affected_rows()) {
            return true;
        } else {            
            return false;
        }
    }


    /**
     * existe_rol  
     * Realiza una consulta en la base de datos para saber si el nombre del rol ya se encuentra registrado     
     * @param     String $nombre. Recibido desde el controlador
     * @return    Truee. Si ya se  el login ya se encuentra registrado.
     *            False. Si no se encuentra registrado.
     * @version   1.0                 
  */ 
    function existe_rol($nombre) {

        $this->db->select('nombre');
        $this->db->where("nombre", $nombre);
        $this->db->from('role');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
}

