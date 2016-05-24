<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Apps extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        checkAuth();

        $this->load->helper('breadcrumb');
        $this->load->model('M_jqGrid', 'jqGrid');
        $this->load->model('M_global');
        $this->load->model('M_profiling');


    }

    public function index()
    {
        $this->load->view('template_in/header');
        //$this->load->view('penduduk/data_penduduk');
        $this->load->view('template_in/footer');

    }



}
