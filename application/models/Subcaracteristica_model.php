<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
         * La clase Subcaracteristica_model extiende de la clase CI_Model, propia del
         * framework Codeignither. Esta clase recibe peticiones del controlador SubcaracteristicaController.
         * conectandodose con la base de datos.
         * @package   levantamientorequisitos/application/models/Subcaracteristica_model.         
         * @version   1.0  Fecha 14-06-2018             
    */ 

class Subcaracteristica_model extends CI_Model {
    /**
      * Constructor de la clase
    */
    function __construct() { 
        parent:: __construct();
    }

    /**
         * getSubcaracteristica  
         * Realiza la consulta a la base de datos de todas las subcaracteristicas y el 
         * nombre de la caracterisitca asociada
         * que se encuentran en la BD. 
         * @param     la funcion no recibe paramateros 
         * @return    Un arreglo con toda la información relacionada.
         *            False, si no hay resultados-.
         * @version   1.0                 
    */ 
    function getSubcaracteristica() {
        $this->db->select('S.id_sub,S.nombre,S.descripcion,C.nombre nombre_c');
        $this->db->from('sub_caracteristica S');
        $this->db->join('caracteristica C','C.id = S.id_caract');
        $data=$this->db->get();

        if($data->num_rows()>0){
            return $data->result_array();
        }else{
            return false;
        }
    }

    /**
         * registrarSubcaracteristica
         * Realiza el registro de la información de una subcaracteristica  a la base de datos.               
         * @param     Array $data. Un arreglo con los datos enviados por el controlador. 
         * @return    True. Si los datos se agregan en la tabla de la base de datos
         *            False. Si no se ingresan los datos.
         * @version   1.0                 
    */ 

    function registrarSubcaracteristica($data) {
        $this->db->insert('sub_caracteristica', $data);
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
         * Subcaracteristica_Id
         * Realiza la consulta a la base de datos en la tabla subcaracteristica.
         * @param     Integer $id_sub 
         * @return    True. Un array con toda la información de la subcaracteristica
        *             False. Si no asocia nada en la busqueda.
         * @version   1.0                 
    */ 

    function Subcaracteristica_Id($id_sub) {

        $this->db->select('*');
        $this->db->where('id_sub', $id_sub);
        $this->db->from('sub_caracteristica');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->row();
        } else {
            return false;
        }
    }
    
    /**
         * actualizarSubcaracteristica 
         * Actualiza la información de una subcaracteristica en la base de datos. 
         * @param     Array $data, Integer $id                      
         * @return    True. Si los datos se actualiza en la tabla de la base de datos
         *            False. Si no se actualizan los datos.
         * @version   1.0                 
    */ 

    function actualizarSubcaracteristica($data, $id) {//actualizar
        $this->db->where("id_sub", $id);
        $this->db->update('sub_caracteristica', $data);
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
         * eliminarSubcaracteristica. 
         * 
         * Elimina un registro de la tabla sub_caracteristica.          
         * @param     Integer $id_sub 
         * @return    True. Si el registro se elimina en la tabla de la base de datos
         *            False. Si no se elimina el registro.
         * @version   1.0                 
    */ 

     function eliminarSubcaracteristica($id_sub){
        $this->db->where("id_sub", $id_sub);
        $this->db->delete('sub_caracteristica');
       if ($this->db->affected_rows()) {
            return true;
        } else {            
            return false;
        }
    }   
    
    /**
         * ListarSubCaracteristicas 
         * 
         * lista una subcaracteristica.
         *              
         * @param     Integer $id_caracteristica
         * @return    array $data con la informacion 
         *            False. Si la consulta no tiene exito.
         * @version   1.0                 
    */ 

    function ListarSubCaracteristicas($id_caracteristica) {

        $this->db->select('*');
        $this->db->where('id_caract', $id_caracteristica);
        $this->db->from('sub_caracteristica');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result();
        } else {
            return false;
        }
    }
    
    /**
         * ListarSubCaracteristicas_All
         * 
         * Lista todas las subcaracteristicas         
         * 
         *                    
         * @param     la funcion no recibe paramateros 
         * @return    array $data con la informacion 
         *            False. Si la consulta no tiene exito.
         * @version   1.0                 
    */ 

    function ListarSubCaracteristicas_All() {

        $this->db->select('*');
        $this->db->order_by('nombre',"asc");
        $this->db->from('sub_caracteristica');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result();
        } else {
            return false;
        }
    }
}
