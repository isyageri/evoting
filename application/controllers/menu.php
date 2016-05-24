<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller
{

    private $head = "Menu";

    function __construct()
    {
        parent::__construct();

        checkAuth();

        $this->load->helper('breadcrumb');
        $this->load->model('M_jqGrid', 'jqGrid');
        $this->load->model('M_global');
        $this->load->model('M_penduduk');


    }

    public function index()
    {
        $this->load->view('penduduk/header');
        $this->load->view('penduduk/data_penduduk');
        $this->load->view('penduduk/footer');
		exit;

    }

   


}
