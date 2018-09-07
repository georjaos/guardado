<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
     /**
         * La  clase UsuarioController extiende de la clase CI_Controller, propia del
         * framework Codeignither
         * Es una clase que hace uso de los metodos de la clase Usuario_model.
         * @package   levantamientorequisitos/application/controllers/UsuarioController.         
         * @version   1.0  Fecha 13-06-2018                 
    */ 

class UsuarioController extends CI_Controller{
  
  /**
         * Es una función que crea el constructor de la clase. En esta se pueden cargar 
         * librerias,helper,modelos.                
    */ 
  function __construct() {
      parent:: __construct();
      $this->load->library('form_validation');
      /* 
         * biblioteca de codigo disponible, donde hacemos el llamdo de funciones especiales para permirtir 
         * usar formularios y peticiones de diferentes url 
         */        
      $this->load->helper(array('form', 'url'));
      //Invocamos a la clase Usuario_model para poder hacer uso de sus metodos
      $this->load->model('Usuario_model');
      //Invocamos a la clase Login_model para poder hacer uso de sus metodos
      $this->load->model('Login_model');
  }
  /**
         * Este metodo se carga de manera predeterminada cuando llamamos al controlador a traves de la URL       
         * funcion que carga la vista
    */ 

  function index(){
    $this->load->view('usuario_view');
  }
  
  /**
      * Este metodo se encarga de carga la vista del login para inciiar sesion,
      * funcion que carga la vista
    */ 
  function login_view(){
    $this->load->view("login.php");
  }

  /**
     * register_user 
     * Registra los datos de un usuario. los datos se obtienen mediante metodo POST
     * desde la vista usuario_view.php  y utiliza la clase Usuario_model
     * para registrarlos en la base de datos.    
     * @param     la funcion no recibe paramateros 
     * @return    
     * @version   1.0                 
  */ 

  public function register_user(){
    //array $user para guardar los datos que se reciben de la vista
    $user=array(
      'user_name'=>$this->input->post('user_name'),
      'user_apellido'=>$this->input->post('user_apellido'),
      'user_email'=>$this->input->post('user_email'),
      'user_login'=>$this->input->post('user_login'),
      //el password se encripta con sha1
      'user_password'=>sha1(($this->input->post('user_password'))),
      'user_type'=>$this->input->post('user_tipousuario')
    );
      //Invocacion a la clase Usario_model para verificar si el email que se ingresa ya esta registrado
      $email_check = $this->Usuario_model->email_check($user['user_email']);
      //Invocacion a la clase Usario_model para verificar si login que se ingresa ya esta registrado
      $login_check = $this->Usuario_model->login_check($user['user_login']);

      if(!$email_check){
        if(!$login_check){
          $result = $this->Usuario_model->register_user($user);         
          echo json_decode($result);          
        }
        else{
          echo json_encode("exist_login");
        }        
      }
      else{
        echo json_encode("exist_email");
      }
  }


  /**
     * listarTipoUsuario
     * Se encarga de invocar a la clase Usario_model para que obtenga desde la base de datos 
     * todos los tipos de usuario y se muestren en la vista del formulario.
     * @param     la funcion no recibe paramateros 
     * @return    array con la informacion de los tipos de usuario.
     * @version   1.0                 
  */ 

  function listarTipoUsuario(){
    $result = $this->Usuario_model->getTipoUsuario();
    echo json_encode($result);
  }
}
