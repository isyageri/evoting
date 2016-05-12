<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Penduduk extends CI_Controller
{

    private $head = "Penduduk";

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
        $this->load->view('template_in/header');
        $this->load->view('penduduk');
        $this->load->view('template_in/footer');

    }

    

    public function gridClient()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "v_penduduk";

        //JqGrid Parameters
        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "or_where" => null,
            "or_where_in" => null,
            "or_where_not_in" => null,
            "search" => $this->input->post('_search'),
            "search_field" => ($this->input->post('searchField')) ? $this->input->post('searchField') : null,
            "search_operator" => ($this->input->post('searchOper')) ? $this->input->post('searchOper') : null,
            "search_str" => ($this->input->post('searchString')) ? ($this->input->post('searchString')) : null
        );

        // Filter Table *

        $count = $this->jqGrid->countAll($req_param);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - $limit;

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function listRT()
    {
        $result = $this->M_global->getListRT();
        echo "<select>";
        foreach ($result as $value) {
            echo "<option value=" . $value['rt_id'] . ">" . $value['rt_code'] . "</option>";
        }
        echo "</select>";
    }

    public function listRW()
    {
        $result = $this->M_global->getListRW();
        echo "<select>";
        foreach ($result as $value) {
            echo "<option value=" . $value['rw_id'] . ">" . $value['rw_code'] . "</option>";
        }
        echo "</select>";
    }


    public function crudPenduduk(){
         $this->M_penduduk->crud_penduduk();
    }


}
