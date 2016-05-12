<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Code Igniter

 * @package		CodeIgniter
 * @author		Gery

 **/

    function checkAuth() {
        $CI =& get_instance();
        if($CI->session->userdata('admin_id')=="" || $CI->session->userdata('super_admin')=="") {
           return redirect("auth");
        }
    }