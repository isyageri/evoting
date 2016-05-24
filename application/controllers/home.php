<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function __construct() {
		parent::__construct();

        checkAuth();
		$this->load->model('M_profiling');
		$this->load->model('M_user');
	}

	public function index()
	{

        $this->load->view('templates/header');
        $this->load->view('home');
        $this->load->view('templates/footer');
	}

    function get_menu($data, $parent = 0) {
        if (isset($data[$parent])) {
            $html = "";
            //$i++;
            foreach ($data[$parent] as $v) {
                $child = $this->get_menu($data, $v->MENU_ID);
               // $html .= "<li class='setting_nav' id='".$v->FILE_NAME."' href='".site_url($v->MENU_LINK)."'>";
                $html .= "<li class='setting_nav' id='".$v->FILE_NAME."' href='".site_url($v->MENU_LINK)."/".$v->MENU_ID."'>";
                $html .= "<a href='#' class='dropdown-toggle'>";
                if($v->MENU_ICON == ""){
                   $html .= '<i class="menu-icon fa fa-caret-right"></i>';
                }else{
                    $html .= '<i class="'.$v->MENU_ICON.'"></i>';
                }

                $html .= '<span class="menu-text">'.$v->MENU_NAME.'</span>';

                if($child){
                   $html .= '<b class="arrow fa fa-angle-down"></b>';
                }
                $html .=  '</a>';
                $html .= '<b class="arrow"></b>';
                if ($child) {
                    //$i--;
                    $html .= '<ul class="submenu">';
                    $html .= $child;
                  //  $html .= '</ul>';
                }
                $html .= '</li>';

            }
            $html .= '</ul>';
            return $html;
        } else {
            return false;
        }
    }
	
	public function set_module() {
		$module_id = $this->input->post('module_id');
		$this->session->set_userdata(array('module_id' => $module_id));
		$data['success'] = true;
		echo json_encode($data);
	}
	

	

	
}
