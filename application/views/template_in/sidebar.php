<?php
$menu = "";
$module_id = $this->session->userdata("module_id");
        $result = $this->M_profiling->getMenuByModule($module_id);

        foreach ($result as $datas) {
            $data[$datas->parent_id][] = $datas;

            $menu = get_menu($data);

        }

       // $this->menu = $menu;


function get_menu($data, $parent = 0) {
        if (isset($data[$parent])) {
            $html = "";
            //$i++;
            foreach ($data[$parent] as $v) {
                $child = get_menu($data, $v->menu_id);
               // $html .= "<li class='setting_nav' id='".$v->FILE_NAME."' href='".site_url($v->MENU_LINK)."'>";
                $html .= "<li class='setting_nav' id='".$v->file_name."' href='".site_url($v->file_name)."'>";
                $html .= "<a href='#' class='dropdown-toggle'>";
                if($v->menu_icon == ""){
                   $html .= '<i class="menu-icon fa fa-caret-right"></i>';
                }else{
                    $html .= '<i class="'.$v->menu_icon.'"></i>';
                }

                $html .= '<span class="menu-text">'.$v->code.'</span>';

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
?>

<div id="sidebar" class="sidebar  responsive">
<!-- List Menu -->
    <ul class="nav nav-list">
        <?php echo $menu;?>
    </ul><!-- /.nav-list -->
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left"
            data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div>        
