<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * ***************************************************************
 *  Script : 
 *  Version : 
 *  Date :
 *  Author : Pudyasto Adi W.
 *  Email : mr.pudyasto@gmail.com
 *  Description : 
 * ***************************************************************
 */

/**
 * Description of Menus
 *
 * @author adi
 */
class Menus extends MY_Controller {
    protected $data = '';
    protected $val = '';
    public function __construct()
    {
        parent::__construct();
        $this->data = array(
            'msg_main' => $this->msg_main,
            'msg_detail' => $this->msg_detail,
            
            'submit' => site_url('menus/submit'),
            'show_form' => site_url('menus/form'),
            'reload' => site_url('menus'),
        );
        $this->load->model('menus_qry');
    }
    
    public function index(){
        $this->template
            ->title($this->msg_main, $this->apps->name)
            ->set_layout('main-layout')
            ->build('index',$this->data);
    }
    
    public function form() {
        $id = $this->input->get('id');
        $this->data['material'] = $this->load->view('material_icons', '', TRUE);
        if($id){
            $this->_init_edit($id);
        }else{
            $this->_init_add();
        }
        echo $this->load->view('form',$this->data,false);
    }
    
    public function json_dgview() {
        $columns = array( 'id', 'menu_name', 'submenu', 'description',);
        $table = ' (SELECT
                        submenu.id,
                        CASE WHEN menus.menu_name IS NULL 
                            THEN submenu.menu_name 
                            ELSE menus.menu_name 
                        END AS menu_name,
                        CASE WHEN menus.menu_name IS NULL 
                            THEN NULL 
                            ELSE submenu.menu_name 
                        END AS submenu,
                        submenu.description,
                        submenu.link
                    FROM
                            menus
                    RIGHT JOIN menus AS submenu 
                            ON submenu.mainmenuid = menus.id
                    WHERE
                            menus.mainmenuid IS NULL
                    ) AS a ';
        $index = "id";
        $output = $this->paw_table->output($columns, $table, $index);
        echo $output;
    }
    
    public function submit() {  
        $id = $this->input->post('id');
        $stat = $this->input->post('stat');
        
        if($this->validate($id,$stat) == TRUE){
            $res = $this->menus_qry->submit();
            echo $res;
        }else{
            $res = array(
                'state' => "0", 
                'msg' => strip_tags(validation_errors()),
                'csrf_return' => $this->security->get_csrf_hash(),
            );
            echo json_encode($res);
        }
    }
    
    private function _init_add(){
        if(set_value('mainmenuid')){
            $checked = FALSE;
        }else{
            $checked = TRUE;
        }
        
        $mainmenuid = $this->menus_qry->select_main_menu();
        $opt_mainmenu[''] = '-- Set Main Menu --';
        foreach ($mainmenuid as $value) {
            $opt_mainmenu[$value['id']] = $value['menu_name'];
        }
        
        $opt_statmenu = array(
            '1' => 'Aktif',
            '0' => 'Tidak',
        );
        $this->data['form'] = array(
           'id'=> array(
                    'type'        => 'hidden',
                    'placeholder' => 'ID',
                    'id'          => 'id',
                    'name'        => 'id',
                    'value'       => set_value('id'),
                    'class'       => 'form-control ',
            ),
           'menu_name'=> array(
                    'placeholder' => 'Nama Menu',
                    'id'          => 'menu_name',
                    'name'        => 'menu_name',
                    'value'       => set_value('menu_name'),
                    'class'       => 'form-control ',
                    'required'    => '',
                    'autofocus'   => ''
            ),
           'chkmainmenu'=> array(
                    'id'        => 'chkmainmenu',
                    'value'     => 'ok',
                    'checked'   => $checked,
                    'class'     => 'filled-in chk-col-red',
            ),
            'mainmenuid'=> array(
                    'attr'        => array(
                        'id'    => 'mainmenuid',
                        'class' => 'form-control ',
                    ),
                    'data'     => $opt_mainmenu,
                    'value'   => set_value('mainmenuid'),
                    'name'     => 'mainmenuid',
            ),
           'link'=> array(
                    'placeholder' => 'Class Menu',
                    'id'          => 'link',
                    'name'        => 'link',
                    'value'       => '#',
                    'class'       => 'form-control ',
                    'required'    => '',
            ),
           'icon'=> array(
                    'placeholder' => 'Icon',
                    'id'          => 'icon',
                    'name'        => 'icon',
                    'value'       => 'chevron_right',
                    'class'       => 'form-control ',
            ),
            'description'=> array(
                    'placeholder' => 'Keterangan',
                    'id'          => 'description',
                    'name'        => 'description',
                    'value'       => set_value('description'),
                    'class'       => 'form-control ',
                    'style'       => 'resize: vertical;height: 80px;min-height: 80px;',
            ),
            'statmenu'=> array(
                    'attr'        => array(
                        'id'    => 'statmenu',
                        'class' => 'form-control ',
                    ),
                    'data'     => $opt_statmenu,
                    'value'   => set_value('statmenu'),
                    'name'     => 'statmenu',
            ),
        );
    }
    
    private function _init_edit($id = null){
        if(!$id){
            $id = $this->uri->segment(3);
        }
        $this->_check_id($id);
        if($this->val[0]['mainmenuid']){
            $checked = FALSE;
        }else{
            $checked = TRUE;
        }
        
        $mainmenuid = $this->menus_qry->select_main_menu($id);
        $opt_mainmenu[''] = '-- Set Main Menu --';
        foreach ($mainmenuid as $value) {
            $opt_mainmenu[$value['id']] = $value['menu_name'];
        }
        
        $opt_statmenu = array(
            '1' => 'Aktif',
            '0' => 'Tidak',
        );
        $this->data['form'] = array(
           'id'=> array(
                    'type'        => 'hidden',
                    'placeholder' => 'ID',
                    'id'          => 'id',
                    'name'        => 'id',
                    'value'       => $this->val[0]['id'],
                    'class'       => 'form-control ',
            ),
           'menu_name'=> array(
                    'placeholder' => 'Nama Menu',
                    'id'          => 'menu_name',
                    'name'        => 'menu_name',
                    'value'       => $this->val[0]['menu_name'],
                    'class'       => 'form-control ',
                    'required'    => '',
                    'autofocus'   => ''
            ),
           'chkmainmenu'=> array(
                    'id'        => 'chkmainmenu',
                    'value'     => 'ok',
                    'checked'   => $checked,
                    'class'     => 'filled-in chk-col-red',
            ),
            'mainmenuid'=> array(
                    'attr'        => array(
                        'id'    => 'mainmenuid',
                        'class' => 'form-control ',
                    ),
                    'data'     => $opt_mainmenu,
                    'value'   => $this->val[0]['mainmenuid'],
                    'name'     => 'mainmenuid',
            ),
           'link'=> array(
                    'placeholder' => 'Class Menu',
                    'id'          => 'link',
                    'name'        => 'link',
                    'value'       => $this->val[0]['link'],
                    'class'       => 'form-control ',
                    'required'    => '',
            ),
           'icon'=> array(
                    'placeholder' => 'Icon',
                    'id'          => 'icon',
                    'name'        => 'icon',
                    'value'       => $this->val[0]['icon'],
                    'class'       => 'form-control ',
            ),
            'description'=> array(
                    'placeholder' => 'Keterangan',
                    'id'          => 'description',
                    'name'        => 'description',
                    'value'       => $this->val[0]['description'],
                    'class'       => 'form-control ',
                    'style'       => 'resize: vertical;height: 80px;min-height: 80px;',
            ),
            'statmenu'=> array(
                    'attr'        => array(
                        'id'    => 'statmenu',
                        'class' => 'form-control ',
                    ),
                    'data'     => $opt_statmenu,
                    'value'   => $this->val[0]['statmenu'],
                    'name'     => 'statmenu',
            ),
        );
    }
    
    private function _check_id($id){
        if(empty($id)){
            return false;
        }
        
        $this->val= $this->menus_qry->select_data($id);
        
        if(empty($this->val)){
            return false;
        }
    }
    
    private function validate($id,$stat) {
        if(!empty($id) && !empty($stat)){
            return true;
        }
        $config = array(
            array(
                    'field' => 'menu_name',
                    'label' => 'Menu Name',
                    'rules' => 'required|alpha_numeric_spaces|max_length[50]',
                ),
            array(
                    'field' => 'description',
                    'label' => 'Description',
                    'rules' => 'alpha_numeric_spaces|max_length[250]',
                    ),
            array(
                    'field' => 'link',
                    'label' => 'Link',
                    'rules' => 'required|max_length[150]',
                    ),
            array(
                    'field' => 'statmenu',
                    'label' => 'Status',
                    'rules' => 'required|alpha_numeric_spaces|max_length[15]',
                    ),
        );
        
        $this->form_validation->set_rules($config);   
        if ($this->form_validation->run() == FALSE)
        {
            return false;
        }else{
            return true;
        }
    }
}
