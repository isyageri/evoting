<?php

class M_penduduk extends CI_Model
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper('sequence');
    }

   

   

    

    

    

    public function crud_penduduk()
    {
        $this->db->_protect_identifiers = false;

        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $table = "penduduk";

        $penduduk_id = $this->input->post('penduduk_id');
        $rt_code = $this->input->post('rt_code');
        $rw_code =  $this->input->post('rw_code');
        $penduduk_name = ucfirst($this->input->post('penduduk_name'));
        $gender = $this->input->post('gender');
        $date_of_birth = $this->input->post('date_of_birth');
        $email = $this->input->post('email');
        $telp = $this->input->post('telp');
        $hp = $this->input->post('hp');
        $address = $this->input->post('address');

        $update_by = $this->session->userdata('admin_user');

        $data = array('penduduk_id' => $penduduk_id,
            'rw_id' => $rw_code,
            'rt_id' => $rt_code,
            'penduduk_name' => $penduduk_name,
            'penduduk_password' => $this->password_generate(5),
            'gender' => $gender,
            'date_of_birth' => $date_of_birth,
            'email' => $email,
            'telp' => $telp,
            'hp' => $hp,
            'address' => $address,
            'update_by' => $update_by
        );

        switch ($oper) {
            case 'add':
                $this->db->set('update_date', 'NOW()', FALSE);
                $this->db->insert($table, $data);
                break;
            case 'edit':
                $this->db->set('update_date', 'NOW()', FALSE);
                $this->db->where('penduduk_id', $id_);
                $this->db->update($table, $data);
                break;
            case 'del':
                $this->db->where('penduduk_id', $id_);
                $this->db->delete($table);
                break;
        }

    }

    private function password_generate($panjang)
    {
       $pengacak = 'ABCDEFGHIJKLMNOPQRSTU1234567890';
       $string = '';
       for($i = 0; $i < $panjang; $i++) {
       $pos = rand(0, strlen($pengacak)-1);
       $string .= $pengacak{$pos};
       }
        return $string;
    }

    public function crud_datin()
    {
        $this->db->_protect_identifiers = false;
        $this->db->protect_identifiers('TEN_ND_NP', FALSE);
        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $table = "TEN_ND_NP";
        $PRODUCT_ID = $this->input->post('PRODUCT_ID');
        $TEN_ID = $this->input->post('TEN_ID');
        $CREATED_DATE = date('d/M/Y');
        $CREATED_BY = $this->session->userdata('d_user_name');

        $data = array('PRODUCT_ID' => $PRODUCT_ID,
            'TEN_ID' => $TEN_ID,
            'CREATED_DATE' => $CREATED_DATE,
            'CREATED_BY' => $CREATED_BY
        );

        switch ($oper) {
            case 'add':
                $check = $this->Mfee->checkDuplicateND_NP($TEN_ID, $PRODUCT_ID);
                if ($check == 0) {
                    $this->db->insert($table, $data);
                }
                break;
            case 'edit':
                $this->db->where('PRODUCT_ID', $id_);
                $this->db->where('TEN_ID', $TEN_ID);
                $this->db->update($table, $data);
                break;
            case 'del':
                $this->db->where('PRODUCT_ID', $id_);
                $this->db->where('TEN_ID', $TEN_ID);
                $this->db->delete($table);
                break;
        }

    }

    public function insertFastel($data)
    {
        $this->db->_protect_identifiers = false;
        $this->db->insert('TEN_ND', $data);
        return $this->db->affected_rows();
    }

    public function insertDatin($data)
    {
        $this->db->_protect_identifiers = false;
        $this->db->insert('TEN_ND_NP', $data);
        return $this->db->affected_rows();
    }

    public function deleteFastelByTenant($ten_id)
    {
        $this->db->where('TEN_ID', $ten_id);
        $this->db->delete('TEN_ND');
    }

    public function deleteDatinByTenant($ten_id)
    {
        $this->db->where('TEN_ID', $ten_id);
        $this->db->delete('TEN_ND_NP');
    }

    public function crud_detailmitra()
    {
        $this->db->_protect_identifiers = false;

        $table = "P_MAP_MIT_CC";
        $pk = "P_MAP_MIT_CC_ID";

        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $p_map_mit_cc = $this->input->post("p_map_mit_cc");
        $cc_id = $this->input->post("cc_id");
        $mitra_id = $this->input->post("mitra_id");
        $eam_id = $this->input->post("eam_id");
        $action = $this->input->post("action");
        $CREATED_DATE = date('d/M/Y');
        $CREATED_BY = $this->session->userdata('d_user_name');


        $data = array('PGL_ID' => $mitra_id,
            'P_DAT_AM_ID' => $eam_id,
            'ID_CC' => $cc_id,
            'CREATION_DATE' => $CREATED_DATE,
            'CREATE_BY' => $CREATED_BY
        );

        if ($action == "add") {
            $new_id = gen_id($pk, $table);
            $this->db->set($pk, $new_id);
            $this->db->insert($table, $data);
            if ($this->db->affected_rows() > 0) {
                $data["success"] = true;
                $data["message"] = "Data berhasil ditambahakan";
            } else {
                $data["success"] = false;
                $data["message"] = "Gagal menambah data";
            }

        } elseif ($action == "edit") {
            $this->db->where($pk, $p_map_mit_cc);
            $this->db->update($table, $data);
            if ($this->db->affected_rows() > 0) {
                $data["success"] = true;
                $data["message"] = "Edit data berhasil";
            } else {
                $data["success"] = false;
                $data["message"] = "Gagal edit data";
            }
        } elseif ($oper == 'del') {
            $this->db->where($pk, $id_);
            $this->db->delete($table);
        } else {
            $data["success"] = false;
            $data["message"] = "Unknown Error";
        }
        echo json_encode($data);
    }

    public function crud_lokasimitra()
    {
        $this->db->_protect_identifiers = false;

        //$this->db->protect_identifiers('TEN_ND', FALSE);
        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $table = "P_MP_LOKASI";
        $pk = "P_MP_LOKASI_ID";

        $LOKASI = $this->input->post('LOKASI');
        $P_MAP_MIT_CC_ID = $this->input->post('P_MAP_MIT_CC_ID');
        $CREATION_DATE = date('d-m-Y');
        $UPDATE_DATE = date('d/m/Y');
        $CREATE_BY = $this->session->userdata('d_user_name');
        $UPDATE_BY = $this->session->userdata('d_user_name');
        $VALID_FROM = $this->input->post('VALID_FROM');
        $VALID_UNTIL = $this->input->post('VALID_UNTIL');


        switch ($oper) {
            case 'add':
                $data = array('P_MAP_MIT_CC_ID' => $P_MAP_MIT_CC_ID,
                    'LOKASI' => $LOKASI,
                    'CREATE_BY' => $CREATE_BY
                );

                $new_id = gen_id($pk, $table);
                $this->db->set($pk, $new_id);
                $this->db->set('VALID_FROM',"to_date('$VALID_FROM','dd/mm/yyyy')",FALSE);
                $this->db->set('VALID_UNTIL',"to_date('$VALID_UNTIL','dd/mm/yyyy')",FALSE);
                $this->db->set('CREATION_DATE',"SYSDATE",FALSE);
                $this->db->insert($table, $data);
                if ($this->db->affected_rows() > 0) {
                    $data["success"] = true;
                    $data["message"] = "Data berhasil ditambahakan";
                } else {
                    $data["success"] = false;
                    $data["message"] = "Gagal menambah data";
                }
                break;
            case 'edit':
                $data = array(
                    'LOKASI' => $LOKASI,
                    'UPDATE_BY' => $UPDATE_BY
                );
                $this->db->set('VALID_FROM',"to_date('$VALID_FROM','dd/mm/yyyy')",FALSE);
                $this->db->set('VALID_UNTIL',"to_date('$VALID_UNTIL','dd/mm/yyyy')",FALSE);
                $this->db->set('UPDATE_DATE',"to_date('$UPDATE_DATE','dd/mm/yyyy')",FALSE);
                $this->db->where($pk, $id_);
                $this->db->update($table, $data);
                if ($this->db->affected_rows() > 0) {
                    $data["success"] = true;
                    $data["message"] = "Edit data berhasil";
                } else {
                    $data["success"] = false;
                    $data["message"] = "Gagal edit data";
                }
                break;
            case 'del':
                $this->db->where($pk, $id_);
                $this->db->delete($table);
                if ($this->db->affected_rows() > 0) {
                    $data["success"] = true;
                    $data["message"] = "Data berhasil dihapus";
                } else {
                    $data["success"] = false;
                    $data["message"] = "Gagal menghapus data !";
                }
                break;
        }
        echo json_encode($data);

    }

    public function crud_mapping_pic()
    {
        $this->db->_protect_identifiers = false;

        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $table = "P_MP_PIC";
        $pk = "P_MP_PIC_ID";

        $P_MP_PIC_ID = $this->input->post("p_mp_pic_id");
        $contact = $this->input->post('contact');
        $p_mp_lokasi_id = $this->input->post('p_mp_lokasi_id');
        $pic_id = $this->input->post('pic_id');

        $CREATE_DATE = date('d/M/Y');
        $UPDATE_DATE = date('d/M/Y');
        $CREATED_BY = $this->session->userdata('d_user_name');
        $UPDATE_BY = $this->session->userdata('d_user_name');


        switch ($oper) {
            case 'add':
                $data = array('P_MP_LOKASI_ID' => $p_mp_lokasi_id,
                    'P_CONTACT_TYPE_ID' => $contact,
                    'P_PIC_ID' => $pic_id,
                    'CREATED_BY' => $CREATED_BY,
                    'CREATE_DATE' => $CREATE_DATE,
                    'UPDATE_DATE' => $UPDATE_DATE,
                    'UPDATE_BY' => $UPDATE_BY
                );

                $new_id = gen_id($pk, $table);
                $this->db->set($pk, $new_id);
                $this->db->insert($table, $data);
                if ($this->db->affected_rows() > 0) {
                    $datas["success"] = true;
                    $datas["message"] = "Data berhasil ditambahakan";
                } else {
                    $datas["success"] = false;
                    $datas["message"] = "Gagal menambah data";
                }
                break;
            case 'edit':
                $data = array('P_MP_LOKASI_ID' => $p_mp_lokasi_id,
                    'P_CONTACT_TYPE_ID' => $contact,
                    'P_PIC_ID' => $pic_id,
                    'UPDATE_DATE' => $UPDATE_DATE,
                    'UPDATE_BY' => $UPDATE_BY
                );
                $this->db->where($pk, $P_MP_PIC_ID);
                $this->db->update($table, $data);
                if ($this->db->affected_rows() > 0) {
                    $datas["success"] = true;
                    $datas["message"] = "Edit data berhasil";
                } else {
                    $datas["success"] = false;
                    $datas["message"] = "Gagal edit data";
                }
                break;
            case 'del':
                $this->db->where($pk, $id_);
                $this->db->delete($table);
                if ($this->db->affected_rows() > 0) {
                    $datas["success"] = true;
                    $datas["message"] = "Data berhasil dihapus";
                } else {
                    $datas["success"] = false;
                    $datas["message"] = "Gagal menghapus data !";
                }
                break;
        }
        echo json_encode($datas);

    }

    public function crud_pks()
    {
        $this->db->_protect_identifiers = false;

        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $table = "P_MP_PKS";
        $pk = "P_MP_PKS_ID";

        $P_MP_PKS_ID = $this->input->post('P_MP_PKS_ID');
        $NO_PKS = strtoupper($this->input->post("NO_PKS"));
        $P_MP_LOKASI_ID = $this->input->post('P_MP_LOKASI_ID');
        $VALID_FROM = $this->input->post('VALID_FROM');
        $VALID_UNTIL = $this->input->post('VALID_UNTIL');

        $CREATED_DATE = date('d/M/Y');
        $UPDATED_DATE = date('d/M/Y');
        $CREATED_BY = $this->session->userdata('d_user_name');
        $UPDATED_BY = $this->session->userdata('d_user_name');


        switch ($oper) {
            case 'add':
                $data = array('P_MP_LOKASI_ID' => $P_MP_LOKASI_ID,
                    'NO_PKS' => $NO_PKS,
                    'CREATED_BY' => $CREATED_BY,
                    'CREATED_DATE' => $CREATED_DATE,
                    'UPDATED_DATE' => $UPDATED_DATE,
                    'UPDATED_BY' => $UPDATED_BY
                );
                $ck = $this->Mfee->checkDuplicate($table, 'NO_PKS', $NO_PKS);
                if ($ck > 0) {
                    $datas["success"] = false;
                    $datas["message"] = "No PKS sudah ada !";
                } else {
                    $new_id = gen_id($pk, $table);
                    $this->db->set($pk, $new_id);

                    $this->db->set('VALID_FROM',"to_date('$VALID_FROM','dd/mm/yyyy')",FALSE);
                    $this->db->set('VALID_UNTIL',"to_date('$VALID_UNTIL','dd/mm/yyyy')",FALSE);

                    $this->db->insert($table, $data);
                    if ($this->db->affected_rows() > 0) {
                        $datas["success"] = true;
                        $datas["message"] = "Data berhasil ditambahakan";
                    } else {
                        $datas["success"] = false;
                        $datas["message"] = "Gagal menambah data";
                    }
                }


                break;
            case 'edit':
                $data = array(
                    'NO_PKS' => $NO_PKS,
                    'UPDATED_DATE' => $UPDATED_DATE,
                    'UPDATED_BY' => $UPDATED_BY
                );
                $ck = $this->Mfee->checkDuplicated($table,array('NO_PKS' => $NO_PKS,'P_MP_PKS_ID !=' =>  $id_));
                if ($ck > 0) {
                    $datas["success"] = false;
                    $datas["message"] = "No PKS sudah ada !";
                }else{
                    $this->db->set('VALID_FROM',"to_date('$VALID_FROM','dd/mm/yyyy')",FALSE);
                    $this->db->set('VALID_UNTIL',"to_date('$VALID_UNTIL','dd/mm/yyyy')",FALSE);
                    $this->db->where($pk, $P_MP_PKS_ID);
                    $this->db->update($table, $data);
                    if ($this->db->affected_rows() > 0) {
                        $datas["success"] = true;
                        $datas["message"] = "Edit data berhasil";
                    } else {
                        $datas["success"] = false;
                        $datas["message"] = "Gagal edit data";
                    }
                }

                break;
            case 'del':
                $this->db->where($pk, $id_);
                $this->db->delete($table);
                if ($this->db->affected_rows() > 0) {
                    $datas["success"] = true;
                    $datas["message"] = "Data berhasil dihapus";
                } else {
                    $datas["success"] = false;
                    $datas["message"] = "Gagal menghapus data !";
                }
                break;
        }
        echo json_encode($datas);

    }
	function crud_map_datin()
    {
        $this->db->_protect_identifiers = false;
        $this->db->protect_identifiers('PGID', FALSE);
        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');
		if(empty($id_)) {
			$id_ = "NULL";
		}
		
        $table = "P_MAP_DATIN_ACC";
        $PGL_ID = $this->input->post('PGL_ID');
        $ACCOUNT_NUM = $this->input->post('ACCOUNT_NUM');
        $VALID_FROM = $this->input->post('VALID_FROM');
        $CREATED_BY = $this->session->userdata('d_user_name');
		$UPDATE_BY = $this->session->userdata('d_user_name');
        $VALID_UNTIL = $this->input->post('VALID_UNTIL');
        $CREATION_DATE = $this->input->post('CREATION_DATE');
		$UPDATE_DATE = $this->input->post('UPDATE_DATE');
		$P_MAP_DATIN_ACC_ID = $this->input->post('P_MAP_DATIN_ACC_ID');
		$timefr = strtotime($VALID_FROM);
		$timeutl = strtotime($VALID_UNTIL);
		$time_create = strtotime($CREATION_DATE);
		$time_update = strtotime($UPDATE_DATE);
		$VALID_FROM = date('d-M-Y',$timefr);
		$VALID_UNTIL = date('d-M-Y',$timeutl);
		$CREATION_DATE = date('d-M-Y',$time_create);
		$UPDATE_DATE = date('d-M-Y',$time_update);
		

        $data = array('PGL_ID' => $PGL_ID,
            'ACCOUNT_NUM' => $ACCOUNT_NUM,
            'VALID_FROM' => $VALID_FROM,
            'VALID_UNTIL' => $VALID_UNTIL,
            'CREATED_BY' => $CREATED_BY,
			'UPDATE_BY' => $UPDATE_BY,
			'CREATION_DATE' => $CREATION_DATE,
			'UPDATE_DATE' => $UPDATE_DATE,
			'P_MAP_DATIN_ACC_ID' => $P_MAP_DATIN_ACC_ID
        );

        switch ($oper) {
            case 'add':
				$data['P_MAP_DATIN_ACC_ID'] = gen_id('P_MAP_DATIN_ACC_ID','P_MAP_DATIN_ACC')+1;
                $this->db->insert($table, $data);
                break;
            case 'edit':
                $this->db->where('P_MAP_DATIN_ACC_ID', $id_);	
                $this->db->update($table, $data);
                break;
            case 'del':
                $this->db->where('P_MAP_DATIN_ACC_ID', $id_);				
                $this->db->delete($table);
                break;
        }

    }
	public function getListPglAcc($id_pg,$id_acc) {
        $result = array();
        $sql = "SELECT B.* FROM APP_USER_C2BI A, CUST_PGL B WHERE A.PGL_ID=B.PGL_ID AND A.USER_ID=".$user_id;
        $sql .= " ORDER BY B.PGL_NAME";
		$sql = "select a.pgl_id PG, a.ACCOUNT_NUM AN from P_MAP_DATIN_ACC a, cust_pgl b, MV_LIS_ACCOUNT_NP c where b.". $id_pg . " = a.pgl_id AND c.". $id_acc ." = a.ACCOUNT_NUM";
        $q = $this->db->query($sql);
        if($q->num_rows() > 0) {
            $result = $q->result();
        }
        return $result;

    }

}