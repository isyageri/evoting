<?php

class M_global extends CI_Model
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper('sequence');
    }

    public function getListRT()
    {
        $this->db->order_by("rt_code", "ASC");
        $q = $this->db->get('rt');
        return $q->result_array();
    }
    public function getListRW()
    {
        $this->db->order_by("rw_code", "ASC");
        $q = $this->db->get('rw');
        return $q->result_array();
    }

}