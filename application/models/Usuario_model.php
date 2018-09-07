<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
     * La clase Usuario_model extiende de la clase CI_Model, propia del
     * framework Codeignither. Esta clase recibe peticiones del controlador UsuarioController.
     * conectandodose con la base de datos.
     * @package   levantamientorequisitos/application/models/Usuario_model.         
     * @version   1.0  Fecha 14-06-2018             
  */ 

class Usuario_model extends CI_Model{
  /**
      * Constructor de la clase
    */
  function __construct(){
    parent::__construct();
  }

  /**
     * login_check   
     * Realiza una consulta en la base de datos para saber si el login ya se encuentra registrado     
     * @param     String $user. Recibido desde el controlador
     * @return    Truee. Si ya se  el login ya se encuentra registrado.
     *            False. Si no se encuentra registrado.
     * @version   1.0                 
  */ 

  public function login_check($user){    
    $this->db->from('usuario');
    $this->db->where('user_login',$user);
    $query= $this->db->get();
    if($query->num_rows()>0){
      return true;
    }
    else {
      return false;
    }
  }

  /**
     * login_check   
     * Esta funcion es para consultar si el email ya se encuentra registrado
     * @param     String $correo. Recibido desde el controlador
     * @return    True. Si ya se  el email ya se encuentra registrado.
     *            False. Si no se encuentra registrado.
     * @version   1.0                 
  */ 
  public function email_check($correo){
    $this->db->from('usuario');
    $this->db->where('user_email',$correo);
    $query=$this->db->get();

    if($query->num_rows()>0){
      return true;
    }
    else {
      return false;
    }
  }

  
  /**
     * register_user
     * Esta funcion realiza el registro de un Usuario a  la aplicacion.
     *         
     * @param     array $user con todos los campos para registrar
     * @return    True. Si se registro la información en la base de datos.
     *            False. Si no se registro la información en la base de datos.
     * @version   1.0                 
  */ 
  public function register_user($user){    
    $this->db->insert('usuario', $user);
    if ($this->db->affected_rows()) {
      return true;
   } else {
      return false;
    }
  }

  /**
     * getTipoUsuario 
     * Se encarga de consultar todos los registros de tipos de usuario en la base de datos
     * @param     la funcion no recibe paramateros 
     * @return    array $query con los registros
     *            false. Si no encuentra registros.
     * @version   1.0                 
  */ 
  public function getTipoUsuario(){
    $this->db->order_by("nombre_tipousu", "asc");
    $this->db->from('tipo_usuario');
    $query = $this->db->get();

    if($query ->num_rows()>0){
      return $query->result_array();
    }else{
      return false;
    }   
  }

}
