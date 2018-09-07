<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Preguntas_model extends CI_Model {

    function __construct() { ///funcion por defecto, NO QUITAR
        parent:: __construct();
    }

    function agregarPregunta($datos) {
        $this->db->insert('preguntas', $datos);
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    function getPregunta() {

        $this->db->select('P.id, P.nombre, P.id_sub_caracteristica, SB.nombre nombre_sb ');
        $this->db->from('preguntas P');
        $this->db->join('sub_caracteristica SB', 'SB.id_sub = P.id_sub_caracteristica');
        $data = $this->db->get();

        if ($data->num_rows() > 0) { //si el numero de filas es mayor a 0
            return $data->result_array(); //retorna un arreglo de tipo roles
        } else {
            return false; /// si no hay datos  en la tabla retorna false
        }
    }

    function preguntas_caracteristicas($id_pro) {

        $this->db->select('*');
        $this->db->where('id', $id_pro);
        $this->db->from('preguntas');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result();
        } else {
            return false;
        }
    }

    function pregunta_Id($id_pregunta) {

        $this->db->select('P.nombre,SB.nombre nombrecaracteristica,P.id_sub_caracteristica');
        $this->db->where('P.id', $id_pregunta);
        $this->db->from('preguntas P');
        $this->db->join('sub_caracteristica SB', 'SB.id_sub = P.id_sub_caracteristica');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->row();
        } else {
            return false;
        }
    }

    function eliminarPreguntas($id) {
        $this->db->where("id", $id);
        $this->db->delete('preguntas');
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    function actualizarPregunta($data, $id) {//actualizar
        $this->db->where("id", $id);
        $this->db->update('preguntas', $data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    function preguntas_SubCaracteristicas($id_pro) {

        $this->db->select('*');
        $this->db->where('id_sub_caracteristica', $id_pro);
        $this->db->from('preguntas');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data->result();
        } else {
            return false;
        }
    }

    function numPreguntas() {

        $data = $this->db->query("select count(*) num_preguntas from preguntas");
        if ($data->num_rows() > 0) {
            return $data->row();
        } else {
            return false;
        }
    }
    
    function numRespuestasProceso($id_proc) {

        $data = $this->db->query("select count(*) num_respuestas from respuesta where id_proceso=".$id_proc);
        if ($data->num_rows() > 0) {
            return $data->row();
        } else {
            return false;
        }
    }

}
