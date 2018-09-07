<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
         * La clase Login_model extiende de la clase CI_Model, propia del
         * framework Codeignither. Esta clase recibe peticiones del controlador Login
         * conectandodose con la base de datos.
         * @package   levantamientorequisitos/application/models/Login_model
         * @version   1.0  Fecha 14-06-2018             
    */ 

class Login_model extends CI_Model {
  /**
      * Constructor de la clase
    */
    function __construct() {
        parent:: __construct();
    }


    /**
         * get_user  
         * Realiza la consulta a la base de datos del usuario que inicia sesion         
         * que se encuentran en la BD. 
         * @param     $username
         * @return    Un arreglo con toda la información relacionada.
         *            False, si no hay resultados-.
         * @version   1.0                 
    */ 
    function get_user($username) {
        $this->db->select('*');
        $this->db->where("user_login", $username);
        $this->db->or_where('user_email', $username);
        $this->db->from('usuario');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->row();
        } else {
            return false;
        }
    }  
}
