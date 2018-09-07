<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sai extends CI_Controller {

    function __construct() {
        parent:: __construct();
    }

    public function index() {
        
    }

    public function enviarEmail_operacion() {

        $params = json_decode(file_get_contents("php://input"), true);
        $mnsj = $params['txt'];
        $subject = $params['subj'];

        $to = "";
        $copia = "";
        $from = "";

        $this->sendEmail($subject, $mnsj, $to, $copia, $from);
    }

    public function sendEmail($suject, $mensaje, $correo, $copia, $from) {

        $config = $this->configuracionSAI();

        $this->load->library("email", $config);
        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($correo);
        $this->email->cc($copia);
        $this->email->subject($suject);
        $this->email->message($mensaje);
        $this->email->send();
        //con esto podemos ver el resultado
        //var_dump($this->email->print_debugger());
    }

    public function configuracionSAI() {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => '',
            'smtp_pass' => '',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        );
        return $config;
    }

    public function enviarEmailSAI() {

        $mnsj = $this->input->post('txt');
        $carro = $this->input->post('car');
        $correo = $this->session->userdata('correo'); ///cambiar al correo de mantenimiento
        //configuracion para gmail
        $txt = $mnsj;

        $this->sendEmailSAI($txt, $correo, $carro);
    }

    public function configuracionEmail() {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => '',
            'smtp_pass' => '',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        );
        return $config;
    }

    public function sendEmailSAI($mensaje, $correo, $carro) {

        $config = $this->configuracionSAI();

        $this->load->library("email", $config);
        $this->email->set_newline("\r\n");
        $this->email->from("saipubenza@gmail.com");
        $this->email->to($correo);
        $this->email->subject($carro);
        $this->email->message($mensaje);
        $this->email->send();
        //con esto podemos ver el resultado
        //var_dump($this->email->print_debugger());
    }

}
