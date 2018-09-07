<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
         * La  clase Login extiende de la clase CI_Controller, propia del
         * framework Codeignither
         * Es una clase que responde a la invocacion a los metodos de la clase login_model.
         * @package   levantamientorequisitos/application/controllers/Login
         * @version   1.0  Fecha 13-06-2018                 
    */ 
class Login extends CI_Controller {
    /**
         * Es una función que crea el constructor de la clase. En esta se pueden cargar 
         * librerias,helper,modelos.                
    */ 
    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('encryption');
        $this->load->model('Login_model');
        $this->load->helper(array('form', 'url'));
    }

    public function index() {
        $this->load->view('login');
    }

    /**
         * login_user
         * 
         * Permite iniciar la sesion de un usuario registrado.
         * los datos se obtienen mediante metodo POST  y utiliza la clase Login_model
         *                    
         * @param     la funcion no recibe parametros 
         * @return    JSON       
         * @version   1.0                 
    */ 
    public function login_user() {

        if ($this->input->post()) {

            $user = $this->security->xss_clean($this->input->POST('user'));
            $pwd = $this->security->xss_clean($this->input->POST('pwd'));

            $data = $this->Login_model->get_user($user);
            if ($data != false) {

                if ($data->user_login == $user || $data->user_email == $user) {
                    if ($data->user_password == sha1($pwd)) {

                        $UserData = array(
                            "username" => $data->user_login,
                            "nombre" => $data->user_name,
                            "apellido" => $data->user_apellido,
                            "email" => $data->user_email,
                            "tipo" => $data->user_type,
                            "login" => TRUE
                        );

                        $this->session->set_userdata($UserData);
                        $this->logueado();
                    } else {
                        echo json_encode("no-pass");
                    }
                } else {
                    echo json_encode("no-user");
                }
            } else {
                echo json_encode("no-exist");
            }
        }
    }
    /**
         * logueado
         * 
         * Permite saber si se encuentra en sesion
         * los datos se obtienen mediante metodo POST  y utiliza la clase Login_model
         *                    
         * @param     la funcion no recibe parametros 
         * @return    JSON       
         * @version   1.0                 
    */ 
    public function logueado() {

        if ($this->session->userdata('login')) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }
    /**
         * cerrar
         * 
         * Permite cerrar la  sesion desturye las variables que se encontrban en sesion
         *                    
         * @param     la funcion no recibe parametros 
         * @return    JSON       
         * @version   1.0                 
    */ 
    public function cerrar() {

        $this->session->sess_destroy();
        echo json_encode(true);
    }
    /**
         * login_user
         * 
         *                    
         * @param     la funcion no recibe parametros 
         * @return    JSON       
         * @version   1.0                 
    */ 
    public function islogin() {
        $login["username"] = $this->session->userdata('username');
        $login["role"] = $this->session->userdata('rol');
        $login["login"] = $this->session->userdata('login');
        $login["email"] = $this->session->userdata('email');
        echo json_encode($login);
    }

}
