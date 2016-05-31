<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

    private $head = "Admin System";

	function __construct() {
		parent::__construct();
		
		//Load Library Cek Session
        checkAuth();

        $this->load->helper('breadcrumb');

		$this->load->model('M_profiling');
		$this->load->model('M_user');
		$this->load->model('M_admin');
		$this->load->model('M_global');
        $this->load->model('M_jqGrid', 'jqGrid');

	}

	public function index() {
		redirect("/");
	}
	
	public function menu() {
        //BreadCrumb
        $title = $_POST['title'];
        $bc = array($this->head,$title);
        $this->breadcrumb = getBreadcrumb($bc);

		$this->load->view('admin/menu');
	}
    public function profile() {
        //BreadCrumb
        $title = $_POST['title'];
        $bc = array($this->head,$title);
        $this->breadcrumb = getBreadcrumb($bc);

        $this->load->view('admin/list_profile');
    }

    public function gridMenu()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "menu";

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

    public function gridProfile() {
        $page = intval($_REQUEST['page']) ;
        $limit = $_REQUEST['rows'] ;
        $sidx = $_REQUEST['sidx'] ;
        $sord = $_REQUEST['sord'] ;

        $table = "APP_PROFILE";

        $req_param = array (
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField'])?$_REQUEST['searchField']:null,
            "search_operator" => isset($_REQUEST['searchOper'])?$_REQUEST['searchOper']:null,
            "search_str" => isset($_REQUEST['searchString'])?$_REQUEST['searchString']:null
        );

        $req_param['field'] = array();
        $req_param['value'] = array();

        $row = $this->jqGrid->get_data($req_param)->result_array();
        $count = count($row);

        if( $count >0 ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit*$page - ($limit-1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function crud_master(){
       // crud(tabel_name,field,key_unix,field yg mau di insert/update)
        $table = "APP_MENU";
        $id = $this->input->post('id');
        $this->jqGrid->crud($table,'MENU_ID', $id, array('MENU_NAME','MENU_PARENT', 'MENU_ICON','MENU_DESC'));
    }

    public function crud_profile(){
        // crud(tabel_name,field_id,key_unix,field yg mau di insert/update)
        $table = "APP_PROFILE";
        $id = $this->input->post('id');
        $this->jqGrid->crud($table,'PROF_ID', $id, array('PROF_NAME','PROF_DESC'));
    }


    public function crud_detail(){
        // crud(tabel_name,field,key_unix,field yg mau di insert/update)
        $table = "APP_MENU";
        $id = $this->input->post('id');
        $this->jqGrid->crud($table,'MENU_ID', $id, array('MENU_NAME', 'MENU_LINK','FILE_NAME','MENU_PARENT'));
    }

    public function menuchild($id) {

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sidx = $_POST['sidx'] ;
        $sord = $_POST['sord'] ;

        $count = $this->M_admin->getCountListMenuChild($id);
        $record= $count[0]->COUNT;

        $result['page'] = $page;
        $result['total'] = ceil($record/$rows);
        $result['records'] = $record;
        $result['sidx'] = $sidx;
        $result['sord'] = $sord;
        $result['id'] = $id;

        $req_param = array (
            "sort_by" => $sidx,
            "page" => isset($_POST['page']) ? intval($_POST['page']) : 1,
            "rows" => isset($_POST['rows']) ? intval($_POST['rows']) : 10,
            "sord" => $sord,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField'])?$_REQUEST['searchField']:null,
            "search_operator" => isset($_REQUEST['searchOper'])?$_REQUEST['searchOper']:null,
            "search_str" => isset($_REQUEST['searchString'])?$_REQUEST['searchString']:null,
            "id" => $id
        );

        $this->parent_id = $id;

        $result['Data'] = $this->M_admin->getListMenuChild($req_param);
        echo json_encode($result);

    }

    public function menuchild2($id) {
        $page = intval($_REQUEST['page']) ;
        $limit = $_REQUEST['rows'] ;
        $sidx = $_REQUEST['sidx'] ;
        $sord = $_REQUEST['sord'] ;

        $table = "APP_MENU";

        $req_param = array (
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField'])?$_REQUEST['searchField']:null,
            "search_operator" => isset($_REQUEST['searchOper'])?$_REQUEST['searchOper']:null,
            "search_str" => isset($_REQUEST['searchString'])?$_REQUEST['searchString']:null
        );

        $req_param['field'] = array(
            'field1' => 'MENU_PARENT'
        );
        $req_param['value'] = array(
             'value1' => $id
            //'value2' => 'null'
        );

        // Count Total row
        $row = $this->jqGrid->get_data($req_param)->result_array();
        $count = count($row);

        if( $count >0 ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit*$page - ($limit-1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function menuTree(){
        $data['prof_id'] = $this->input->post('prof_id');
        $this->load->view('admin/menu_tree',$data);
    }
    public function getMenuTreeJson($prof_id){
        $result = $this->M_admin->getTreeMenu();
        $i = 0;
        $data = array();
        foreach($result as $menu){

            $tmp = array(
                'id' => $menu->MENU_ID,
                'parentid' => $menu->MENU_PARENT,
                'text' => $menu->MENU_NAME,
                'value' =>$menu->MENU_ID,
                'expanded' =>true

            );

            //Cek count di tabel menu profile untuk menu_id , jika >0 maka checked true
            $profile_id = $prof_id;
            $tmpCount = $this->M_admin->cekMenuProfile($menu->MENU_ID,$profile_id)->result_array;

            $countMenu = count($tmpCount);

            if($countMenu > 0){
                $tmp = array_merge($tmp, array('checked' => true));
            }

            $data[$i] = $tmp;
            $i=$i+1;

        }
        echo json_encode($data);
    }

    public function updateProfile(){
        $menu_id = $this->input->post('check_val');
        $prof_id = $this->input->post('prof_id');

        if($prof_id != "" || $prof_id != null){
            // delete app menu profile where id profile = ...
            $this->M_admin->delMenuProf($prof_id);

            if (!empty($menu_id)) {
                $menu_ids = implode(",", $menu_id);
                $this->M_admin->insMenuProf($menu_ids,$prof_id);
            }

        }
        $this->menuTree();
    }

    public function user() {
        $title = $_POST['title'];
        //BreadCrumb
        $bc = array($this->head,$title);
        $this->breadcrumb = getBreadcrumb($bc);

        $this->load->view('admin/list_user');
    }
    public function gridUser() {
        $page = intval($_REQUEST['page']) ;
        $limit = $_REQUEST['rows'] ;
        $sidx = $_REQUEST['sidx'] ;
        $sord = $_REQUEST['sord'] ;

        $table = "APP_USERS";

        $req_param = array (
            "custom_code" => 'user',
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField'])?$_REQUEST['searchField']:null,
            "search_operator" => isset($_REQUEST['searchOper'])?$_REQUEST['searchOper']:null,
            "search_str" => isset($_REQUEST['searchString'])?$_REQUEST['searchString']:null
        );

        // Filter table. Jumlah array field harus sama dengan value.
        $req_param['field'] = array('NIK !=','NIK !=');
        $req_param['value'] = array('DEV','ADMIN');

        $row = $this->jqGrid->get_data($req_param)->result_array();
        $count = count($row);

        if( $count >0 ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit*$page - ($limit-1);

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function crud_user(){
        $this->M_admin->crud_user();
    }

    public function resetPWD(){
        $uid = $this->input->post('user_id');
        $nik = md5(strtolower($this->input->post('nik')));
        $this->M_admin->resetPwd($uid,$nik);
        if($this->db->affected_rows() > 0){
            echo "Password berhasil direset";
        }else{
            echo "Update Gagal";
        }
    }

    public function listMenu(){
        $result = $this->db->get('menu')->result_array();
        echo "<select>";
        echo "<option value='0'> Ya </option>";
        foreach($result  as $value ){
            echo "<option value=".$value['menu_id'].">".ucfirst($value['code'])."</option>";
        }
        echo "</select>";
    }

    public function crudMenu(){
        $this->M_global->crud_menu();
    }
}
