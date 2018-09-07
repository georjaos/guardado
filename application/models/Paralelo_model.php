<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Paralelo_model extends CI_Model {

    function __construct() { ///funcion por defecto, NO QUITAR
        parent:: __construct();
        
    }
    function insertar($data){
        $this->db->insert('paralelos', $data);
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
    function getProcesosParalelos($proceso) {
        
        $this->db->select('pa.proceso, P.nombre, P.descripcion, P.prioridad');
        $this->db->where("pa.proceso", $proceso);
        //$this->db->where("P.idproceso !=", $proceso);
        $this->db->order_by("pa.proceso", "asc");
        $this->db->from('proceso P');
        $this->db->join('paralelos pa','P.idproceso = pa.paralelo');
        $data=$this->db->get();

        if ($data->num_rows() > 0) { //si el numero de filas es mayor a 0
            return $data->result_array(); //retorna un arreglo de tipo proceoss
        } else {
            return false; /// si no hay datos  en la tabla retorna false
        }
    }
}