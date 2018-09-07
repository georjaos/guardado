<?php

//Esta clase es el modelo para gestionar las normativas asociadas a cada proceso que recibe
//peticiones del controlador enviando los datos consultados en la base de datos

defined('BASEPATH') OR exit('No direct script access allowed');

class Normativa_model extends CI_Model {
    
    //Funcion por defecto
    function __construct() { 
        parent:: __construct();
    }

    //Devuelve todos los registros de la tabla normativa de la base de datos
    function getNormativas() {
        $this->db->select('N.idnormativa, N.idproceso, N.nombre nombre_norma, N.descripcion descrip, P.nombre nombre_pro');
        $this->db->from('normativa N');
        $this->db->join('proceso P', 'P.idproceso = N.idproceso');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result_array();
        } else {
            return false;
        }              
    }

    //Recibe los datos para crear un nuevo registro en la tabla normativa
    function agregarNormativa($data) {
        $this->db->insert('normativa', $data);
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    //Recibe Id norma y devuelve el registro respectivo
    function normativa_Id($id_norma) {
        $this->db->select('N.nombre,N.descripcion,P.nombre nombreproceso,P.descripcion descripcionproceso, N.idproceso');
        $this->db->where('N.idnormativa', $id_norma);
        $this->db->from('normativa N');
        $this->db->join('proceso P','P.idproceso = N.idproceso');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->row();
        } else {
            return false;
        }
    }
    
    //Recibe Id proceso y devuelve las normas asociadas 
    function normativa_Proceso($id_pro) {

        $this->db->select('*');
        $this->db->where('idproceso', $id_pro);
        $this->db->from('normativa');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result();
        } else {
            return false;
        }
    }
    
    //Recibe Id de normativa mas los datos y actualiza el registro 
    function actualizarNormativa($data, $id) {//actualizar
        $this->db->where("idnormativa", $id);
        $this->db->update('normativa', $data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    //Recibe Id de normativa y elimina el registro 
    function eliminarNormativa($id) {
        $this->db->where("idnormativa", $id);
        $this->db->delete('normativa');
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
    
    //Recibe Id de proceso y devuelve las normativas asociadas
    function geNormativa_Proceso($id){
        $this->db->select('N.nombre,N.descripcion');
        $this->db->where('N.idproceso', $id);
        $this->db->from('normativa N');
        $this->db->join('proceso P','N.idproceso = P.idproceso');
        $data=$this->db->get();
        if($data->num_rows()>0){
            return $data->result();
        }else{
            return false;
        }
    }

    //Recibe el nombre de la normativa y devuelve false o true si existe ese nombre
    function existe_normativa($nombre) {

        $this->db->select('nombre');
        $this->db->where("nombre", $nombre);
        $this->db->from('normativa');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}
