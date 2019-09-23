<?php
namespace MetWoo\Core\Builders;
defined( 'ABSPATH' ) || exit;

Class Base extends \MetWoo\Base\Common{

    use \MetWoo\Traits\Singleton;

   // $api veriable call for Cpt Class Instance 
    public $form;

    // $api veriable call for Api Class Instance 
    public $api;


    public function get_dir(){
        return dirname(__FILE__);
    }

    public function __construct(){

    }
    
    public function init(){
        $this->form = new Cpt();
        $this->api = new Api();
        Hooks::instance()->Init();
        

        add_action('admin_footer', [$this, 'modal_view']);  
    }

    public function modal_view(){
        
        $screen = get_current_screen();

        if($screen->id == 'edit-'.$this->form->get_name() || $screen->id == 'metform_page_mt-form-settings'){
            include_once 'views/modal-editor.php';
        }
    }
}