<?php

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->session->sess_destroy();
        $this->load->view('user/v_login');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url() . "auth");
    }

    public function timeout()
    {
        $session_id = $this->session->userdata('name');
        if ($session_id == '' or $session_id == NULL) {
            $status = 'expired';
        } else {
            $status = 'success';
        }
        $data['status'] = $status;
        $this->status = $status;
        $this->load->view('templates/interval', $data);
    }

    public function login()
    {
        $this->load->model('M_user');
        $username = strtoupper($this->security->xss_clean($this->input->post('username')));
        $pwd = MD5($this->security->xss_clean($this->input->post('pwd')));

        //Returns TRUE if every character in text is either a letter or a digit, FALSE otherwise.
        if (ctype_alnum($username)) {
            $rc = $this->M_user->getUserPwd($this->security->xss_clean($username), $pwd)->result();
            if (count($rc) == 1 AND $rc[0]->admin_password == $pwd) {
                $sessions = array(
                    'admin_id' => $rc[0]->admin_id,
                    'admin_user' => $rc[0]->admin_user,
                    'admin_name' => $rc[0]->admin_name,
                    'admin_email' => $rc[0]->admin_email,
                    'super_admin' => $rc[0]->super_admin

                );
                //Set session
                $this->session->set_userdata($sessions);

                //echo json_encode(array('success'=>true,'msg'=>"You will be direct .. !"));
                $data['success'] = true;
                $data['msg'] = "You will be direct .. !";
                echo json_encode($data);
            } else {
                echo json_encode(array('msg' => "Username / Password salah !"));
            }

        } else {
            echo json_encode(array('msg' => "Disallow character"));
        }
    }


    public function update_profile()
    {
        $this->load->model('M_user');

        $user_password_old = $this->security->xss_clean($this->input->post('user_password_old'));
        $user_password1 = $this->security->xss_clean($this->input->post('user_password1'));
        $user_password2 = $this->security->xss_clean($this->input->post('user_password2'));

        $user_email = $this->security->xss_clean($this->input->post('user_email'));
        $user_realname = $this->security->xss_clean($this->input->post('user_realname'));

        $data = array('items' => array(), 'total' => 0, 'success' => false, 'message' => '');

        $user_id = $this->session->userdata('d_user_id');

        try {
            /*
                $this->db->set($this->record);
			    $this->db->where($this->pkey, $this->record[$this->pkey]);
			    $this->db->update( $this->table );
            */
            $record = array();

            if (empty($user_id)) {
                throw new Exception("Session Anda telah habis");
            }

            if (empty($user_realname)) {
                throw new Exception("Nama Lengkap harus diisi");
            }

            if (!empty($user_password1) or !empty($user_password_old)) {
                if (strcmp($user_password1, $user_password2) != 0) throw new Exception("Password baru tidak sama dengan konfirmasi password. Silahkan diperiksa lagi.");

                if (strlen($user_password1) < 6) throw new Exception("Password baru minimal 6 karakter");

                if (empty($user_password_old)) {
                    throw new Exception("Password Lama harus diisi");
                }

                $data_user = $this->M_user->getUserItem($user_id);
                if (md5($user_password_old) != $data_user['PASSWD']) {
                    throw new Exception("Password lama Anda salah");
                }

                $record['PASSWD'] = md5($user_password1);
            }

            if (empty($user_email)) {
                throw new Exception("Email harus diisi");
            }

            if (!empty($user_email)) {
                if (!$this->isValidEmail($user_email)) {
                    throw new Exception("Format email Anda salah. Silahkan diperbaiki");
                }
            }

            $record['EMAIL'] = $user_email;
            $record['FULL_NAME'] = $user_realname;

            $this->M_user->db->set($record);
            $this->M_user->db->where("USER_ID", $user_id);
            $this->M_user->db->update("APP_USERS");

            $this->session->set_userdata('d_full_name', $user_realname);
            $this->session->set_userdata('d_email', $user_email);

            $data['success'] = true;
            $data['message'] = 'Data profile berhasil diupdate';

        } catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        echo json_encode($data);
        exit;
    }

}
