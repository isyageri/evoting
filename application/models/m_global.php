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
        $rw_id = $this->input->post('rw_id');

        if($rw_id){
             $this->db->where("rw_id", $rw_id);
        }
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

    public function crud_RW(){
        $this->db->_protect_identifiers = false;

        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $table = "rw";

        $rw_code = ucfirst($this->input->post('rw_code'));
        $description = ucfirst($this->input->post('description'));

        $update_by = $this->session->userdata('admin_user');

        $data = array('rw_code' => $rw_code,
            'description' => $description,
            'update_by' => $update_by
        );

        switch ($oper) {
            case 'add':
                $this->db->set('update_date', 'NOW()', FALSE);
                $this->db->insert($table, $data);
                break;
            case 'edit':
                $this->db->set('update_date', 'NOW()', FALSE);
                $this->db->where('rw_id', $id_);
                $this->db->update($table, $data);
                break;
            case 'del':
                $this->db->where('rw_id', $id_);
                $this->db->delete($table);
                break;
        }
    }

    public function crud_RT(){
        $this->db->_protect_identifiers = false;

        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $table = "rt";

        $rt_code = ucfirst($this->input->post('rt_code'));
        $rw_id = (int)$this->input->post('rw_id');
        $description = ucfirst($this->input->post('description'));

        $update_by = $this->session->userdata('admin_user');

        $data = array('rt_code' => $rt_code,
            'rw_id' => $rw_id,
            'description' => $description,
            'update_by' => $update_by
        );

        switch ($oper) {
            case 'add':
                $this->db->set('update_date', 'NOW()', FALSE);
                $this->db->insert($table, $data);
                break;
            case 'edit':
                $this->db->set('update_date', 'NOW()', FALSE);
                $this->db->where('rt_id', $id_);
                $this->db->update($table, $data);
                break;
            case 'del':
                $this->db->where('rt_id', $id_);
                $this->db->delete($table);
                break;
        }
    }

    function crud_menu(){
        $oper = $this->input->post('oper');
        $id = (int)$this->input->post('id');

        $code = ucfirst($this->input->post('code'));
        $file_name = $this->input->post('file_name');
        $is_parent = (int)$this->input->post('is_parent');
        $is_active = (int)$this->input->post('is_active');
        $icon = $this->input->post('menu_icon');

        $table = "menu";
        $pk = "menu_id";
        switch ($oper) {
            case 'add':
                $data = array('code' => $code,
                    "file_name" => $file_name,
                    "menu_icon" => $icon,
                    "is_active" => $is_active,
                    "parent_id" => $is_parent
                );
                $this->db->insert($table,$data);
                break;
            case 'edit':
                $data = array('code' => $code,
                    "file_name" => $file_name,
                    "menu_icon" => $icon,
                    "is_active" => $is_active,
                    "parent_id" => $is_parent
                );
                $this->db->where($pk,$id);
                $this->db->update($table, $data);

                break;
            case 'del':
                $this->db->where($pk,$id);
                $this->db->delete($table);
                break;
        }
        //return $oper;
    }

}